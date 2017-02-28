
LoginRadius
==========
-----------------------------------------------
LoginRadius PHP wrapper provides access to LoginRadius.

LoginRadius is a unified **Customer Identity Management** API platform that combines 30 major social platforms into a single simplified and maintenance-free API. With LoginRadius' API, websites and mobile apps can implement capture user profile data, enable social login, enable social sharing, add single sign-on and many more.

LoginRadius helps businesses boost user engagement on their web/mobile platform, manage online identities, utilize social media for marketing, capture accurate consumer data and get unique social insight into their customer base.

Please visit http://apidocs.loginradius.com/docs/php for more information.

PHP Library
--------------

This document contains information and examples regarding the LoginRadius PHP SDK. It provides guidance for working with social authentication, capture user profile data, enable social login, enable social sharing, single sign-on, user profile data and sending messages with a variety of social networks such as Facebook, Google, Twitter, Yahoo, LinkedIn, and more.


## Installation

The recommended way to install is through [Composer](http://getcomposer.org/).
 
```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of library:

```bash
composer require loginradius/php-sdk:dev-master
```

You can then later update LoginRadius PHP SDK using composer:

```bush
composer update
```

After installing, you need to require Composer's autoloader:

```bush
require 'vendor/autoload.php'
```
```bush
include_once "LoginRadiusSDK/Utility/Functions.php";
include_once "LoginRadiusSDK/LoginRadiusException.php";
include_once "LoginRadiusSDK/Clients/IHttpClient.php";
include_once "LoginRadiusSDK/Clients/DefaultHttpClient.php";
include_once "LoginRadiusSDK/Utility/SOTT.php";
include_once "LoginRadiusSDK/CustomerRegistration/Social/ProvidersAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Social/SocialLoginAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Social/AdvanceSocialLoginAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Authentication/UserAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Authentication/AuthCustomObjectAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Management/AccountAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Management/RoleAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Management/CustomObjectAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Management/SchemaAPI.php";
include_once "LoginRadiusSDK/Advance/RestHooksAPI.php";
```

##Configuration

After successfully install, you need to define following LoginRadius Account info in your project anywhere before use LoginRadius SDK or in config file of your project:
```bush
<?php
    define('LR_APP_NAME', 'LOGINRADIUS_SITE_NAME_HERE'); // Replace LOGINRADIUS_SITE_NAME_HERE with your site name that provide in LoginRadius account.
    define('LR_API_KEY', 'LOGINRADIUS_API_KEY_HERE'); // Replace LOGINRADIUS_API_KEY_HERE with your site API key that provide in LoginRadius account.
    define('LR_API_SECRET', 'LOGINRADIUS_API_SECRET_HERE'); // Replace LOGINRADIUS_API_SECRET_HERE with your site Secret key that provide in LoginRadius account.
?>
```

##Implementation
Importing/aliasing with the use operator.
```bush
use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;
use LoginRadiusSDK\Clients\IHttpClient;
use LoginRadiusSDK\Clients\DefaultHttpClient;
use LoginRadiusSDK\Utility\SOTT;
use LoginRadiusSDK\CustomerRegistration\Social\ProvidersAPI;
use LoginRadiusSDK\CustomerRegistration\Social\SocialLoginAPI;
use LoginRadiusSDK\CustomerRegistration\Social\AdvanceSocialLoginAPI;
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use LoginRadiusSDK\CustomerRegistration\Authentication\AuthCustomObjectAPI;
use LoginRadiusSDK\CustomerRegistration\Management\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Management\RoleAPI;
use LoginRadiusSDK\CustomerRegistration\Management\CustomObjectAPI;
use LoginRadiusSDK\CustomerRegistration\Management\SchemaAPI;
use LoginRadiusSDK\Advance\RestHooksAPI;
```
Create a LoginRadius object using API & Secret key:
```bush
// Social APIs
$getProviderObject = new ProvidersAPI(LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$socialLoginObject = new SocialLoginAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$advanceSocialLoginObject = new AdvanceSocialLoginAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

// Authentication APIs
$authenticationObject = new UserAPI(LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$authCustomObject = new AuthCustomObjectAPI(LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$accountObject = new AccountAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$schemaObject = new SchemaAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$accountObject = new AccountAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$roleObject = new RoleAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$customObject = new CustomObjectAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$resthookObject = new RestHooksAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));
        
```
####Call GetProvidersAPI API's
Get list of provider selected in LoginRadius user account.
```bush
try{
    $providers = $getProviderObject->getProvidersList();
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#### Call SocialLoginAPI API's
#####Get Access token
http://apidocs.loginradius.com/docs/access-token
```bush
try{
    $accesstoken = $socialLoginObject->exchangeAccessToken($request_token);//$request_token loginradius token get from social/traditional interface after success authentication.
    $access_token= $accesstoken->access_token;
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get User Profile Data
http://apidocs.loginradius.com/docs/user-profile
```bush
try{
    $userProfileData = $socialLoginObject->getUserProfiledata($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get photo Albums Data
http://apidocs.loginradius.com/docs/album
```bush
try{
    $photoAlbums = $socialLoginObject->getPhotoAlbums($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get photos Data
http://apidocs.loginradius.com/docs/photo
```bush
try{
    $photos = $socialLoginObject->getPhotos($access_token, $album_id);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Checkins Data
http://apidocs.loginradius.com/docs/check-in
```bush
try{
    $checkins = $socialLoginObject->getCheckins($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Audio Data
http://apidocs.loginradius.com/docs/audio
```bush
try{
    $audio = $socialLoginObject->getAudio($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Contacts Data
http://apidocs.loginradius.com/docs/contact
```bush
try{
    $contacts = $socialLoginObject->getContacts($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Mentions Data
http://apidocs.loginradius.com/docs/mention
```bush
try{
    $mentions= $socialLoginObject->getMentions($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Following Data
http://apidocs.loginradius.com/docs/following
```bush
try{
    $following = $socialLoginObject->getFollowing($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Events Data
http://apidocs.loginradius.com/docs/event
```bush
try{
    $events= $socialLoginObject->getEvents($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Posts Data
http://apidocs.loginradius.com/docs/post
```bush
try{
    $posts= $socialLoginObject->getPosts($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Followed Companies Data
http://apidocs.loginradius.com/docs/following
```bush
try{
    $followedCompanies= $socialLoginObject->getFollowedCompanies($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get groups Data
http://apidocs.loginradius.com/docs/group
```bush
try{
    $groups= $socialLoginObject->getGroups($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get status Data
http://apidocs.loginradius.com/docs/get-status-posting
```bush
try{
    $status= $socialLoginObject->getStatus($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Videos Data
http://apidocs.loginradius.com/docs/video
```bush
try{
    $videos= $socialLoginObject->getVideos($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Likes Data
http://apidocs.loginradius.com/docs/like
```bush
try{
    $likes= $socialLoginObject->getLikes($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Pages Data
http://apidocs.loginradius.com/docs/page
```bush
try{
    $pages= $socialLoginObject->getPages($access_token, $page_name);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Post Status Data
http://apidocs.loginradius.com/docs/post-status-posting
```bush
try{
    $postStatus= $socialLoginObject->postStatus($access_token, $title, $url, $imageurl, $status, $caption, $description);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Send Message Data
http://apidocs.loginradius.com/docs/post-message
```bush
try{
    $sendMessage= $socialLoginObject->sendMessage($access_token, $to, $subject, $message);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Token Validate
```bush
try{
    $validate= $socialLoginObject->tokenValidate($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Token Invalidate
```bush
try{
    $invalidate= $socialLoginObject->tokenInvalidate($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####validate Key and Secret Message Data
```bush
try{
    $invalidatekey= $socialLoginObject->validateKeyandSecret();
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```


#### Advance Social API's
#####Get access token by passing facebook token
```bush
try{
    $result= $advanceSocialLoginObject->getAccessTokenByPassingFacebookToken($fb_access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get access token by passing twitter token
```bush
try{
    $result= $advanceSocialLoginObject->getAccessTokenByPassingTwitterToken($tw_access_token, $tw_token_secret);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Refresh User Profile
```bush
try{
    $result= $advanceSocialLoginObject->refreshUserProfile($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Refresh Access Token
```bush
try{
    $result= $advanceSocialLoginObject->refreshAccessToken($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Trackable Status Fetching
```bush
try{
    $result= $advanceSocialLoginObject->trackableStatus($postid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Trackable Status Stats
```bush
try{
    $result= $advanceSocialLoginObject->trackableStatusStats($access_token, $status, $title , $url , $imageurl , $caption, $description );
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Shorten Url
```bush
try{
   $result= $advanceSocialLoginObject->shortenUrl($url);
}
catch (LoginRadiusException $e){
   $e->getMessage();
   $e->getErrorResponse();
}
```
#####Trakable Status Posting
```bush
try{
    $result= $advanceSocialLoginObject->trackableStatusPosting($access_token, $status, $title , $url , $imageurl , $caption, $description );
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```

#### Call User APIs
#####Login By Email
This api used to provide login with email/password combination.
```bush   
try{
    $result= $authenticationObject->loginByEmail($email, $password, $verification_url, $login_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Login By Username
This api used to provide login with username/password combination
```bush
   
try{
    $result= $authenticationObject->loginByUsername($username, $password, $verification_url, $login_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Login By Phone
This api used to provide login with phone/password combination.
```bush
try{
    $result= $authenticationObject->loginByPhone($phone, $password, $verification_url, $login_url, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Register User
This api used to register a user.
```bush
try{
    $profile= $authenticationObject->register($userprofile, $verification_url, $email_template, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Resend Email Verification
This api used to resend email verification link.
```bush
try{
    $profile= $authenticationObject->resendEmailVerification($email, $verification_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Profile
This API is used to get profile by access token.
```bush
try{
    $profile= $authenticationObject->getProfile($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Profile
This API is used to update user profile by access token.
```bush
try{
    $profile= $authenticationObject->updateProfile($access_token, $userprofile, $verification_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Account By Email Confirmation
Delete account after email confirmation.
```bush
try{
    $profile= $authenticationObject->deleteAccountByEmailConfirmation($access_token, $delete_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Forgot Password
```bush
try{
    $profile= $authenticationObject->forgotPassword($email, $reset_password_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Reset Password
```bush
try{
    $profile= $authenticationObject->resetPassword($vtoken, $password, $welcome_email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Change account Password
```bush
try{
    $profile= $authenticationObject->changeAccountPassword($access_token, $old_password, $new_password);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Add Email
```bush
try{
    $profile= $authenticationObject->addEmail($access_token, $email, $type, $verification_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Remove Email
```bush
try{
    $profile= $authenticationObject->removeEmail($access_token, $email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Verify Email
```bush
try{
    $profile= $authenticationObject->verifyEmail($vtoken, $url, $welcome_email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check Availability Of Email
```bush
try{
    $profile= $authenticationObject->checkAvailablityOfEmail($email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Change Username
```bush
try{
    $profile= $authenticationObject->changeUsername($access_token, $username);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check Username
```bush
try{
    $profile= $authenticationObject->checkUsername($username);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Account Link
```bush
try{
    $profile= $authenticationObject->accountLink($access_token, $candidate_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Account Unlink
```bush
try{
    $profile= $authenticationObject->accountUnlink($access_token, $id, $provider);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Social Profile
```bush
try{
    $profile= $authenticationObject->getSocialProfile($access_token, $email_template );
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check Availability of phone
```bush
try{
    $profile= $authenticationObject->checkAvailablityOfPhone($phone);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Phone
```bush
try{
    $profile= $authenticationObject->updatePhone($access_token, $phone, $smsTemplate);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Resend OTP
```bush
try{
    $profile= $authenticationObject->resendOTP($phone, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Resend OTP By Token
```bush
try{
    $profile= $authenticationObject->resendOTPByToken($access_token, $phone, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Verify OTP
```bush
try{
    $profile= $authenticationObject->verifyOTP($otp, $phone,$sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Verify OTP by token
```bush
try{
    $profile= $authenticationObject->verifyOTPByToken($access_token, $otp, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```

#### Call Custom Object APIs
This API is used to manage a custom object for the user and relies on the User Entity object. If you are unsure of your Object ID you can reach out to the support team for details on this. If you haven't already initialized the User Registration Custom Object API do so now.
#####Insert Data in Custom Object
```bush    
try{
    $profile= $authCustomObject->createCustomObject($access_token, $objectname, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Custom Object Data
```bush    
try{
    $profile= $authCustomObject->updateCustomObjectData($access_token, $objectname, $object_record_id, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Custom Object Sets by token
```bush    
try{
    $profile= $authCustomObject->getCustomObjectSetsByToken($access_token, $object_name);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Custom Object Set By ID
```bush
try{
    $profile= $authCustomObject->getCustomObjectSetByID($access_token, $object_name, $object_record_id);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Custom Object Set
```bush
try{
    $profile= $authCustomObject->deleteCustomObjectSet($access_token, $object_name, $object_record_id);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```


#### Call Account API's
#####Create User
```bush
   /**
*    $data  =   '{
* "Prefix":"",
* "FirstName":"Kunal",
* "MiddleName":null,
* "LastName":"Saini",
* "Suffix":null,
* "FullName":"Kunal Saini",
* "NickName":null,
*  "ProfileName":null,
* "BirthDate":"10-12-1985",
*  "Gender":"M",
*  "Website":null,
* "EmailVerified":"true",
*  "Password" : "*********",
* "Email":[
* {
* "Type":"Primary",
* "Value":"xxxxx@xxxxx.com"
* },
* ]}';
*/
try{
    $result = $accountObject->create($data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Account
```bush
  /**
*    $data  =   '{
* "Prefix":"",
* "FirstName":"Kunal",
* "MiddleName":null,
* "LastName":"Saini",
* "Suffix":null,
* "FullName":"Kunal Saini",
* "NickName":null,
*  "ProfileName":null,
* "BirthDate":"10-12-1985",
*  "Gender":"M",
*  "Website":null
*  }';
*/
try{
    $result = $accountObject->update($uid, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Account
```bush
  /**
*
* $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; //UID, the identifier for each user    
* account, it may have multiple IDs(identifier for each social platform) attached 
*  with
*
*/
try{
    $result= $accountObject->delete($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Set Password
This API is used to set a password for an account. It does not require to know the previous(old) password.
```bush
  /**
*
* $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple 
* IDs(identifier for each social platform) attached with
* $password = 'xxxxxxxxxx';
*
*/
try{
    $result = $accountObject->setPassword($uid, $password);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Hash Password
This API is used to get the password field of an account.
```bush
  /**
*
* $uid = 'xxxxxxxxxxx';
*
*/
try{
    $result = $accountObject->getHashPassword($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Profile by Email
This API retrieves the profile data associated with the specific user using the passing in email address.
```bush
  /**
*
* $email = 'xxxxxxxxxxx';
*
*/
try{
    $result = $accountObject->getProfileByEmail($email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Profile by username
```bush
  /**
*
* $username = '************';
*
*/
try{
    $result = $accountObject->getProfileByUsername($username);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Profile by phone
```bush
  /**
*
* $phone = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
*
*/
try{
    $result = $accountObject->getProfileByPhone($phone);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Profile by uid
```bush
  /**
*
* $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
*
*/
try{
    $result = $accountObject->getProfileByUid($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```


#### Call Role APIs
If you still not created Role object
#####Get Role
```bush
   
try{
    $result = $roleObject->get();
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Create roles
```bush
/**
*$roles = '{"Roles":[
*   {"Name":"Administrator",
*   "Permissions":{"Edit":true, "Manage":true}}]}';
*
*/
try{
    $result = $roleObject->create($roles);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete role
```bush
/**
* $role = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; //Name of Role
*
*/
try{
    $result = $roleObject->delete($role);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Add Permission
```bush
/**
*
* $role = 'xxxxxx'; // role name
* $permissions ='{"Permissions":["EditUser","DeleteUser"] }';
*
*/
try{
    $result = $roleObject->addPermission($role, $permissions);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Remove Permission
```bush
/**
*
* $role = 'xxxxxx'; // role name
* $permissions = {"Permissions": ["Edit User", "Delete User"] }';
*
*/
try{
    $result = $roleObject->removePermission($role, $permissions);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Account Role by UID
```bush
/**
* $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple
* @param $data = '{"Roles" : ["Role1","Role2"]}';
* @return type
*/
try{
    $result = $roleObject->assignRolesByUid($uid, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Assign Roles by UID
```bush
/**
* $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple
* @param $data = '{"Roles" : ["Role1","Role2"]}';
*
*/
try{
    $result = $roleObject->assignRolesByUid($uid, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Account Roles
```bush
/**
*
* $role = 'xxxxxx'; // role name
* $permissions = {"Permissions": ["Edit User", "Delete User"] }';
*
*/
try{
    $result = $roleObject->removePermission($role, $permissions);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```



#### Call Custom Object APIs
#####Insert Custom Object
This API is used to create custom objects.
```bush
   /**
*
* @param $uid='xxxxxx';//// UID, the identifier for each user account
* @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
* @param $data='{"objectdataa":"field1"}';
* @return type
*/
try{
    $result= $customObject->insert($uid, $object_name, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Object By Accountid
This API is used to retrieve the Custom Object for the specified account based on the account ID(UID).
```bush
/**
*
* @param $uid='xxxxxx';//// UID, the identifier for each user account
* @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
* @return type
*/
try{
    $result= $customObject->getObjectByAccountid($uid, $object_name);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Object By RecordID
This API is used to retrieve the Custom Object for the specified account based on the account ID(UID).
```bush
/**
*
* @param $uid='xxxxxx';//// UID, the identifier for each user account
* @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
* @param $object_record_id='xxxxxxxxx';//Unique identifier of the user's record in 
* Custom Object
* @param $data='{"objectdataa":"field1"}';
* @return type
*/
try{
    $result= $customObject->updateObjectByRecordID($uid, $object_name, $object_record_id, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Object By RecordID
This API is used to retrieve the Custom Object for the specified account based on the record ID($object_record_id).
```bush
/**
*
* @param $uid='xxxxxx';//// UID, the identifier for each user account
* @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
* @param $object_record_id='xxxxxxxxx';//Unique identifier of the user's record in 
* Custom Object
* @return type
*/
try{
    $result= $customObject->getObjectByRecordID($uid, $object_name, $object_record_id, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Custom Object
Gets information on the specified custom object. http://apidocs.loginradius.com/docs/get-custom-object-stats
```bush
/**
* @param $uid='xxxxxx';//// UID, the identifier for each user account
* @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
* @param $object_record_id='xxxxxxxxx';//Unique identifier of the user's record in 
* Custom Object
* @return type
*/
try{
    $result= $customObject->delete($uid, $object_name, $object_record_id);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Schema API
if you still not created schema object then create
######Get schema of Registration form
```bush
try{
    $result= $schemaObject->getSchemaList();
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```


#### Call Rest Hook APIs
#####User List
```bush
try{
    $result= $resthookObject->userList($from, $select = '', $where = '', $orderby = '', $skip = '', $limit );
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Insights
```bush
/**
* @param $from From Date
* @param $to To Date
* @param $first_data_point Aggregation Field
* @param $stats_type Type of users should apply to
* @return type
*/
try{
    $result= $resthookObject->insights($from, $to, $first_data_point, $stats_type);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Rest Hooks Settings
```bush
try{
    $result= $resthookObject->restHooksSettings();
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Field List
```bush
try{
    $result= $resthookObject->fieldList();
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Rest Hooks Subscribed Urls
```bush
try{
    $result= $resthookObject->getRestHooksSubscribedUrls();
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Subscribe RestHooks
```bush
try{
    $result= $resthookObject->subscribeRestHooks($target_url, $event);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Unsubscribe Rest Hooks
```bush
try{
    $result= $resthookObject->unsubscribeRestHooks($target_url);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```


##Implement Custom HTTP Client
1. In order to implement custom http client.  Create the customhttpclient.php file in your project.
```bush
<?php
namespace LoginRadiusSDK\Clients\IHttpClient;
use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

class CustomHttpClient implements IHttpClient {

    public function request($path, $query_array = array(), $options = array()) {
    //custom HTTP client request handler code here
    }
}
?>
```
2. After that,  pass the class name of your custom http client in global variable **$apiClient_class** in your project.
```bush
<?php
global $apiClient_class;
$apiClient_class = 'CustomHttpClient';
?>
```

Note: Now your Custom HTTP client library will be used to handle LoginRadius APIs.