<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : UserAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Authentication;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\Utility\SOTT;

/**
 * User API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Authentication API.
 */
class UserAPI
{

    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {
        $options = array_merge(array('authentication' => 'key'), $customize_options);
        new Functions($apikey, $apisecret, $options);
    }

    /**
     * This api used to provide login with email/password combination.
     *
     * @param $email
     * @param $password
     * @param string $verification_url  email verification
     * @param string $login_url url from where user is going login
     * @param string $email_template email template name
     * @return type userprofile object
     */
    public function loginByEmail($email, $password, $verification_url = '', $login_url = '', $email_template = '')
    {
        return $this->apiClientHandler("login", array('email' => $email, 'password' => $password, 'verificationUrl' => $verification_url, 'loginUrl' => $login_url, 'emailTemplate' => $email_template));
    }

    /**
     * This api used to provide login with username/password combination.
     *
     * @param $username
     * @param $password
     * @param string $verification_url  email verification
     * @param string $login_url url from where user is going login
     * @param string $email_template email template name
     * @return type userprofile object
     */
    public function loginByUsername($username, $password, $verification_url = '', $login_url = '', $email_template = '')
    {
        return $this->apiClientHandler("login", array('username' => $username, 'password' => $password, 'verificationUrl' => $verification_url, 'loginUrl' => $login_url, 'emailTemplate' => $email_template));
    }

    /**
     * This api used to provide login with phone/password combination.
     *
     * @param $phone
     * @param $password
     * @param string $verification_url  email verification
     * @param string $login_url url from where user is going login
     * @param string $sms_template sms template name
     * @return type userprofile object
     */
    public function loginByPhone($phone, $password, $verification_url = '', $login_url = '', $sms_template = '')
    {
        return $this->apiClientHandler("login", array('phone' => $phone, 'password' => $password, 'verificationUrl' => $verification_url, 'loginUrl' => $login_url, 'smsTemplate' => $sms_template));
    }

