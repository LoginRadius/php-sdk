<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AccountAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Management;

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
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array()) {
        new Functions($apikey, $apisecret, $customize_options);
    }

    /**
     * This API is create account.
     *
     * @param json $data
     * @return type
     *      {
     * "Prefix":"",
     * "FirstName":"",
     * "MiddleName":null,
     * "LastName":"",
     * "Suffix":null,
     * "FullName":"",
     * "NickName":null,
     *  "ProfileName":null,
     * "BirthDate":"10-12-1985",
     *  "Gender":"M",
     *  "Website":null,
     * "Email":[
     * {
     * "Type":"Primary",
     * "Value":"example@example.com"
     * }
     * ],
     * "Country":{
     * "Code":"",
     * "Name":"India"
     * },
     * "ThumbnailImageUrl":null,
     * "ImageUrl":null,
     * "Favicon":null,
     * "ProfileUrl":null,
     * "HomeTown":null,
     * "State":"Alberta",
     * "City":"Edmonton",
     * "Industry":null,
     * "About":null,
     * "TimeZone":null,
     * "LocalLanguage":null,
     * "CoverPhoto":null,
     *  "TagLine":null,
     * "Positions":[
     * {
     * "Positions":"astronaut",
     * "Summary":"An astronaut.",
     * "StartDate":"",
     * "EndDate":"",
     * "IsCurrent":"",
     * "Location":"",
     * "Comapny":{
     * "Name":"",
     * "Type":"",
     * "Industry":""
     * }
     * }
     * ],
     * "Educations":[
     * {
     * "School":null,
     * "year":null,
     * "type":null,
     * "notes":null,
     * "activities":null,
     * "degree":null,
     * "fieldofstudy":null,
     * "StartDate":null,
     * "EndDate":null
     * }
     * ],
     * "PhoneNumbers":[
     * {
     * "PhoneType":"Mobile",
     * "PhoneNumber":"18882052816"
     * }
     * ],
     * "IMAccounts":[
     * {
     * "AccountType":null,
     * "AccountName":null
     * }
     * ],
     * "Addresses":[
     * {
     * "Type":null,
     * "Address1":null,
     * "Address2":null,
     * "City":"Edmonton",
     * "State":"Alberta",
     * "PostalCode":null,
     * "Region":null,
     * "Country":"Canada"
     * }
     * ],
     * "MainAddress":null,
     * "LocalCity":null,
     * "ProfileCity":"Edmonton",
     * "LocalCountry":null,
     * "ProfileCountry":"Canada",
     * "IsProtected":false,
     * "RelationshipStatus":null,
     * "Quota":null,
     * "Quote":null,
     * "InterestedIn":[
     * "blah",
     * "blah"
     * ],
     * "Interests":[
     * {
     * "InterestedType":null,
     * "InterestedName":null
     * }
     * ],
     * "Religion":null,
     * "Political":null,
     * "Sports":[
     * {
     * "Id":null,
     * "Name":null
     * }
     * ],
     * "InspirationalPeople":[
     * {
     * "Id":null,
     * "Name":null
     * }
     * ],
     * "HttpsImageUrl":null,
     * "FollowersCount":0,
     * "FriendsCount":0,
     * "IsGeoEnabled":null,
     * "TotalStatusesCount":0,
     * "Associations":null,
     * "NumRecommenders":0,
     * "Honors":null,
     * "Awards":null,
     * "Skills":null,
     * "CurrentStatus":null,
     * "Certifications":null,
     * "Courses":null,
     * "Volunteer":null,
     * "RecommendationsReceived":null,
     * "Languages":null,
     * "Projects":null,
     * "Games":null,
     * "Family":null,
     * "TeleVisionShow":null,
     * "MutualFriends":null,
     * "Movies":null,
     * "Books":null,
     * "AgeRange":null,
     * "PublicRepository":null,
     * "Hireable":false,
     * "RepositoryUrl":null,
     * "Age":null,
     * "Patents":null,
     * "FavoriteThings":null,
     * "ProfessionalHeadline":null,
     * "ProviderAccessCredential":null,
     * "RelatedProfileViews":null,
     * "KloutScore":null,
     * "LRUserID":null,
     * "PlacesLived":null,
     * "Publications":null,
     * "JobBookmarks":null,
     * "Suggestions":null,
     * "Badges":null,
     * "MemberUrlResources":null,
     * "TotalPrivateRepository":0,
     * "Currency":null,
     * "StarredUrl":null,
     * "GistsUrl":null,
     * "PublicGists":0,
     * "PrivateGists":0,
     * "Subscription":null,
     * "Company":null,
     * "GravatarImageUrl":null,
     * "ProfileImageUrls":null,
     * "WebProfiles":null,
     * "Password":null,
     * "Uid":null,
     * "CustomFields":null,
     * "IsEmailSubscribed":false,
     * "UserName":null,
     * "PhoneId":null
     * }
     */
    public function create($data, $fields = '*') {
        return $this->apiClientHandler("", array('fields' => $fields), array('method' => 'POST', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to Modify/Update details of an existing user.
     *
     * $uid //The LoginRadius user identifier for a particular social platform(like "Facebook", "Twitter") attached with that user account
      /**
     * @param json type $data
     * @return type
     *      {
     * "Prefix":"",
     * "FirstName":"",
     * "MiddleName":null,
     * "LastName":"",
     * "Suffix":null,
     * "FullName":"",
     * "NickName":null,
     *  "ProfileName":null,
     * "BirthDate":"10-12-1985",
     *  "Gender":"M",
     *  "Website":null,
     * "Country":{
     * "Code":"",
     * "Name":"India"
     * },
     * "ThumbnailImageUrl":null,
     * "ImageUrl":null,
     * "Favicon":null,
     * "ProfileUrl":null,
     * "HomeTown":null,
     * "State":"Alberta",
     * "City":"Edmonton",
     * "Industry":null,
     * "About":null,
     * "TimeZone":null,
     * "LocalLanguage":null,
     * "CoverPhoto":null,
     *  "TagLine":null,
     * "Positions":[
     * {
     * "Positions":"astronaut",
     * "Summary":"An astronaut.",
     * "StartDate":"",
     * "EndDate":"",
     * "IsCurrent":"",
     * "Location":"",
     * "Comapny":{
     * "Name":"",
     * "Type":"",
     * "Industry":""
     * }
     * }
     * ],
     * "Educations":[
     * {
     * "School":null,
     * "year":null,
     * "type":null,
     * "notes":null,
     * "activities":null,
     * "degree":null,
     * "fieldofstudy":null,
     * "StartDate":null,
     * "EndDate":null
     * }
     * ],
     * "PhoneNumbers":[
     * {
     * "PhoneType":"Mobile",
     * "PhoneNumber":"18882052816"
     * }
     * ],
     * "IMAccounts":[
     * {
     * "AccountType":null,
     * "AccountName":null
     * }
     * ],
     * "Addresses":[
     * {
     * "Type":null,
     * "Address1":null,
     * "Address2":null,
     * "City":"Edmonton",
     * "State":"Alberta",
     * "PostalCode":null,
     * "Region":null,
     * "Country":"Canada"
     * }
     * ],
     * "MainAddress":null,
     * "LocalCity":null,
     * "ProfileCity":"Edmonton",
     * "LocalCountry":null,
     * "ProfileCountry":"Canada",
     * "IsProtected":false,
     * "RelationshipStatus":null,
     * "Quota":null,
     * "Quote":null,
     * "InterestedIn":[
     * "blah",
     * "blah"
     * ],
     * "Interests":[
     * {
     * "InterestedType":null,
     * "InterestedName":null
     * }
     * ],
     * "Religion":null,
     * "Political":null,
     * "Sports":[
     * {
     * "Id":null,
     * "Name":null
     * }
     * ],
     * "InspirationalPeople":[
     * {
     * "Id":null,
     * "Name":null
     * }
     * ],
     * "HttpsImageUrl":null,
     * "FollowersCount":0,
     * "FriendsCount":0,
     * "IsGeoEnabled":null,
     * "TotalStatusesCount":0,
     * "Associations":null,
     * "NumRecommenders":0,
     * "Honors":null,
     * "Awards":null,
     * "Skills":null,
     * "CurrentStatus":null,
     * "Certifications":null,
     * "Courses":null,
     * "Volunteer":null,
     * "RecommendationsReceived":null,
     * "Languages":null,
     * "Projects":null,
     * "Games":null,
     * "Family":null,
     * "TeleVisionShow":null,
     * "MutualFriends":null,
     * "Movies":null,
     * "Books":null,
     * "AgeRange":null,
     * "PublicRepository":null,
     * "Hireable":false,
     * "RepositoryUrl":null,
     * "Age":null,
     * "Patents":null,
     * "FavoriteThings":null,
     * "ProfessionalHeadline":null,
     * "ProviderAccessCredential":null,
     * "RelatedProfileViews":null,
     * "KloutScore":null,
     * "LRUserID":null,
     * "PlacesLived":null,
     * "Publications":null,
     * "JobBookmarks":null,
     * "Suggestions":null,
     * "Badges":null,
     * "MemberUrlResources":null,
     * "TotalPrivateRepository":0,
     * "Currency":null,
     * "StarredUrl":null,
     * "GistsUrl":null,
     * "PublicGists":0,
     * "PrivateGists":0,
     * "Subscription":null,
     * "Company":null,
     * "GravatarImageUrl":null,
     * "ProfileImageUrls":null,
     * "WebProfiles":null,
     * "Password":null,
     * "Uid":null,
     * "CustomFields":null,
     * "IsEmailSubscribed":false,
     * "UserName":null,
     * "PhoneId":null
     * }
     * 
     * $is_null_support = true
     * Currently Supporting fields for this feature: “UserName�?,"Prefix", "FirstName", "MiddleName", "LastName", "Suffix", "NickName", "ProfileName", "BirthDate", "Gender",     "Website", "ThumbnailImageUrl", "ImageUrl", "Favicon", "ProfileUrl", "HomeTown", "State", "City", "Industry", "About", "TimeZone",
     * "LocalLanguage", "CoverPhoto", "TagLine" , "Language", "MainAddress", "LocalCity", "ProfileCity", "LocalCountry",   "RelationshipStatus", "Religion", "Political", "HttpsImageUrl", "IsGeoEnabled", "Associations", "Honors",
     * "PublicRepository", "RepositoryUrl", "ProfessionalHeadline", "Currency", "StarredUrl", "GistsUrl", "Company",  "GravatarImageUrl", Languages , PlacesLived , Addresses , PhoneNumbers
     * 
     * return {"isPosted": true}
     */
    public function update($uid, $data, $is_null_support = 'false', $fields = '*') {
        return $this->apiClientHandler('/' . $uid, array('nullsupport' => $is_null_support, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * Delete an account from your LoginRadius app.
     *
     * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; //UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return {"IsDeleted": "true"}
     */
    public function delete($uid, $fields = '*') {
        return $this->apiClientHandler('/' . $uid, array('fields' => $fields), array('method' => 'DELETE', 'post_data' => true));
    }

    /**
     * This API is used to set a password for an account. It does not require to know the previous(old) password.
     *
     * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     * $password = 'xxxxxxxxxx';
     *
     * return {“PasswordHash�? : “passwordhash�?}
     */
    public function setPassword($uid, $password, $fields = '*') {
        $data = array('password' => $password);
        return $this->apiClientHandler("/" . $uid . "/password", array('fields' => $fields), array('method' => 'PUT', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * This API is used to get the password field of an account.
     *
     * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return {“passwordHash�? : “passwordhash�?}
     */
    public function getHashPassword($uid, $fields = '*') {
        return $this->apiClientHandler("/" . $uid . "/password", array('fields' => $fields));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in email address.
     *
     * $email = 'example@doamin.com';
     *
     * return all user profile
     */
    public function getProfileByEmail($email, $fields = '*') {
        return $this->apiClientHandler('', array('email' => $email, 'fields' => $fields));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in username.
     *
     * $username = 'example';
     *
     * return all user profile
     */
    public function getProfileByUsername($username, $fields = '*') {
        return $this->apiClientHandler('', array('username' => $username, 'fields' => $fields));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in phone number.
     *
     * $username = 'example';
     *
     * return all user profile
     */
    public function getProfileByPhone($phone, $fields = '*') {
        return $this->apiClientHandler('', array('phone' => $phone, 'fields' => $fields));
    }

    /**
     * This API is used to retrieve all of the profile data from each of the linked social provider accounts associated with the account. For ex: A user has linked facebook and google account then this api will retrieve both profile data.
     *
     * $uid = uid; uid; UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return Array of user profile
     */
    public function getProfileByUid($uid, $fields = '*') {
        return $this->apiClientHandler("/" . $uid, array('fields' => $fields));
    }

    /**
     * This API is used to retrieve Access Token based on UID or user impersonation API.
     *
     * $uid = uid; UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return Array of user profile
     */
    public function getAccessTokenByUid($uid, $fields = '*') {
        return $this->apiClientHandler("/access_token", array('uid' => $uid, 'fields' => $fields));
    }    
    
    /**
     * This API is used to invalidate the account.
     * 
     * @param $uid
     * @param $data = true(boolean type) if have you no body parameters
     * 
     * @return array
     */
    
    public function invalidateEmail($uid, $data, $fields = '*') {
        return $this->apiClientHandler("/" . $uid . '/invalidateemail', array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
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
     * This API Returns an Email Verification token.
     * 
     * @param $email
     *
     * @return 
     */
    
    public function getEmailVerificationToken($email, $fields = '*') {
        $data = json_encode(['Email' => $email]);        
        return $this->apiClientHandler('/verify/token', array('fields' => $fields), array('method' => 'POST', 'post_data' => $data, 'content_type' => 'json'));
    }
    
    /**
     * This API Returns a forgot password token.
     * 
     * @param $email
     *
     * @return 
     */
    
    public function getForgotPasswordToken($email, $fields = '*') {
        $data = json_encode(['Email' => $email]);  
        return $this->apiClientHandler('/forgot/token', array('fields' => $fields), array('method' => 'POST', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to remove email using uid.
     * 
     * @param $uid
     * @param $email
     *
     * @return 
     */
    
    public function removeEmailByUidAndEmail($uid, $email, $fields = '*') {
        $data = json_encode(['Email' => $email]);  
        return $this->apiClientHandler('/' . $uid . '/email', array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $data, 'content_type' => 'json'));
    }
    
    /**
     * This API is used to update or insert email using uid.
     * 
     * @param $uid
     * @param $data
     * {
     *   “Email” : [
     *  {
     *   “Type” : “Primary”,
     *   “Value” : “abc@mailinator.com”
     *   }
     *   ]
     *   }
     * @return 
     */
    
    public function updateOrInsertEmailByUid($uid, $data, $fields = '*') {        
        return $this->apiClientHandler('/' . $uid . '/email', array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * Remove Google Authenticator and SMS Authenticator By UID.
     *
     * @param $uid
     * @return "IsDeleted": "true"
     */
    public function removeOrResetGoogleAuthenticator($uid, $otpauthenticator, $googleauthenticator, $fields = '*') {
        $data = array('otpauthenticator' => $otpauthenticator, 'googleauthenticator' => $googleauthenticator);
        return $this->apiClientHandler("/2FA/authenticator", array('uid' => $uid, 'fields' => $fields), array('method' => 'DELETE', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * This API is used to receive a backup code to login via the UID.
     *
     * @param $uid
     * @return 
     */
    public function getBackupCodeForLoginbyUID($uid, $fields = '*') {
        return $this->apiClientHandler("/2fa/backupcode", array('uid' => $uid, 'fields' => $fields));
    }

    /**
     * This API is used to get backup codes for login by the UID.
     *
     * @param $uid
     * @return 
     */
    public function resetBackupCodeForLoginbyUID($uid, $fields = '*') {
        return $this->apiClientHandler("/2fa/backupcode/reset", array('uid' => $uid, 'fields' => $fields));
    }

    /**
     * This API is used to reset phone id verification by the UID.
     *
     * @param $uid
     * @param $data = true(boolean type) if have you no body parameters
     * @return 
     */
    public function resetPhoneIdVerification($uid, $data, $fields = '*') {
        return $this->apiClientHandler('/' . $uid . '/invalidatephone', array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API allows you to query your LoginRadius account for basic server information and server time information which is useful when generating an SOTT token.
     *
     * @param $time_difference   
     * @return 
     */
    public function getServerTime($time_difference = '10', $fields = '*') {
        return Functions::apiClient("/identity/v2/serverinfo", array("timedifference" => $time_difference, 'fields' => $fields), array('output_format' => 'json'));
    }

    /**
     * Note: This function has been deprecated we will remove this in our next release
     *       Use LoginRadiusSDK->Utility->SOTT->encrypt() to get sott.
     * This API allows you to generate SOTT with a given expiration time.
     * 
     * @param $time_difference
     * @return 
     */
    public function generateSOTT($time_difference = '10', $fields = '*') {
        return $this->apiClientHandler("/sott", array('timedifference' => $time_difference, 'fields' => $fields));
    }

    /**
     * This API is used to update security questions configuration using uid.
     * 
     * @param $uid
     * @param $data
     * {
     * "securityquestionanswer": {
     * "MiddleName": "value1",
     * "PetName": "value1"
     * }
     * }
     * @return 
     */
    public function updateSecurityQuestionByUid($uid, $data, $fields = '*') {
        return $this->apiClientHandler("/" . $uid, array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }
   
    /**
     * handle account APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $customize_options = array()) {
        $options = array_merge(array('authentication' => 'headsecure'), $customize_options);
        return Functions::apiClient("/identity/v2/manage/account" . $path, $query_array, $options);
    }
}
