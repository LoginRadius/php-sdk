
LoginRadius
==========

![Home Image](http://docs.lrcontent.com/resources/github/banner-1544x500.png)

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
composer require loginradius/php-sdk-2.0:4.3.0
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
include_once "LoginRadiusSDK/CustomerRegistration/Management/CustomRegistrationDataAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Management/RoleAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Management/CustomObjectAPI.php";
include_once "LoginRadiusSDK/CustomerRegistration/Management/SchemaAPI.php";
include_once "LoginRadiusSDK/Advance/WebHooksAPI.php";
```

##Configuration

After successfully install, you need to define following LoginRadius Account info in your project anywhere before use LoginRadius SDK or in config file of your project:
```bush
<?php
    define('LR_APP_NAME', 'LOGINRADIUS_SITE_NAME_HERE'); // Replace LOGINRADIUS_SITE_NAME_HERE with your site name that provide in LoginRadius account.
    define('LR_API_KEY', 'LOGINRADIUS_API_KEY_HERE'); // Replace LOGINRADIUS_API_KEY_HERE with your site API key that provide in LoginRadius account.
    define('LR_API_SECRET', 'LOGINRADIUS_API_SECRET_HERE'); // Replace LOGINRADIUS_API_SECRET_HERE with your site Secret key that provide in LoginRadius account.
    define('HOST', 'PROXY_HOST'); // Replace PROXY_HOST with your proxy server host.
    define('PORT', 'PROXY_PORT'); // Replace PROXY_PORT with your proxy server port.
    define('USER', 'PROXY_USER'); // Replace PROXY_USER with your proxy server username.
    define('PASSWORD', 'PROXY_PASSWORD'); // Replace PROXY_PASSWORD with your proxy server password.
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
use LoginRadiusSDK\CustomerRegistration\Management\CustomRegistrationDataAPI;
use LoginRadiusSDK\CustomerRegistration\Management\RoleAPI;
use LoginRadiusSDK\CustomerRegistration\Management\CustomObjectAPI;
use LoginRadiusSDK\CustomerRegistration\Management\SchemaAPI;
use LoginRadiusSDK\Advance\WebHooksAPI;
```
Create a LoginRadius object using API & Secret key:
```bush
$getProviderObject = new ProvidersAPI(LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$socialLoginObject = new SocialLoginAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$advanceSocialLoginObject = new AdvanceSocialLoginAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$authenticationObject = new UserAPI(LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$authCustomObject = new AuthCustomObjectAPI(LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$accountObject = new AccountAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$customRegistrationDataObject = new CustomRegistrationDataAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$schemaObject = new SchemaAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$roleObject = new RoleAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$customObject = new CustomObjectAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$webhookObject = new WebHooksAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));
        
```
If you are using proxy server then create a LoginRadius object using API & Secret key & proxy server details.
```bush
** Example **

$accountObject = new AccountAPI(LR_API_KEY, LR_API_SECRET, array('output_format' => 'json', 'proxy'=> array('host' => '','port' => '','user' => '','password' => ''))); 
        
```

###API Examples
####Partial API response
```bush

We have an option to select fields(partial response) which you require as an API response.<br>
For this you need to pass an extra parameter(optional) at the end of each API function..

- If any field passed is does not exists in response, will be ignored.
- In case of nested, only root object is selectable.
- Values should be separated by comma.

**Example:**

$fields= "email, username";

  try {
        $result = $accountObject->getProfileByEmail($email, $fields);  
    }
    catch (LoginRadiusException $e) { 
            $e->getErrorResponse();
    }


**Output Response:**

{ 
    UserName: 'test1213',
    Email: [ { Type: 'Primary', Value: 'test1213@sthus.com' } ]
}
        
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
    $result= $authenticationObject->authLoginByEmail($verification_url, $login_url, $email_template, $g_recaptcha_response, $data);
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
    $result= $authenticationObject->authLoginByUsername($verification_url, $login_url, $email_template, $g_recaptcha_response, $data);
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
    $result= $authenticationObject->authLoginByPhone($login_url, $sms_template, $g_recaptcha_response, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Register User by email
This api used to register a user using email.
```bush
try{
    $result= $authenticationObject->registerByEmail($userprofile, $sott, $verification_url, $email_template, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Register User by phone
This api used to register a user using phone number.
```bush
try{
    $result= $authenticationObject->registerByPhone($userprofile, $sott, $verification_url, $sms_template);
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
    $result= $authenticationObject->resendEmailVerification($email, $verification_url, $email_template);
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
    $result= $authenticationObject->getProfile($access_token);
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
    $result= $authenticationObject->updateProfile($access_token, $userprofile, $verification_url, $email_template);
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
    $result= $authenticationObject->deleteAccountByEmailConfirmation($access_token, $delete_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Forgot Password
```bush
try{
    $result= $authenticationObject->forgotPassword($email, $reset_password_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Reset Password
```bush
try{
    $result= $authenticationObject->resetPassword($vtoken, $password, $welcome_email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Change account Password
```bush
try{
    $result= $authenticationObject->changeAccountPassword($access_token, $old_password, $new_password);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Add Email
```bush
try{
    $result= $authenticationObject->addEmail($access_token, $email, $type, $verification_url, $email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Remove Email
```bush
try{
    $result= $authenticationObject->removeEmail($access_token, $email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Verify Email
```bush
try{
    $result= $authenticationObject->verifyEmail($vtoken, $url, $welcome_email_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check Availability Of Email
```bush
try{
    $result= $authenticationObject->checkAvailablityOfEmail($email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Change Username
```bush
try{
    $result= $authenticationObject->changeUsername($access_token, $username);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check Username
```bush
try{
    $result= $authenticationObject->checkUsername($username);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Account Link
```bush
try{
    $result= $authenticationObject->accountLink($access_token, $candidate_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Account Unlink
```bush
try{
    $result= $authenticationObject->accountUnlink($access_token, $id, $provider);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Social Profile
```bush
try{
    $result= $authenticationObject->getSocialProfile($access_token, $email_template );
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check Availability of phone
```bush
try{
    $result= $authenticationObject->checkAvailablityOfPhone($phone);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Phone
```bush
try{
    $result= $authenticationObject->updatePhone($access_token, $phone, $smsTemplate);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Resend OTP
```bush
try{
    $result= $authenticationObject->resendOTP($phone, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Resend OTP By Token
```bush
try{
    $result= $authenticationObject->resendOTPByToken($access_token, $phone, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Verify OTP
```bush
try{
    $result= $authenticationObject->verifyOTP($otp, $phone,$sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Verify OTP by token
```bush
try{
    $result= $authenticationObject->verifyOTPByToken($access_token, $otp, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check token validity
```bush
try{
    $result= $authenticationObject->checkTokenValidity($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Invalidate token by access token
```bush
try{
    $result= $authenticationObject->invalidateTokenByAccessToken($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Security Questions By Access Token
```bush
try{
    $result= $authenticationObject->getSecurityQuestionsByAccessToken($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Security Questions By Email
```bush
try{
    $result= $authenticationObject->getSecurityQuestionsByEmail($email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Security Questions By User Name
```bush
try{
    $result= $authenticationObject->getSecurityQuestionsByUserName($username);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Security Questions By Phone
```bush
try{
    $result= $authenticationObject->getSecurityQuestionsByPhone($phone);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Auth Reset Password by Security Question
```bush
try{
    $result= $authenticationObject->authResetPasswordBySecurityQuestion($data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Security Question by Access token
```bush
try{
    $result= $authenticationObject->updateSecurityQuestionByAccessToken($access_token, $data);
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
#####User impersonation API
```bush
   
try{
    $result = $accountObject->getAccessTokenByUid($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Remove Google Authenticator and SMS Authenticator By UID
```bush
   
try{
    $result = $accountObject->removeOrResetGoogleAuthenticator($uid, $otpauthenticator, $googleauthenticator);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Backup code for login by UID
```bush
   
try{
    $result = $accountObject->getBackupCodeForLoginbyUID($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Reset Backup code for login by UID
```bush
   
try{
    $result = $accountObject->resetBackupCodeForLoginbyUID($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Reset phone ID verification
```bush
   
try{
    $result = $accountObject->resetPhoneIdVerification($uid, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Account Update Security Question Configuration
```bush
   
try{
    $result = $accountObject->updateSecurityQuestionByUid($uid, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Server Time
```bush
   
try{
    $result = $accountObject->getServerTime($time_difference);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Generate SOTT
```bush
   
try{
    $result = $accountObject->generateSOTT($time_difference);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```

#### Two Factor Authentication API's
#####2FA Email Login
```bush
try{
    $result= $authenticationObject->twoFALoginByEmail($email, $password, $login_url, $verification_url, $email_template, $sms_template2FA);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####2FA by Google Authenticator Code OR OTP by Token
```bush
try{
    $result= $authenticationObject->verifyTwoFAGoogleAuthenticatorOrOtpByToken($access_token, $google_auth_code, $otp, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####2FA Phone Login
```bush
try{
    $result= $authenticationObject->twoFALoginByPhone($phone, $password, $login_url, $verification_url, $email_template, $sms_template2FA);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####2FA by Token
```bush
try{
    $result= $authenticationObject->configureTwoFAByToken($access_token, $sms_template2FA);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####2FA UserName Login
```bush
try{
    $result= $authenticationObject->twoFALoginByUsername($username, $password, $login_url, $verification_url, $email_template, $sms_template2FA);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####2FA Verify Google Authenticator Code OR OTP
```bush
try{
    $result= $authenticationObject->verifyTwoFAByGoogleAuthCodeOrOtp($second_factor_auth_token, $google_auth_code, $otp, $sms_template2FA);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####2FA Update Phone Number
```bush
try{
    $result= $authenticationObject->twoFAUpdatePhoneNoByOtp($second_factor_auth_token, $data, $sms_template2FA);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####2FA Update Phone Number by Token
```bush
try{
    $result= $authenticationObject->twoFAUpdatePhoneNoByToken($second_factor_auth_token, $data, $sms_template2FA);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Remove Google Authenticator and SMS Authenticator By Token
```bush
try{
    $result= $authenticationObject->removeOrResetGoogleAuthenticatorByToken($second_factor_auth_token, $data, $sms_template2FA);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Backup code for login by access token
```bush
try{
    $result= $authenticationObject->getBackupCodeForLoginbyAccessToken($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get login By Backup code
```bush
try{
    $result= $authenticationObject->getLoginbyBackupCode($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Reset Back Up code by access token
```bush
try{
    $result= $authenticationObject->resetBackupCodebyAccessToken($access_token);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```

#### Instant Link login API's
#####Instant Link Login By Email
```bush
try{
    $result= $authenticationObject->instantLinkLoginByEmail($email, $oneclicksignintemplate, $verificationurl);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}

```
#####Instant Link Login By UserName
```bush
try{
    $result= $authenticationObject->instantLinkLoginByUserName($username, $oneclicksignintemplate, $verificationurl);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}

```
#####Instant Link Login Verification
```bush
try{
    $result= $authenticationObject->instantLinkLoginVerification($verificationtoken, $welcomeemailtemplate);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}

```
#### Email Prompt Auto login API's
#####Auto Login to any device after email verification by email
```bush
try{
    $result= $authenticationObject->emailPromptAutoLoginbyEmail($clientguid, $email, $autologinemailtemplate, $welcomeemailtemplate, $redirecturl);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```

#####Auto Login to any device after email verification by username
```bush
try{
    $result= $authenticationObject->emailPromptAutoLoginbyUserName($clientguid, $username, $autologinemailtemplate, $welcomeemailtemplate,$redirecturl);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Ping login api to verify user in different device
```bush
try{
    $result= $authenticationObject->emailPromptAutoLoginPing($clientguid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Verify Auto Login Email for Login
```bush
try{
    $result= $authenticationObject->verifyAutoLoginEmailForLogin($vtoken, $welcomeemailtemplate);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#### Simplified Registration API's
#####Simplified Instant Registration By Email Id
```bush
try{
    $result= $authenticationObject->simplifiedInstantRegistrationByEmail($email, $name, $clientguid, $redirecturl, $noregistrationemailtemplate, welcomeemailtemplate);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Simplified Instant Registration By Phone
```bush
try{
    $result= $authenticationObject->simplifiedInstantRegistrationByPhone($phone, $name, $smstemplate);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
#####Simplified Instant Registration OTP Verification
```bush
try{
    $result= $authenticationObject->simplifiedInstantRegistrationOTPVerification($otp, $data, $sms_template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#### Custom Registration Data API's
#####Add Registration Data
```bush
try{
    $result= $customRegistrationDataObject->addRegistrationData($data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Validate Registration Data Code
```bush
try{
    $result= $authenticationObject->validateRegistrationDataCode($data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Registration Data
```bush
try{
    $result= $customRegistrationDataObject->getRegistrationData($type, $parent_id, $skip, $limit);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Auth Get Registration Data Server
```bush
try{
    $result= $authenticationObject->authGetRegistrationDataServer($type, $parent_id, $skip, $limit);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Registration Data
```bush
try{
    $result= $customRegistrationDataObject->updateRegistrationData($recordid, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Registration Data
```bush
try{
    $result= $customRegistrationDataObject->deleteRegistrationData($recordid);
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
    $result= $authCustomObject->createCustomObject($access_token, $objectname, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Update Custom Object Data
```bush    
try{
    $result= $authCustomObject->updateCustomObjectData($access_token, $objectname, $object_record_id, $update_type, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Custom Object Sets by token
```bush    
try{
    $result= $authCustomObject->getCustomObjectSetsByToken($access_token, $object_name);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Custom Object Set By ID
```bush
try{
    $result= $authCustomObject->getCustomObjectSetByID($access_token, $object_name, $object_record_id);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Custom Object Set
```bush
try{
    $result= $authCustomObject->deleteCustomObjectSet($access_token, $object_name, $object_record_id);
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
#####Get Context with Roles and Permissions
```bush
   
try{
    $result = $roleObject->getContext($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Add/Update Roles Context
```bush
   
try{
    $result = $roleObject->upsertContext($uid, $rolesContext);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Roles Context by Role Context Name
```bush
   
try{
    $result = $roleObject->deleteContextbyContextName($uid, $roleContextName);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Roles From Context
```bush
   
try{
    $result = $roleObject->deleteRoleFromContext($uid, $roleContextName, $roles);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Delete Additional Permission by Role Context Name
```bush
   
try{
    $result = $roleObject->deleteAdditionalPermissionFromContext($uid, $roleContextName, $additionalPermission);
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
* @param $update_type='xxxxxxxxx';
* Custom Object
* @param $data='{
     * "field1": "Store my field1 value",
     * "field2": "Store my field2 value"
     * }';
* @return type
*/
try{
    $result= $customObject->updateObjectByRecordID($uid, $object_name, $object_record_id, $update_type, $data);
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

#### Call Web Hook APIs
#####Web Hooks Settings
```bush
try{
    $result= $webhookObject->webHooksSettings();
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Subscribe WebHooks
```bush
try{
    $result= $webhookObject->subscribeWebHooks($target_url, $event);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Web Hooks Subscribed Urls
```bush
try{
    $result= $webhookObject->getWebHooksSubscribedUrls($event);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Unsubscribe Web Hooks
```bush
try{
    $result= $webhookObject->unsubscribeWebHooks($target_url, $event);
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