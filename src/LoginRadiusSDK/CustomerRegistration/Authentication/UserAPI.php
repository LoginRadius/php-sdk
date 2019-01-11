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
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;

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
     * @param type $options
     */
    public function __construct($apikey = '', $apisecret = '', $options = array())
    {        
        new Functions($apikey, $apisecret, $options);
    }
    
    /**
     * This API creates a user in the database as well as sends a verification email to the user.
     * @param $payload = '{
         "FirstName": "",
         "LastName": "",
         "Password": "*********",
         "Email":[
         {
         "Type": "Primary",
         "Value": "xxx@xxxxxx.com"
         }
         ]}';  
     * @param string $verification_url  email verification url(Optional)
     * @param string $email_template email template name (Optional)
     * @param string $options Prevent verification email (Optional) 
     * @return {"isPosted": "true"}
     */    
        
    public function registerByEmail($payload, $verification_url = '', $email_template = '', $options = '', $fields = '*') {
        $accountObj = new AccountAPI();
        $response = $accountObj->generateSOTT();  
        if(!is_object($response)) {
            $response = json_decode($response);
        }
        return $this->apiClientHandler("register", array('verificationurl' => $verification_url, 'emailtemplate' => $email_template, 'options' => $options, 'fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json', 'X-LoginRadius-Sott' => $response->Sott));
    }
     
    /**
     * This API retrieves a copy of the user data based on the Email.
     * @param $payload =
       '{
       "email":"xxxx@xxxx.com",
       "password": "xxxxxxxx",
       "securityanswer": ""
       }';
     * @param string $verification_url  email verification url (Optional)
     * @param string $login_url url from where user is going login (Optional)
     * @param string $email_template email template name (Optional)
     * @param string $g_recaptcha_response It is only required for locked accounts when logging in (Optional)
     * @return type userprofile object
     */
    public function authLoginByEmail($payload, $verification_url = '', $login_url = '', $email_template = '', $g_recaptcha_response = '', $fields = '*') {
        return $this->apiClientHandler("login", array('verificationUrl' => $verification_url, 'loginUrl' => $login_url, 'emailTemplate' => $email_template, 'g-recaptcha-response' => $g_recaptcha_response, 'fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }
 
    /**
     * This API retrieves a copy of the user data based on the username.
     *   
     * @param $payload=
       '{
       "username":"xxxxxx",
       "password": "xxxxxxxx",
       "securityanswer": ""
       }';
     * @param string $verification_url  email verification (Optional)
     * @param string $login_url url from where user is going login (Optional)
     * @param string $email_template email template name (Optional)
     * @param string $g_recaptcha_response It is only required for locked accounts when logging in (Optional)
     * @return type userprofile object
     */
    public function authLoginByUsername($payload, $verification_url = '', $login_url = '', $email_template = '', $g_recaptcha_response = '', $fields = '*') {
        return $this->apiClientHandler("login", array('verificationUrl' => $verification_url, 'loginUrl' => $login_url, 'emailTemplate' => $email_template, 'g-recaptcha-response' => $g_recaptcha_response, 'fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }
    
    /**
     * Add email to account.
     *
     * @param $access_token (Required)
     * @param $email  Email to be added to the user's account(Required)
     * @param $type  String to identify the type of email(Required)
     * @param $verificationUrl  Email verification url(Optional)
     * @param $email_template  Name of the email template(Optional)
     * @return type
     */
    public function addEmail($access_token, $email, $type, $verification_url = '', $email_template = '', $fields = '*') {
        return $this->apiClientHandler("email", array('verificationurl' => $verification_url, 'emailtemplate' => $email_template, 'fields' => $fields), array('method' => 'POST', 'post_data' => array('email' => $email, 'type' => $type), 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
    
    /**
     * Forgot password
     *
     * @param $email
     * @param $reset_password_url
     * @param $email_template (Optional)
     * @return type
     */
    public function forgotPassword($email, $reset_password_url, $email_template = '', $fields = '*') {
        return $this->apiClientHandler("password", array('resetpasswordurl' => $reset_password_url, 'emailtemplate' => $email_template, 'fields' => $fields), array('method' => 'POST', 'post_data' => array('email' => $email), 'content_type' => 'json'));
    }
        
    /**
     * check email exist.
     *
     * @param $email
     * @return type
     */
    public function checkAvailablityOfEmail($email, $fields = '*') {
        return $this->apiClientHandler("email", array('email' => $email, 'fields' => $fields));
    }
    
    /**
     * check username.exist
     *
     * @param $username
     * @return type
     */
    public function checkUsername($username, $fields = '*') {
        return $this->apiClientHandler("username", array('username' => $username, 'fields' => $fields));
    }
    
    /**
     * Get profile by access token.
     *
     * @param $access_token
     * @return userprofile object
     */
    public function getProfile($access_token, $fields = '*') {
        return $this->apiClientHandler("account", array('fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }
    
    /**
     * This API is used update the privacy policy stored in the user's profile.
     *
     * @param $access_token
     * @return userprofile object
     */
    public function privacyPolicyAccept($access_token, $fields = '*') {
        return $this->apiClientHandler("privacypolicy/accept", array('fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }
    
    /**
     * This API will send welcome email.
     *
     * @param $access_token
     * @param $welcome_email_template
     * @return IsPosted object
     */
    public function sendWelcomeEmail($access_token, $welcome_email_template = '', $fields = '*') {
        return $this->apiClientHandler("account/sendwelcomeemail", array('welcomeemailtemplate' => $welcome_email_template, 'fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }    
    
    /**
     * Get Social Profile.
     *
     * @param $access_token
     * @param $fields
     * @return type
     */
    public function getSocialProfile($access_token, $fields = '*') {
        return $this->apiClientHandler("socialidentity", array('fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }
        
    /**
     * Validates access token,if valid then returns a response with its expiry otherwise error
     *
     * @param $access_token     * 
     * @return object type
     */
    public function checkTokenValidity($access_token, $fields = '*') {
        return $this->apiClientHandler("access_token/validate", array('fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }
    
    /**
     * Verify email     *
     * @param $vtoken
     * @param $url
     * @param $welcome_email_template
     * @return type
     */
    public function verifyEmail($vtoken, $url = '', $welcome_email_template = '', $fields = '*') {
        return $this->apiClientHandler("email", array('verificationtoken' => $vtoken, 'url' => $url, 'welcomeemailtemplate' => $welcome_email_template, 'fields' => $fields));
    }
    
    /**
     * Delete Account.
     *
     * @param $deletetoken
     * @return type
     */
    public function deleteAccount($deletetoken, $fields = '*') {
        return $this->apiClientHandler("account/delete", array('deletetoken' => $deletetoken, 'fields' => $fields));
    }
    
    /**
     * Invalidates access token or expires an access token validity.
     *
     * @param $access_token     * 
     * @return "IsPosted": "true"
     */
    public function invalidateTokenByAccessToken($access_token, $fields = '*') {
        return $this->apiClientHandler("access_token/invalidate", array('fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }
    
    /**
     * This API is used to retrieve the list of questions using access token.
     *
     * @param string $access_token
     * @param $fields  
     * @return type json object
     */
    public function getSecurityQuestionsByAccessToken($access_token, $fields = '*') {
        return $this->apiClientHandler("securityquestion/accesstoken", array('fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }    
    
    /**
     * This API is used to retrieve the list of questions using email.
     *
     * @param type $email
     * @param type $fields
     * @return type json object
     */
    public function getSecurityQuestionsByEmail($email, $fields = '*') {
        return $this->apiClientHandler("securityquestion/email", array('email' => $email, 'fields' => $fields));
    }    
    
    /**
     * This API is used to retrieve the list of questions using username.
     *
     * @param string $username 
     * @param $fields  
     * @return type json object
     */
    public function getSecurityQuestionsByUserName($username, $fields = '*') {
        return $this->apiClientHandler("securityquestion/username", array('username' => $username, 'fields' => $fields));
    }

    /**
     * This API is used to retrieve the list of questions using phone id.
     *
     * @param string $phone 
     * @param $fields
     * @return type json object
     */
    public function getSecurityQuestionsByPhone($phone, $fields = '*') {
        return $this->apiClientHandler("securityquestion/phone", array('phone' => $phone, 'fields' => $fields));
    }   
    
    /**
     * Verify email by OTP .
     *
     * @param $payload json data
     * @param $url Mention URL to log the main URL(Domain name) in Database(Optional)
     * @param $welcome_email_template  Email template for welcome email(Optional)
     * @return type
     */
    public function verifyEmailByOtp($payload, $url = '', $welcome_email_template = '', $fields = '*') {
        return $this->apiClientHandler("email", array('url' => $url, 'welcomeemailtemplate' => $welcome_email_template, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json'));
    }
    
    /* Change Account Password.
     *
     * @param $access_token
     * @param $old_password
     * @param $new_password
     * @return type
     */

    public function changeAccountPassword($access_token, $old_password, $new_password, $fields = '*') {
        $data = array('oldpassword' => $old_password, 'newpassword' => $new_password);
        return $this->apiClientHandler("password/change", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }   
    
    /**
     * Link account.
     *
     * @param $access_token
     * @param $candidate_token
     * @return type
     */
    public function accountLink($access_token, $candidate_token, $fields = '*') {
        $data = array('candidatetoken' => $candidate_token);
        return $this->apiClientHandler("socialidentity", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }    
    
    /**
     * This api used to resend email verification link.
     *
     * @param $email
     * @param string $verification_url
     * @param string $email_template
     * @return {"isPosted": "true"}
     */
    public function resendEmailVerification($email, $verification_url = '', $email_template = '', $fields = '*') {
        return $this->apiClientHandler("register", array('verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'fields' => $fields), array('method' => 'PUT', 'post_data' => array('email' => $email), 'content_type' => 'json'));
    }    
    
    /**
     * Reset Password by reset token.
     *
     * @param $reset_token
     * @param $password
     * @param string $welcome_email_template (Optional)
     * @param string $reset_password_email_template (Optional)
     * @return type
     */
    public function resetPassword($reset_token, $password, $welcome_email_template = '', $reset_password_email_template = '', $fields = '*') {
        return $this->apiClientHandler("password/reset", array('fields' => $fields), array('method' => 'PUT', 'post_data' => array('resettoken' => $reset_token, 'password' => $password, 'welcomeEmailTemplate' => $welcome_email_template, 'resetpasswordemailtemplate' => $reset_password_email_template), 'content_type' => 'json'));
    }    
    
    /**
     * Reset Password by OTP.
     *
     * @param $password
     * @param $otp
     * @param $email
     * @param $welcome_email_template (Optional)
     * @param $reset_password_email_template (Optional)
     * @return type
     */
    public function resetPasswordByOtp($password, $otp, $email, $welcome_email_template = '', $reset_password_email_template = '', $fields = '*') {
        return $this->apiClientHandler("password/reset", array('fields' => $fields), array('method' => 'PUT', 'post_data' => array('password' => $password, 'otp' => $otp, 'email' => $email, 'welcomeemailtemplate' => $welcome_email_template, 'resetpasswordemailtemplate' => $reset_password_email_template), 'content_type' => 'json'));
    }
    
    /**
     * This API is used to reset password for the specified account By email.
     *
     * @param $payload =
       '{
       "securityanswer": {
       "cb7*******3e40ef8a****01fb****20": "Answer"
       },
       "email": "",
       "password": "xxxxxxxxxx",
       "resetpasswordemailtemplate": ""
       }';
     * @return {"IsPosted" : "true"}
     */    
    
    public function authResetPasswordBySecurityAnswerAndEmail($payload, $fields = '*') {
        return $this->apiClientHandler("password/securityanswer", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json'));
    }
    
    /**
     * This API is used to reset password for the specified account By phone.
     *
     * @param $payload = 
       '{
       "securityanswer": {
       "cb7*******3e40ef8a****01fb****20": "Answer"
       },
       "phone": "",
       "password": "xxxxxxxxxx",
       "resetpasswordemailtemplate": ""
       }';
     * @return {"IsPosted" : "true"}
     */    
    
    public function authResetPasswordBySecurityAnswerAndPhone($payload, $fields = '*') {
        return $this->apiClientHandler("password/securityanswer", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json'));
    }
    
    /**
     * This API is used to reset password for the specified account By UserName.
     *
     * @param $payload = 
       '{
       "securityanswer": {
       "cb7*******3e40ef8a****01fb****20": "Answer"
       },
       "userName": "",
       "password": "xxxxxxxxxx",
       "resetpasswordemailtemplate": ""
       }';
     * @return {"IsPosted" : "true"}
     */    
    
    public function authResetPasswordBySecurityAnswerAndUserName($payload, $fields = '*') {
        return $this->apiClientHandler("password/securityanswer", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json'));
    }    
    
    /**
     * change Username .
     *
     * @param $access_token
     * @param $username
     * @return type
     */
    public function changeUsername($access_token, $username, $fields = '*') {
        return $this->apiClientHandler("username", array('fields' => $fields), array('method' => 'PUT', 'post_data' => array('username' => $username), 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }

   /**
    * Update user profile by access token.
    * @param $access_token
    * @param $payload = '{
        "Prefix":"",
        "FirstName":"Joe",
        "MiddleName":null,
        "LastName":"Smith",
        "BirthDate":"10-12-1985",
        "Gender":"M",
        "Website":null
       }';
    * @param string $verification_url (Optional)
    * @param string $email_template (Optional)
    * @param string $sms_template (Optional)
    * @return type object
   */
 
    public function updateProfile($access_token, $payload, $verification_url = '', $email_template = '', $sms_template = '', $fields = '*') {
        return $this->apiClientHandler("account", array('verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'smstemplate ' => $sms_template ,'fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
    
    /**
     * This API is used to update security questions by the access token.
     * @param string $access_token 
     * @param $payload  =
     * '{
     * "securityquestionanswer": {
     * "db7****8a73e4******bd9****8c20": "Answer"
     * }
     * }';
     * @return type json object
     */
    public function updateSecurityQuestionByAccessToken($access_token, $payload, $fields = '*') {
        return $this->apiClientHandler("account", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }

    /**
     * Delete account after email confirmation.
     *
     * @param $access_token
     * @param string $deleteUrl
     * @param string $email_template
     * @return type
     */
    public function deleteAccountByEmailConfirmation($access_token, $delete_url = '', $email_template = '', $fields = '*') {
        return $this->apiClientHandler('account', array('deleteUrl' => $delete_url, 'emailTemplate' => $email_template, 'fields' => $fields), array('method' => 'DELETE', 'post_data' => true, 'access-token' => "Bearer ".$access_token));
    }

    /**
     * Remove Email to account.
     *
     * @param $access_token
     * @param $email string "xxx@xxxxxxx.com"
     * @return type

     */
    public function removeEmail($access_token, $email, $fields = '*') {
        $data = array('Email' => $email);
        return $this->apiClientHandler("email", array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
  
    /**
     * Unlink account.
     *
     * @param $access_token
     * @param $provider_id Unique ID of the linked account
     * @param $provider Name of the provider
     * @return type
     */    
    public function accountUnlink($access_token, $provider_id, $provider, $fields = '*') {
        $data = array('Provider' => $provider, 'ProviderId' => $provider_id);
        return $this->apiClientHandler("socialidentity", array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
    
    /* Custom Registration Data */

    /**
     * This API allows you to validate code for a particular dropdown member.
     *
     * @param json $payload      
     * @return type json object
     */
    public function validateRegistrationDataCode($payload, $fields = '*') {
        return $this->apiClientHandler("registrationdata/validatecode", array('fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }

    /**
     * This API is used to retrieve dropdown data.
     *
     * @param $type  
     * @param string $parentid    
     * @param string $skip    
     * @param string $limit    
     * @return type json object
     */
    public function authGetRegistrationDataServer($type, $parent_id = '', $skip = '', $limit = '', $fields = '*') {
        return $this->apiClientHandler("registrationdata/" . $type, array('parentid' => $parent_id, 'skip' => $skip, 'limit' => $limit, 'fields' => $fields));
    }
       
        
    /* Password Less Login API's */
    
    /**
     * This API is used to send a Passwordless Login verification link to the provided Email ID.
     *
     * @param $email  
     * @param string $passwordlesslogintemplate (Optional)
     * @param string $verificationurl (Optional)
     * @return type {"IsPosted": true}
     */
    public function passwordLessLoginByEmail($email, $verificationurl = '', $passwordlesslogintemplate = '') {
        return $this->apiClientHandler("login/passwordlesslogin/email", array('email' => $email, 'passwordlesslogintemplate' => $passwordlesslogintemplate, 'verificationurl' => $verificationurl));
    }
   
    /**
     * This API is used to send a Passwordless Login Verification Link to a user by providing their UserName.
     *
     * @param $username  
     * @param string $passwordlesslogintemplate  (Optional)
     * @param string $verificationurl (Optional)
     * @return type {"IsPosted": true}
     */
    public function passwordLessLoginByUserName($username, $verificationurl = '', $passwordlesslogintemplate = '') {
        return $this->apiClientHandler("login/passwordlesslogin/email", array('username' => $username, 'passwordlesslogintemplate' => $passwordlesslogintemplate, 'verificationurl' => $verificationurl));
    }

    /**
     * This API is used to verify the Passwordless Login verification link.
     *
     * @param $verificationtoken  
     * @param string $welcomeemailtemplate (Optional)   
     * @return type object
     */
    public function passwordLessLoginVerification($verificationtoken, $welcomeemailtemplate = '') {
        return $this->apiClientHandler("login/passwordlesslogin/email/verify", array('verificationtoken' => $verificationtoken, 'welcomeemailtemplate' => $welcomeemailtemplate));
    }    
          
    /**
     * API can be used to send a One-time Passcode.
     *
     * @param $phone
     * @param $sms_template (Optional)
     * @return type object
     */
    public function phoneSendOtp($phone, $sms_template = '') {
        return $this->apiClientHandler("login/passwordlesslogin/otp", array('phone' => $phone, 'smstemplate' => $sms_template));
    }  
    
    /**
     * This API verifies an account by OTP and allows the user to login.
     *
     * @param $data
     * @param $sms_template (Optional)
     * @return type object
     */
    public function phoneLoginByOtp($data, $sms_template = '') {
        return $this->apiClientHandler("login/passwordlesslogin/otp/verify", array('smstemplate' => $sms_template), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }
  
    /* Smart Login API's */
     
     /**
     * This API sends a Smart Login link to the user's Email Id.
     * 
     * @param type $clientguid
     * @param type $email
     * @param type $smartloginemailtemplate (Optional)
     * @param type $welcomeemailtemplate (Optional)
     * @param type $redirecturl (Optional)
     * @return type {"IsPosted": true}
     */
    public function smartLoginByEmail($clientguid, $email, $smartloginemailtemplate = "", $welcomeemailtemplate = "", $redirecturl = "") {
        return $this->apiClientHandler("login/smartlogin", array('email' => $email, 'clientguid' => $clientguid,
              'smartloginemailtemplate' => $smartloginemailtemplate,
              'welcomeemailtemplate' => $welcomeemailtemplate,
              'redirecturl' => $redirecturl)
        );
    }    
    
    /**
     * This API sends a Smart Login link to the user's Email Id.
     * 
     * @param type $clientguid
     * @param type $username
     * @param type $smartloginemailtemplate (Optional)
     * @param type $welcomeemailtemplate (Optional)
     * @param type $redirecturl (Optional)
     * @return type {"IsPosted": true}
     */
    public function smartLoginByUserName($clientguid, $username, $smartloginemailtemplate = "", $welcomeemailtemplate = "", $redirecturl = "") {
        return $this->apiClientHandler("login/smartlogin", array('username' => $username,
              'clientguid' => $clientguid, 'smartloginemailtemplate' => $smartloginemailtemplate,
              'welcomeemailtemplate' => $welcomeemailtemplate, 'redirecturl' => $redirecturl)
        );
    }    
   
    /**
     * This API is used to check if the Smart Login link has been clicked or not.
     * 
     * @param type $clientguid 
     * @return type object
     */
    public function smartLoginPing($clientguid) {
        return $this->apiClientHandler("login/smartlogin/ping", array('clientguid' => $clientguid));
    }   
      
    /**
     * This API verifies the provided token for Smart Login.
     * 
     * @param type $verificationtoken 
     * @param type $welcomeemailtemplate (Optional)
     * @return type {"IsPosted": true,"IsVerified": true}
     */
    public function smartLoginVerifyToken($verificationtoken, $welcomeemailtemplate = "") {
        return $this->apiClientHandler("email/smartlogin", array('verificationtoken' => $verificationtoken,
              'welcomeemailtemplate' => $welcomeemailtemplate)
        );
    }        
    
    /* One Touch Login API's */
    
     /**
     * This API is used to send a link to a specified email for a frictionless login/registration
     *
     * @param $payload = '{
            "clientguid": "",
            "email": "",
            "name": "",
            "qq_captcha_ticket": "",
            "qq_captcha_randstr": "",
            "g-recaptcha-response ": ""
        }';
     * @param type $redirecturl  (Optional)
     * @param type $onetouchloginemailtemplate (Optional)
     * @param type $welcomeemailtemplate (Optional)
     * @return {"isPosted" : true}     
     */
    
    public function oneTouchLoginByEmail($payload, $redirecturl = '', $onetouchloginemailtemplate = '', $welcomeemailtemplate = '') {
        return $this->apiClientHandler("onetouchlogin/email", array('redirecturl' => $redirecturl, 'onetouchloginemailtemplate' => $onetouchloginemailtemplate, 'welcomeemailtemplate' => $welcomeemailtemplate), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }    
    
    /**
     * This API is used to send one time password to a given phone number for a frictionless login/registration.
     *
     * @param $payload = '{
        "phone": "",
        "name": "",
        "qq_captcha_ticket": "",
        "qq_captcha_randstr": "",
        "g-recaptcha-response ": ""
      }'
     * @param string $smstemplate (Optional)
     * @return type object
     */
    public function oneTouchLoginByPhone($payload, $smstemplate = '') {
         return $this->apiClientHandler("onetouchlogin/phone", array('smstemplate' => $smstemplate), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }  
    
    /**
     * This API is used to verify the otp for One Touch Login.
     *     
     * @param $otp  = "xxxxxx"
     * @param $phone  = "xxxxxxxxx"
     * @param $sms_template  (Optional)
     * @return type object
     */
    public function oneTouchOtpVerification($otp, $phone, $sms_template = '') {
        return $this->apiClientHandler("onetouchlogin/phone/verify", array('otp' => $otp, 'smstemplate' => $sms_template), array('method' => 'PUT', 'post_data' => array('phone' => $phone), 'content_type' => 'json'));
    }   
    
    /* Phone Authentication API's */
    
    /**
     * This API retrieves a copy of the user data based on the Phone.
     *   
     * @param $payload = '{
       "phone":"xxxxxxxxxx",
       "password": "xxxxxxxx",
       "securityanswer": ""
       }';    
     * @param string $login_url url from where user is going login
     * @param string $sms_template sms template name
     * @param string $g_recaptcha_response It is only required for locked accounts when logging in
     * @return type userprofile object
     */
    public function authLoginByPhone($payload, $login_url = '', $sms_template = '', $g_recaptcha_response = '', $fields = '*') {
        return $this->apiClientHandler("login", array('loginUrl' => $login_url, 'smstemplate' => $sms_template, 'g-recaptcha-response' => $g_recaptcha_response, 'fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }  
  
    /**
     * Phone Forgot password By OTP
     *
     * @param $phone = "xxxxxxxx" The Registered Phone Number
     * @param $sms_template  (Optional)
     * @return type object
     */
    public function forgotPasswordByOtp($phone, $sms_template = '') {
        return $this->apiClientHandler("password/otp", array('smstemplate' => $sms_template), array('method' => 'POST', 'post_data' => array('phone' => $phone), 'content_type' => 'json'));
    }
    
    /**
     * Phone Resend OTP.
     *
     * @param $phone = "xxxxxxxx" The Registered Phone Number
     * @param string $sms_template (Optional)
     * @return type object
     */
    public function resendOTP($phone, $sms_template = '') {
        return $this->apiClientHandler("phone/otp", array('smsTemplate' => $sms_template), array('method' => 'POST', 'post_data' => array('phone' => $phone), 'content_type' => 'json'));
    }
    
    /**
     * Phone Resend OTP by token.
     *
     * @param $access_token
     * @param $phone = "xxxxxxxx" The Registered Phone Number
     * @param string $sms_template (Optional)
     * @return type object
     */
    public function resendOTPByToken($access_token, $phone, $sms_template = '') {
        return $this->apiClientHandler("phone/otp", array('smsTemplate' => $sms_template), array('method' => 'POST', 'post_data' => array('phone' => $phone), 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
    
    /**
     * This API used to register a user using phone.
     *
     * @param $payload = '{
         "FirstName": "",
         "PhoneId": "**************",
         "Password": "*********",
         "Email":[
         {
         "Type": "Primary",
         "Value": "xxx@xxxxxx.com"
         }
         ]}';
     * @param string $verification_url  email verification
     * @param string $sms_template email template name    
     * @return {"isPosted": "true"}
     */
    public function registerByPhone($payload, $verification_url = '', $sms_template = '', $options = '') {
        $accountObj = new AccountAPI();
        $response = $accountObj->generateSOTT(); 
        if(!is_object($response)) {
            $response = json_decode($response);
        }
        return $this->apiClientHandler("register", array('verificationurl' => $verification_url, 'smstemplate' => $sms_template, 'options' => $options), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json', 'X-LoginRadius-Sott' => $response->Sott));
    }
    
    /**
     * Check Phone number exist.
     *
     * @param $phone = "xxxxxxxxx" The Registered Phone Number
     * @return type {"IsExist": true}
     */
    public function checkAvailablityOfPhone($phone) {
        return $this->apiClientHandler("phone", array('phone' => $phone));
    }
       
    /**
     * Update phone number.
     *
     * @param $access_token
     * @param $phone = "xxxxxxxx" New Phone number
     * @param string $sms_template (Optional)
     * @return type object
     */
    public function updatePhone($access_token, $phone, $sms_template = '') {
        return $this->apiClientHandler("phone", array('smsTemplate' => $sms_template), array('method' => 'PUT', 'post_data' => array('phone' => $phone), 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
    
    /**
     * Phone reset password by OTP.
     *
     * @param $phone  The Registered Phone Number
     * @param $otp  The Verification Code
     * @param $password  New password
     * @param $sms_template  SMS Template Name (Optional)
     * @param $reset_password_email_template  Reset Password Email Template (Optional)
     * @return type {"IsPosted": true}
     */
    public function phoneResetPasswordByOtp($phone, $otp, $password, $sms_template = '', $reset_password_email_template = '') {
        return $this->apiClientHandler("password/otp", array(), array('method' => 'PUT', 'post_data' => array('phone' => $phone, 'otp' => $otp, 'password' => $password, 'smstemplate' => $sms_template, 'resetpasswordemailtemplate' => $reset_password_email_template), 'content_type' => 'json'));
    }

    /**
     * Phone Verify OTP.
     *
     * @param $otp = 'xxxxxxxxx'
     * @param $phone = 'xxxxxxxxxxx'
     * @param $sms_template (Optional)
     * @return type object
     */
    public function verifyOTP($otp, $phone, $sms_template = '', $fields = '*') {
        return $this->apiClientHandler("phone/otp", array('otp' => $otp, 'smstemplate' => $sms_template, 'fields' => $fields), array('method' => 'PUT', 'post_data' => array('phone' => $phone), 'content_type' => 'json'));
    }

    /**
     * Verify OTP by token.
     *
     * @param $access_token = 'xxxxxxxxxxxx'
     * @param $otp = 'xxxxxx'
     * @param $sms_template (Optional)
     * @return type {"IsPosted": true}
     */
    public function verifyOTPByToken($access_token, $otp, $sms_template = '') {
        return $this->apiClientHandler("phone/otp", array('otp' => $otp, 'smstemplate' => $sms_template), array('method' => 'PUT', 'post_data' => array('phone' => ''), 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
   
    /** 
     * This API is used to delete the Phone ID.
     *
     * @param $access_token
     * @return type {"IsDeleted": true}
     */
    public function deletePhoneIdByAccessToken($access_token) {
        return $this->apiClientHandler("phone", array(), array('method' => 'DELETE', 'post_data' => true, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }    
    
        
    /* Multi Factor Authenctiation API's */    
    
    /**
     * This API used to provide multi factor login with email/password combination.
     * @param $payload =
       '{
       "email":"xxxx@xxxxxxx.com",
       "password": "xxxxxx"
       }';
     * @param string $login_url url from where user is going login (Optional)
     * @param string $verification_url  email verification (Optional)
     * @param string $email_template email template name (Optional)
     * @param string $sms_template_2fa sms template 2fa name (Optional)
     * @return type SecondFactorAuthentication object
     */
    
    public function mfaEmailLogin($payload, $login_url = '', $verification_url = '', $email_template = '', $sms_template_2fa = '', $fields = '*') {
        return $this->apiClientHandler("login/2fa", array('loginUrl' => $login_url, 'verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'smstemplate2fa' => $sms_template_2fa, 'fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }
     
    /**
     * This API used to provide multi factor login with username/password combination.
     *
     * @param $payload =
       '{
       "username":"xxxxxxx",
       "password": "xxxxxx"
       }';
     * @param string $login_url url from where user is going login (Optional)
     * @param string $verification_url  email verification (Optional)
     * @param string $email_template email template name (Optional)
     * @param string $sms_template_2fa sms template 2fa name (Optional)
     * @return type SecondFactorAuthentication object
     */
    public function mfaUserNameLogin($payload, $login_url = '', $verification_url = '', $email_template = '', $sms_template_2fa = '', $fields = '*') {
        return $this->apiClientHandler("login/2fa", array('loginUrl' => $login_url, 'verificationUrl' => $verification_url, 'emailTemplate' => $email_template, 'smstemplate2fa' => $sms_template_2fa, 'fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }
    
    /**
     * This API used to provide multi factor login with phone/password combination.
     * 
     * @param $payload =
       '{
       "phone":"xxxxxxx",
       "password": "xxxxxx"
       }';
     * @param string $login_url url from where user is going login (Optional)
     * @param string $verification_url  email verification (Optional)
     * @param string $sms_template sms template name (Optional)
     * @param string $sms_template_2fa sms template 2fa name (Optional)
     * @return type SecondFactorAuthentication object
     */
    public function mfaPhoneLogin($payload, $login_url = '', $verification_url = '', $sms_template = '', $sms_template_2fa = '', $fields = '*') {
        return $this->apiClientHandler("login/2fa", array('loginUrl' => $login_url, 'verificationUrl' => $verification_url, 'smsTemplate' => $sms_template, 'smstemplate2fa' => $sms_template_2fa, 'fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }  
    
    /**
     * MFA Validate Access Token
     * This API is used to configure the multi-factor-authentication after login by using the access token
     *
     * @param $access_token
     * @param string $sms_template_2fa (Optional)
     * @return type object
     */
    public function mfaValidateAccessToken($access_token, $sms_template_2fa = '', $fields = '*') {
        return $this->apiClientHandler("account/2fa", array('smstemplate2fa' => $sms_template_2fa, 'fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }   
          
    /**
     * MFA Backup Code by Access Token
     * 
     * @param type $access_token
     * @return type backup codes object
     */
    public function getBackupCodeForLoginbyAccessToken($access_token, $fields = '*') {
        return $this->apiClientHandler("account/2fa/backupcode", array('fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }        
         
    /**
     * Reset Back Up code by access token
     * 
     * @param type $access_token
     * @return type
     */
    public function resetBackupCodebyAccessToken($access_token, $fields = '*') {
        return $this->apiClientHandler("account/2fa/backupcode/reset", array('fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }  
   
    /**
     * MFA Validate Backup code
     * @param type $second_factor_auth_token  Second factor authentication token
     * @param type $backupcode = 'xxxxxxxx'  Backup Code for login
     * @return type
     */
    public function getLoginbyBackupCode($second_factor_auth_token, $backupcode, $fields = '*') {
        $data = array('backupcode' => $backupcode);
        return $this->apiClientHandler("login/2fa/verification/backupcode", array('SecondFactorAuthenticationToken' => $second_factor_auth_token, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }
    
    /**
     * This API is used to log in by completing the multi-factor-authentication by passing the one time passcode.
     * @param $second_factor_auth_token
     * @param $payload json data
     * @param string $sms_template_2fa sms template 2fa name (optional)
     * @return type 
     */
    
    public function mfaValidateOtp($second_factor_auth_token, $payload, $sms_template_2fa = '', $fields = '*') {
        return $this->apiClientHandler("login/2fa/verification/otp", array('SecondFactorAuthenticationToken' => $second_factor_auth_token, 'smstemplate2fa' => $sms_template_2fa, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json'));
    }
    
    /**
     * This API is used to log in by completing the multi-factor-authentication by passing the google authenticator code.
     * @param $second_factor_auth_token
     * @param  $google_auth_code  'xxxxxxxxxx' The code generated by google authenticator app.
     * @param  $sms_template_2fa  SMS Template Name (optional)
     * @return type 
     */
    
    public function mfaValidateGoogleAuthCode($second_factor_auth_token, $google_auth_code, $sms_template_2fa = '', $fields = '*') {
        $data = array('googleauthenticatorcode' => $google_auth_code);
        return $this->apiClientHandler("login/2fa/verification/googleauthenticatorcode", array('SecondFactorAuthenticationToken' => $second_factor_auth_token, 'smstemplate2fa' => $sms_template_2fa, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }
    
    /**
     * This API is used to update the multi-factor-authentication phone number by sending the verification OTP to the provided phone number.
     *
     * @param $second_factor_auth_token
     * @param $phoneno2fa = 'xxxxxxxxxx'
     * @param string $sms_template_2fa (optional)
     * @return type
     */
    public function mfaUpdatePhoneNo($second_factor_auth_token, $phoneno2fa, $sms_template_2fa = '') {
        $data = array('phoneno2fa' => $phoneno2fa);
        return $this->apiClientHandler("login/2fa", array('SecondFactorAuthenticationToken' => $second_factor_auth_token, 'smstemplate2fa' => $sms_template_2fa), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to update the multi-factor-authentication phone number by sending the access token to the provided phone number.
     *
     * @param $access_token
     * @param $phoneno2fa = 'xxxxxxxxxx'
     * @param string $sms_template_2fa (optional)
     * @return type
     */
    public function mfaUpdatePhoneNoByToken($access_token, $phoneno2fa, $sms_template_2fa = '') {
        $data = array('phoneno2fa' => $phoneno2fa);
        return $this->apiClientHandler("account/2fa", array('smstemplate2fa' => $sms_template_2fa), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    } 
  
    /**
     * Update MFA by Access Token
     * This API is used to Enable Multi-factor authentication by access token on user login.
     *
     * @param $access_token
     * @param $google_auth_code = 'xxxxxxxxxx' The code generated by google authenticator app after scanning QR code
     * @param string $sms_template (optional) 
     * @return type 
     */
    
    public function updateMfaByGoogleAuthCode($access_token, $google_auth_code, $sms_template = '', $fields = '*') {
        $data = array('googleauthenticatorcode' => $google_auth_code); 
        return $this->apiClientHandler("account/2fa/verification/googleauthenticatorcode", array('smstemplate' => $sms_template, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }   
    
    /**
     * Update MFA Setting
     * This API is used to trigger the Multi-factor authentication settings after login for secure actions.
     *
     * @param $access_token     
     * @param $payload
     * @param string $sms_template (optional)  
     * @return type 
     */
    
    public function updateMfaByOtp($access_token, $payload, $sms_template = '', $fields = '*') {
        return $this->apiClientHandler("account/2fa/verification/otp", array('smstemplate' => $sms_template, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }  
   
    /**
     * MFA Reset Google Authenticator by Token
     * This API Removes/Reset Google Authenticator By Token.
     *
     * @param $access_token
     * @param $googleauthenticator  pass boolean(true) to remove Google Authenticator
     * @return {"IsDeleted": "true"}
     */
    public function resetGoogleAuthenticatorByToken($access_token, $googleauthenticator, $fields = '*') {
        $data = array('googleauthenticator' => $googleauthenticator);
        return $this->apiClientHandler("account/2fa/authenticator", array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
    
    /**
     * MFA Reset SMS Authenticator by Token
     * This API Removes/Reset SMS Authenticator By Token.
     *
     * @param $access_token
     * @param $otpauthenticator pass boolean(true) to remove SMS Authenticator
     * @return "IsDeleted": "true"
     */
    public function resetSMSAuthenticatorByToken($access_token, $otpauthenticator, $fields = '*') {
        $data = array('otpauthenticator' => $otpauthenticator);
        return $this->apiClientHandler("account/2fa/authenticator", array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }    
    
    /* Re-Authentication API */
    
    /**
     * Multi Factor Re-Authenticate
     * This API can be used to trigger Multi-Factor Autentication workflow for the provided access_token.
     * @param $access_token
     * @param $sms_template_2fa (optional)
     * @return type 
     */
    
    public function mfaReAuthentiation($access_token, $sms_template_2fa = '', $fields = '*') {
        return $this->apiClientHandler("account/reauth/2fa", array('smstemplate2fa' => $sms_template_2fa, 'fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }
    
    /**
     * Validate MFA by Google Authenticator Code
     * This API is used to re-authenticate via Multi-factor-authentication by passing the google authenticator code.
     * @param $access_token
     * @param $google_authenticator = 'xxxxxxxxxx'
     * @return type 
     */
    
    public function validateMfaByGoogleAuthCode($access_token, $google_authenticator, $fields = '*') {
        $data = array('googleauthenticatorcode' => $google_authenticator);
        return $this->apiClientHandler("account/reauth/2fa/googleauthenticatorcode", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
       
    /**
     * Validate MFA by Backup Code
     * This API is used to re-authenticate by set of backup codes via access token.
     * @param $access_token 
     * @param $backupcode = 'xxxxxxxx'
     * @return type 
     */
    
    public function validateMfaByBackupCode($access_token, $backupcode, $fields = '*') {
        $data = array('backupcode' => $backupcode);
        return $this->apiClientHandler("account/reauth/2fa/backupcode", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }    
    
    /**
     * Validate MFA by OTP
     * This API is used to re-authenticate via Multi-factor authentication by passing the One Time Password received via SMS.
     * @param $access_token
     * @param $payload json data 
     * @param string $sms_template_2fa (Optional)
     * @return type 
     */
    
    public function validateMfaByOtp($access_token, $payload, $sms_template_2fa = '', $fields = '*') {
        return $this->apiClientHandler("account/reauth/2fa/otp", array('smstemplate' => $sms_template_2fa, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }  
    /**
     * This API can be used to verify event based multi factor authentication by Password.
     * @param $access_token
     * @param $payload json data
     * @param string $sms_template_2fa (Optional)
     * @return type 
     */
    
    public function validateMfaByPassword($access_token, $payload, $sms_template_2fa = '', $fields = '*') {
        return $this->apiClientHandler("account/reauth/password", array('smstemplate' => $sms_template_2fa, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }
          
    /**
     * Handle User APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    
    private function apiClientHandler($path, $query_array = array(), $options = array()) {
        return Functions::apiClient("/identity/v2/auth/" . $path, $query_array, array_merge(array('authentication' => 'key'), $options));
    }
}