    /**
     * This api used to register a user.
     *
     * @param $userprofile  user profile json
     * @param string $verification_url  email verification
     * @param string $email_template email template name
     * @param string $sms_template sms template name
     * @return {"isPosted": "true"}
     */
    public function register($userprofile, $verification_url = '', $email_template = '', $sms_template = '')
    {
        $sott =  new SOTT();
        $encrypt =  $sott->encrypt();
        return $this->apiClientHandler("register", array('sott'=> $encrypt, 'verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'smsTemplate' => $sms_template), array('method' => 'post', 'post_data' => $userprofile, 'content_type' => 'json'));
    }

    /**
     * This api used to resend email verification link.
     *
     * @param $email
     * @param string $verification_url
     * @param string $email_template
     * @return {"isPosted": "true"}
     */

    public function resendEmailVerification($email, $verification_url = '', $email_template = '')
    {
        return $this->apiClientHandler("register", array('verificationUrl' => $verification_url, 'emailTemplate' => $email_template), array('method' => 'put', 'post_data' => json_encode(array('email' => $email)), 'content_type' => 'json'));
    }

    /**
     * Get profile by access token.
     *
     * @param $access_token
     * @return userprofile object
     */
    public function getProfile($access_token)
    {
        return $this->apiClientHandler("account", array('access_token' => $access_token));
    }

    /**
     * Update user profile by access token.
     *
     * @param $access_token
     * @param $data userprofile  json.
     * @param string $verification_url
     * @param string $email_template
     * @return type
     */

    public function updateProfile($access_token, $data, $verification_url = '', $email_template = '')
    {
        return $this->apiClientHandler("account", array('verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'access_token' => $access_token), array('method' => 'put', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * Delete account after email confirmation.
     *
     * @param $access_token
     * @param string $deleteUrl
     * @param string $email_template
     * @return type
     */
    public function deleteAccountByEmailConfirmation($access_token, $delete_url = '', $email_template = '')
    {
        return $this->apiClientHandler('account', array('access_token' => $access_token, 'deleteUrl' => $delete_url, 'emailTemplate' => $email_template), array('method' => 'delete', 'post_data' => true));
    }

    /**
     * Forgot password
     *
     * @param $email
     * @param $reset_password_url
     * @param $email_template
     * @return type
     */
    public function forgotPassword($email, $reset_password_url, $email_template = '')
    {
        return $this->apiClientHandler("password", array('resetPasswordUrl' => $reset_password_url, 'emailTemplate' => $email_template), array('method' => 'post', 'post_data' => json_encode(array('email' => $email)), 'content_type' => 'json'));
    }
    
    /**
     * Forgot password By Otp
     *
     * @param $phone   
     * @param $sms_template
     * @return type
     */
    public function forgotPasswordByOtp($phone, $sms_template = '')
    {
        return $this->apiClientHandler("password/otp", array('smsTemplate' => $sms_template), array('method' => 'post', 'post_data' => json_encode(array('phone' => $phone)), 'content_type' => 'json'));
    }

    /**
     * Reset Password.
     *
     * @param $vtoken
     * @param $password
     * @param string $welcome_email_template
     * @return type
     */
    public function resetPassword($vtoken, $password, $welcome_email_template = '')
    {
        return $this->apiClientHandler("password", array(), array('method' => 'put', 'post_data' => json_encode(array('ResetToken' => $vtoken, 'password' => $password, 'welcomeEmailTemplate' => $welcome_email_template)), 'content_type' => 'json'));
    }
    
    /**
     * Reset Password by otp.
     *
     * @param $phone
     * @param $otp
     * @param $password
     * @return type
     */
    public function resetPasswordByOtp($phone, $otp, $password)
    {
        return $this->apiClientHandler("password/otp", array(), array('method' => 'put', 'post_data' => json_encode(array('phone' => $phone, 'otp' => $otp, 'password' => $password)), 'content_type' => 'json'));
    }

    /**Change Account Password.
     *
     * @param $access_token
     * @param $old_password
     * @param $new_password
     * @return type
     */
    public function changeAccountPassword($access_token, $old_password, $new_password)
    {
        $data = array('oldpassword' => $old_password, 'newpassword' => $new_password);
        return $this->apiClientHandler("password", array('access_token' => $access_token), array('method' => 'put', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * Add email to account.
     *
     * @param $access_token
     * @param $email
     * @param $type
     * @param $verificationUrl
     * @param $email_template
     * @return type
     */
    public function addEmail($access_token, $email, $type, $verification_url = '', $email_template = '')
    {
        $data = array('Email' => $email, 'Type' => $type);
        return $this->apiClientHandler("email", array('access_token' => $access_token, 'verificationUrl' => $verification_url, 'emailTemplate' => $email_template), array('method' => 'post', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * Remove Email to account.
     *
     * @param $access_token
     * @param $email
     * @return type

     */
    public function removeEmail($access_token, $email)
    {
        $data = array('Email' => $email);
        return $this->apiClientHandler("email", array('access_token' => $access_token), array('method' => 'delete', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * Verify email .
     *
     * @param $vtoken
     * @param $url
     * @param $welcome_email_template
     * @return type
     */
    public function verifyEmail($vtoken, $url, $welcome_email_template = '')
    {
        return $this->apiClientHandler("email", array('VerificationToken' => $vtoken, 'url' => $url, 'welcomeEmailTemplate' => $welcome_email_template));
    }

    /**
     * check email exist.
     *
     * @param $email
     * @return type
     */
    public function checkAvailablityOfEmail($email)
    {
        return $this->apiClientHandler("email", array('email' => $email));
    }

    /**
     * change Username .
     *
     * @param $access_token
     * @param $username
     * @return type
     */
    public function changeUsername($access_token, $username)
    {

        return $this->apiClientHandler("username", array('access_token' => $access_token), array('method' => 'put', 'post_data' => json_encode(array('username' => $username)), 'content_type' => 'json'));
    }

    /**
     * check username.
     *
     * @param $username
     * @return type
     */
    public function checkUsername($username)
    {
        return $this->apiClientHandler("username", array('username' => $username));
    }

    /**
     * Link account.
     *
     * @param $access_token
     * @param $candidate_token
     * @return type
     */
    public function accountLink($access_token, $candidate_token)
    {
        $data = array('candidateToken' => $candidate_token);
        return $this->apiClientHandler("socialIdentity", array('access_token' => $access_token), array('method' => 'put', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * Unlink account.
     *
     * @param $access_token
     * @param $id
     * @param $provider
     * @return type
     */
    public function accountUnlink($access_token, $id, $provider)
    {
        $data = array('Provider' => $provider, 'ProviderId' => $id);
        return $this->apiClientHandler("socialIdentity", array('access_token' => $access_token), array('method' => 'delete', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }
    /**
     * Get Social Profile.
     *
     * @param $access_token
     * @param $email_template
     * @return type
     */
    public function getSocialProfile($access_token, $email_template = '')
    {
        return $this->apiClientHandler("socialIdentity", array('access_token' => $access_token, 'emailTemplate' => $email_template));
    }
    /**
     * check Phone number exist.
     *
     * @param $phone
     * @return type
     */
    public function checkAvailablityOfPhone($phone)
    {
        return $this->apiClientHandler("phone", array('phone' => $phone));
    }

    /**
     * Update phone number.
     *
     * @param $phone
     * @param string $sms_template
     * @return type
     */
    public function updatePhone($access_token, $phone, $sms_template = '')
    {
        return $this->apiClientHandler("phone", array('access_token' => $access_token, 'smsTemplate' => $sms_template), array('method' => 'put', 'post_data' => json_encode(array('phone' => $phone)), 'content_type' => 'json'));
    }

    /**
     * Resend OTP.
     *
     * @param $phone
     * @param string $sms_template
     * @return type
     */
    public function resendOTP($phone, $sms_template = '')
    {
        return $this->apiClientHandler("phone/otp", array('smsTemplate' => $sms_template), array('method' => 'post', 'post_data' => json_encode(array('phone' => $phone)), 'content_type' => 'json'));
    }

    /**
     * Resend OTP by token.
     *
     * @param $access_token
     * @param $phone
     * @param string $sms_template
     * @return type
     */
    public function resendOTPByToken($access_token, $phone, $sms_template = '')
    {
        return $this->apiClientHandler("phone/otp", array('access_token' => $access_token, 'smsTemplate' => $sms_template), array('method' => 'post', 'post_data' => json_encode(array('phone' => $phone)), 'content_type' => 'json'));
    }

    /**
     * Verify OTP.
     *
     * @param $otp
     * @return type
     */
    public function verifyOTP($otp, $phone, $sms_template = '')
    {
        return $this->apiClientHandler("phone/otp", array('Otp' => $otp, 'smsTemplate' => $sms_template), array('method' => 'put', 'post_data' => json_encode(array('phone' => $phone)), 'content_type' => 'json'));        
    }

    /**
     * Verify OTP by token.
     *
     * @param $access_token
     * @param $otp
     * @return type
     */
    public function verifyOTPByToken($access_token, $otp) {
        return $this->apiClientHandler("phone/otp", array('access_token' => $access_token, 'Otp' => $otp, 'smsTemplate' => $sms_template), array('method' => 'put', 'post_data' => json_encode(array('phone' => '')), 'content_type' => 'json'));
    }

    /**
     * handle User APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $options = array())
    {
        return Functions::apiClient("/identity/v2/auth/" . $path, $query_array, $options);
    }

}
