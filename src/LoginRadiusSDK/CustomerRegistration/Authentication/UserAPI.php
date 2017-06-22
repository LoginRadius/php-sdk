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
class UserAPI {

    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array()) {
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
    public function loginByEmail($email, $password, $verification_url = '', $login_url = '', $email_template = '', $g_recaptcha_response = '') {
        return $this->apiClientHandler("login", array('email' => $email, 'password' => $password, 'verificationUrl' => $verification_url, 'loginUrl' => $login_url, 'emailTemplate' => $email_template, 'g-recaptcha-response' => $g_recaptcha_response));
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
    public function loginByUsername($username, $password, $verification_url = '', $login_url = '', $email_template = '', $g_recaptcha_response = '') {
        return $this->apiClientHandler("login", array('username' => $username, 'password' => $password, 'verificationUrl' => $verification_url, 'loginUrl' => $login_url, 'emailTemplate' => $email_template, 'g-recaptcha-response' => $g_recaptcha_response));
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
    public function loginByPhone($phone, $password, $verification_url = '', $login_url = '', $sms_template = '', $g_recaptcha_response = '') {
        return $this->apiClientHandler("login", array('phone' => $phone, 'password' => $password, 'verificationUrl' => $verification_url, 'loginUrl' => $login_url, 'smsTemplate' => $sms_template, 'g-recaptcha-response' => $g_recaptcha_response));
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
    public function register($userprofile, $verification_url = '', $email_template = '', $sms_template = '') {
        $sott = new SOTT();
        $encrypt = $sott->encrypt();
        return $this->apiClientHandler("register", array('sott' => $encrypt, 'verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'smsTemplate' => $sms_template), array('method' => 'post', 'post_data' => $userprofile, 'content_type' => 'json'));
    }

    /**
     * This api used to resend email verification link.
     *
     * @param $email
     * @param string $verification_url
     * @param string $email_template
     * @return {"isPosted": "true"}
     */
    public function resendEmailVerification($email, $verification_url = '', $email_template = '') {
        return $this->apiClientHandler("register", array('verificationUrl' => $verification_url, 'emailTemplate' => $email_template), array('method' => 'put', 'post_data' => json_encode(array('email' => $email)), 'content_type' => 'json'));
    }

    /**
     * Get profile by access token.
     *
     * @param $access_token
     * @return userprofile object
     */
    public function getProfile($access_token) {
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
    public function updateProfile($access_token, $data, $verification_url = '', $email_template = '') {
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
    public function deleteAccountByEmailConfirmation($access_token, $delete_url = '', $email_template = '') {
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
    public function forgotPassword($email, $reset_password_url, $email_template = '') {
        return $this->apiClientHandler("password", array('resetPasswordUrl' => $reset_password_url, 'emailTemplate' => $email_template), array('method' => 'post', 'post_data' => json_encode(array('email' => $email)), 'content_type' => 'json'));
    }

    /**
     * Forgot password By Otp
     *
     * @param $phone   
     * @param $sms_template
     * @return type
     */
    public function forgotPasswordByOtp($phone, $sms_template = '') {
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
    public function resetPassword($vtoken, $password, $welcome_email_template = '') {
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
    public function resetPasswordByOtp($phone, $otp, $password) {
        return $this->apiClientHandler("password/otp", array(), array('method' => 'put', 'post_data' => json_encode(array('phone' => $phone, 'otp' => $otp, 'password' => $password)), 'content_type' => 'json'));
    }

    /*     * Change Account Password.
     *
     * @param $access_token
     * @param $old_password
     * @param $new_password
     * @return type
     */

    public function changeAccountPassword($access_token, $old_password, $new_password) {
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
    public function addEmail($access_token, $email, $type, $verification_url = '', $email_template = '') {
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
    public function removeEmail($access_token, $email) {
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
    public function verifyEmail($vtoken, $url, $welcome_email_template = '') {
        return $this->apiClientHandler("email", array('VerificationToken' => $vtoken, 'url' => $url, 'welcomeEmailTemplate' => $welcome_email_template));
    }

    /**
     * check email exist.
     *
     * @param $email
     * @return type
     */
    public function checkAvailablityOfEmail($email) {
        return $this->apiClientHandler("email", array('email' => $email));
    }

    /**
     * change Username .
     *
     * @param $access_token
     * @param $username
     * @return type
     */
    public function changeUsername($access_token, $username) {

        return $this->apiClientHandler("username", array('access_token' => $access_token), array('method' => 'put', 'post_data' => json_encode(array('username' => $username)), 'content_type' => 'json'));
    }

    /**
     * check username.
     *
     * @param $username
     * @return type
     */
    public function checkUsername($username) {
        return $this->apiClientHandler("username", array('username' => $username));
    }

    /**
     * Link account.
     *
     * @param $access_token
     * @param $candidate_token
     * @return type
     */
    public function accountLink($access_token, $candidate_token) {
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
    public function accountUnlink($access_token, $id, $provider) {
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
    public function getSocialProfile($access_token, $email_template = '') {
        return $this->apiClientHandler("socialIdentity", array('access_token' => $access_token, 'emailTemplate' => $email_template));
    }

    /**
     * check Phone number exist.
     *
     * @param $phone
     * @return type
     */
    public function checkAvailablityOfPhone($phone) {
        return $this->apiClientHandler("phone", array('phone' => $phone));
    }

    /**
     * Update phone number.
     *
     * @param $phone
     * @param string $sms_template
     * @return type
     */
    public function updatePhone($access_token, $phone, $sms_template = '') {
        return $this->apiClientHandler("phone", array('access_token' => $access_token, 'smsTemplate' => $sms_template), array('method' => 'put', 'post_data' => json_encode(array('phone' => $phone)), 'content_type' => 'json'));
    }

    /**
     * Resend OTP.
     *
     * @param $phone
     * @param string $sms_template
     * @return type
     */
    public function resendOTP($phone, $sms_template = '') {
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
    public function resendOTPByToken($access_token, $phone, $sms_template = '') {
        return $this->apiClientHandler("phone/otp", array('access_token' => $access_token, 'smsTemplate' => $sms_template), array('method' => 'post', 'post_data' => json_encode(array('phone' => $phone)), 'content_type' => 'json'));
    }

    /**
     * Verify OTP.
     *
     * @param $otp
     * @return type
     */
    public function verifyOTP($otp, $phone, $sms_template = '') {
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
     * Validates access token,if valid then returns a response with its expiry otherwise error
     *
     * @param $access_token     * 
     * @return type
     */
    public function checkTokenValidity($access_token) {
        return $this->apiClientHandler("access_token/Validate", array('access_token' => $access_token));
    }

    /**
     * InValidates access token or expires an access token validity.
     *
     * @param $access_token     * 
     * @return "IsPosted": "true"
     */
    public function invalidateTokenByAccessToken($access_token) {
        return $this->apiClientHandler("access_token/InValidate", array('access_token' => $access_token));
    }

    /**
     * This api used to provide two-factor login with email/password combination.
     *
     * @param $email
     * @param $password    
     * @param string $login_url url from where user is going login
     * @param string $verification_url  email verification
     * @param string $email_template email template name
     * @param string $sms_template2FA sms template 2fa name
     * @return type SecondFactorAuthentication object
     */
    public function twoFALoginByEmail($email, $password, $login_url = '', $verification_url = '', $email_template = '', $sms_template2FA = '') {
        return $this->apiClientHandler("login/2fa", array('email' => $email, 'password' => $password, 'loginUrl' => $login_url, 'verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'smsTemplate2FA' => $sms_template2FA));
    }

    /**
     * This API can be used to verify the google authenticator code or otp to enable the two-factor-authentication.
     *
     * @param $access_token
     * @param $google_auth_code
     * @param $otp    
     * @param string $sms_template sms template name  
     * @return type 
     */
    public function verifyTwoFAGoogleAuthenticatorOrOtpByToken($access_token, $google_auth_code, $otp, $sms_template = '') {
        return $this->apiClientHandler("account/2fa/verification", array('access_token' => $access_token, 'googleAuthenticatorCode' => $google_auth_code, 'otp' => $otp, 'smsTemplate' => $sms_template));
    }

    /**
     * This api used to provide two-factor login with phone/password combination.
     *
     * @param $phone
     * @param $password
     * @param string $login_url url from where user is going login
     * @param string $verification_url  email verification
     * @param string $sms_template sms template name
     * @param string $sms_template2FA sms template 2fa name
     * @return type SecondFactorAuthentication object
     */
    public function twoFALoginByPhone($phone, $password, $login_url = '', $verification_url = '', $sms_template = '', $sms_template2FA = '') {
        return $this->apiClientHandler("login/2fa", array('phone' => $phone, 'password' => $password, 'loginUrl' => $login_url, 'verificationUrl' => $verification_url, 'smsTemplate' => $sms_template, 'smsTemplate2FA' => $sms_template2FA));
    }

    /**
     * This API is used to configure the two-factor-authentication after login by using the access token
     *
     * @param $access_token
     * @param string $sms_template2FA sms template 2fa name
     * @return type 
     */
    public function configureTwoFAByToken($access_token, $sms_template2FA = '') {
        return $this->apiClientHandler("account/2fa", array('access_token' => $access_token, 'smsTemplate2FA' => $sms_template2FA));
    }

    /**
     * This api used to provide two-factor login with username/password combination.
     *
     * @param $username
     * @param $password    
     * @param string $login_url url from where user is going login
     * @param string $verification_url  email verification
     * @param string $email_template email template name
     * @param string $sms_template2FA sms template 2fa name
     * @return type SecondFactorAuthentication object
     */
    public function twoFALoginByUsername($username, $password, $login_url = '', $verification_url = '', $email_template = '', $sms_template2FA = '') {
        return $this->apiClientHandler("login/2fa", array('username' => $username, 'password' => $password, 'loginUrl' => $login_url, 'verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'smsTemplate2FA' => $sms_template2FA));
    }

    /**
     * This API is used to log in by completing the two-factor-authentication by passing the google authenticator code or one time password
     *
     * @param $second_factor_auth_token
     * @param $google_auth_code
     * @param $otp    
     * @param string $sms_template2FA sms template 2fa name
     * @return type 
     */
    public function verifyTwoFAByGoogleAuthCodeOrOtp($second_factor_auth_token, $google_auth_code, $otp, $sms_template2FA = '') {
        return $this->apiClientHandler("login/2fa/verification", array('SecondFactorAuthenticationToken' => $second_factor_auth_token, 'googleAuthenticatorCode' => $google_auth_code, 'otp' => $otp, 'smsTemplate2FA' => $sms_template2FA));
    }

    /**
     * This API is used to update the two-factor-authentication phone number by sending the verification OTP to the provided phone number.
     *
     * @param $second_factor_auth_token
     * @param $data phoneno json.
     * @param string $sms_template2FA
     * @return type
     */
    public function twoFAUpdatePhoneNoByOtp($second_factor_auth_token, $data, $sms_template2FA = '') {
        return $this->apiClientHandler("login/2fa", array('SecondFactorAuthenticationToken' => $second_factor_auth_token, 'smsTemplate2FA' => $sms_template2FA), array('method' => 'put', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to update the two-factor-authentication phone number by sending the access token to the provided phone number.
     *
     * @param $access_token
     * @param $data phoneno json.
     * @param string $sms_template
     * @return type
     */
    public function twoFAUpdatePhoneNoByToken($access_token, $data, $sms_template = '') {
        return $this->apiClientHandler("account/2fa", array('access_token' => $access_token, 'smsTemplate' => $sms_template), array('method' => 'put', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API Removes/Reset Google Authenticator and SMS Authenticator By Token.
     *
     * @param $uid
     * @return "IsDeleted": "true"
     */
    public function removeOrResetGoogleAuthenticatorByToken($access_token, $otpauthenticator = false, $googleauthenticator = false) {

        $data = array('otpauthenticator' => $otpauthenticator, 'googleauthenticator' => $googleauthenticator);
        return $this->apiClientHandler("account/2fa/authenticator", array('access_token' => $access_token), array('method' => 'delete', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * Auto Login to any device after email verification by email
     * 
     * @param type $clientguid
     * @param type $email
     * @param type $autologinemailtemplate
     * @param type $welcomeemailtemplate
     * @return type
     */
    public function emailPromptAutoLoginbyEmail($clientguid, $email, $autologinemailtemplate = "", $welcomeemailtemplate = "") {
        return $this->apiClientHandler("login/autologin", array('email' => $email,
                    'clientguid' => $clientguid,
                    'autologinemailtemplate' => $autologinemailtemplate,
                    'welcomeemailtemplate' => $welcomeemailtemplate)
        );
    }

    /**
     * Auto Login to any device after email verification by username
     * 
     * @param type $clientguid
     * @param type $username
     * @param type $autologinemailtemplate
     * @param type $welcomeemailtemplate
     * @return type
     */
    public function emailPromptAutoLoginbyUserName($clientguid, $username, $autologinemailtemplate = "", $welcomeemailtemplate = "") {
        return $this->apiClientHandler("login/autologin", array('username' => $username,
                    'clientguid' => $clientguid,
                    'autologinemailtemplate' => $autologinemailtemplate,
                    'welcomeemailtemplate' => $welcomeemailtemplate)
        );
    }
    /**
     * Ping login api to verify user in different device.
     * 
     * @param type $clientguid // unique string that is already pass in function emailPromptAutoLoginbyEmail OR emailPromptAutoLoginbyUserName
     * @return type
     */
    public function emailPromptAutoLoginPing($clientguid) {
        return $this->apiClientHandler("login/autologin/ping", array('clientguid' => $clientguid));
    }
    /**
     * Get Backup code for login by access token
     * 
     * @param type $access_token // Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @return type
     */
    public function getBackupCodeForLoginbyAccessToken($access_token) {
        return $this->apiClientHandler("account/2fa/backupcode", array('access_token' => $access_token));
    }
    /**
     * Get login By Backup code
     * 
     * @param type $second_factor_auth_token 
     * @param type $backupcode 
     * @return type
     */
    public function getLoginbyBackupCode($second_factor_auth_token, $backupcode) {
        return $this->apiClientHandler("login/2fa/backupcode", array('SecondFactorAuthenticationToken' => $second_factor_auth_token,
                    'backupcode' => $backupcode)
        );
    }
    
    /**
     * Reset Back Up code by access token
     * 
     * @param type $access_token // Uniquely generated identifier key by LoginRadius that is activated after successful authentication
     * @return type
     */
    public function resetBackupCodebyAccessToken($access_token) {
        return $this->apiClientHandler("account/2fa/backupcode/reset", array('access_token' => $access_token));
    }    
    

    /**
     * handle User APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $options = array()) {
        return Functions::apiClient("/identity/v2/auth/" . $path, $query_array, $options);
    }

}
