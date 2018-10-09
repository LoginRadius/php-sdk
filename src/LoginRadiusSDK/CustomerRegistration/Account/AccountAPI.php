<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AccountAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Account;

use LoginRadiusSDK\Utility\Functions;

/**
 * Account API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Account API.
 */
class AccountAPI {

    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $options
     */
    public function __construct($apikey = '', $apisecret = '', $options = array()) {
        new Functions($apikey, $apisecret, $options);
    }

    /**
     * This API is create account.
     *
     * @param $payload = '{
      "FirstName":"",
      "LastName":"",
      "Password" : "*********",
      "Email":[
      {
      "Type":"Primary",
      "Value":"xxx@xxxxxx.com"
      }
      ]}';
     * @return type Object
     */
    public function create($payload, $fields = '*') {
        return $this->apiClientHandler("", array('fields' => $fields), array('method' => 'POST', 'post_data' => $payload, 'content_type' => 'json'));
    }

    /**
     * This API Returns an Email Verification token.
     * 
     * @param $email
     *
     * @return 
     */
    public function getEmailVerificationToken($email, $fields = '*') {
        return $this->apiClientHandler('/verify/token', array('fields' => $fields), array('method' => 'POST', 'post_data' => array('Email' => $email), 'content_type' => 'json'));
    }

    /**
     * This API Returns a forgot password token.
     * 
     * @param $email
     *
     * @return 
     */
    public function getForgotPasswordToken($email, $fields = '*') {
        return $this->apiClientHandler('/forgot/token', array('fields' => $fields), array('method' => 'POST', 'post_data' => array('Email' => $email), 'content_type' => 'json'));
    }

    /**
     * This API is used to Get Identities by Email Id.
     * 
     * @param $email
     * @return array
     */
    public function getIdentitiesByEmail($email, $fields = '*') {
        return $this->apiClientHandler('/identities', array('email' => $email, 'fields' => $fields));
    }

    /**
     * This API is used to retrieve Access Token based on UID or user impersonation API.
     *
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     *
     * return Array of user profile
     */
    public function getAccessTokenByUid($uid, $fields = '*') {
        return $this->apiClientHandler("/access_token", array('uid' => $uid, 'fields' => $fields));
    }

