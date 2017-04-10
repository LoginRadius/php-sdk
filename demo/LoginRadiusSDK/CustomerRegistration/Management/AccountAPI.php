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
        $options = array_merge(array('authentication' => 'secret'), $customize_options);
        new Functions($apikey, $apisecret, $options);
    }

    /**
     * This API is create account.
     *
     * @param json $data
     * @return type
     *      {
     * "Prefix":"",
     * "FirstName":"Kunal",
     * "MiddleName":null,
     * "LastName":"",
     * "Suffix":null,
     * "FullName":"Karl wittig",
     * "NickName":null,
     *  "ProfileName":null,
     * "BirthDate":"10-12-1985",
     *  "Gender":"M",
     *  "Website":null,
     * "Email":[
     * {
     * "Type":"Primary",
     * "Value":"kunal@loginradius.com"
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
     *"PhoneId":null
     * }
     */
    public function create($data)
    {
        return $this->apiClientHandler("", array(), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
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
     * "FirstName":"Kunal",
     * "MiddleName":null,
     * "LastName":"",
     * "Suffix":null,
     * "FullName":"Karl wittig",
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
     *"PhoneId":null
     * }
     *
     * return {"isPosted": true}
     */
    public function update($uid, $data)
    {
        return $this->apiClientHandler('/' . $uid, array(), array('method' => 'put', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * Delete an account from your LoginRadius app.
     *
     * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; //UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return {"IsDeleted": "true"}
     */
    public function delete($uid)
    {
        return $this->apiClientHandler('/' . $uid, array(), array('method' => 'delete', 'post_data' => true));
    }

    /**
     * This API is used to set a password for an account. It does not require to know the previous(old) password.
     *
     * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     * $password = 'xxxxxxxxxx';
     *
     * return {“PasswordHash” : “passwordhash”}
     */
    public function setPassword($uid, $password)
    {
        $data =  array('password' => $password);
        return $this->apiClientHandler("/" . $uid . "/password", array(), array('method' => 'put', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * This API is used to get the password field of an account.
     *
     * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return {“passwordHash” : “passwordhash”}
     */
    public function getHashPassword($uid)
    {
        return $this->apiClientHandler("/" . $uid . "/password");
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in email address.
     *
     * $email = 'example@doamin.com';
     *
     * return all user profile
     */
    public function getProfileByEmail($email)
    {
        return $this->apiClientHandler('', array('email' => $email));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in username.
     *
     * $username = 'example';
     *
     * return all user profile
     */
    public function getProfileByUsername($username)
    {
        return $this->apiClientHandler('', array('username' => $username));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in phone number.
     *
     * $username = 'example';
     *
     * return all user profile
     */
    public function getProfileByPhone($phone)
    {
        return $this->apiClientHandler('', array('phone' => $phone));
    }

    /**
     * This API is used to retrieve all of the profile data from each of the linked social provider accounts associated with the account. For ex: A user has linked facebook and google account then this api will retrieve both profile data.
     *
     * $uid = uid; uid; UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return Array of user profile
     */
    public function getProfileByUid($uid)
    {
        return $this->apiClientHandler("/" . $uid);
    }
    
      /**
     * This API is used to retrieve Access Token based on UID or user impersonation API.
     *
     * $uid = uid; uid; UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
     *
     * return Array of user profile
     */
    public function getAccessTokenByUid($uid)
    {
        return $this->apiClientHandler("/access_token", array('uid' => $uid));
    }
    
    /**
     * Remove or Reset Google Authenticator settings.
     *
     * @param $uid
     * @return "IsDeleted": "true"
     */
    public function removeOrResetGoogleAuthenticator($uid, $otpauthenticator, $googleauthenticator) 
    {
        $data =  array('otpauthenticator' => $otpauthenticator, 'googleauthenticator'=>$googleauthenticator);
        return $this->apiClientHandler("/2FA/authenticator", array('uid' => $uid), array('method' => 'delete', 'post_data' => json_encode($data), 'content_type' => 'json'));
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
        return Functions::apiClient("/identity/v2/manage/account" . $path, $query_array, $options);
    }

}
