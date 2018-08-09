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
composer require loginradius/php-sdk
```

You can then later update LoginRadius PHP SDK using composer:

```bush
composer update
```

After installing, you need to require Composer's autoloader:

```bush
require 'vendor/autoload.php'
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
use LoginRadiusSDK\LoginRadius;
use LoginRadiusSDK\LoginRadiusException;
use LoginRadiusSDK\SocialLogin\GetProvidersAPI;
use LoginRadiusSDK\SocialLogin\SocialLoginAPI;
use LoginRadiusSDK\CustomerRegistration\UserAPI;
use LoginRadiusSDK\CustomerRegistration\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\CustomObjectAPI;
```
Create a LoginRadius object using API & Secret key:
```bush
// Social API's
$getProviderObject = new GetProvidersAPI(LR_API_KEY, LR_API_SECRET, array('authentication'=>false, 'output_format' => 'json'));

$socialLoginObject = new SocialLoginAPI (LR_API_KEY, LR_API_SECRET, array('authentication'=>false, 'output_format' => 'json'));

// Customer Registration API's
$userObject = new UserAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$accountObject = new AccountAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));

$customObject = new CustomObjectAPI (LR_API_KEY, LR_API_SECRET, array('output_format' => 'json'));
        
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

#### Call UserAPI API's
#####Create User
This API is used to create a new user on your site. This API bypasses the normal email verification process and manually creates the user for your system.
http://apidocs.loginradius.com/docs/create-user
```bush
    /**
     * $data = array("emailid" => "example@example.com",
     * "password" => "FakePass",
     * "firstname" => "Joe",
     * "lastname" => "Smith",
     * "gender" => "M",
     * "birthdate" => "11-08-1987",
     * "Country" => "USA",
     * "city" => "Chicago",
     * "state" => "Illinois ",
     * "phonenumber" => "1232333232",
     * "address1" => "23/43, II Street",
     * "address2" => "Near Paris garden",
     * "company" => "Orange Inc.",
     * "postalcode" => "43435",
     * "emailsubscription" => "true",
     * "customfields" => array(
     *      "example_field1" => "some data 1",
     *      "example_field2" => "some data 2",
     *      "example_field3" => "some data 3"
     * )
     * );
     * /
try{
    $profile= $userObject->create($data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Register User
This API used to register user from server side, verification email will be send to provided email address
http://apidocs.loginradius.com/docs/registration-api
```bush
    /**
     * $data = array("emailid" => "example@example.com",
     * "password" => "FakePass",
     * "firstname" => "Joe",
     * "lastname" => "Smith",
     * "gender" => "M",
     * "birthdate" => "11-08-1987",
     * "Country" => "USA",
     * "city" => "Chicago",
     * "state" => "Illinois ",
     * "phonenumber" => "1232333232",
     * "address1" => "23/43, II Street",
     * "address2" => "Near Paris garden",
     * "company" => "Orange Inc.",
     * "postalcode" => "43435",
     * "emailsubscription" => "true",
     * "customfields" => array(
     *      "example_field1" => "some data 1",
     *      "example_field2" => "some data 2",
     *      "example_field3" => "some data 3"
     * ),
     * "EmailVerificationUrl" => "http://yoursite.com/verifyemail"
     * );
     * /
try{
    $profile= $userObject->registration($data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
##### Update User
This API is used to Modify/Update details of an existing user.
http://apidocs.loginradius.com/docs/update-user
```bush
    /**
     * $user_id = 'xxxxxxxxxxxxxxxxx'; // The LoginRadius user identifier for a particular social platform(like "Facebook", "Twitter") attached with that user account.
     *  $data = array(
     *  firstname => 'first name',
     *  lastname => 'last name',
     *  gender => 'm',
     *  birthdate => 'MM-DD-YYYY',
     *  ....................
     *  ....................
     * );
     * /
try{
    $result= $userObject->edit($user_id, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
##### Delete User with Email Confirmation
This API is used to remove an user's account from LoginRadius system. For security and mis-click concerns, it will send a delete confirmation email to user's email inbox to ask user to confirm the action.
http://apidocs.loginradius.com/docs/user-delete-with-email-confirmation
```bush
/**
 * $user_id = 'xxxxxxxxxxxxxxxxx'; // The LoginRadius user identifier for a particular social platform(like "Facebook", "Twitter") attached with that user account.
 * $deleteuserlink Website link where delete user link will handle.
 *
 */
