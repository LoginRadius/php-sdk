<?php

use LoginRadiusSDK\LoginRadius;
use LoginRadiusSDK\SocialLogin\SocialLoginAPI;
use LoginRadiusSDK\LoginRadiusException;
use LoginRadiusSDK\CustomerRegistration\UserAPI;
use LoginRadiusSDK\CustomerRegistration\AccountAPI;

session_start();

/**
 * Class user
 *
 * handle complete functionality
 */
class Authentication {

    function getProfileForm($data) {
        $output = '<form action="" method="post">';
        foreach ($data as $key => $value) {
            if (in_array($key, array('FirstName', 'LastName', 'BirthDate', 'Email', 'Country', 'City'))) {
                $date = $disabled = '';
                if ($key == "BirthDate") {
                    $date = 'class = "loginradius-raas-birthdate"';
                } elseif ($key == 'Email') {
                    $disabled = 'disabled = disabled';
                }
                if (!empty($key)) {
                    $output .= '<label class="lr-input-frame lr-inline"> <span class="lr-input-label">' . $key . '</span>';
                    $output .= '<input type = "text" placeholder = "' . $key . '" name = "' . trim($key) . '" value = "' . (($value == 'unknown')?'':$value) . '" ' . $date . ' ' . $disabled . '>';
                    $output .= '</label>';
                }
            }
        }

        $output .= '<div class="lr-submit-frame lr-align-right">';
        $output .= '<input name="update" type="submit" value="Save">';
        $output .= '</div>';
        $output .= '</form>';
        return $output;
    }

    /**
     * Handle Login functionality
     */
    public static function login() {
        $user_profile = $_SESSION['userprofile'];
        if (isset($user_profile->Uid) && $user_profile->Uid != '') {
            $_SESSION['user_id'] = $user_profile->Uid;
            $user_profile = self::mapProfile($user_profile);
            $_SESSION['userprofile'] = $user_profile;
            header("Location: profile.php");
            exit();
        }
    }

    /**
     * Handle login functionality
     * unset session.
     */
    public static function logout() {
               if (isset($_SESSION['user_id'])) {
            session_destroy();
        }
        unset($_SESSION['user_id']);
    }

