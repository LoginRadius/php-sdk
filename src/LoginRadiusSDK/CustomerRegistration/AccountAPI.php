<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AccountAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration;

use LoginRadiusSDK\LoginRadius;

/**
 * Account API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Account API.
 */
class AccountAPI
{

    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {
        $options = array_merge(array('authentication'=>true),$customize_options);
        new LoginRadius($apikey, $apisecret, $options);
    }

    /**
     * This API is used to link a user account with a specified providers user account.
     *
     * @param type $uid
     * @param type $id
     * @param type $provider
     *
     * return {"isPosted": "true"}
     */
    public function accountLink($uid, $id, $provider)
    {
        $data = array('accountid' => $uid, 'provider' => $provider, 'providerid' => $id);
        return $this->apiClientHandler("link", array(), array('method' => 'post', 'post_data' => $data));
    }

    /**
     * This API is used to unlink a user account with a specified providers user account.
     *
     * @param type $uid
     * @param type $id
     * @param type $provider
     *
     * return {"isPosted": "true"}
     */
    public function accountUnlink($uid, $id, $provider)
    {
        $data = array('accountid' => $uid, 'provider' => $provider, 'providerid' => $id);
        return $this->apiClientHandler("unlink", array(), array('method' => 'post', 'post_data' => $data));
    }

    /**
     * This API is used to create a user using the currently logged in social provider.
     *
     * $data = array(
     *      'accountid'=> uid,
     *      'password'=> 'xxxxxxxxxx',
     *      'emailid'=> 'example@doamin.com'
     * );
     *
     * return {"isPosted": "true"}
     */
    public function createUserRegistrationProfile($data)
    {
        return $this->apiClientHandler("profile", array(), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to retrieve all of the profile data from each of the linked social provider accounts associated with the account. For ex: A user has linked facebook and google account then this api will retrieve both profile data.
     *
     * $uid = uid; uid; UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return Array of user profile
     */
    public function getAccounts($uid)
    {
        return $this->apiClientHandler("", array('accountid' => $uid));
    }

    /**
     * This API is used to add or remove a particular email from one user's account.
     *
     * $uid = uid; UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     * $action Add or remove
     *
     * $data = array(
     *      'emailid'=> 'example@doamin.com',
     *      'emailType'=> 'Business', //Email Type like "Business" or Personal
     *
     * );
     * return {"isPosted": "true"}
     */
    public function userAdditionalEmail($uid, $action, $data)
    {
        return $this->apiClientHandler("email", array('accountid' => $uid, 'action' => $action), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API generates a forgot password token so you can manually pass into the reset password page and reset some's password.
     *
     * $email = 'example@doamin.com';
     *
     * return {"Guid": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx", "Providers": ["xxxxxx"]}
     */
    public function forgotPassword($email)
    {
        return $this->apiClientHandler("password/forgot", array('email' => $email));
    }

    /**
     * Delete an account from your LoginRadius app.
     *
     * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; //UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return {"isPosted": "true"}
     */
    public function deleteAccount($uid)
    {
        return $this->apiClientHandler("delete", array('accountid' => $uid));
    }

    /**
     * This API is used to change the password field of an account, you need to know the old password before you change it.
     *
     * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; //UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     * $old_password => 'xxxxxxxxxx';
     * $new_password => 'xxxxxxxxxx';
     *
     * return {“isPosted”: “true”}
     */
    public function changeAccountPassword($uid, $old_password, $new_password)
    {
        $data = array('oldpassword' => $old_password, 'newpassword' => $new_password);
        return $this->apiClientHandler("password", array('accountid' => $uid), array('method' => 'post', 'post_data' => $data));
    }

    /**
     * This API is used to get the password field of an account.
     *
     * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return {"PasswordHash": "fFy\u0004���F�v\n��\n��\u0001؅I"}
     */
    public function getHashPassword($uid)
    {
        return $this->apiClientHandler("password", array('accountid' => $uid));
    }

    /**
     * This API is used to set a password for an account. It does not require to know the previous(old) password.
     *
     * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     * $password = 'xxxxxxxxxx';
     *
     * return {“isPosted”: “true”}
     */
    public function setPassword($uid, $password)
    {
        $parameter = array('accountid' => $uid, 'action' => 'set');
        return $this->apiClientHandler("password", $parameter, array('method' => 'post', 'post_data' => array('password' => $password)));
    }

    /**
     * This API is used for changing user name by account Id.
     *
     * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     * @param type $uid
     * @param type $username
     * @param type $new_username
     * return {“isPosted”: “true”}
     */
    public function changeUsername($uid, $username, $new_username)
    {
        $data = array('currentusername' => $username, 'newusername' => $new_username);
        return $this->apiClientHandler("changeusername", array('accountid' => $uid), array('method' => 'post', 'post_data' => $data));
    }

    /**
     * This API is used to check username exists or not on your site.
     *
     * $username = 'xxxxxx'; //Username that you want to validate
     * return { "isExist": false}
     */
    public function checkUsername($username)
    {
        return $this->apiClientHandler("checkusername", array('username' => $username));
    }

    /**
     * This API is used for set user name by user Id.
     *
     * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     * $newusername = 'xxxxxx'  //New username
     * return { "isPosted": true}
     */
    public function setUsername($uid, $newusername)
    {
        return $this->apiClientHandler("setusername", array('accountId' => $uid), array('method' => 'post', 'post_data' => array('newusername' => $newusername)));
    }

    /**
     * This API is used to generate an email-token that can be sent out to a user in a link in order to verify their email.
     *
     * $email = 'example@doamin.com' //email id //required
     * $link  = 'example.com' //Verification Url link address //required
     * $template = 'xxxxx'  //Verification Email Template
     *
     * return { "Guid":"234324343432432324" }
     */
    public function resendEmailVerification($email, $link, $template)
    {
        return $this->apiClientHandler("verificationemail", array('emailid' => $email, 'link' => $link, 'template' => $template));
    }

    /**
     * This API is used to block or un-block a user using the users unique UserID (UID).
     *
     * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
     * $action = true/false(boolean)
     *
     * return {"isPosted": "true"}
     */
    public function setStatus($uid, $action = true)
    {
        return $this->apiClientHandler("status", array('accountid' => $uid), array('method' => 'post', 'post_data' => array('isblock' => $action)));
    }

    /**
     * handle account APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $options = array())
    {
        return LoginRadius::apiClient("/raas/v1/account/" . $path, $query_array, $options);
    }

}