try{
    $result= $userObject->deleteUserEmail($user_id, $delete_user_link);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
##### User Authentication
This API is used to authenticate users and returns the profile data associated with the authenticated user.
http://apidocs.loginradius.com/docs/user-authentication
```bush
/**
 * $user_name = 'username';//email id
 * $password = 'xxxxxxxxxx';
 */
try{
    $result= $userObject->signIn($user_name, $password);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get User Profile By User ID
This API retrieves the profile data associated with the specific user using the users unique UserID.
http://apidocs.loginradius.com/docs/get-user-profile
```bush
/**
 * $user_id = 'xxxxxxxxxx';
 */
try{
    $result= $userObject->getProfileByID($user_id);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
##### Get User Profile By Email
This API retrieves the profile data associated with the specific user using the passing in email address.
http://apidocs.loginradius.com/docs/user-profile-by-email
```bush
/**
 * $email = 'example@doamin.com';
 */
try{
    $result= $userObject->getProfileByEmail($email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check User Email Availability
This API is used to check the availability of an email from your Customer registration system.
http://apidocs.loginradius.com/docs/user-email-availability-server
```bush
/**
 * $email = 'example@doamin.com';
 */
try{
    $result= $userObject->checkEmail($email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```

#### Call AccountAPI API's
##### Link Account
This API is used to link a user account with a specified providers user account.
http://apidocs.loginradius.com/docs/link-user
```bush
/**
 * @param type $uid
 * @param type $id
 * @param type $provider
 */
try{
    $result = $accountObject->accountLink($uid, $id, $provider);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Unlink Account
This API is used to unlink a user account with a specified providers user account.
http://apidocs.loginradius.com/docs/unlink-user
```bush
/**
 * @param type $uid
 * @param type $id
 * @param type $provider
 */
try{
    $result = $accountObject->accountUnlink($uid, $id, $provider);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Block/Unblock Account
This API is used to block or un-block a user using the users unique UserID (UID).
http://apidocs.loginradius.com/docs/account-blockunblock
```bush
/**
 * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
 * $action = true/false(boolean)
 */
try{
    $result= $accountObject->setStatus($uid, true/false);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
##### Create Registration Profile
This API is used to create a user using the currently logged in social provider.
http://apidocs.loginradius.com/docs/create-user-registration-profile
```bush
/**
 * $data = array(
 *      'accountid'=> uid,
 *      'password'=> 'xxxxxxxxxx',
 *      'emailid'=> 'example@doamin.com'
 * );
 */
try{
    $result = $accountObject->createUserRegistrationProfile($data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```

#####Get User Profiles
This API is used to retrieve all of the profile data from each of the linked social provider accounts associated with the account. For ex: A user has linked facebook and google account then this api will retrieve both profile data.
http://apidocs.loginradius.com/docs/get-user-profiles
```bush
/**
 * $uid = 'xxxxxxxxxxx';
 */
try{
    $result = $accountObject->getAccounts($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
##### Set User Email
This API is used to add or remove a particular email from one user's account.
http://apidocs.loginradius.com/docs/user-email-set
```bush
/**
 * $uid = 'xxxxxxxxxxx';
 * $action Add or remove
 * $data = array(
 *      'emailid'=> 'example@doamin.com',
 *      'emailType'=> 'Business', //Email Type like "Business" or Personal
 *
 * );
 */
try{
    $result = $accountObject->userAdditionalEmail($uid, $action, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
###### Forgot Password token
This API generates a forgot password token so you can manually pass into the reset password page and reset some's password.
http://apidocs.loginradius.com/docs/user-password-forgot-token
```bush
/**
 * $email = 'example@doamin.com';
 */
try{
    $result = $accountObject->forgotPassword($email);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Account Delete
Delete an account from your LoginRadius app.
http://apidocs.loginradius.com/docs/account-delete
```bush
/**
 * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; 
 */
try{
    $result = $accountObject->deleteAccount($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Change Account Password
This API is used to change the password field of an account, you need to know the old password before you change it.
http://apidocs.loginradius.com/docs/account-password-change
```bush
/**
 * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; 
 * $old_password => 'xxxxxxxxxx';
 * $new_password => 'xxxxxxxxxx';
 */
try{
    $result = $accountObject->changeAccountPassword($uid, $old_password, $new_password);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Get Account Password
This API is used to get the password field of an account.
http://apidocs.loginradius.com/docs/account-password-get
```bush
/**
 * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
 */
try{
    $result = $accountObject->getHashPassword($uid);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Set Account Password
This API is used to set a password for an account. It does not require to know the previous(old) password.
http://apidocs.loginradius.com/docs/account-password-set
```bush
/**
 * $uid = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
 * $password = 'xxxxxxxxxx';
 */
try{
    $result = $accountObject->setPassword($uid, $password);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Change UserName
This API is used for changing user name by account Id.
http://apidocs.loginradius.com/docs/user-name-change
```bush
/**
 * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
 * @param type $uid
 * @param type $username
 * @param type $new_username
 */
try{
    $result = $accountObject->changeUsername($uid, $username, $new_username);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Check UserName
This API is used to check username exists or not on your site.
http://apidocs.loginradius.com/docs/user-name-check-server
```bush
/**
 * $username = 'xxxxxx'; //Username that you want to validate
 */
try{
    $result = $accountObject->checkUsername($username);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Set UserName
This API is used for set user name by user Id.
http://apidocs.loginradius.com/docs/user-name-set
```bush
/**
 * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
 * $newusername = 'xxxxxx'  //New username
 */
try{
    $result = $accountObject->setUsername($uid, $newusername);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#####Resend Email Verification
This API is used to generate an email-token that can be sent out to a user in a link in order to verify their email.
http://apidocs.loginradius.com/docs/verification-email-resend
```bush
/**
 * $uid = 'xxxxxx'; // UID, the identifier for each user account, it may have multiple IDs(identifier for each social platform) attached with
 * $email = 'example@doamin.com' //email id //required
 * $link  = 'example.com' //Verification Url link address //required
 * $template = 'xxxxx'  //Verification Email Template
 */
try{
    $result = $accountObject->resendEmailVerification($email, $link, $template);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
#### Call CustomObjectAPI API's
This API is used to retrieve all of the custom objects by account ID (UID).
http://apidocs.loginradius.com/docs/get-custom-object-by-account-id
```bush
/**
 *
 * $object_id = 'xxxxxxxxxxxx';
 * $account_id = 'xxxxxxxxxxxx';
 *
 */
try{
    $result= $customObject->getObjectByAccountid($object_id, $account_id);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
This API is used to retrieve all of the custom objects via a list of account IDs(UID) separated by , (Max 20).
http://apidocs.loginradius.com/docs/get-custom-object-by-multiple-account-ids
```bush
/**
 *
 * $object_id = 'xxxxxxxxxxxx';
 * $account_ids = 'xxxxxxxxxxxx,xxxxxxxxxxxx,xxxxxxxxxxxx';
 *
 */
try{
    $result= $customObject->getObjectByAccountIds($object_id, $account_ids);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
This API is used to retrieve all of the custom objects by an object’s unique ID and filtered by a query
http://apidocs.loginradius.com/docs/get-custom-objects-by-query
```bush
/**
 *
 * $object_id = 'xxxxxxxxxxxx';
 * $query = "<Expression LogicalOperation='AND'>
 *              <Field Name='Provider' ComparisonOperator='Equal'>facebook</Field>
 *              <Expression LogicalOperation='OR'>
 *                  <Field Name='Gender' ComparisonOperator='Equal'>M</Field>
 *                  <Field Name='Gender' ComparisonOperator='Equal'>U</Field>
 *              </Expression>
 *          </Expression>";
 * ------------------ OR ------------------
 * $query = "<Field Name='Gender' ComparisonOperator='Equal'>F</Field>";
 *
 * $nextCursor=>[1]; (optional)
 */
try{
    $result= $customObject->getObjectByQuery($object_id, $query, $next_cursor);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
This API is used to retrieve all records from a custom object.
http://apidocs.loginradius.com/docs/get-all-custom-object-records
```bush
/**
 *
 * $object_id = 'xxxxxxxxxxxx';
 * $nextCursor=>[1]; (optional)
 */
try{
    $result= $customObject->getAllObjects($object_id, $next_cursor);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
This API is used to retrieve stats associated with a custom object
http://apidocs.loginradius.com/docs/get-custom-object-stats
```bush
/**
 *
 * $object_id = 'xxxxxxxxxxxx';
 */
try{
    $result= $customObject->getStats($object_id);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
This API is used to save custom objects, by providing ID of object, to a specified account if the object is not exist it will create a new object.
```bush
/**
 *
 * $object_id = 'xxxxxxxxxxxx';
 * $account_id = 'xxxxxxxxxx';
 * $data = array(
 *  firstname => 'first name',
 *  lastname => 'last name',
 *  gender => 'm',
 *  birthdate => 'MM-DD-YYYY',
 *  ....................
 *  ....................
 * );
 */
try{
    $result= $customObject->upsert($object_id, $account_id, $data);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
This API is used to block Custom Object.
```bush
/**
 *
 * $object_id = 'xxxxxxxxxxxx';
 * $account_id = 'xxxxxxxxxx';
 * $action = true/false(boolean)
 */
try{
    $result= $customObject->setStatus($object_id, $account_id, $action);
}
catch (LoginRadiusException $e){
    $e->getMessage();
    $e->getErrorResponse();
}
```
This API is used to check the existence of a custom object under an account id.
```bush
/**
 *
 * $object_id = 'xxxxxxxxxxxx';
 * $account_id = 'xxxxxxxxxx';
 */
try{
    $result= $customObject->checkObject($object_id, $account_id);
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

use LoginRadiusSDK\LoginRadius;
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