    /**
     * @param $post_value
     * Update User profile data.
     *
     */
    public static function updateProfile($post_value) {
        $userRegUser = new UserAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));
        $data = $_SESSION['userprofile'];
        unset($post_value['update']);

        if (!empty($data->ID)) {
            try {
                $result = $userRegUser->edit($data->ID, $post_value);
                if (isset($result->isPosted) && $result->isPosted) {
                    $user_profile = $userRegUser->getProfileByID($data->ID);
                    $profile_data = self::mapProfile($user_profile);
                    $_SESSION['userprofile'] = $profile_data;

                    self::setMessage("Profile updated successfully");
                }
            } catch (LoginRadiusException $e) {
                self::setMessage($e->getErrorResponse()->description);
            }
        }
    }

    /**
     * @param $post_value
     * Change user password
     */
    public static function changePassword($post_value) {
        $data = $_SESSION['userprofile'];
        $userRegUser = new AccountAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));
        if (!empty($data->Uid)) {

            try {
                $result = $userRegUser->changeAccountPassword($data->Uid, $post_value['oldpassword'], $post_value['newpassword']);
                if (isset($result->isPosted) && $result->isPosted) {
                    self::setMessage('Password changed successfully');
                }
            } catch (LoginRadiusException $e) {
                self::setMessage($e->getErrorResponse()->description);
            }
        }
    }

    /**
     * @param $post_value
     * Set user password.
     */
    public static function setPassword($post_value) {
        $data = $_SESSION['userprofile'];
        $userRegUser = new AccountAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));
        if (!empty($data->Uid)) {
            $data = array(
                'accountid' => $data->Uid,
                'password' => $post_value['password'],
                'emailid' => $post_value['emailid']
            );
            $result = $userRegUser->createUserRegistrationProfile($data);
            if (isset($result->isPosted) && $result->isPosted) {
                self::setMessage('Your Password set successfully');
            } else {
                self::setMessage($result->description);
            }
        }
    }

    /**
     * @param $post_value
     * Unlink user account.
     *
     */
    public static function unlinkAccount($post_value) {

        $accountApi = new AccountAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));
        $data = $_SESSION['userprofile'];
        if (!empty($data->Uid) && !empty($post_value['provider']) && !empty($post_value['providerId'])) {
            try {
                $result = $accountApi->accountUnlink($data->Uid, $post_value['providerId'], $post_value['provider']);
            } catch (LoginRadiusException $e) {
                self::setMessage($e->getErrorResponse()->description);
            }
            if (isset($result->isPosted) && $result->isPosted) {
                self::setMessage('Account Unlinked successfully');
            }
        }
    }

    /**
     * @param $post_value
     * Link user account
     */
    public static function linkAccount($post_value) {

        $userRegBasic = new SocialLoginAPI (LR_API_KEY, LR_API_SECRET, array('authentication'=>false, 'output_format' => 'json'));
        if (!empty($post_value['token'])) {
            $profile_data = array();
            try {
                $result_accesstoken = $userRegBasic->exchangeAccessToken($post_value['token']);
                $accessToken = $result_accesstoken->access_token;
            } catch (LoginRadiusException $e) {
                self::setMessage($e->getErrorResponse()->description);
            }
            if (!empty($accessToken)) {
                try {
                    $profile_data = $userRegBasic->getUserProfiledata($accessToken);
                } catch (LoginRadiusException $e) {
                    self::setMessage($e->getErrorResponse()->description);
                }
            }
            $data = $_SESSION['userprofile'];
            if (isset($profile_data->ID) && !empty($profile_data->ID) && isset($data->Uid) && !empty($data->Uid)) {
                try {
                    $accountApi = new AccountAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));
                    $result = $accountApi->accountLink($data->Uid, $profile_data->ID, $profile_data->Provider);

                    if (isset($result->isPosted) && $result->isPosted) {
                        self::setMessage('Account Linked Successfully');
                    }
                } catch (LoginRadiusException $e) {
                    self::setMessage($e->getErrorResponse()->description);
                }
            } else {
                self::setMessage('You cannot link this account either it is already linked with another account or email is not verified.');
            }
        }
    }

    public static function getProfiles() {
        $userRegBasic = new SocialLoginAPI (LR_API_KEY, LR_API_SECRET, array('authentication'=>false, 'output_format' => 'json'));
        $output = '';
        try {
            $result_accesstoken = $userRegBasic->exchangeAccessToken($_REQUEST['token']);
            $accessToken = $result_accesstoken->access_token;
        } catch (LoginRadiusException $e) {
            self::setMessage($e->getErrorResponse()->description);
        }

        if (!empty($accessToken)) {
            $_SESSION['userprofile'] = $userRegBasic->getUserProfiledata($accessToken);
            $_SESSION['access_token'] = $accessToken;
            $output = "You're traditionally loggedin";
        }
        return $output;
    }

    public function showProfile($array, $sub_table = FALSE) {
        $style = '';
        $output = '<table id="sociallogin_userprofile_table"  cellspacing="0">';
        $count = 1;

        if ($sub_table) {
            $output .= '<tfoot>';

            foreach ($array as $temp) {
                if (($count % 2) == 0) {
                    $style = 'style="background-color:#fcfcfc"';
                }
                foreach ($temp as $key => $val) {
                    $output .= '<tr ' . $style . '>';

                    if ($key == 'user_id') {
                        continue;
                    } else {
                        $output .= '<th scope="col" class="manage-colum">' . ucfirst($key) . '</th>';

                        if ($key == 'picture' && !empty($val)) {
                            $output .= '<th scope="col" class="manage-colum"><img height="60" width="60" src= "' . (isset($val) ? $val : '') . '" /></th>';
                        } else {
                            $output .= '<th scope="col" class="manage-colum">' . ucfirst($val) . '</th>';
                        }
                    }

                    $output .= '</tr>';
                }

                $count++;
            }
        } else {
            $output .= '<thead><tr>';

            foreach ($array as $key) {
                foreach (array_keys((array) $key) as $value) {
                    if ($value == 'user_id' || $value == 'provider') {
                        continue;
                    }

                    $value = str_replace('_', ' ', $value);
                    $output .= '<th scope="col"><strong>' . ucfirst($value) . '</strong></th>';
                }
                break;
            }

            $output .= '</tr>
      </thead>
     <tfoot>';

            foreach ($array as $contact) {
                if (($count % 2) == 0) {
                    $style = 'style="background-color:#fcfcfc"';
                }
                $output .= '<tr ' . $style . '>';

                foreach ($contact as $key => $val) {
                    if ($key == 'user_id' || $key == 'provider') {
                        continue;
                    } elseif ($key == 'provider_access_token') {
                        $val = unserialize($val);
                    } elseif ($key == 'company' && $val != NULL && $val != '') {
                        // Companies.
                        $companies_result = db_query("SELECT * FROM {loginradius_companies} WHERE id = :uid", array(':uid' => $val));
                        $companies = $companies_result->fetchAll();

                        if (count($companies) > 0) {
                            $output .= '<th scope="col" class="manage-colum">' . lr_social_profile_data_show($companies) . '</th>';
                            continue;
                        }
                    } else {
                        if (!empty($val) && ($key == 'image_url' || $key == 'picture')) {
                            $val = '<img height="50" width="50" src= "' . (isset($val) ? $val : '') . '" />';
                        }

                        $output .= '<th scope="col" class="manage-colum">' . ucfirst($val) . '</th>';
                    }
                }

                $output .= '</tr>';
                $count++;
            }
        }

        $output .= '</tfoot></table>';
        return $output;
    }

    /**
     * @param $user_profile
     * @return mixed
     * Get required user data.
     *
     */
    private static function mapProfile($user_profile) {
        $user_profile->FullName = isset($user_profile->FullName) ? $user_profile->FullName : '';
        $user_profile->FirstName = isset($user_profile->FirstName) ? $user_profile->FirstName : '';
        $user_profile->LastName = isset($user_profile->LastName) ? $user_profile->LastName : '';
        $user_profile->Country = isset($user_profile->Country->Name) ? $user_profile->Country->Name : '';
        $user_profile->City = isset($user_profile->City) ? $user_profile->City : '';
        $user_profile->ID = isset($user_profile->ID) ? $user_profile->ID : '';
        $user_profile->Email = isset($user_profile->Email[0]->Value) ? $user_profile->Email[0]->Value : '';
        $user_profile->Provider = isset($user_profile->Provider) ? $user_profile->Provider : '';
        $user_profile->Name = self::getUsername($user_profile);
        return $user_profile;
    }

    /**
     * @param $user_profile
     * @return string
     * Get username.
     */
    private static function getUsername($user_profile) {
        if (!empty($user_profile->FullName)) {
            $name = $user_profile->FullName;
        } elseif (!empty($user_profile->FirstName) && !empty($user_profile->LastName)) {
            $name = $user_profile->FirstName . ' ' . $user_profile->LastName;
        } elseif (!empty($user_profile->ProfileName)) {
            $name = $user_profile->ProfileName;
        } elseif (!empty($user_profile->NickName)) {
            $name = $user_profile->NickName;
        } elseif (!empty($user_profile->Email)) {
            $user_name = explode('@', $user_profile->Email);
            $name = $user_name[0];
        } else {
            $name = $user_profile->ID;
        }

        return $name;
    }

    /**
     * 
     * @param type $message
     */
    public static function setMessage($message) {
        $_SESSION['mymessage'] = $message;
    }

}