    /**
     * This API is used to get the password field of an account.
     *
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     *
     * return {passwordHash : passwordhash}
     */
    public function getHashPassword($uid, $fields = '*') {
        return $this->apiClientHandler("/" . $uid . "/password", array('fields' => $fields));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in email address.
     *
     * @param $email = 'example@doamin.com';
     *
     * return all user profile
     */
    public function getProfileByEmail($email, $fields = '*') {
        return $this->apiClientHandler('', array('email' => $email, 'fields' => $fields));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in username.
     *
     * @param $username = 'example';
     *
     * return all user profile
     */
    public function getProfileByUsername($username, $fields = '*') {
        return $this->apiClientHandler('', array('username' => $username, 'fields' => $fields));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in phone number.
     *
     * @param $phone = 'example';
     *
     * return all user profile
     */
    public function getProfileByPhone($phone, $fields = '*') {
        return $this->apiClientHandler('', array('phone' => $phone, 'fields' => $fields));
    }

    /**
     * This API is used to retrieve all of the profile data from each of the linked social provider accounts associated with the account. For ex: A user has linked facebook and google account then this api will retrieve both profile data.
     *
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     *
     * return Array of user profile
     */
    public function getProfileByUid($uid, $fields = '*') {
        return $this->apiClientHandler("/" . $uid, array('fields' => $fields));
    }

    /**
     * This API is used to set a password for an account. It does not require to know the previous(old) password.
     *
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     * @param $password = 'xxxxxxxxxx';
     *
     * return {PasswordHash : passwordhash}
     */
    public function setPassword($uid, $password, $fields = '*') {
        return $this->apiClientHandler("/" . $uid . "/password", array('fields' => $fields), array('method' => 'PUT', 'post_data' => array('password' => $password), 'content_type' => 'json'));
    }

    /**
     * This API is used to Modify/Update details of an existing user.
     *
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     * @param $payload = '{
      "Prefix":"",
      "FirstName":"",
      "MiddleName":null,
      "LastName":"",
      "Suffix":null,
      "FullName":"",
      "NickName":null,
      "ProfileName":null,
      "BirthDate":"10-12-1985",
      "Gender":"M",
      "Website":null
      }';
     * @return type Object
     */
    public function update($uid, $payload, $is_null_support = 'false', $fields = '*') {
        return $this->apiClientHandler('/' . $uid, array('nullsupport' => $is_null_support, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json'));
    }

    /**
     * This API is used to update security questions configuration using uid.
     * 
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     * @param $payload =
      {
      "securityquestionanswer": {
      "MiddleName": "value1",
      "PetName": "value1"
      }
      }
     * @return type object
     */
    public function updateSecurityQuestionByUid($uid, $payload, $fields = '*') {
        return $this->apiClientHandler("/" . $uid, array('fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json'));
    }

    /**
     * This API is used to invalidate the account.
     * 
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     * @param $data = true(boolean type) if have you no body parameters
     * 
     * @return array
     */
    public function invalidateEmail($uid, $data, $fields = '*') {
        return $this->apiClientHandler("/" . $uid . '/invalidateemail', array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to remove email using uid.
     * 
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     * @param $email = 'xxxx@xxxxxx.com'
     * @return type object
     */
    public function removeEmailByUidAndEmail($uid, $email, $fields = '*') {
        return $this->apiClientHandler('/' . $uid . '/email', array('fields' => $fields), array('method' => 'DELETE', 'post_data' => array('Email' => $email), 'content_type' => 'json'));
    }

    /**
     * Delete an account from your LoginRadius app.
     *
     * @param $uid = 'xxxxxxxxxx' //UID, the unified identifier for each user account.
     *
     * return {"IsDeleted": "true"}
     */
    public function delete($uid, $fields = '*') {
        return $this->apiClientHandler('/' . $uid, array('fields' => $fields), array('method' => 'DELETE', 'post_data' => true));
    }

    /**
     * This API is used to update or insert email using uid.
     * 
     * @param $uid
     * @param $payload =
      '{
      "Email" : [
      {
      "Type" : "Primary",
      "Value" : "xxx@xxxxxxxx.com"
      }
      ]
      }';
     * @return type object
     */
    public function updateOrInsertEmailByUid($uid, $payload, $fields = '*') {
        return $this->apiClientHandler('/' . $uid . '/email', array('fields' => $fields), array('method' => 'PUT', 'post_data' => $payload, 'content_type' => 'json'));
    }

    /**
     * This API is used to receive a backup code to login via the UID.
     *
     * @param $uid
     * @return type object
     */
    public function mfaGetBackupCodeByUid($uid, $fields = '*') {
        return $this->apiClientHandler("/2fa/backupcode", array('uid' => $uid, 'fields' => $fields));
    }

    /**
     * This API is used to get backup codes for login by the UID.
     *
     * @param $uid
     * @return type object
     */
    public function mfaResetBackupCodeByUid($uid, $fields = '*') {
        return $this->apiClientHandler("/2fa/backupcode/reset", array('uid' => $uid, 'fields' => $fields));
    }

    /**
     * MFA Reset Google Authenticator By UID
     * 
     * @param $uid
     * @param $googleauthenticator
     * @return {"IsDeleted": "true"}
     */
    public function mfaResetGoogleAuthenticatorByUid($uid, $googleauthenticator) {
        return $this->apiClientHandler("/2fa/authenticator", array('uid' => $uid), array('method' => 'DELETE', 'post_data' => array('googleauthenticator' => $googleauthenticator), 'content_type' => 'json'));
    }

    /**
     * MFA Reset SMS Authenticator By UID
     * 
     * @param $uid
     * @param $otpauthenticator
     * @return {"IsDeleted": "true"}
     */
    public function mfaResetSMSAuthenticatorByUid($uid, $otpauthenticator) {
        return $this->apiClientHandler("/2fa/authenticator", array('uid' => $uid), array('method' => 'DELETE', 'post_data' => array('otpauthenticator' => $otpauthenticator), 'content_type' => 'json'));
    }

    /**
     * This API is used to reset phone id verification by the UID.
     *
     * @param $uid
     * @param $data = true(boolean type) if have you no body parameters
     * @return type object
     */
    public function resetPhoneIdVerification($uid, $data, $fields = '*') {
        return $this->apiClientHandler('/' . $uid . '/invalidatephone', array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API allows you to generate SOTT with a given expiration time.
     * 
     * @param $time_difference
     * @return type object
     */
    public function generateSOTT($time_difference = '10', $fields = '*') {
        return $this->apiClientHandler("/sott", array('timedifference' => $time_difference, 'fields' => $fields));
    }

    /**
     * Handle account APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $options = array()) {
        return Functions::apiClient("/identity/v2/manage/account" . $path, $query_array, array_merge(array('authentication' => 'secret'), $options));
    }

}
