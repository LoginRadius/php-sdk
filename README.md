
LoginRadius
==========

![Home Image](http://docs.lrcontent.com/resources/github/banner-1544x500.png)

-----------------------------------------------
LoginRadius PHP wrapper provides access to LoginRadius.

LoginRadius is a unified **Customer Identity Management** API platform that combines 30 major social platforms into a single simplified and maintenance-free API. With LoginRadius' API, websites and mobile apps can implement capture user profile data, enable social login, enable social sharing, add single sign-on and many more.

LoginRadius helps businesses boost user engagement on their web/mobile platform, manage online identities, utilize social media for marketing, capture accurate consumer data and get unique social insight into their customer base.


PHP Library
=====


-------

>Disclaimer<br>
<br>
This library is meant to help you with a quick implementation of the LoginRadius platform and also to serve as a reference point for the LoginRadius API. Keep in mind that it is an open source library, which means you are free to download and customize the library functions based on your specific application needs.


## Installation

The recommended way to install is through [Composer](http://getcomposer.org/).
 
```
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of library:

```
composer require loginradius/php-sdk:11.0.0
```

Include the following files in your Project Directory

```
require_once "src/LoginRadiusSDK/Utility/Functions.php";
require_once "src/LoginRadiusSDK/LoginRadiusException.php";
require_once "src/LoginRadiusSDK/Clients/IHttpClientInterface.php";
require_once "src/LoginRadiusSDK/Clients/DefaultHttpClient.php";

require_once "src/LoginRadiusSDK/CustomerRegistration/Authentication/AuthenticationAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Authentication/OneTouchLoginAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Authentication/PasswordLessLoginAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Authentication/PhoneAuthenticationAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Authentication/PINAuthenticationAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Authentication/RiskBasedAuthenticationAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Authentication/SmartLoginAPI.php";

require_once "src/LoginRadiusSDK/CustomerRegistration/Account/AccountAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Account/RoleAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Account/SottAPI.php";

require_once "src/LoginRadiusSDK/CustomerRegistration/Advanced/ConfigurationAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Advanced/ConsentManagementAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Advanced/CustomObjectAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Advanced/CustomRegistrationDataAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Advanced/MultiFactorAuthenticationAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Advanced/ReAuthenticationAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Advanced/WebHookAPI.php";

require_once "src/LoginRadiusSDK/CustomerRegistration/Social/NativeSocialAPI.php";
require_once "src/LoginRadiusSDK/CustomerRegistration/Social/SocialAPI.php";
```
Modify the config.php file in the SDK to include your LoginRadius Credentials

## Quickstart Guide

### Configuration

After successful install, you need to define the following LoginRadius Account info in your project anywhere before using the LoginRadius SDK or in the config file of your project:
```
define('APP_NAME', 'LOGINRADIUS_SITE_NAME_HERE'); // Replace LOGINRADIUS_SITE_NAME_HERE with your site name that provide in LoginRadius account.
define('LR_API_KEY', 'LOGINRADIUS_API_KEY_HERE'); // Replace LOGINRADIUS_API_KEY_HERE with your site API key that provide in LoginRadius account.
define('LR_API_SECRET', 'LOGINRADIUS_API_SECRET_HERE'); // Replace LOGINRADIUS_API_SECRET_HERE with your site Secret key that provide in LoginRadius account.

define('API_REQUEST_SIGNING', ''); // Pass boolean true if this option is enabled on you app.
define('API_REGION', ''); // Pass APi Region for your app

define('PROTOCOL', 'PROXY_PROTOCOL'); // Replace PROXY_PROTOCOL with your proxy server protocoal ie http or https.
define('HOST', 'PROXY_HOST'); // Replace PROXY_HOST with your proxy server host.
define('PORT', 'PROXY_PORT'); // Replace PROXY_PORT with your proxy server port.
define('USER', 'PROXY_USER'); // Replace PROXY_USER with your proxy server username.
define('PASSWORD', 'PROXY_PASSWORD'); // Replace PROXY_PASSWORD with your proxy server password.

define('API_DOMAIN', 'DEFINE_CUSTOM_API_DOMAIN');   // Custom API Domain
```

>Replace 'LOGINRADIUS_SITE_NAME_HERE', 'LOGINRADIUS_API_KEY_HERE' and  'LOGINRADIUS_API_SECRET_HERE' in the above code with your LoginRadius Site Name, LoginRadius API Key, and Secret which you can get [here](https://www.loginradius.com/docs/api/v2/admin-console/platform-security/api-key-and-secret).

>API Request Signing:- define('API_REQUEST_SIGNING', true); When initializing the SDK, you can optionally specify enabling this feature. Enabling this feature means the customer does not need to pass an API secret in an API request. Instead, they can pass a dynamically generated hash value. This feature will also make sure that the message is not tampered during transit when someone calls our APIs.

>Pass the **proxy configurations** if you want to **set Http Server Proxy Configuration** through your PHP SDK. Protocol, Host and port are required to set Http Server Proxy configuration (username and password are optional).

>If you have Custom API Domain then define 'API_DOMAIN' then replaced it with your custom API domain, Otherwise no need to define this option in configuration.

### Implementation

Importing/aliasing with the use operator.
```
use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClientInterface;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\SottAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\ConfigurationAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\ConsentManagementAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\CustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\CustomRegistrationDataAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\ReAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\WebHookAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\OneTouchLoginAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PasswordLessLoginAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PhoneAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PINAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\RiskBasedAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\SmartLoginAPI;
use \LoginRadiusSDK\CustomerRegistration\Social\SocialAPI;
use \LoginRadiusSDK\CustomerRegistration\Social\NativeSocialAPI;
```

Create a LoginRadius object :
```
$accountObject = new AccountAPI();

```

### API Examples

#### Partial API response
We have an option to select fields(partial response) which you require as an API response.<br>
For this, you need to pass an extra parameter(optional) at the end of each API function.

- If any field passed does not exist in response, will be ignored.
- In case of nested, only root object is selectable.
- Values should be separated by the comma.

**Example:**

```

$fields= "email, username";
$email = 'xxxxxr@xxxxx.com';

$result = $accountObject->accountProfileByEmail($email,$fields);

```

**Output Response:**

```
{
    UserName: 'test1213',
    Email: [ { Type: 'Primary', Value: 'test1213@sthus.com' } ]
}

```



### Authentication API

List of APIs in this Section:<br>
[PUT : Auth Update Profile by Token](#UpdateProfileByAccessToken-put-)<br>
[PUT : Auth Unlock Account by Access Token](#UnlockAccountByToken-put-)<br>
[PUT : Auth Verify Email By OTP](#VerifyEmailByOTP-put-)<br>
[PUT : Auth Reset Password by Security Answer and Email](#ResetPasswordBySecurityAnswerAndEmail-put-)<br>
[PUT : Auth Reset Password by Security Answer and Phone](#ResetPasswordBySecurityAnswerAndPhone-put-)<br>
[PUT : Auth Reset Password by Security Answer and UserName](#ResetPasswordBySecurityAnswerAndUserName-put-)<br>
[PUT : Auth Reset Password by Reset Token](#ResetPasswordByResetToken-put-)<br>
[PUT : Auth Reset Password by OTP](#ResetPasswordByEmailOTP-put-)<br>
[PUT : Auth Reset Password by OTP and UserName](#ResetPasswordByOTPAndUserName-put-)<br>
[PUT : Auth Change Password](#ChangePassword-put-)<br>
[PUT : Auth Set or Change UserName](#SetOrChangeUserName-put-)<br>
[PUT : Auth Resend Email Verification](#AuthResendEmailVerification-put-)<br>
[POST : Auth Add Email](#AddEmail-post-)<br>
[POST : Auth Login by Email](#LoginByEmail-post-)<br>
[POST : Auth Login by Username](#LoginByUserName-post-)<br>
[POST : Auth Forgot Password](#ForgotPassword-post-)<br>
[POST : Auth Link Social Identities](#LinkSocialIdentities-post-)<br>
[POST : Auth Link Social Identities By Ping](#LinkSocialIdentitiesByPing-post-)<br>
[POST : Auth User Registration by Email](#UserRegistrationByEmail-post-)<br>
[POST : Auth User Registration By Captcha](#UserRegistrationByCaptcha-post-)<br>
[GET : Get Security Questions By Email](#GetSecurityQuestionsByEmail-get-)<br>
[GET : Get Security Questions By UserName](#GetSecurityQuestionsByUserName-get-)<br>
[GET : Get Security Questions By Phone](#GetSecurityQuestionsByPhone-get-)<br>
[GET : Get Security Questions By Access Token](#GetSecurityQuestionsByAccessToken-get-)<br>
[GET : Auth Validate Access token](#AuthValidateAccessToken-get-)<br>
[GET : Access Token Invalidate](#AuthInValidateAccessToken-get-)<br>
[GET : Access Token Info](#GetAccessTokenInfo-get-)<br>
[GET : Auth Read all Profiles by Token](#GetProfileByAccessToken-get-)<br>
[GET : Auth Send Welcome Email](#SendWelcomeEmail-get-)<br>
[GET : Auth Delete Account](#DeleteAccountByDeleteToken-get-)<br>
[GET : Auth Check Email Availability](#CheckEmailAvailability-get-)<br>
[GET : Auth Verify Email](#VerifyEmail-get-)<br>
[GET : Auth Check UserName Availability](#CheckUserNameAvailability-get-)<br>
[GET : Auth Privacy Policy Accept](#AcceptPrivacyPolicy-get-)<br>
[GET : Auth Privacy Policy History By Access Token](#GetPrivacyPolicyHistoryByAccessToken-get-)<br>
[DELETE : Auth Delete Account with Email Confirmation](#DeleteAccountWithEmailConfirmation-delete-)<br>
[DELETE : Auth Remove Email](#RemoveEmail-delete-)<br>
[DELETE : Auth Unlink Social Identities](#UnlinkSocialIdentities-delete-)<br>

If you have not already initialized the Authentication object do so now
```
$authenticationAPI = new AuthenticationAPI(); 
```


<h6 id="UpdateProfileByAccessToken-put-">Auth Update Profile by Token (PUT)</h6>
This API is used to update the user's profile by passing the access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-update-profile-by-token/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"firstName" : "<firstName>",
"lastName" : "<lastName>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$nullSupport = "true"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $authenticationAPI->updateProfileByAccessToken($access_token,$payload,$emailTemplate,$fields,$nullSupport,$smsTemplate,$verificationUrl);
 ```

 
<h6 id="UnlockAccountByToken-put-">Auth Unlock Account by Access Token (PUT)</h6>
This API is used to allow a customer with a valid access token to unlock their account provided that they successfully pass the prompted Bot Protection challenges. The Block or Suspend block types are not applicable for this API. For additional details see our Auth Security Configuration documentation.You are only required to pass the Post Parameters that correspond to the prompted challenges.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-unlock-account-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"g-recaptcha-response" : "<g-recaptcha-response>"
}';  //Required
 
$result = $authenticationAPI->unlockAccountByToken($access_token,$payload);
 ```

 
<h6 id="VerifyEmailByOTP-put-">Auth Verify Email By OTP (PUT)</h6>
This API is used to verify the email of user when the OTP Email verification flow is enabled, please note that you must contact LoginRadius to have this feature enabled.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-verify-email-by-otp/)

 ```

 $payload = '{
"email" : "<email>",
"otp" : "<otp>"
}';  //Required 
$fields = null; //Optional 
$url = "url"; //Optional 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $authenticationAPI->verifyEmailByOTP($payload,$fields,$url,$welcomeEmailTemplate);
 ```

 
<h6 id="ResetPasswordBySecurityAnswerAndEmail-put-">Auth Reset Password by Security Answer and Email (PUT)</h6>
This API is used to reset password for the specified account by security question
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-reset-password-by-email)

 ```

 $payload = '{
"email" : "<email>",
"password" : "<password>",
"securityAnswer" : {"QuestionID":"Answer"}
}';  //Required
 
$result = $authenticationAPI->resetPasswordBySecurityAnswerAndEmail($payload);
 ```

 
<h6 id="ResetPasswordBySecurityAnswerAndPhone-put-">Auth Reset Password by Security Answer and Phone (PUT)</h6>
This API is used to reset password for the specified account by security question
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-reset-password-by-phone)

 ```

 $payload = '{
"password" : "<password>",
"phone" : "<phone>",
"securityAnswer" : {"QuestionID":"Answer"}
}';  //Required
 
$result = $authenticationAPI->resetPasswordBySecurityAnswerAndPhone($payload);
 ```

 
<h6 id="ResetPasswordBySecurityAnswerAndUserName-put-">Auth Reset Password by Security Answer and UserName (PUT)</h6>
This API is used to reset password for the specified account by security question
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-reset-password-by-username)

 ```

 $payload = '{
"password" : "<password>",
"securityAnswer" : {"QuestionID":"Answer"},
"userName" : "<userName>"
}';  //Required
 
$result = $authenticationAPI->resetPasswordBySecurityAnswerAndUserName($payload);
 ```

 
<h6 id="ResetPasswordByResetToken-put-">Auth Reset Password by Reset Token (PUT)</h6>
This API is used to set a new password for the specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-reset-password-by-reset-token)

 ```

 $payload = '{
"password" : "<password>",
"resetToken" : "<resetToken>"
}';  //Required
 
$result = $authenticationAPI->resetPasswordByResetToken($payload);
 ```

 
<h6 id="ResetPasswordByEmailOTP-put-">Auth Reset Password by OTP (PUT)</h6>
This API is used to set a new password for the specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-reset-password-by-otp)

 ```

 $payload = '{
"email" : "<email>",
"otp" : "<otp>",
"password" : "<password>"
}';  //Required
 
$result = $authenticationAPI->resetPasswordByEmailOTP($payload);
 ```

 
<h6 id="ResetPasswordByOTPAndUserName-put-">Auth Reset Password by OTP and UserName (PUT)</h6>
This API is used to set a new password for the specified account if you are using the username as the unique identifier in your workflow
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-reset-password-by-otp-and-username/)

 ```

 $payload = '{
"otp" : "<otp>",
"password" : "<password>",
"userName" : "<userName>"
}';  //Required
 
$result = $authenticationAPI->resetPasswordByOTPAndUserName($payload);
 ```

 
<h6 id="ChangePassword-put-">Auth Change Password (PUT)</h6>
This API is used to change the accounts password based on the previous password
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-change-password)

 ```
 
$access_token = "access_token"; //Required 
$newPassword = "newPassword"; //Required 
$oldPassword = "oldPassword"; //Required
 
$result = $authenticationAPI->changePassword($access_token,$newPassword,$oldPassword);
 ```

 
<h6 id="SetOrChangeUserName-put-">Auth Set or Change UserName (PUT)</h6>
This API is used to set or change UserName by access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-set-or-change-user-name/)

 ```
 
$access_token = "access_token"; //Required 
$username = "username"; //Required
 
$result = $authenticationAPI->setOrChangeUserName($access_token,$username);
 ```

 
<h6 id="AuthResendEmailVerification-put-">Auth Resend Email Verification (PUT)</h6>
This API resends the verification email to the user.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-resend-email-verification/)

 ```
 
$email = "email"; //Required 
$emailTemplate = "emailTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $authenticationAPI->authResendEmailVerification($email,$emailTemplate,$verificationUrl);
 ```

 
<h6 id="AddEmail-post-">Auth Add Email (POST)</h6>
This API is used to add additional emails to a user's account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-add-email)

 ```
 
$access_token = "access_token"; //Required 
$email = "email"; //Required 
$type = "type"; //Required 
$emailTemplate = "emailTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $authenticationAPI->addEmail($access_token,$email,$type,$emailTemplate,$verificationUrl);
 ```

 
<h6 id="LoginByEmail-post-">Auth Login by Email (POST)</h6>
This API retrieves a copy of the user data based on the Email
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-login-by-email)

 ```

 $payload = '{
"email" : "<email>",
"password" : "<password>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $authenticationAPI->loginByEmail($payload,$emailTemplate,$fields,$loginUrl,$verificationUrl);
 ```

 
<h6 id="LoginByUserName-post-">Auth Login by Username (POST)</h6>
This API retrieves a copy of the user data based on the Username
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-login-by-username)

 ```

 $payload = '{
"password" : "<password>",
"username" : "<username>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $authenticationAPI->loginByUserName($payload,$emailTemplate,$fields,$loginUrl,$verificationUrl);
 ```

 
<h6 id="ForgotPassword-post-">Auth Forgot Password (POST)</h6>
This API is used to send the reset password url to a specified account. Note: If you have the UserName workflow enabled, you may replace the 'email' parameter with 'username'
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-forgot-password)

 ```
 
$email = "email"; //Required 
$resetPasswordUrl = "resetPasswordUrl"; //Required 
$emailTemplate = "emailTemplate"; //Optional
 
$result = $authenticationAPI->forgotPassword($email,$resetPasswordUrl,$emailTemplate);
 ```

 
<h6 id="LinkSocialIdentities-post-">Auth Link Social Identities (POST)</h6>
This API is used to link up a social provider account with an existing LoginRadius account on the basis of access token and the social providers user access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-link-social-identities)

 ```
 
$access_token = "access_token"; //Required 
$candidateToken = "candidateToken"; //Required
 
$result = $authenticationAPI->linkSocialIdentities($access_token,$candidateToken);
 ```

 
<h6 id="LinkSocialIdentitiesByPing-post-">Auth Link Social Identities By Ping (POST)</h6>
This API is used to link up a social provider account with an existing LoginRadius account on the basis of ping and the social providers user access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-link-social-identities-by-ping)

 ```
 
$access_token = "access_token"; //Required 
$clientGuid = "clientGuid"; //Required
 
$result = $authenticationAPI->linkSocialIdentitiesByPing($access_token,$clientGuid);
 ```

 
<h6 id="UserRegistrationByEmail-post-">Auth User Registration by Email (POST)</h6>
This API creates a user in the database as well as sends a verification email to the user.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-user-registration-by-email)

 ```

 $payload = '{
"email" : [   { 
 "type" : "<type>"  ,
 "value" : "<value>"   
}  ] ,
"firstName" : "<firstName>",
"lastName" : "<lastName>",
"password" : "<password>"
}';  //Required 
$sott = "sott"; //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$options = "options"; //Optional 
$verificationUrl = "verificationUrl"; //Optional 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $authenticationAPI->userRegistrationByEmail($payload,$sott,$emailTemplate,$fields,$options,$verificationUrl,$welcomeEmailTemplate);
 ```

 
<h6 id="UserRegistrationByCaptcha-post-">Auth User Registration By Captcha (POST)</h6>
This API creates a user in the database as well as sends a verification email to the user.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-user-registration-by-recaptcha)

 ```

 $payload = '{
"email" : [   { 
 "type" : "<type>"  ,
 "value" : "<value>"   
}  ] ,
"firstName" : "<firstName>",
"g-recaptcha-response" : "<g-recaptcha-response>",
"lastName" : "<lastName>",
"password" : "<password>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$options = "options"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $authenticationAPI->userRegistrationByCaptcha($payload,$emailTemplate,$fields,$options,$smsTemplate,$verificationUrl,$welcomeEmailTemplate);
 ```

 
<h6 id="GetSecurityQuestionsByEmail-get-">Get Security Questions By Email (GET)</h6>
This API is used to retrieve the list of questions that are configured on the respective LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/security-questions-by-email/)

 ```
 
$email = "email"; //Required
 
$result = $authenticationAPI->getSecurityQuestionsByEmail($email);
 ```

 
<h6 id="GetSecurityQuestionsByUserName-get-">Get Security Questions By UserName (GET)</h6>
This API is used to retrieve the list of questions that are configured on the respective LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/security-questions-by-user-name/)

 ```
 
$userName = "userName"; //Required
 
$result = $authenticationAPI->getSecurityQuestionsByUserName($userName);
 ```

 
<h6 id="GetSecurityQuestionsByPhone-get-">Get Security Questions By Phone (GET)</h6>
This API is used to retrieve the list of questions that are configured on the respective LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/security-questions-by-phone/)

 ```
 
$phone = "phone"; //Required
 
$result = $authenticationAPI->getSecurityQuestionsByPhone($phone);
 ```

 
<h6 id="GetSecurityQuestionsByAccessToken-get-">Get Security Questions By Access Token (GET)</h6>
This API is used to retrieve the list of questions that are configured on the respective LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/security-questions-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 
$result = $authenticationAPI->getSecurityQuestionsByAccessToken($access_token);
 ```

 
<h6 id="AuthValidateAccessToken-get-">Auth Validate Access token (GET)</h6>
This api validates access token, if valid then returns a response with its expiry otherwise error.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-validate-access-token/)

 ```
 
$access_token = "access_token"; //Required
 
$result = $authenticationAPI->authValidateAccessToken($access_token);
 ```

 
<h6 id="AuthInValidateAccessToken-get-">Access Token Invalidate (GET)</h6>
This api call invalidates the active access token or expires an access token's validity.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-invalidate-access-token/)

 ```
 
$access_token = "access_token"; //Required 
$preventRefresh = "true"; //Optional
 
$result = $authenticationAPI->authInValidateAccessToken($access_token,$preventRefresh);
 ```

 
<h6 id="GetAccessTokenInfo-get-">Access Token Info (GET)</h6>
This api call provide the active access token Information
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-access-token-info/)

 ```
 
$access_token = "access_token"; //Required
 
$result = $authenticationAPI->getAccessTokenInfo($access_token);
 ```

 
<h6 id="GetProfileByAccessToken-get-">Auth Read all Profiles by Token (GET)</h6>
This API retrieves a copy of the user data based on the access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-read-profiles-by-token/)

 ```
 
$access_token = "access_token"; //Required 
$fields = null; //Optional
 
$result = $authenticationAPI->getProfileByAccessToken($access_token,$fields);
 ```

 
<h6 id="SendWelcomeEmail-get-">Auth Send Welcome Email (GET)</h6>
This API sends a welcome email
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-send-welcome-email/)

 ```
 
$access_token = "access_token"; //Required 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $authenticationAPI->sendWelcomeEmail($access_token,$welcomeEmailTemplate);
 ```

 
<h6 id="DeleteAccountByDeleteToken-get-">Auth Delete Account (GET)</h6>
This API is used to delete an account by passing it a delete token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-delete-account/)

 ```
 
$deletetoken = "deletetoken"; //Required
 
$result = $authenticationAPI->deleteAccountByDeleteToken($deletetoken);
 ```

 
<h6 id="CheckEmailAvailability-get-">Auth Check Email Availability (GET)</h6>
This API is used to check the email exists or not on your site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-email-availability/)

 ```
 
$email = "email"; //Required
 
$result = $authenticationAPI->checkEmailAvailability($email);
 ```

 
<h6 id="VerifyEmail-get-">Auth Verify Email (GET)</h6>
This API is used to verify the email of user. Note: This API will only return the full profile if you have 'Enable auto login after email verification' set in your LoginRadius Admin Console's Email Workflow settings under 'Verification Email'.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-verify-email/)

 ```
 
$verificationToken = "verificationToken"; //Required 
$fields = null; //Optional 
$url = "url"; //Optional 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $authenticationAPI->verifyEmail($verificationToken,$fields,$url,$welcomeEmailTemplate);
 ```

 
<h6 id="CheckUserNameAvailability-get-">Auth Check UserName Availability (GET)</h6>
This API is used to check the UserName exists or not on your site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-username-availability/)

 ```
 
$username = "username"; //Required
 
$result = $authenticationAPI->checkUserNameAvailability($username);
 ```

 
<h6 id="AcceptPrivacyPolicy-get-">Auth Privacy Policy Accept (GET)</h6>
This API is used to update the privacy policy stored in the user's profile by providing the access token of the user accepting the privacy policy
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-privacy-policy-accept)

 ```
 
$access_token = "access_token"; //Required 
$fields = null; //Optional
 
$result = $authenticationAPI->acceptPrivacyPolicy($access_token,$fields);
 ```

 
<h6 id="GetPrivacyPolicyHistoryByAccessToken-get-">Auth Privacy Policy History By Access Token (GET)</h6>
This API will return all the accepted privacy policies for the user by providing the access token of that user.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/privacy-policy-history-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 
$result = $authenticationAPI->getPrivacyPolicyHistoryByAccessToken($access_token);
 ```

 
<h6 id="DeleteAccountWithEmailConfirmation-delete-">Auth Delete Account with Email Confirmation (DELETE)</h6>
This API will send a confirmation email for account deletion to the customer's email when passed the customer's access token
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-delete-account-with-email-confirmation/)

 ```
 
$access_token = "access_token"; //Required 
$deleteUrl = "deleteUrl"; //Optional 
$emailTemplate = "emailTemplate"; //Optional
 
$result = $authenticationAPI->deleteAccountWithEmailConfirmation($access_token,$deleteUrl,$emailTemplate);
 ```

 
<h6 id="RemoveEmail-delete-">Auth Remove Email (DELETE)</h6>
This API is used to remove additional emails from a user's account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-remove-email)

 ```
 
$access_token = "access_token"; //Required 
$email = "email"; //Required
 
$result = $authenticationAPI->removeEmail($access_token,$email);
 ```

 
<h6 id="UnlinkSocialIdentities-delete-">Auth Unlink Social Identities (DELETE)</h6>
This API is used to unlink up a social provider account with the specified account based on the access token and the social providers user access token. The unlinked account will automatically get removed from your database.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-unlink-social-identities)

 ```
 
$access_token = "access_token"; //Required 
$provider = "provider"; //Required 
$providerId = "providerId"; //Required
 
$result = $authenticationAPI->unlinkSocialIdentities($access_token,$provider,$providerId);
 ```

 



### Account API

List of APIs in this Section:<br>
[PUT : Account Update](#UpdateAccountByUid-put-)<br>
[PUT : Update Phone ID by UID](#UpdatePhoneIDByUid-put-)<br>
[PUT : Account Set Password](#SetAccountPasswordByUid-put-)<br>
[PUT : Account Invalidate Verification Email](#InvalidateAccountEmailVerification-put-)<br>
[PUT : Reset phone ID verification](#ResetPhoneIDVerificationByUid-put-)<br>
[PUT : Upsert Email](#UpsertEmail-put-)<br>
[POST : Account Create](#CreateAccount-post-)<br>
[POST : Forgot Password token](#GetForgotPasswordToken-post-)<br>
[POST : Email Verification token](#GetEmailVerificationToken-post-)<br>
[GET : Get Privacy Policy History By Uid](#GetPrivacyPolicyHistoryByUid-get-)<br>
[GET : Account Profiles by Email](#GetAccountProfileByEmail-get-)<br>
[GET : Account Profiles by Username](#GetAccountProfileByUserName-get-)<br>
[GET : Account Profile by Phone ID](#GetAccountProfileByPhone-get-)<br>
[GET : Account Profiles by UID](#GetAccountProfileByUid-get-)<br>
[GET : Account Password](#GetAccountPasswordHashByUid-get-)<br>
[GET : Access Token based on UID or User impersonation API](#GetAccessTokenByUid-get-)<br>
[GET : Refresh Access Token by Refresh Token](#RefreshAccessTokenByRefreshToken-get-)<br>
[GET : Revoke Refresh Token](#RevokeRefreshToken-get-)<br>
[GET : Account Identities by Email](#GetAccountIdentitiesByEmail-get-)<br>
[DELETE : Account Delete](#DeleteAccountByUid-delete-)<br>
[DELETE : Account Remove Email](#RemoveEmail-delete-)<br>
[DELETE : Delete User Profiles By Email](#AccountDeleteByEmail-delete-)<br>

If you have not already initialized the Account object do so now
```
$accountAPI = new AccountAPI(); 
```


<h6 id="UpdateAccountByUid-put-">Account Update (PUT)</h6>
This API is used to update the information of existing accounts in your Cloud Storage. See our Advanced API Usage section <a href='https://www.loginradius.com/docs/api/v2/customer-identity-api/advanced-api-usage/'>Here</a> for more capabilities.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-update)

 ```

 $payload = '{
"firstName" : "<firstName>",
"lastName" : "<lastName>"
}';  //Required 
$uid = "uid"; //Required 
$fields = null; //Optional 
$nullSupport = "true"; //Optional
 
$result = $accountAPI->updateAccountByUid($payload,$uid,$fields,$nullSupport);
 ```

 
<h6 id="UpdatePhoneIDByUid-put-">Update Phone ID by UID (PUT)</h6>
This API is used to update the PhoneId by using the Uid's. Admin can update the PhoneId's for both the verified and unverified profiles. It will directly replace the PhoneId and bypass the OTP verification process.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/update-phoneid-by-uid)

 ```
 
$phone = "phone"; //Required 
$uid = "uid"; //Required 
$fields = null; //Optional
 
$result = $accountAPI->updatePhoneIDByUid($phone,$uid,$fields);
 ```

 
<h6 id="SetAccountPasswordByUid-put-">Account Set Password (PUT)</h6>
This API is used to set the password of an account in Cloud Storage.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-set-password)

 ```
 
$password = "password"; //Required 
$uid = "uid"; //Required
 
$result = $accountAPI->setAccountPasswordByUid($password,$uid);
 ```

 
<h6 id="InvalidateAccountEmailVerification-put-">Account Invalidate Verification Email (PUT)</h6>
This API is used to invalidate the Email Verification status on an account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-invalidate-verification-email)

 ```
 
$uid = "uid"; //Required 
$emailTemplate = "emailTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $accountAPI->invalidateAccountEmailVerification($uid,$emailTemplate,$verificationUrl);
 ```

 
<h6 id="ResetPhoneIDVerificationByUid-put-">Reset phone ID verification (PUT)</h6>
This API Allows you to reset the phone no verification of an end user’s account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/reset-phone-id-verification)

 ```
 
$uid = "uid"; //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $accountAPI->resetPhoneIDVerificationByUid($uid,$smsTemplate);
 ```

 
<h6 id="UpsertEmail-put-">Upsert Email (PUT)</h6>
This API is used to add/upsert another emails in account profile by different-different email types. If the email type is same then it will simply update the existing email, otherwise it will add a new email in Email array.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/upsert-email)

 ```

 $payload = '{
"email" : [   { 
 "type" : "<type>"  ,
 "value" : "<value>"   
}  ] 
}';  //Required 
$uid = "uid"; //Required 
$fields = null; //Optional
 
$result = $accountAPI->upsertEmail($payload,$uid,$fields);
 ```

 
<h6 id="CreateAccount-post-">Account Create (POST)</h6>
This API is used to create an account in Cloud Storage. This API bypass the normal email verification process and manually creates the user. <br><br>In order to use this API, you need to format a JSON request body with all of the mandatory fields
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-create)

 ```

 $payload = '{
"email" : [   { 
 "type" : "<type>"  ,
 "value" : "<value>"   
}  ] ,
"firstName" : "<firstName>",
"lastName" : "<lastName>",
"password" : "<password>"
}';  //Required 
$fields = null; //Optional
 
$result = $accountAPI->createAccount($payload,$fields);
 ```

 
<h6 id="GetForgotPasswordToken-post-">Forgot Password token (POST)</h6>
This API Returns a Forgot Password Token it can also be used to send a Forgot Password email to the customer. Note: If you have the UserName workflow enabled, you may replace the 'email' parameter with 'username' in the body.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/get-forgot-password-token)

 ```
 
$email = "email"; //Required 
$emailTemplate = "emailTemplate"; //Optional 
$resetPasswordUrl = "resetPasswordUrl"; //Optional 
$sendEmail = "true"; //Optional
 
$result = $accountAPI->getForgotPasswordToken($email,$emailTemplate,$resetPasswordUrl,$sendEmail);
 ```

 
<h6 id="GetEmailVerificationToken-post-">Email Verification token (POST)</h6>
This API Returns an Email Verification token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/get-email-verification-token)

 ```
 
$email = "email"; //Required
 
$result = $accountAPI->getEmailVerificationToken($email);
 ```

 
<h6 id="GetPrivacyPolicyHistoryByUid-get-">Get Privacy Policy History By Uid (GET)</h6>
This API is used to retrieve all of the accepted Policies by the user, associated with their UID.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/privacy-policy-history-by-uid/)

 ```
 
$uid = "uid"; //Required
 
$result = $accountAPI->getPrivacyPolicyHistoryByUid($uid);
 ```

 
<h6 id="GetAccountProfileByEmail-get-">Account Profiles by Email (GET)</h6>
This API is used to retrieve all of the profile data, associated with the specified account by email in Cloud Storage.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-profiles-by-email)

 ```
 
$email = "email"; //Required 
$fields = null; //Optional
 
$result = $accountAPI->getAccountProfileByEmail($email,$fields);
 ```

 
<h6 id="GetAccountProfileByUserName-get-">Account Profiles by Username (GET)</h6>
This API is used to retrieve all of the profile data associated with the specified account by user name in Cloud Storage.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-profiles-by-user-name)

 ```
 
$userName = "userName"; //Required 
$fields = null; //Optional
 
$result = $accountAPI->getAccountProfileByUserName($userName,$fields);
 ```

 
<h6 id="GetAccountProfileByPhone-get-">Account Profile by Phone ID (GET)</h6>
This API is used to retrieve all of the profile data, associated with the account by phone number in Cloud Storage.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-profiles-by-phone-id/)

 ```
 
$phone = "phone"; //Required 
$fields = null; //Optional
 
$result = $accountAPI->getAccountProfileByPhone($phone,$fields);
 ```

 
<h6 id="GetAccountProfileByUid-get-">Account Profiles by UID (GET)</h6>
This API is used to retrieve all of the profile data, associated with the account by uid in Cloud Storage.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-profiles-by-uid)

 ```
 
$uid = "uid"; //Required 
$fields = null; //Optional
 
$result = $accountAPI->getAccountProfileByUid($uid,$fields);
 ```

 
<h6 id="GetAccountPasswordHashByUid-get-">Account Password (GET)</h6>
This API use to retrive the hashed password of a specified account in Cloud Storage.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-password)

 ```
 
$uid = "uid"; //Required
 
$result = $accountAPI->getAccountPasswordHashByUid($uid);
 ```

 
<h6 id="GetAccessTokenByUid-get-">Access Token based on UID or User impersonation API (GET)</h6>
The API is used to get LoginRadius access token based on UID.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-impersonation-api)

 ```
 
$uid = "uid"; //Required
 
$result = $accountAPI->getAccessTokenByUid($uid);
 ```

 
<h6 id="RefreshAccessTokenByRefreshToken-get-">Refresh Access Token by Refresh Token (GET)</h6>
This API is used to refresh an access token via it's associated refresh token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/refresh-token/refresh-access-token-by-refresh-token)

 ```
 
$refresh_Token = "refresh_Token"; //Required
 
$result = $accountAPI->refreshAccessTokenByRefreshToken($refresh_Token);
 ```

 
<h6 id="RevokeRefreshToken-get-">Revoke Refresh Token (GET)</h6>
The Revoke Refresh Access Token API is used to revoke a refresh token or the Provider Access Token, revoking an existing refresh token will invalidate the refresh token but the associated access token will work until the expiry.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/refresh-token/revoke-refresh-token)

 ```
 
$refresh_Token = "refresh_Token"; //Required
 
$result = $accountAPI->revokeRefreshToken($refresh_Token);
 ```

 
<h6 id="GetAccountIdentitiesByEmail-get-">Account Identities by Email (GET)</h6>
Note: This is intended for specific workflows where an email may be associated to multiple UIDs. This API is used to retrieve all of the identities (UID and Profiles), associated with a specified email in Cloud Storage.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-identities-by-email)

 ```
 
$email = "email"; //Required 
$fields = null; //Optional
 
$result = $accountAPI->getAccountIdentitiesByEmail($email,$fields);
 ```

 
<h6 id="DeleteAccountByUid-delete-">Account Delete (DELETE)</h6>
This API deletes the Users account and allows them to re-register for a new account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-delete)

 ```
 
$uid = "uid"; //Required
 
$result = $accountAPI->deleteAccountByUid($uid);
 ```

 
<h6 id="RemoveEmail-delete-">Account Remove Email (DELETE)</h6>
Use this API to Remove emails from a user Account
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-email-delete)

 ```
 
$email = "email"; //Required 
$uid = "uid"; //Required 
$fields = null; //Optional
 
$result = $accountAPI->removeEmail($email,$uid,$fields);
 ```

 
<h6 id="AccountDeleteByEmail-delete-">Delete User Profiles By Email (DELETE)</h6>
This API is used to delete all user profiles associated with an Email.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/account/account-email-delete/)

 ```
 
$email = "email"; //Required
 
$result = $accountAPI->accountDeleteByEmail($email);
 ```

 



### Social API

List of APIs in this Section:<br>
[POST : Post Message API](#PostMessage-post-)<br>
[POST : Status Posting ](#StatusPosting-post-)<br>
[POST : Trackable Status Posting](#TrackableStatusPosting-post-)<br>
[GET : Access Token](#ExchangeAccessToken-get-)<br>
[GET : Refresh Token](#RefreshAccessToken-get-)<br>
[GET : Token Validate](#ValidateAccessToken-get-)<br>
[GET : Access Token Invalidate](#InValidateAccessToken-get-)<br>
[GET : Get Active Session Details](#GetActiveSession-get-)<br>
[GET : Get Active Session By Account Id](#GetActiveSessionByAccountID-get-)<br>
[GET : Get Active Session By Profile Id](#GetActiveSessionByProfileID-get-)<br>
[GET : Album](#GetAlbums-get-)<br>
[GET : Get Albums with cursor](#GetAlbumsWithCursor-get-)<br>
[GET : Audio](#GetAudios-get-)<br>
[GET : Get Audio With Cursor](#GetAudiosWithCursor-get-)<br>
[GET : Check In](#GetCheckIns-get-)<br>
[GET : Get CheckIns With Cursor](#GetCheckInsWithCursor-get-)<br>
[GET : Contact](#GetContacts-get-)<br>
[GET : Event](#GetEvents-get-)<br>
[GET : Get Events With Cursor](#GetEventsWithCursor-get-)<br>
[GET : Following](#GetFollowings-get-)<br>
[GET : Get Followings With Cursor](#GetFollowingsWithCursor-get-)<br>
[GET : Group](#GetGroups-get-)<br>
[GET : Get Groups With Cursor](#GetGroupsWithCursor-get-)<br>
[GET : Like](#GetLikes-get-)<br>
[GET : Get Likes With Cursor](#GetLikesWithCursor-get-)<br>
[GET : Mention](#GetMentions-get-)<br>
[GET : Page](#GetPage-get-)<br>
[GET : Photo](#GetPhotos-get-)<br>
[GET : Get Post](#GetPosts-get-)<br>
[GET : Get Trackable Status Stats](#GetTrackableStatusStats-get-)<br>
[GET : Trackable Status Fetching](#TrackableStatusFetching-get-)<br>
[GET : User Profile](#GetSocialUserProfile-get-)<br>
[GET : Refresh User Profile](#GetRefreshedSocialUserProfile-get-)<br>
[GET : Video](#GetVideos-get-)<br>

If you have not already initialized the Social object do so now
```
$socialAPI = new SocialAPI(); 
```


<h6 id="PostMessage-post-">Post Message API (POST)</h6>
Post Message API is used to post messages to the user's contacts.<br><br><b>Supported Providers:</b> Twitter, LinkedIn <br><br>The Message API is used to post messages to the user?s contacts. This is one of the APIs that makes up the LoginRadius Friend Invite System. After using the Contact API, you can send messages to the retrieved contacts. This API requires setting permissions in your LoginRadius Dashboard.<br><br>GET & POST Message API work the same way except the API method is different
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/post-message-api)

 ```
 
$access_Token = "access_Token"; //Required 
$message = "message"; //Required 
$subject = "subject"; //Required 
$to = "to"; //Required
 
$result = $socialAPI->postMessage($access_Token,$message,$subject,$to);
 ```

 
<h6 id="StatusPosting-post-">Status Posting  (POST)</h6>
The Status API is used to update the status on the user's wall.<br><br><b>Supported Providers:</b>  Facebook, Twitter, LinkedIn
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/status-posting/)

 ```
 
$access_Token = "access_Token"; //Required 
$caption = "caption"; //Required 
$description = "description"; //Required 
$imageurl = "imageurl"; //Required 
$status = "status"; //Required 
$title = "title"; //Required 
$url = "url"; //Required 
$shorturl = "shorturl"; //Optional
 
$result = $socialAPI->statusPosting($access_Token,$caption,$description,$imageurl,$status,$title,$url,$shorturl);
 ```

 
<h6 id="TrackableStatusPosting-post-">Trackable Status Posting (POST)</h6>
The Trackable status API works very similar to the Status API but it returns a Post id that you can use to track the stats(shares, likes, comments) for a specific share/post/status update. This API requires setting permissions in your LoginRadius Dashboard.<br><br> The Trackable Status API is used to update the status on the user's wall and return an Post ID value. It is commonly referred to as Permission based sharing or Push notifications.<br><br> POST Input Parameter Format: application/x-www-form-urlencoded
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/trackable-status-posting/)

 ```
 
$access_Token = "access_Token"; //Required
 $payload = '{
"caption" : "<caption>",
"description" : "<description>",
"imageurl" : "<imageurl>",
"status" : "<status>",
"title" : "<title>",
"url" : "<url>"
}';  //Required
 
$result = $socialAPI->trackableStatusPosting($access_Token,$payload);
 ```

 
<h6 id="ExchangeAccessToken-get-">Access Token (GET)</h6>
This API Is used to translate the Request Token returned during authentication into an Access Token that can be used with other API calls.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/access-token)

 ```
 
$token = "token"; //Required
 
$result = $socialAPI->exchangeAccessToken($token);
 ```

 
<h6 id="RefreshAccessToken-get-">Refresh Token (GET)</h6>
The Refresh Access Token API is used to refresh the provider access token after authentication. It will be valid for up to 60 days on LoginRadius depending on the provider. In order to use the access token in other APIs, always refresh the token using this API.<br><br><b>Supported Providers :</b> Facebook,Yahoo,Google,Twitter, Linkedin.<br><br> Contact LoginRadius support team to enable this API.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/refresh-token/refresh-token)

 ```
 
$access_Token = "access_Token"; //Required 
$expiresIn = 0; //Optional 
$isWeb = "true"; //Optional
 
$result = $socialAPI->refreshAccessToken($access_Token,$expiresIn,$isWeb);
 ```

 
<h6 id="ValidateAccessToken-get-">Token Validate (GET)</h6>
This API validates access token, if valid then returns a response with its expiry otherwise error.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/validate-access-token)

 ```
 
$access_token = "access_token"; //Required
 
$result = $socialAPI->validateAccessToken($access_token);
 ```

 
<h6 id="InValidateAccessToken-get-">Access Token Invalidate (GET)</h6>
This api invalidates the active access token or expires an access token validity.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/invalidate-access-token)

 ```
 
$access_token = "access_token"; //Required
 
$result = $socialAPI->inValidateAccessToken($access_token);
 ```

 
<h6 id="GetActiveSession-get-">Get Active Session Details (GET)</h6>
This api is use to get all active session by Access Token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/get-active-session-details)

 ```
 
$token = "token"; //Required
 
$result = $socialAPI->getActiveSession($token);
 ```

 
<h6 id="GetActiveSessionByAccountID-get-">Get Active Session By Account Id (GET)</h6>
This api is used to get all active sessions by AccountID(UID).
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/active-session-by-account-id/)

 ```
 
$accountId = "accountId"; //Required
 
$result = $socialAPI->getActiveSessionByAccountID($accountId);
 ```

 
<h6 id="GetActiveSessionByProfileID-get-">Get Active Session By Profile Id (GET)</h6>
This api is used to get all active sessions by ProfileId.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/active-session-by-profile-id/)

 ```
 
$profileId = "profileId"; //Required
 
$result = $socialAPI->getActiveSessionByProfileID($profileId);
 ```

 
<h6 id="GetAlbums-get-">Album (GET)</h6>
<b>Supported Providers:</b> Facebook, Google, Live, Vkontakte.<br><br> This API returns the photo albums associated with the passed in access tokens Social Profile.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/album/)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getAlbums($access_Token);
 ```

 
<h6 id="GetAlbumsWithCursor-get-">Get Albums with cursor (GET)</h6>
<b>Supported Providers:</b> Facebook, Google, Live, Vkontakte.<br><br> This API returns the photo albums associated with the passed in access tokens Social Profile.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/album/)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Required
 
$result = $socialAPI->getAlbumsWithCursor($access_Token,$nextCursor);
 ```

 
<h6 id="GetAudios-get-">Audio (GET)</h6>
The Audio API is used to get audio files data from the user's social account.<br><br><b>Supported Providers:</b> Live, Vkontakte
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/audio)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getAudios($access_Token);
 ```

 
<h6 id="GetAudiosWithCursor-get-">Get Audio With Cursor (GET)</h6>
The Audio API is used to get audio files data from the user's social account.<br><br><b>Supported Providers:</b> Live, Vkontakte
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/audio)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Required
 
$result = $socialAPI->getAudiosWithCursor($access_Token,$nextCursor);
 ```

 
<h6 id="GetCheckIns-get-">Check In (GET)</h6>
The Check In API is used to get check Ins data from the user's social account.<br><br><b>Supported Providers:</b> Facebook, Foursquare, Vkontakte
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/check-in)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getCheckIns($access_Token);
 ```

 
<h6 id="GetCheckInsWithCursor-get-">Get CheckIns With Cursor (GET)</h6>
The Check In API is used to get check Ins data from the user's social account.<br><br><b>Supported Providers:</b> Facebook, Foursquare, Vkontakte
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/check-in)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Required
 
$result = $socialAPI->getCheckInsWithCursor($access_Token,$nextCursor);
 ```

 
<h6 id="GetContacts-get-">Contact (GET)</h6>
The Contact API is used to get contacts/friends/connections data from the user's social account.This is one of the APIs that makes up the LoginRadius Friend Invite System. The data will normalized into LoginRadius' standard data format. This API requires setting permissions in your LoginRadius Dashboard. <br><br><b>Note:</b> Facebook restricts access to the list of friends that is returned. When using the Contacts API with Facebook you will only receive friends that have accepted some permissions with your app. <br><br><b>Supported Providers:</b> Facebook, Foursquare, Google, LinkedIn, Live, Twitter, Vkontakte, Yahoo
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/contact)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Optional
 
$result = $socialAPI->getContacts($access_Token,$nextCursor);
 ```

 
<h6 id="GetEvents-get-">Event (GET)</h6>
The Event API is used to get the event data from the user's social account.<br><br><b>Supported Providers:</b> Facebook, Live
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/event)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getEvents($access_Token);
 ```

 
<h6 id="GetEventsWithCursor-get-">Get Events With Cursor (GET)</h6>
The Event API is used to get the event data from the user's social account.<br><br><b>Supported Providers:</b> Facebook, Live
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/event)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Required
 
$result = $socialAPI->getEventsWithCursor($access_Token,$nextCursor);
 ```

 
<h6 id="GetFollowings-get-">Following (GET)</h6>
Get the following user list from the user's social account.<br><br><b>Supported Providers:</b> Twitter
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/following)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getFollowings($access_Token);
 ```

 
<h6 id="GetFollowingsWithCursor-get-">Get Followings With Cursor (GET)</h6>
Get the following user list from the user's social account.<br><br><b>Supported Providers:</b> Twitter
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/following)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Required
 
$result = $socialAPI->getFollowingsWithCursor($access_Token,$nextCursor);
 ```

 
<h6 id="GetGroups-get-">Group (GET)</h6>
The Group API is used to get group data from the user's social account.<br><br><b>Supported Providers:</b> Facebook, Vkontakte
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/group)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getGroups($access_Token);
 ```

 
<h6 id="GetGroupsWithCursor-get-">Get Groups With Cursor (GET)</h6>
The Group API is used to get group data from the user's social account.<br><br><b>Supported Providers:</b> Facebook, Vkontakte
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/group)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Required
 
$result = $socialAPI->getGroupsWithCursor($access_Token,$nextCursor);
 ```

 
<h6 id="GetLikes-get-">Like (GET)</h6>
The Like API is used to get likes data from the user's social account.<br><br><b>Supported Providers:</b> Facebook
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/like)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getLikes($access_Token);
 ```

 
<h6 id="GetLikesWithCursor-get-">Get Likes With Cursor (GET)</h6>
The Like API is used to get likes data from the user's social account.<br><br><b>Supported Providers:</b> Facebook
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/like)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Required
 
$result = $socialAPI->getLikesWithCursor($access_Token,$nextCursor);
 ```

 
<h6 id="GetMentions-get-">Mention (GET)</h6>
The Mention API is used to get mentions data from the user's social account.<br><br><b>Supported Providers:</b> Twitter
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/mention)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getMentions($access_Token);
 ```

 
<h6 id="GetPage-get-">Page (GET)</h6>
The Page API is used to get the page data from the user's social account.<br><br><b>Supported Providers:</b>  Facebook, LinkedIn
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/page)

 ```
 
$access_Token = "access_Token"; //Required 
$pageName = "pageName"; //Required
 
$result = $socialAPI->getPage($access_Token,$pageName);
 ```

 
<h6 id="GetPhotos-get-">Photo (GET)</h6>
The Photo API is used to get photo data from the user's social account.<br><br><b>Supported Providers:</b>  Facebook, Foursquare, Google, Live, Vkontakte
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/photo)

 ```
 
$access_Token = "access_Token"; //Required 
$albumId = "albumId"; //Required
 
$result = $socialAPI->getPhotos($access_Token,$albumId);
 ```

 
<h6 id="GetPosts-get-">Get Post (GET)</h6>
The Post API is used to get post message data from the user's social account.<br><br><b>Supported Providers:</b>  Facebook
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/post)

 ```
 
$access_Token = "access_Token"; //Required
 
$result = $socialAPI->getPosts($access_Token);
 ```

 
<h6 id="GetTrackableStatusStats-get-">Get Trackable Status Stats (GET)</h6>
The Trackable status API works very similar to the Status API but it returns a Post id that you can use to track the stats(shares, likes, comments) for a specific share/post/status update. This API requires setting permissions in your LoginRadius Dashboard.<br><br> The Trackable Status API is used to update the status on the user's wall and return an Post ID value. It is commonly referred to as Permission based sharing or Push notifications.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/get-trackable-status-stats/)

 ```
 
$access_Token = "access_Token"; //Required 
$caption = "caption"; //Required 
$description = "description"; //Required 
$imageurl = "imageurl"; //Required 
$status = "status"; //Required 
$title = "title"; //Required 
$url = "url"; //Required
 
$result = $socialAPI->getTrackableStatusStats($access_Token,$caption,$description,$imageurl,$status,$title,$url);
 ```

 
<h6 id="TrackableStatusFetching-get-">Trackable Status Fetching (GET)</h6>
The Trackable status API works very similar to the Status API but it returns a Post id that you can use to track the stats(shares, likes, comments) for a specific share/post/status update. This API requires setting permissions in your LoginRadius Dashboard.<br><br> This API is used to retrieve a tracked post based on the passed in post ID value. This API requires setting permissions in your LoginRadius Dashboard.<br><br> <b>Note:</b> To utilize this API you need to find the ID for the post you want to track, which might require using Trackable Status Posting API first.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/trackable-status-fetching/)

 ```
 
$postId = "postId"; //Required
 
$result = $socialAPI->trackableStatusFetching($postId);
 ```

 
<h6 id="GetSocialUserProfile-get-">User Profile (GET)</h6>
The User Profile API is used to get social profile data from the user's social account after authentication.<br><br><b>Supported Providers:</b>  All
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/user-profile)

 ```
 
$access_Token = "access_Token"; //Required 
$fields = null; //Optional
 
$result = $socialAPI->getSocialUserProfile($access_Token,$fields);
 ```

 
<h6 id="GetRefreshedSocialUserProfile-get-">Refresh User Profile (GET)</h6>
The User Profile API is used to get the latest updated social profile data from the user's social account after authentication. The social profile will be retrieved via oAuth and OpenID protocols. The data is normalized into LoginRadius' standard data format. This API should be called using the access token retrieved from the refresh access token API.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/refresh-token/refresh-user-profile)

 ```
 
$access_Token = "access_Token"; //Required 
$fields = null; //Optional
 
$result = $socialAPI->getRefreshedSocialUserProfile($access_Token,$fields);
 ```

 
<h6 id="GetVideos-get-">Video (GET)</h6>
The Video API is used to get video files data from the user's social account.<br><br><b>Supported Providers:</b>   Facebook, Google, Live, Vkontakte
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/advanced-social-api/video)

 ```
 
$access_Token = "access_Token"; //Required 
$nextCursor = "nextCursor"; //Required
 
$result = $socialAPI->getVideos($access_Token,$nextCursor);
 ```

 



### CustomObject API

List of APIs in this Section:<br>
[PUT : Custom Object Update by Access Token](#UpdateCustomObjectByToken-put-)<br>
[PUT : Custom Object Update by UID](#UpdateCustomObjectByUid-put-)<br>
[POST : Create Custom Object by Token](#CreateCustomObjectByToken-post-)<br>
[POST : Create Custom Object by UID](#CreateCustomObjectByUid-post-)<br>
[GET : Custom Object by Token](#GetCustomObjectByToken-get-)<br>
[GET : Custom Object by ObjectRecordId and Token](#GetCustomObjectByRecordIDAndToken-get-)<br>
[GET : Custom Object By UID](#GetCustomObjectByUid-get-)<br>
[GET : Custom Object by ObjectRecordId and UID](#GetCustomObjectByRecordID-get-)<br>
[DELETE : Custom Object Delete by Record Id And Token](#DeleteCustomObjectByToken-delete-)<br>
[DELETE : Account Delete Custom Object by ObjectRecordId](#DeleteCustomObjectByRecordID-delete-)<br>

If you have not already initialized the CustomObject object do so now
```
$customObjectAPI = new CustomObjectAPI(); 
```


<h6 id="UpdateCustomObjectByToken-put-">Custom Object Update by Access Token (PUT)</h6>
This API is used to update the specified custom object data of the specified account. If the value of updatetype is 'replace' then it will fully replace custom object with the new custom object and if the value of updatetype is 'partialreplace' then it will perform an upsert type operation
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/custom-object-update-by-objectrecordid-and-token)

 ```
 
$access_token = "access_token"; //Required 
$objectName = "objectName"; //Required 
$objectRecordId = "objectRecordId"; //Required
 $payload = '{"customdata1": "Store my customdata1 value" }';  //Required 
$updateType = "updateType"; //Optional
 
$result = $customObjectAPI->updateCustomObjectByToken($access_token,$objectName,$objectRecordId,$payload,$updateType);
 ```

 
<h6 id="UpdateCustomObjectByUid-put-">Custom Object Update by UID (PUT)</h6>
This API is used to update the specified custom object data of a specified account. If the value of updatetype is 'replace' then it will fully replace custom object with new custom object and if the value of updatetype is partialreplace then it will perform an upsert type operation.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/custom-object-update-by-objectrecordid-and-uid)

 ```
 
$objectName = "objectName"; //Required 
$objectRecordId = "objectRecordId"; //Required
 $payload = '{"customdata1": "Store my customdata1 value" }';  //Required 
$uid = "uid"; //Required 
$updateType = "updateType"; //Optional
 
$result = $customObjectAPI->updateCustomObjectByUid($objectName,$objectRecordId,$payload,$uid,$updateType);
 ```

 
<h6 id="CreateCustomObjectByToken-post-">Create Custom Object by Token (POST)</h6>
This API is used to write information in JSON format to the custom object for the specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/create-custom-object-by-token)

 ```
 
$access_token = "access_token"; //Required 
$objectName = "objectName"; //Required
 $payload = '{"customdata1": "Store my customdata1 value" }';  //Required
 
$result = $customObjectAPI->createCustomObjectByToken($access_token,$objectName,$payload);
 ```

 
<h6 id="CreateCustomObjectByUid-post-">Create Custom Object by UID (POST)</h6>
This API is used to write information in JSON format to the custom object for the specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/create-custom-object-by-uid)

 ```
 
$objectName = "objectName"; //Required
 $payload = '{"customdata1": "Store my customdata1 value" }';  //Required 
$uid = "uid"; //Required
 
$result = $customObjectAPI->createCustomObjectByUid($objectName,$payload,$uid);
 ```

 
<h6 id="GetCustomObjectByToken-get-">Custom Object by Token (GET)</h6>
This API is used to retrieve the specified Custom Object data for the specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/custom-object-by-token)

 ```
 
$access_token = "access_token"; //Required 
$objectName = "objectName"; //Required
 
$result = $customObjectAPI->getCustomObjectByToken($access_token,$objectName);
 ```

 
<h6 id="GetCustomObjectByRecordIDAndToken-get-">Custom Object by ObjectRecordId and Token (GET)</h6>
This API is used to retrieve the Custom Object data for the specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/custom-object-by-objectrecordid-and-token)

 ```
 
$access_token = "access_token"; //Required 
$objectName = "objectName"; //Required 
$objectRecordId = "objectRecordId"; //Required
 
$result = $customObjectAPI->getCustomObjectByRecordIDAndToken($access_token,$objectName,$objectRecordId);
 ```

 
<h6 id="GetCustomObjectByUid-get-">Custom Object By UID (GET)</h6>
This API is used to retrieve all the custom objects by UID from cloud storage.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/custom-object-by-uid)

 ```
 
$objectName = "objectName"; //Required 
$uid = "uid"; //Required
 
$result = $customObjectAPI->getCustomObjectByUid($objectName,$uid);
 ```

 
<h6 id="GetCustomObjectByRecordID-get-">Custom Object by ObjectRecordId and UID (GET)</h6>
This API is used to retrieve the Custom Object data for the specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/custom-object-by-objectrecordid-and-uid)

 ```
 
$objectName = "objectName"; //Required 
$objectRecordId = "objectRecordId"; //Required 
$uid = "uid"; //Required
 
$result = $customObjectAPI->getCustomObjectByRecordID($objectName,$objectRecordId,$uid);
 ```

 
<h6 id="DeleteCustomObjectByToken-delete-">Custom Object Delete by Record Id And Token (DELETE)</h6>
This API is used to remove the specified Custom Object data using ObjectRecordId of a specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/custom-object-delete-by-objectrecordid-and-token)

 ```
 
$access_token = "access_token"; //Required 
$objectName = "objectName"; //Required 
$objectRecordId = "objectRecordId"; //Required
 
$result = $customObjectAPI->deleteCustomObjectByToken($access_token,$objectName,$objectRecordId);
 ```

 
<h6 id="DeleteCustomObjectByRecordID-delete-">Account Delete Custom Object by ObjectRecordId (DELETE)</h6>
This API is used to remove the specified Custom Object data using ObjectRecordId of specified account.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-object/custom-object-delete-by-objectrecordid-and-uid)

 ```
 
$objectName = "objectName"; //Required 
$objectRecordId = "objectRecordId"; //Required 
$uid = "uid"; //Required
 
$result = $customObjectAPI->deleteCustomObjectByRecordID($objectName,$objectRecordId,$uid);
 ```

 



### PhoneAuthentication API

List of APIs in this Section:<br>
[PUT : Phone Reset Password by OTP](#ResetPasswordByPhoneOTP-put-)<br>
[PUT : Phone Verification OTP](#PhoneVerificationByOTP-put-)<br>
[PUT : Phone Verification OTP by Token](#PhoneVerificationOTPByAccessToken-put-)<br>
[PUT : Phone Number Update](#UpdatePhoneNumber-put-)<br>
[POST : Phone Login](#LoginByPhone-post-)<br>
[POST : Phone Forgot Password by OTP](#ForgotPasswordByPhoneOTP-post-)<br>
[POST : Phone Resend Verification OTP](#PhoneResendVerificationOTP-post-)<br>
[POST : Phone Resend Verification OTP By Token](#PhoneResendVerificationOTPByToken-post-)<br>
[POST : Phone User Registration by SMS](#UserRegistrationByPhone-post-)<br>
[GET : Phone Number Availability](#CheckPhoneNumberAvailability-get-)<br>
[DELETE : Remove Phone ID by Access Token](#RemovePhoneIDByAccessToken-delete-)<br>

If you have not already initialized the PhoneAuthentication object do so now
```
$phoneAuthenticationAPI = new PhoneAuthenticationAPI(); 
```


<h6 id="ResetPasswordByPhoneOTP-put-">Phone Reset Password by OTP (PUT)</h6>
This API is used to reset the password
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-reset-password-by-otp)

 ```

 $payload = '{
"otp" : "<otp>",
"password" : "<password>",
"phone" : "<phone>"
}';  //Required
 
$result = $phoneAuthenticationAPI->resetPasswordByPhoneOTP($payload);
 ```

 
<h6 id="PhoneVerificationByOTP-put-">Phone Verification OTP (PUT)</h6>
This API is used to validate the verification code sent to verify a user's phone number
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-verify-otp)

 ```
 
$otp = "otp"; //Required 
$phone = "phone"; //Required 
$fields = null; //Optional 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $phoneAuthenticationAPI->phoneVerificationByOTP($otp,$phone,$fields,$smsTemplate);
 ```

 
<h6 id="PhoneVerificationOTPByAccessToken-put-">Phone Verification OTP by Token (PUT)</h6>
This API is used to consume the verification code sent to verify a user's phone number. Use this call for front-end purposes in cases where the user is already logged in by passing the user's access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-verify-otp-by-token)

 ```
 
$access_token = "access_token"; //Required 
$otp = "otp"; //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $phoneAuthenticationAPI->phoneVerificationOTPByAccessToken($access_token,$otp,$smsTemplate);
 ```

 
<h6 id="UpdatePhoneNumber-put-">Phone Number Update (PUT)</h6>
This API is used to update the login Phone Number of users
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-number-update)

 ```
 
$access_token = "access_token"; //Required 
$phone = "phone"; //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $phoneAuthenticationAPI->updatePhoneNumber($access_token,$phone,$smsTemplate);
 ```

 
<h6 id="LoginByPhone-post-">Phone Login (POST)</h6>
This API retrieves a copy of the user data based on the Phone
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-login)

 ```

 $payload = '{
"password" : "<password>",
"phone" : "<phone>"
}';  //Required 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $phoneAuthenticationAPI->loginByPhone($payload,$fields,$loginUrl,$smsTemplate);
 ```

 
<h6 id="ForgotPasswordByPhoneOTP-post-">Phone Forgot Password by OTP (POST)</h6>
This API is used to send the OTP to reset the account password.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-forgot-password-by-otp)

 ```
 
$phone = "phone"; //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $phoneAuthenticationAPI->forgotPasswordByPhoneOTP($phone,$smsTemplate);
 ```

 
<h6 id="PhoneResendVerificationOTP-post-">Phone Resend Verification OTP (POST)</h6>
This API is used to resend a verification OTP to verify a user's Phone Number. The user will receive a verification code that they will need to input
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-resend-otp)

 ```
 
$phone = "phone"; //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $phoneAuthenticationAPI->phoneResendVerificationOTP($phone,$smsTemplate);
 ```

 
<h6 id="PhoneResendVerificationOTPByToken-post-">Phone Resend Verification OTP By Token (POST)</h6>
This API is used to resend a verification OTP to verify a user's Phone Number in cases in which an active token already exists
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-resend-otp-by-token)

 ```
 
$access_token = "access_token"; //Required 
$phone = "phone"; //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $phoneAuthenticationAPI->phoneResendVerificationOTPByToken($access_token,$phone,$smsTemplate);
 ```

 
<h6 id="UserRegistrationByPhone-post-">Phone User Registration by SMS (POST)</h6>
This API registers the new users into your Cloud Storage and triggers the phone verification process.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-user-registration-by-sms)

 ```

 $payload = '{
"firstName" : "<firstName>",
"lastName" : "<lastName>",
"password" : "<password>",
"phoneId" : "<phoneId>"
}';  //Required 
$sott = "sott"; //Required 
$fields = null; //Optional 
$options = "options"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $phoneAuthenticationAPI->userRegistrationByPhone($payload,$sott,$fields,$options,$smsTemplate,$verificationUrl,$welcomeEmailTemplate);
 ```

 
<h6 id="CheckPhoneNumberAvailability-get-">Phone Number Availability (GET)</h6>
This API is used to check the Phone Number exists or not on your site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-number-availability)

 ```
 
$phone = "phone"; //Required
 
$result = $phoneAuthenticationAPI->checkPhoneNumberAvailability($phone);
 ```

 
<h6 id="RemovePhoneIDByAccessToken-delete-">Remove Phone ID by Access Token (DELETE)</h6>
This API is used to delete the Phone ID on a user's account via the access token
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/remove-phone-id-by-access-token)

 ```
 
$access_token = "access_token"; //Required
 
$result = $phoneAuthenticationAPI->removePhoneIDByAccessToken($access_token);
 ```

 



### MultiFactorAuthentication API

List of APIs in this Section:<br>
[PUT : Update MFA Setting](#MFAUpdateSetting-put-)<br>
[PUT : Update MFA by Access Token](#MFAUpdateByAccessToken-put-)<br>
[PUT : MFA Update Phone Number by Token](#MFAUpdatePhoneNumberByToken-put-)<br>
[PUT : MFA Validate OTP](#MFAValidateOTPByPhone-put-)<br>
[PUT : MFA Validate Google Auth Code](#MFAValidateGoogleAuthCode-put-)<br>
[PUT : MFA Validate Backup code](#MFAValidateBackupCode-put-)<br>
[PUT : MFA Update Phone Number](#MFAUpdatePhoneNumber-put-)<br>
[POST : MFA Email Login](#MFALoginByEmail-post-)<br>
[POST : MFA UserName Login](#MFALoginByUserName-post-)<br>
[POST : MFA Phone Login](#MFALoginByPhone-post-)<br>
[GET : MFA Validate Access Token](#MFAConfigureByAccessToken-get-)<br>
[GET : MFA Backup Code by Access Token](#MFABackupCodeByAccessToken-get-)<br>
[GET : Reset Backup Code by Access Token](#MFAResetBackupCodeByAccessToken-get-)<br>
[GET : MFA Resend Otp](#MFAResendOTP-get-)<br>
[GET : MFA Backup Code by UID](#MFABackupCodeByUid-get-)<br>
[GET : MFA Reset Backup Code by UID](#MFAResetBackupCodeByUid-get-)<br>
[DELETE : MFA Reset Google Authenticator by Token](#MFAResetGoogleAuthByToken-delete-)<br>
[DELETE : MFA Reset SMS Authenticator by Token](#MFAResetSMSAuthByToken-delete-)<br>
[DELETE : MFA Reset SMS Authenticator By UID](#MFAResetSMSAuthenticatorByUid-delete-)<br>
[DELETE : MFA Reset Google Authenticator By UID](#MFAResetGoogleAuthenticatorByUid-delete-)<br>

If you have not already initialized the MultiFactorAuthentication object do so now
```
$multiFactorAuthenticationAPI = new MultiFactorAuthenticationAPI(); 
```


<h6 id="MFAUpdateSetting-put-">Update MFA Setting (PUT)</h6>
This API is used to trigger the Multi-factor authentication settings after login for secure actions
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/sms-authenticator/update-mfa-setting/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"otp" : "<otp>"
}';  //Required 
$fields = null; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaUpdateSetting($access_token,$payload,$fields);
 ```

 
<h6 id="MFAUpdateByAccessToken-put-">Update MFA by Access Token (PUT)</h6>
This API is used to Enable Multi-factor authentication by access token on user login
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/google-authenticator/update-mfa-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"googleAuthenticatorCode" : "<googleAuthenticatorCode>"
}';  //Required 
$fields = null; //Optional 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaUpdateByAccessToken($access_token,$payload,$fields,$smsTemplate);
 ```

 
<h6 id="MFAUpdatePhoneNumberByToken-put-">MFA Update Phone Number by Token (PUT)</h6>
This API is used to update the Multi-factor authentication phone number by sending the verification OTP to the provided phone number
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/sms-authenticator/mfa-update-phone-number-by-token/)

 ```
 
$access_token = "access_token"; //Required 
$phoneNo2FA = "phoneNo2FA"; //Required 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaUpdatePhoneNumberByToken($access_token,$phoneNo2FA,$smsTemplate2FA);
 ```

 
<h6 id="MFAValidateOTPByPhone-put-">MFA Validate OTP (PUT)</h6>
This API is used to login via Multi-factor authentication by passing the One Time Password received via SMS
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/sms-authenticator/mfa-validate-otp/)

 ```

 $payload = '{
"otp" : "<otp>"
}';  //Required 
$secondFactorAuthenticationToken = "secondFactorAuthenticationToken"; //Required 
$fields = null; //Optional 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaValidateOTPByPhone($payload,$secondFactorAuthenticationToken,$fields,$smsTemplate2FA);
 ```

 
<h6 id="MFAValidateGoogleAuthCode-put-">MFA Validate Google Auth Code (PUT)</h6>
This API is used to login via Multi-factor-authentication by passing the google authenticator code.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/google-authenticator/mfa-validate-google-auth-code/)

 ```
 
$googleAuthenticatorCode = "googleAuthenticatorCode"; //Required 
$secondFactorAuthenticationToken = "secondFactorAuthenticationToken"; //Required 
$fields = null; //Optional 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaValidateGoogleAuthCode($googleAuthenticatorCode,$secondFactorAuthenticationToken,$fields,$smsTemplate2FA);
 ```

 
<h6 id="MFAValidateBackupCode-put-">MFA Validate Backup code (PUT)</h6>
This API is used to validate the backup code provided by the user and if valid, we return an access token allowing the user to login incases where Multi-factor authentication (MFA) is enabled and the secondary factor is unavailable. When a user initially downloads the Backup codes, We generate 10 codes, each code can only be consumed once. if any user attempts to go over the number of invalid login attempts configured in the Dashboard then the account gets blocked automatically
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/backup-codes/mfa-validate-backup-code/)

 ```

 $payload = '{
"backupCode" : "<backupCode>"
}';  //Required 
$secondFactorAuthenticationToken = "secondFactorAuthenticationToken"; //Required 
$fields = null; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaValidateBackupCode($payload,$secondFactorAuthenticationToken,$fields);
 ```

 
<h6 id="MFAUpdatePhoneNumber-put-">MFA Update Phone Number (PUT)</h6>
This API is used to update (if configured) the phone number used for Multi-factor authentication by sending the verification OTP to the provided phone number
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/sms-authenticator/mfa-update-phone-number/)

 ```
 
$phoneNo2FA = "phoneNo2FA"; //Required 
$secondFactorAuthenticationToken = "secondFactorAuthenticationToken"; //Required 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaUpdatePhoneNumber($phoneNo2FA,$secondFactorAuthenticationToken,$smsTemplate2FA);
 ```

 
<h6 id="MFALoginByEmail-post-">MFA Email Login (POST)</h6>
This API can be used to login by emailid on a Multi-factor authentication enabled LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/mfa-email-login)

 ```
 
$email = "email"; //Required 
$password = "password"; //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$smsTemplate2FA = "smsTemplate2FA"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaLoginByEmail($email,$password,$emailTemplate,$fields,$loginUrl,$smsTemplate,$smsTemplate2FA,$verificationUrl);
 ```

 
<h6 id="MFALoginByUserName-post-">MFA UserName Login (POST)</h6>
This API can be used to login by username on a Multi-factor authentication enabled LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/mfa-user-name-login)

 ```
 
$password = "password"; //Required 
$username = "username"; //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$smsTemplate2FA = "smsTemplate2FA"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaLoginByUserName($password,$username,$emailTemplate,$fields,$loginUrl,$smsTemplate,$smsTemplate2FA,$verificationUrl);
 ```

 
<h6 id="MFALoginByPhone-post-">MFA Phone Login (POST)</h6>
This API can be used to login by Phone on a Multi-factor authentication enabled LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/mfa-phone-login)

 ```
 
$password = "password"; //Required 
$phone = "phone"; //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$smsTemplate2FA = "smsTemplate2FA"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaLoginByPhone($password,$phone,$emailTemplate,$fields,$loginUrl,$smsTemplate,$smsTemplate2FA,$verificationUrl);
 ```

 
<h6 id="MFAConfigureByAccessToken-get-">MFA Validate Access Token (GET)</h6>
This API is used to configure the Multi-factor authentication after login by using the access token when MFA is set as optional on the LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/mfa-validate-access-token/)

 ```
 
$access_token = "access_token"; //Required 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaConfigureByAccessToken($access_token,$smsTemplate2FA);
 ```

 
<h6 id="MFABackupCodeByAccessToken-get-">MFA Backup Code by Access Token (GET)</h6>
This API is used to get a set of backup codes via access token to allow the user login on a site that has Multi-factor Authentication enabled in the event that the user does not have a secondary factor available. We generate 10 codes, each code can only be consumed once. If any user attempts to go over the number of invalid login attempts configured in the Dashboard then the account gets blocked automatically
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/backup-codes/mfa-backup-code-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 
$result = $multiFactorAuthenticationAPI->mfaBackupCodeByAccessToken($access_token);
 ```

 
<h6 id="MFAResetBackupCodeByAccessToken-get-">Reset Backup Code by Access Token (GET)</h6>
API is used to reset the backup codes on a given account via the access token. This API call will generate 10 new codes, each code can only be consumed once
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/backup-codes/mfa-reset-backup-code-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 
$result = $multiFactorAuthenticationAPI->mfaResetBackupCodeByAccessToken($access_token);
 ```

 
<h6 id="MFAResendOTP-get-">MFA Resend Otp (GET)</h6>
This API is used to resending the verification OTP to the provided phone number
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/resend-twofactorauthentication-otp/)

 ```
 
$secondFactorAuthenticationToken = "secondFactorAuthenticationToken"; //Required 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $multiFactorAuthenticationAPI->mfaResendOTP($secondFactorAuthenticationToken,$smsTemplate2FA);
 ```

 
<h6 id="MFABackupCodeByUid-get-">MFA Backup Code by UID (GET)</h6>
This API is used to reset the backup codes on a given account via the UID. This API call will generate 10 new codes, each code can only be consumed once.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/backup-codes/mfa-backup-code-by-uid/)

 ```
 
$uid = "uid"; //Required
 
$result = $multiFactorAuthenticationAPI->mfaBackupCodeByUid($uid);
 ```

 
<h6 id="MFAResetBackupCodeByUid-get-">MFA Reset Backup Code by UID (GET)</h6>
This API is used to reset the backup codes on a given account via the UID. This API call will generate 10 new codes, each code can only be consumed once.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/backup-codes/mfa-reset-backup-code-by-uid/)

 ```
 
$uid = "uid"; //Required
 
$result = $multiFactorAuthenticationAPI->mfaResetBackupCodeByUid($uid);
 ```

 
<h6 id="MFAResetGoogleAuthByToken-delete-">MFA Reset Google Authenticator by Token (DELETE)</h6>
This API Resets the Google Authenticator configurations on a given account via the access token
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/google-authenticator/mfa-reset-google-authenticator-by-token/)

 ```
 
$access_token = "access_token"; //Required 
$googleauthenticator = "true"; //Required
 
$result = $multiFactorAuthenticationAPI->mfaResetGoogleAuthByToken($access_token,$googleauthenticator);
 ```

 
<h6 id="MFAResetSMSAuthByToken-delete-">MFA Reset SMS Authenticator by Token (DELETE)</h6>
This API resets the SMS Authenticator configurations on a given account via the access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/sms-authenticator/mfa-reset-sms-authenticator-by-token/)

 ```
 
$access_token = "access_token"; //Required 
$otpauthenticator = "true"; //Required
 
$result = $multiFactorAuthenticationAPI->mfaResetSMSAuthByToken($access_token,$otpauthenticator);
 ```

 
<h6 id="MFAResetSMSAuthenticatorByUid-delete-">MFA Reset SMS Authenticator By UID (DELETE)</h6>
This API resets the SMS Authenticator configurations on a given account via the UID.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/sms-authenticator/mfa-reset-sms-authenticator-by-uid/)

 ```
 
$otpauthenticator = "true"; //Required 
$uid = "uid"; //Required
 
$result = $multiFactorAuthenticationAPI->mfaResetSMSAuthenticatorByUid($otpauthenticator,$uid);
 ```

 
<h6 id="MFAResetGoogleAuthenticatorByUid-delete-">MFA Reset Google Authenticator By UID (DELETE)</h6>
This API resets the Google Authenticator configurations on a given account via the UID.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/google-authenticator/mfa-reset-google-authenticator-by-uid/)

 ```
 
$googleauthenticator = "true"; //Required 
$uid = "uid"; //Required
 
$result = $multiFactorAuthenticationAPI->mfaResetGoogleAuthenticatorByUid($googleauthenticator,$uid);
 ```

 



### PINAuthentication API

List of APIs in this Section:<br>
[PUT : Reset PIN By ResetToken](#ResetPINByResetToken-put-)<br>
[PUT : Reset PIN By SecurityAnswer And Email](#ResetPINByEmailAndSecurityAnswer-put-)<br>
[PUT : Reset PIN By SecurityAnswer And Username](#ResetPINByUsernameAndSecurityAnswer-put-)<br>
[PUT : Reset PIN By SecurityAnswer And Phone](#ResetPINByPhoneAndSecurityAnswer-put-)<br>
[PUT : Change PIN By Token](#ChangePINByAccessToken-put-)<br>
[PUT : Reset PIN by Phone and OTP](#ResetPINByPhoneAndOtp-put-)<br>
[PUT : Reset PIN by Email and OTP](#ResetPINByEmailAndOtp-put-)<br>
[PUT : Reset PIN by Username and OTP](#ResetPINByUsernameAndOtp-put-)<br>
[POST : PIN Login](#PINLogin-post-)<br>
[POST : Forgot PIN By Email](#SendForgotPINEmailByEmail-post-)<br>
[POST : Forgot PIN By UserName](#SendForgotPINEmailByUsername-post-)<br>
[POST : Forgot PIN By Phone](#SendForgotPINSMSByPhone-post-)<br>
[POST : Set PIN By PinAuthToken](#SetPINByPinAuthToken-post-)<br>
[GET : Invalidate PIN Session Token](#InValidatePinSessionToken-get-)<br>

If you have not already initialized the PINAuthentication object do so now
```
$pinAuthenticationAPI = new PINAuthenticationAPI(); 
```


<h6 id="ResetPINByResetToken-put-">Reset PIN By ResetToken (PUT)</h6>
This API is used to reset pin using reset token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/reset-pin-by-resettoken/)

 ```

 $payload = '{
"pin" : "<pin>",
"resetToken" : "<resetToken>"
}';  //Required
 
$result = $pinAuthenticationAPI->resetPINByResetToken($payload);
 ```

 
<h6 id="ResetPINByEmailAndSecurityAnswer-put-">Reset PIN By SecurityAnswer And Email (PUT)</h6>
This API is used to reset pin using security question answer and email.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/reset-pin-by-securityanswer-and-email/)

 ```

 $payload = '{
"email" : "<email>",
"pin" : "<pin>",
"securityAnswer" : {"QuestionID":"Answer"}
}';  //Required
 
$result = $pinAuthenticationAPI->resetPINByEmailAndSecurityAnswer($payload);
 ```

 
<h6 id="ResetPINByUsernameAndSecurityAnswer-put-">Reset PIN By SecurityAnswer And Username (PUT)</h6>
This API is used to reset pin using security question answer and username.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/reset-pin-by-securityanswer-and-username/)

 ```

 $payload = '{
"pin" : "<pin>",
"securityAnswer" : {"QuestionID":"Answer"},
"username" : "<username>"
}';  //Required
 
$result = $pinAuthenticationAPI->resetPINByUsernameAndSecurityAnswer($payload);
 ```

 
<h6 id="ResetPINByPhoneAndSecurityAnswer-put-">Reset PIN By SecurityAnswer And Phone (PUT)</h6>
This API is used to reset pin using security question answer and phone.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/reset-pin-by-securityanswer-and-phone/)

 ```

 $payload = '{
"phone" : "<phone>",
"pin" : "<pin>",
"securityAnswer" : {"QuestionID":"Answer"}
}';  //Required
 
$result = $pinAuthenticationAPI->resetPINByPhoneAndSecurityAnswer($payload);
 ```

 
<h6 id="ChangePINByAccessToken-put-">Change PIN By Token (PUT)</h6>
This API is used to change a user's PIN using access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/change-pin-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"newPIN" : "<newPIN>",
"oldPIN" : "<oldPIN>"
}';  //Required
 
$result = $pinAuthenticationAPI->changePINByAccessToken($access_token,$payload);
 ```

 
<h6 id="ResetPINByPhoneAndOtp-put-">Reset PIN by Phone and OTP (PUT)</h6>
This API is used to reset pin using phoneId and OTP.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/reset-pin-by-phone-and-otp/)

 ```

 $payload = '{
"otp" : "<otp>",
"phone" : "<phone>",
"pin" : "<pin>"
}';  //Required
 
$result = $pinAuthenticationAPI->resetPINByPhoneAndOtp($payload);
 ```

 
<h6 id="ResetPINByEmailAndOtp-put-">Reset PIN by Email and OTP (PUT)</h6>
This API is used to reset pin using email and OTP.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/reset-pin-by-email-and-otp/)

 ```

 $payload = '{
"email" : "<email>",
"otp" : "<otp>",
"pin" : "<pin>"
}';  //Required
 
$result = $pinAuthenticationAPI->resetPINByEmailAndOtp($payload);
 ```

 
<h6 id="ResetPINByUsernameAndOtp-put-">Reset PIN by Username and OTP (PUT)</h6>
This API is used to reset pin using username and OTP.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/reset-pin-by-username-and-otp/)

 ```

 $payload = '{
"otp" : "<otp>",
"pin" : "<pin>",
"username" : "<username>"
}';  //Required
 
$result = $pinAuthenticationAPI->resetPINByUsernameAndOtp($payload);
 ```

 
<h6 id="PINLogin-post-">PIN Login (POST)</h6>
This API is used to login a user by pin and session token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/login-by-pin/)

 ```

 $payload = '{
"pin" : "<pin>"
}';  //Required 
$session_token = "session_token"; //Required
 
$result = $pinAuthenticationAPI->pinLogin($payload,$session_token);
 ```

 
<h6 id="SendForgotPINEmailByEmail-post-">Forgot PIN By Email (POST)</h6>
This API sends the reset pin email to specified email address.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/forgot-pin-by-email/)

 ```

 $payload = '{
"email" : "<email>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$resetPINUrl = "resetPINUrl"; //Optional
 
$result = $pinAuthenticationAPI->sendForgotPINEmailByEmail($payload,$emailTemplate,$resetPINUrl);
 ```

 
<h6 id="SendForgotPINEmailByUsername-post-">Forgot PIN By UserName (POST)</h6>
This API sends the reset pin email using username.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/forgot-pin-by-username/)

 ```

 $payload = '{
"userName" : "<userName>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$resetPINUrl = "resetPINUrl"; //Optional
 
$result = $pinAuthenticationAPI->sendForgotPINEmailByUsername($payload,$emailTemplate,$resetPINUrl);
 ```

 
<h6 id="SendForgotPINSMSByPhone-post-">Forgot PIN By Phone (POST)</h6>
This API sends the OTP to specified phone number
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/forgot-pin-by-phone/)

 ```

 $payload = '{
"phone" : "<phone>"
}';  //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $pinAuthenticationAPI->sendForgotPINSMSByPhone($payload,$smsTemplate);
 ```

 
<h6 id="SetPINByPinAuthToken-post-">Set PIN By PinAuthToken (POST)</h6>
This API is used to change a user's PIN using Pin Auth token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/set-pin-by-pinauthtoken/)

 ```

 $payload = '{
"pin" : "<pin>"
}';  //Required 
$pinAuthToken = "pinAuthToken"; //Required
 
$result = $pinAuthenticationAPI->setPINByPinAuthToken($payload,$pinAuthToken);
 ```

 
<h6 id="InValidatePinSessionToken-get-">Invalidate PIN Session Token (GET)</h6>
This API is used to invalidate pin session token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/pin-authentication/invalidate-pin-session-token/)

 ```
 
$session_token = "session_token"; //Required
 
$result = $pinAuthenticationAPI->inValidatePinSessionToken($session_token);
 ```

 



### ReAuthentication API

List of APIs in this Section:<br>
[PUT : Validate MFA by OTP](#MFAReAuthenticateByOTP-put-)<br>
[PUT : Validate MFA by Backup Code](#MFAReAuthenticateByBackupCode-put-)<br>
[PUT : Validate MFA by Google Authenticator Code](#MFAReAuthenticateByGoogleAuth-put-)<br>
[PUT : Validate MFA by Password](#MFAReAuthenticateByPassword-put-)<br>
[PUT : MFA Re-authentication by PIN](#VerifyPINAuthentication-put-)<br>
[POST : Verify Multifactor OTP Authentication](#VerifyMultiFactorOtpReauthentication-post-)<br>
[POST : Verify Multifactor Password Authentication](#VerifyMultiFactorPasswordReauthentication-post-)<br>
[POST : Verify Multifactor PIN Authentication](#VerifyMultiFactorPINReauthentication-post-)<br>
[GET : Multi Factor Re-Authenticate](#MFAReAuthenticate-get-)<br>

If you have not already initialized the ReAuthentication object do so now
```
$reAuthenticationAPI = new ReAuthenticationAPI(); 
```


<h6 id="MFAReAuthenticateByOTP-put-">Validate MFA by OTP (PUT)</h6>
This API is used to re-authenticate via Multi-factor authentication by passing the One Time Password received via SMS
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/re-authentication/mfa/re-auth-by-otp/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"otp" : "<otp>"
}';  //Required
 
$result = $reAuthenticationAPI->mfaReAuthenticateByOTP($access_token,$payload);
 ```

 
<h6 id="MFAReAuthenticateByBackupCode-put-">Validate MFA by Backup Code (PUT)</h6>
This API is used to re-authenticate by set of backup codes via access token on the site that has Multi-factor authentication enabled in re-authentication for the user that does not have the device
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/re-authentication/mfa/re-auth-by-backup-code/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"backupCode" : "<backupCode>"
}';  //Required
 
$result = $reAuthenticationAPI->mfaReAuthenticateByBackupCode($access_token,$payload);
 ```

 
<h6 id="MFAReAuthenticateByGoogleAuth-put-">Validate MFA by Google Authenticator Code (PUT)</h6>
This API is used to re-authenticate via Multi-factor-authentication by passing the google authenticator code
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/re-authentication/re-auth-by-google-authenticator-code)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"googleAuthenticatorCode" : "<googleAuthenticatorCode>"
}';  //Required
 
$result = $reAuthenticationAPI->mfaReAuthenticateByGoogleAuth($access_token,$payload);
 ```

 
<h6 id="MFAReAuthenticateByPassword-put-">Validate MFA by Password (PUT)</h6>
This API is used to re-authenticate via Multi-factor-authentication by passing the password
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/re-authentication/re-auth-by-password)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"password" : "<password>"
}';  //Required 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $reAuthenticationAPI->mfaReAuthenticateByPassword($access_token,$payload,$smsTemplate2FA);
 ```

 
<h6 id="VerifyPINAuthentication-put-">MFA Re-authentication by PIN (PUT)</h6>
This API is used to validate the triggered MFA authentication flow with a password.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/re-authentication/pin/re-auth-by-pin/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"pin" : "<pin>"
}';  //Required 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $reAuthenticationAPI->verifyPINAuthentication($access_token,$payload,$smsTemplate2FA);
 ```

 
<h6 id="VerifyMultiFactorOtpReauthentication-post-">Verify Multifactor OTP Authentication (POST)</h6>
This API is used on the server-side to validate and verify the re-authentication token created by the MFA re-authentication API. This API checks re-authentications created by OTP.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/re-authentication/mfa/re-auth-validate-mfa/)

 ```

 $payload = '{
"secondFactorValidationToken" : "<secondFactorValidationToken>"
}';  //Required 
$uid = "uid"; //Required
 
$result = $reAuthenticationAPI->verifyMultiFactorOtpReauthentication($payload,$uid);
 ```

 
<h6 id="VerifyMultiFactorPasswordReauthentication-post-">Verify Multifactor Password Authentication (POST)</h6>
This API is used on the server-side to validate and verify the re-authentication token created by the MFA re-authentication API. This API checks re-authentications created by password.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/re-authentication/re-auth-validate-password/)

 ```

 $payload = '{
"secondFactorValidationToken" : "<secondFactorValidationToken>"
}';  //Required 
$uid = "uid"; //Required
 
$result = $reAuthenticationAPI->verifyMultiFactorPasswordReauthentication($payload,$uid);
 ```

 
<h6 id="VerifyMultiFactorPINReauthentication-post-">Verify Multifactor PIN Authentication (POST)</h6>
This API is used on the server-side to validate and verify the re-authentication token created by the MFA re-authentication API. This API checks re-authentications created by PIN.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/re-authentication/pin/re-auth-validate-pin/)

 ```

 $payload = '{
"secondFactorValidationToken" : "<secondFactorValidationToken>"
}';  //Required 
$uid = "uid"; //Required
 
$result = $reAuthenticationAPI->verifyMultiFactorPINReauthentication($payload,$uid);
 ```

 
<h6 id="MFAReAuthenticate-get-">Multi Factor Re-Authenticate (GET)</h6>
This API is used to trigger the Multi-Factor Autentication workflow for the provided access token
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/multi-factor-authentication/re-authentication/re-auth-trigger/)

 ```
 
$access_token = "access_token"; //Required 
$smsTemplate2FA = "smsTemplate2FA"; //Optional
 
$result = $reAuthenticationAPI->mfaReAuthenticate($access_token,$smsTemplate2FA);
 ```

 



### ConsentManagement API

List of APIs in this Section:<br>
[PUT : Update Consent By Access Token](#UpdateConsentProfileByAccessToken-put-)<br>
[POST : Consent By ConsentToken](#SubmitConsentByConsentToken-post-)<br>
[POST : Post Consent By Access Token](#SubmitConsentByAccessToken-post-)<br>
[GET : Get Consent Logs By Uid](#GetConsentLogsByUid-get-)<br>
[GET : Get Consent Log by Access Token](#GetConsentLogs-get-)<br>
[GET : Get Verify Consent By Access Token](#VerifyConsentByAccessToken-get-)<br>

If you have not already initialized the ConsentManagement object do so now
```
$consentManagementAPI = new ConsentManagementAPI(); 
```


<h6 id="UpdateConsentProfileByAccessToken-put-">Update Consent By Access Token (PUT)</h6>
This API is to update consents using access token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/consent-management/update-consent-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"consents" : [   { 
 "consentOptionId" : "<consentOptionId>"  ,
"isAccepted" : true  
}  ] 
}';  //Required
 
$result = $consentManagementAPI->updateConsentProfileByAccessToken($access_token,$payload);
 ```

 
<h6 id="SubmitConsentByConsentToken-post-">Consent By ConsentToken (POST)</h6>
This API is to submit consent form using consent token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/consent-management/consent-by-consent-token/)

 ```
 
$consentToken = "consentToken"; //Required
 $payload = '{
"data" : [   { 
 "consentOptionId" : "<consentOptionId>"  ,
"isAccepted" : true  
}  ] ,
"events" : [   { 
 "event" : "<event>"  ,
"isCustom" : true  
}  ] 
}';  //Required
 
$result = $consentManagementAPI->submitConsentByConsentToken($consentToken,$payload);
 ```

 
<h6 id="SubmitConsentByAccessToken-post-">Post Consent By Access Token (POST)</h6>
API to provide a way to end user to submit a consent form for particular event type.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/consent-management/consent-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 $payload = '{
"data" : [   { 
 "consentOptionId" : "<consentOptionId>"  ,
"isAccepted" : true  
}  ] ,
"events" : [   { 
 "event" : "<event>"  ,
"isCustom" : true  
}  ] 
}';  //Required
 
$result = $consentManagementAPI->submitConsentByAccessToken($access_token,$payload);
 ```

 
<h6 id="GetConsentLogsByUid-get-">Get Consent Logs By Uid (GET)</h6>
This API is used to get the Consent logs of the user.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/consent-management/consent-log-by-uid/)

 ```
 
$uid = "uid"; //Required
 
$result = $consentManagementAPI->getConsentLogsByUid($uid);
 ```

 
<h6 id="GetConsentLogs-get-">Get Consent Log by Access Token (GET)</h6>
This API is used to fetch consent logs.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/consent-management/consent-log-by-access-token/)

 ```
 
$access_token = "access_token"; //Required
 
$result = $consentManagementAPI->getConsentLogs($access_token);
 ```

 
<h6 id="VerifyConsentByAccessToken-get-">Get Verify Consent By Access Token (GET)</h6>
This API is used to check if consent is submitted for a particular event or not.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/consent-management/verify-consent-by-access-token/)

 ```
 
$access_token = "access_token"; //Required 
$event = "event"; //Required 
$isCustom = "true"; //Required
 
$result = $consentManagementAPI->verifyConsentByAccessToken($access_token,$event,$isCustom);
 ```

 



### SmartLogin API

List of APIs in this Section:<br>
[GET : Smart Login Verify Token](#SmartLoginTokenVerification-get-)<br>
[GET : Smart Login By Email](#SmartLoginByEmail-get-)<br>
[GET : Smart Login By Username](#SmartLoginByUserName-get-)<br>
[GET : Smart Login Ping](#SmartLoginPing-get-)<br>

If you have not already initialized the SmartLogin object do so now
```
$smartLoginAPI = new SmartLoginAPI(); 
```


<h6 id="SmartLoginTokenVerification-get-">Smart Login Verify Token (GET)</h6>
This API verifies the provided token for Smart Login
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/smart-login/smart-login-verify-token/)

 ```
 
$verificationToken = "verificationToken"; //Required 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $smartLoginAPI->smartLoginTokenVerification($verificationToken,$welcomeEmailTemplate);
 ```

 
<h6 id="SmartLoginByEmail-get-">Smart Login By Email (GET)</h6>
This API sends a Smart Login link to the user's Email Id.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/smart-login/smart-login-by-email)

 ```
 
$clientGuid = "clientGuid"; //Required 
$email = "email"; //Required 
$redirectUrl = "redirectUrl"; //Optional 
$smartLoginEmailTemplate = "smartLoginEmailTemplate"; //Optional 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $smartLoginAPI->smartLoginByEmail($clientGuid,$email,$redirectUrl,$smartLoginEmailTemplate,$welcomeEmailTemplate);
 ```

 
<h6 id="SmartLoginByUserName-get-">Smart Login By Username (GET)</h6>
This API sends a Smart Login link to the user's Email Id.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/smart-login/smart-login-by-username)

 ```
 
$clientGuid = "clientGuid"; //Required 
$username = "username"; //Required 
$redirectUrl = "redirectUrl"; //Optional 
$smartLoginEmailTemplate = "smartLoginEmailTemplate"; //Optional 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $smartLoginAPI->smartLoginByUserName($clientGuid,$username,$redirectUrl,$smartLoginEmailTemplate,$welcomeEmailTemplate);
 ```

 
<h6 id="SmartLoginPing-get-">Smart Login Ping (GET)</h6>
This API is used to check if the Smart Login link has been clicked or not
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/smart-login/smart-login-ping)

 ```
 
$clientGuid = "clientGuid"; //Required 
$fields = null; //Optional
 
$result = $smartLoginAPI->smartLoginPing($clientGuid,$fields);
 ```

 



### OneTouchLogin API

List of APIs in this Section:<br>
[PUT : One Touch OTP Verification](#OneTouchLoginOTPVerification-put-)<br>
[POST : One Touch Login by Email](#OneTouchLoginByEmail-post-)<br>
[POST : One Touch Login by Phone](#OneTouchLoginByPhone-post-)<br>
[GET : One Touch Email Verification](#OneTouchEmailVerification-get-)<br>
[GET : One Touch Login Ping](#OneTouchLoginPing-get-)<br>

If you have not already initialized the OneTouchLogin object do so now
```
$oneTouchLoginAPI = new OneTouchLoginAPI(); 
```


<h6 id="OneTouchLoginOTPVerification-put-">One Touch OTP Verification (PUT)</h6>
This API is used to verify the otp for One Touch Login.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/one-touch-login/one-touch-otp-verification/)

 ```
 
$otp = "otp"; //Required 
$phone = "phone"; //Required 
$fields = null; //Optional 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $oneTouchLoginAPI->oneTouchLoginOTPVerification($otp,$phone,$fields,$smsTemplate);
 ```

 
<h6 id="OneTouchLoginByEmail-post-">One Touch Login by Email (POST)</h6>
This API is used to send a link to a specified email for a frictionless login/registration
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/one-touch-login/one-touch-login-by-email-captcha/)

 ```

 $payload = '{
"clientguid" : "<clientguid>",
"email" : "<email>",
"g-recaptcha-response" : "<g-recaptcha-response>"
}';  //Required 
$oneTouchLoginEmailTemplate = "oneTouchLoginEmailTemplate"; //Optional 
$redirecturl = "redirecturl"; //Optional 
$welcomeemailtemplate = "welcomeemailtemplate"; //Optional
 
$result = $oneTouchLoginAPI->oneTouchLoginByEmail($payload,$oneTouchLoginEmailTemplate,$redirecturl,$welcomeemailtemplate);
 ```

 
<h6 id="OneTouchLoginByPhone-post-">One Touch Login by Phone (POST)</h6>
This API is used to send one time password to a given phone number for a frictionless login/registration.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/one-touch-login/one-touch-login-by-phone-captcha/)

 ```

 $payload = '{
"g-recaptcha-response" : "<g-recaptcha-response>",
"phone" : "<phone>"
}';  //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $oneTouchLoginAPI->oneTouchLoginByPhone($payload,$smsTemplate);
 ```

 
<h6 id="OneTouchEmailVerification-get-">One Touch Email Verification (GET)</h6>
This API verifies the provided token for One Touch Login
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/one-touch-login/one-touch-email-verification)

 ```
 
$verificationToken = "verificationToken"; //Required 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $oneTouchLoginAPI->oneTouchEmailVerification($verificationToken,$welcomeEmailTemplate);
 ```

 
<h6 id="OneTouchLoginPing-get-">One Touch Login Ping (GET)</h6>
This API is used to check if the One Touch Login link has been clicked or not.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/one-touch-login/one-touch-login-ping/)

 ```
 
$clientGuid = "clientGuid"; //Required 
$fields = null; //Optional
 
$result = $oneTouchLoginAPI->oneTouchLoginPing($clientGuid,$fields);
 ```

 



### PasswordLessLogin API

List of APIs in this Section:<br>
[PUT : Passwordless Login Phone Verification](#PasswordlessLoginPhoneVerification-put-)<br>
[GET : Passwordless Login by Phone](#PasswordlessLoginByPhone-get-)<br>
[GET : Passwordless Login By Email](#PasswordlessLoginByEmail-get-)<br>
[GET : Passwordless Login By UserName](#PasswordlessLoginByUserName-get-)<br>
[GET : Passwordless Login Verification](#PasswordlessLoginVerification-get-)<br>

If you have not already initialized the PasswordLessLogin object do so now
```
$passwordLessLoginAPI = new PasswordLessLoginAPI(); 
```


<h6 id="PasswordlessLoginPhoneVerification-put-">Passwordless Login Phone Verification (PUT)</h6>
This API verifies an account by OTP and allows the customer to login.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/passwordless-login/passwordless-login-phone-verification)

 ```

 $payload = '{
"otp" : "<otp>",
"phone" : "<phone>"
}';  //Required 
$fields = null; //Optional 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $passwordLessLoginAPI->passwordlessLoginPhoneVerification($payload,$fields,$smsTemplate);
 ```

 
<h6 id="PasswordlessLoginByPhone-get-">Passwordless Login by Phone (GET)</h6>
API can be used to send a One-time Passcode (OTP) provided that the account has a verified PhoneID
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/passwordless-login/passwordless-login-by-phone)

 ```
 
$phone = "phone"; //Required 
$smsTemplate = "smsTemplate"; //Optional
 
$result = $passwordLessLoginAPI->passwordlessLoginByPhone($phone,$smsTemplate);
 ```

 
<h6 id="PasswordlessLoginByEmail-get-">Passwordless Login By Email (GET)</h6>
This API is used to send a Passwordless Login verification link to the provided Email ID
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/passwordless-login/passwordless-login-by-email)

 ```
 
$email = "email"; //Required 
$passwordLessLoginTemplate = "passwordLessLoginTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $passwordLessLoginAPI->passwordlessLoginByEmail($email,$passwordLessLoginTemplate,$verificationUrl);
 ```

 
<h6 id="PasswordlessLoginByUserName-get-">Passwordless Login By UserName (GET)</h6>
This API is used to send a Passwordless Login Verification Link to a customer by providing their UserName
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/passwordless-login/passwordless-login-by-username)

 ```
 
$username = "username"; //Required 
$passwordLessLoginTemplate = "passwordLessLoginTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $passwordLessLoginAPI->passwordlessLoginByUserName($username,$passwordLessLoginTemplate,$verificationUrl);
 ```

 
<h6 id="PasswordlessLoginVerification-get-">Passwordless Login Verification (GET)</h6>
This API is used to verify the Passwordless Login verification link. Note: If you are using Passwordless Login by Phone you will need to use the Passwordless Login Phone Verification API
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/passwordless-login/passwordless-login-verification)

 ```
 
$verificationToken = "verificationToken"; //Required 
$fields = null; //Optional 
$welcomeEmailTemplate = "welcomeEmailTemplate"; //Optional
 
$result = $passwordLessLoginAPI->passwordlessLoginVerification($verificationToken,$fields,$welcomeEmailTemplate);
 ```

 



### Configuration API

List of APIs in this Section:<br>[GET : Get Configurations](#getConfigurations-get-)<br>
[GET : Get Server Time](#GetServerInfo-get-)<br>

If you have not already initialized the Configuration object do so now
```
$configurationAPI = new ConfigurationAPI(); 
```
<h6 id="getConfigurations-get-">Get Configurations (GET)</h6>
This API is used to get the configurations which are set in the LoginRadius Dashboard for a particular LoginRadius site/environment 
[More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/configuration/get-configurations/)
```
$result = $configurationAPI->getConfigurations();
```


<h6 id="GetServerInfo-get-">Get Server Time (GET)</h6>
This API allows you to query your LoginRadius account for basic server information and server time information which is useful when generating an SOTT token.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/configuration/get-server-time/)

 ```
 
$timeDifference = 0; //Optional
 
$result = $configurationAPI->getServerInfo($timeDifference);
 ```

 



### Role API

List of APIs in this Section:<br>
[PUT : Assign Roles by UID](#AssignRolesByUid-put-)<br>
[PUT : Upsert Context](#UpdateRoleContextByUid-put-)<br>
[PUT : Add Permissions to Role](#AddRolePermissions-put-)<br>
[POST : Roles Create](#CreateRoles-post-)<br>
[GET : Roles by UID](#GetRolesByUid-get-)<br>
[GET : Get Context with Roles and Permissions](#GetRoleContextByUid-get-)<br>
[GET : Role Context profile](#GetRoleContextByContextName-get-)<br>
[GET : Roles List](#GetRolesList-get-)<br>
[DELETE : Unassign Roles by UID](#UnassignRolesByUid-delete-)<br>
[DELETE : Delete Role Context](#DeleteRoleContextByUid-delete-)<br>
[DELETE : Delete Role from Context](#DeleteRolesFromRoleContextByUid-delete-)<br>
[DELETE : Delete Additional Permission from Context](#DeleteAdditionalPermissionFromRoleContextByUid-delete-)<br>
[DELETE : Account Delete Role](#DeleteRole-delete-)<br>
[DELETE : Remove Permissions](#RemoveRolePermissions-delete-)<br>

If you have not already initialized the Role object do so now
```
$roleAPI = new RoleAPI(); 
```


<h6 id="AssignRolesByUid-put-">Assign Roles by UID (PUT)</h6>
This API is used to assign your desired roles to a given user.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/assign-roles-by-uid/)

 ```

 $payload = '{
"roles" : [  "roles" ] 
}';  //Required 
$uid = "uid"; //Required
 
$result = $roleAPI->assignRolesByUid($payload,$uid);
 ```

 
<h6 id="UpdateRoleContextByUid-put-">Upsert Context (PUT)</h6>
This API creates a Context with a set of Roles
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/upsert-context)

 ```

 $payload = '{
"roleContext" : [   { 
  "additionalPermissions" : ["<additionalPermissions>" ] ,
 "context" : "<context>"  ,
 "expiration" : "<expiration>"  ,
  "roles" : ["<roles>" ]  
}  ] 
}';  //Required 
$uid = "uid"; //Required
 
$result = $roleAPI->updateRoleContextByUid($payload,$uid);
 ```

 
<h6 id="AddRolePermissions-put-">Add Permissions to Role (PUT)</h6>
This API is used to add permissions to a given role.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/add-permissions-to-role)

 ```

 $payload = '{
"permissions" : [  "permissions" ] 
}';  //Required 
$role = "role"; //Required
 
$result = $roleAPI->addRolePermissions($payload,$role);
 ```

 
<h6 id="CreateRoles-post-">Roles Create (POST)</h6>
This API creates a role with permissions.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/roles-create)

 ```

 $payload = '{
"roles" : [   { 
 "name" : "<name>"  ,
"permissions" : {"Permission_name":true}  
}  ] 
}';  //Required
 
$result = $roleAPI->createRoles($payload);
 ```

 
<h6 id="GetRolesByUid-get-">Roles by UID (GET)</h6>
API is used to retrieve all the assigned roles of a particular User.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/get-roles-by-uid)

 ```
 
$uid = "uid"; //Required
 
$result = $roleAPI->getRolesByUid($uid);
 ```

 
<h6 id="GetRoleContextByUid-get-">Get Context with Roles and Permissions (GET)</h6>
This API Gets the contexts that have been configured and the associated roles and permissions.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/get-context)

 ```
 
$uid = "uid"; //Required
 
$result = $roleAPI->getRoleContextByUid($uid);
 ```

 
<h6 id="GetRoleContextByContextName-get-">Role Context profile (GET)</h6>
The API is used to retrieve role context by the context name.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/role-context-profile/)

 ```
 
$contextName = "contextName"; //Required
 
$result = $roleAPI->getRoleContextByContextName($contextName);
 ```

 
<h6 id="GetRolesList-get-">Roles List (GET)</h6>
This API retrieves the complete list of created roles with permissions of your app.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/roles-list)

 ```

 
$result = $roleAPI->getRolesList();
 ```

 
<h6 id="UnassignRolesByUid-delete-">Unassign Roles by UID (DELETE)</h6>
This API is used to unassign roles from a user.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/unassign-roles-by-uid)

 ```

 $payload = '{
"roles" : [  "roles" ] 
}';  //Required 
$uid = "uid"; //Required
 
$result = $roleAPI->unassignRolesByUid($payload,$uid);
 ```

 
<h6 id="DeleteRoleContextByUid-delete-">Delete Role Context (DELETE)</h6>
This API Deletes the specified Role Context
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/delete-context)

 ```
 
$contextName = "contextName"; //Required 
$uid = "uid"; //Required
 
$result = $roleAPI->deleteRoleContextByUid($contextName,$uid);
 ```

 
<h6 id="DeleteRolesFromRoleContextByUid-delete-">Delete Role from Context (DELETE)</h6>
This API Deletes the specified Role from a Context.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/delete-role-from-context/)

 ```
 
$contextName = "contextName"; //Required
 $payload = '{
"roles" : [  "roles" ] 
}';  //Required 
$uid = "uid"; //Required
 
$result = $roleAPI->deleteRolesFromRoleContextByUid($contextName,$payload,$uid);
 ```

 
<h6 id="DeleteAdditionalPermissionFromRoleContextByUid-delete-">Delete Additional Permission from Context (DELETE)</h6>
This API Deletes Additional Permissions from Context.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/delete-permissions-from-context)

 ```
 
$contextName = "contextName"; //Required
 $payload = '{
"additionalPermissions" : [  "additionalPermissions" ] 
}';  //Required 
$uid = "uid"; //Required
 
$result = $roleAPI->deleteAdditionalPermissionFromRoleContextByUid($contextName,$payload,$uid);
 ```

 
<h6 id="DeleteRole-delete-">Account Delete Role (DELETE)</h6>
This API is used to delete the role.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/delete-role)

 ```
 
$role = "role"; //Required
 
$result = $roleAPI->deleteRole($role);
 ```

 
<h6 id="RemoveRolePermissions-delete-">Remove Permissions (DELETE)</h6>
API is used to remove permissions from a role.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/roles-management/remove-permissions)

 ```

 $payload = '{
"permissions" : [  "permissions" ] 
}';  //Required 
$role = "role"; //Required
 
$result = $roleAPI->removeRolePermissions($payload,$role);
 ```

 



### CustomRegistrationData API

List of APIs in this Section:<br>
[PUT : Update Registration Data](#UpdateRegistrationData-put-)<br>
[POST : Validate secret code](#ValidateRegistrationDataCode-post-)<br>
[POST : Add Registration Data](#AddRegistrationData-post-)<br>
[GET : Auth Get Registration Data Server](#AuthGetRegistrationData-get-)<br>
[GET : Get Registration Data](#GetRegistrationData-get-)<br>
[DELETE : Delete Registration Data](#DeleteRegistrationData-delete-)<br>
[DELETE : Delete All Records by Datasource](#DeleteAllRecordsByDataSource-delete-)<br>

If you have not already initialized the CustomRegistrationData object do so now
```
$customRegistrationDataAPI = new CustomRegistrationDataAPI(); 
```


<h6 id="UpdateRegistrationData-put-">Update Registration Data (PUT)</h6>
This API allows you to update a dropdown item
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-registration-data/update-registration-data)

 ```

 $payload = '{
"isActive" : true,
"key" : "<key>",
"type" : "<type>",
"value" : "<value>"
}';  //Required 
$recordId = "recordId"; //Required
 
$result = $customRegistrationDataAPI->updateRegistrationData($payload,$recordId);
 ```

 
<h6 id="ValidateRegistrationDataCode-post-">Validate secret code (POST)</h6>
This API allows you to validate code for a particular dropdown member.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-registration-data/validate-code)

 ```
 
$code = "code"; //Required 
$recordId = "recordId"; //Required
 
$result = $customRegistrationDataAPI->validateRegistrationDataCode($code,$recordId);
 ```

 
<h6 id="AddRegistrationData-post-">Add Registration Data (POST)</h6>
This API allows you to fill data into a dropdown list which you have created for user Registration. For more details on how to use this API please see our Custom Registration Data Overview
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-registration-data/add-registration-data)

 ```

 $payload = '{
"data" : [   { 
 "code" : "<code>"  ,
"isActive" : true ,
 "key" : "<key>"  ,
 "parentId" : "<parentId>"  ,
 "type" : "<type>"  ,
 "value" : "<value>"   
}  ] 
}';  //Required
 
$result = $customRegistrationDataAPI->addRegistrationData($payload);
 ```

 
<h6 id="AuthGetRegistrationData-get-">Auth Get Registration Data Server (GET)</h6>
This API is used to retrieve dropdown data.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-registration-data/auth-get-registration-data)

 ```
 
$type = "type"; //Required 
$limit = 0; //Optional 
$parentId = "parentId"; //Optional 
$skip = 0; //Optional
 
$result = $customRegistrationDataAPI->authGetRegistrationData($type,$limit,$parentId,$skip);
 ```

 
<h6 id="GetRegistrationData-get-">Get Registration Data (GET)</h6>
This API is used to retrieve dropdown data.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-registration-data/get-registration-data)

 ```
 
$type = "type"; //Required 
$limit = 0; //Optional 
$parentId = "parentId"; //Optional 
$skip = 0; //Optional
 
$result = $customRegistrationDataAPI->getRegistrationData($type,$limit,$parentId,$skip);
 ```

 
<h6 id="DeleteRegistrationData-delete-">Delete Registration Data (DELETE)</h6>
This API allows you to delete an item from a dropdown list.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-registration-data/delete-registration-data)

 ```
 
$recordId = "recordId"; //Required
 
$result = $customRegistrationDataAPI->deleteRegistrationData($recordId);
 ```

 
<h6 id="DeleteAllRecordsByDataSource-delete-">Delete All Records by Datasource (DELETE)</h6>
This API allows you to delete all records contained in a datasource.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/custom-registration-data/delete-all-records-by-datasource)

 ```
 
$type = "type"; //Required
 
$result = $customRegistrationDataAPI->deleteAllRecordsByDataSource($type);
 ```

 



### RiskBasedAuthentication API

List of APIs in this Section:<br>
[POST : Risk Based Authentication Login by Email](#RBALoginByEmail-post-)<br>
[POST : Risk Based Authentication Login by Username](#RBALoginByUserName-post-)<br>
[POST : Risk Based Authentication Phone Login](#RBALoginByPhone-post-)<br>

If you have not already initialized the RiskBasedAuthentication object do so now
```
$riskBasedAuthenticationAPI = new RiskBasedAuthenticationAPI(); 
```


<h6 id="RBALoginByEmail-post-">Risk Based Authentication Login by Email (POST)</h6>
This API retrieves a copy of the user data based on the Email
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-login-by-email)

 ```

 $payload = '{
"email" : "<email>",
"password" : "<password>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$passwordDelegation = "true"; //Optional 
$passwordDelegationApp = "passwordDelegationApp"; //Optional 
$rbaBrowserEmailTemplate = "rbaBrowserEmailTemplate"; //Optional 
$rbaBrowserSmsTemplate = "rbaBrowserSmsTemplate"; //Optional 
$rbaCityEmailTemplate = "rbaCityEmailTemplate"; //Optional 
$rbaCitySmsTemplate = "rbaCitySmsTemplate"; //Optional 
$rbaCountryEmailTemplate = "rbaCountryEmailTemplate"; //Optional 
$rbaCountrySmsTemplate = "rbaCountrySmsTemplate"; //Optional 
$rbaIpEmailTemplate = "rbaIpEmailTemplate"; //Optional 
$rbaIpSmsTemplate = "rbaIpSmsTemplate"; //Optional 
$rbaOneclickEmailTemplate = "rbaOneclickEmailTemplate"; //Optional 
$rbaOTPSmsTemplate = "rbaOTPSmsTemplate"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $riskBasedAuthenticationAPI->rbaLoginByEmail($payload,$emailTemplate,$fields,$loginUrl,$passwordDelegation,$passwordDelegationApp,$rbaBrowserEmailTemplate,$rbaBrowserSmsTemplate,$rbaCityEmailTemplate,$rbaCitySmsTemplate,$rbaCountryEmailTemplate,$rbaCountrySmsTemplate,$rbaIpEmailTemplate,$rbaIpSmsTemplate,$rbaOneclickEmailTemplate,$rbaOTPSmsTemplate,$smsTemplate,$verificationUrl);
 ```

 
<h6 id="RBALoginByUserName-post-">Risk Based Authentication Login by Username (POST)</h6>
This API retrieves a copy of the user data based on the Username
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/authentication/auth-login-by-username)

 ```

 $payload = '{
"password" : "<password>",
"username" : "<username>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$passwordDelegation = "true"; //Optional 
$passwordDelegationApp = "passwordDelegationApp"; //Optional 
$rbaBrowserEmailTemplate = "rbaBrowserEmailTemplate"; //Optional 
$rbaBrowserSmsTemplate = "rbaBrowserSmsTemplate"; //Optional 
$rbaCityEmailTemplate = "rbaCityEmailTemplate"; //Optional 
$rbaCitySmsTemplate = "rbaCitySmsTemplate"; //Optional 
$rbaCountryEmailTemplate = "rbaCountryEmailTemplate"; //Optional 
$rbaCountrySmsTemplate = "rbaCountrySmsTemplate"; //Optional 
$rbaIpEmailTemplate = "rbaIpEmailTemplate"; //Optional 
$rbaIpSmsTemplate = "rbaIpSmsTemplate"; //Optional 
$rbaOneclickEmailTemplate = "rbaOneclickEmailTemplate"; //Optional 
$rbaOTPSmsTemplate = "rbaOTPSmsTemplate"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $riskBasedAuthenticationAPI->rbaLoginByUserName($payload,$emailTemplate,$fields,$loginUrl,$passwordDelegation,$passwordDelegationApp,$rbaBrowserEmailTemplate,$rbaBrowserSmsTemplate,$rbaCityEmailTemplate,$rbaCitySmsTemplate,$rbaCountryEmailTemplate,$rbaCountrySmsTemplate,$rbaIpEmailTemplate,$rbaIpSmsTemplate,$rbaOneclickEmailTemplate,$rbaOTPSmsTemplate,$smsTemplate,$verificationUrl);
 ```

 
<h6 id="RBALoginByPhone-post-">Risk Based Authentication Phone Login (POST)</h6>
This API retrieves a copy of the user data based on the Phone
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/phone-authentication/phone-login)

 ```

 $payload = '{
"password" : "<password>",
"phone" : "<phone>"
}';  //Required 
$emailTemplate = "emailTemplate"; //Optional 
$fields = null; //Optional 
$loginUrl = "loginUrl"; //Optional 
$passwordDelegation = "true"; //Optional 
$passwordDelegationApp = "passwordDelegationApp"; //Optional 
$rbaBrowserEmailTemplate = "rbaBrowserEmailTemplate"; //Optional 
$rbaBrowserSmsTemplate = "rbaBrowserSmsTemplate"; //Optional 
$rbaCityEmailTemplate = "rbaCityEmailTemplate"; //Optional 
$rbaCitySmsTemplate = "rbaCitySmsTemplate"; //Optional 
$rbaCountryEmailTemplate = "rbaCountryEmailTemplate"; //Optional 
$rbaCountrySmsTemplate = "rbaCountrySmsTemplate"; //Optional 
$rbaIpEmailTemplate = "rbaIpEmailTemplate"; //Optional 
$rbaIpSmsTemplate = "rbaIpSmsTemplate"; //Optional 
$rbaOneclickEmailTemplate = "rbaOneclickEmailTemplate"; //Optional 
$rbaOTPSmsTemplate = "rbaOTPSmsTemplate"; //Optional 
$smsTemplate = "smsTemplate"; //Optional 
$verificationUrl = "verificationUrl"; //Optional
 
$result = $riskBasedAuthenticationAPI->rbaLoginByPhone($payload,$emailTemplate,$fields,$loginUrl,$passwordDelegation,$passwordDelegationApp,$rbaBrowserEmailTemplate,$rbaBrowserSmsTemplate,$rbaCityEmailTemplate,$rbaCitySmsTemplate,$rbaCountryEmailTemplate,$rbaCountrySmsTemplate,$rbaIpEmailTemplate,$rbaIpSmsTemplate,$rbaOneclickEmailTemplate,$rbaOTPSmsTemplate,$smsTemplate,$verificationUrl);
 ```

 



### Sott API

List of APIs in this Section:<br>
[GET : Generate SOTT](#GenerateSott-get-)<br>

If you have not already initialized the Sott object do so now
```
$sottAPI = new SottAPI(); 
```


<h6 id="GenerateSott-get-">Generate SOTT (GET)</h6>
This API allows you to generate SOTT with a given expiration time.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/session/generate-sott-token)

 ```
 
$timeDifference = 0; //Optional
 
$result = $sottAPI->generateSott($timeDifference);
 ```

 



### NativeSocial API

List of APIs in this Section:<br>
[GET : Access Token via Facebook Token](#GetAccessTokenByFacebookAccessToken-get-)<br>
[GET : Access Token via Twitter Token](#GetAccessTokenByTwitterAccessToken-get-)<br>
[GET : Access Token via Google Token](#GetAccessTokenByGoogleAccessToken-get-)<br>
[GET : Access Token using google JWT token for Native Mobile Login](#GetAccessTokenByGoogleJWTAccessToken-get-)<br>
[GET : Access Token via Linkedin Token](#GetAccessTokenByLinkedinAccessToken-get-)<br>
[GET : Get Access Token By Foursquare Access Token](#GetAccessTokenByFoursquareAccessToken-get-)<br>
[GET : Access Token via Apple Id Code](#GetAccessTokenByAppleIdCode-get-)<br>
[GET : Access Token via WeChat Code](#GetAccessTokenByWeChatCode-get-)<br>
[GET : Access Token via Vkontakte Token](#GetAccessTokenByVkontakteAccessToken-get-)<br>
[GET : Access Token via Google AuthCode](#GetAccessTokenByGoogleAuthCode-get-)<br>

If you have not already initialized the NativeSocial object do so now
```
$nativeSocialAPI = new NativeSocialAPI(); 
```


<h6 id="GetAccessTokenByFacebookAccessToken-get-">Access Token via Facebook Token (GET)</h6>
The API is used to get LoginRadius access token by sending Facebook's access token. It will be valid for the specific duration of time specified in the response.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-facebook-token/)

 ```
 
$fb_Access_Token = "fb_Access_Token"; //Required 
$socialAppName = "socialAppName"; //Optional
 
$result = $nativeSocialAPI->getAccessTokenByFacebookAccessToken($fb_Access_Token,$socialAppName);
 ```

 
<h6 id="GetAccessTokenByTwitterAccessToken-get-">Access Token via Twitter Token (GET)</h6>
The API is used to get LoginRadius access token by sending Twitter's access token. It will be valid for the specific duration of time specified in the response.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-twitter-token)

 ```
 
$tw_Access_Token = "tw_Access_Token"; //Required 
$tw_Token_Secret = "tw_Token_Secret"; //Required 
$socialAppName = "socialAppName"; //Optional
 
$result = $nativeSocialAPI->getAccessTokenByTwitterAccessToken($tw_Access_Token,$tw_Token_Secret,$socialAppName);
 ```

 
<h6 id="GetAccessTokenByGoogleAccessToken-get-">Access Token via Google Token (GET)</h6>
The API is used to get LoginRadius access token by sending Google's access token. It will be valid for the specific duration of time specified in the response.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-google-token)

 ```
 
$google_Access_Token = "google_Access_Token"; //Required 
$client_id = "client_id"; //Optional 
$refresh_token = "refresh_token"; //Optional 
$socialAppName = "socialAppName"; //Optional
 
$result = $nativeSocialAPI->getAccessTokenByGoogleAccessToken($google_Access_Token,$client_id,$refresh_token,$socialAppName);
 ```

 
<h6 id="GetAccessTokenByGoogleJWTAccessToken-get-">Access Token using google JWT token for Native Mobile Login (GET)</h6>
This API is used to Get LoginRadius Access Token using google jwt id token for google native mobile login/registration.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-googlejwt)

 ```
 
$id_Token = "id_Token"; //Required
 
$result = $nativeSocialAPI->getAccessTokenByGoogleJWTAccessToken($id_Token);
 ```

 
<h6 id="GetAccessTokenByLinkedinAccessToken-get-">Access Token via Linkedin Token (GET)</h6>
The API is used to get LoginRadius access token by sending Linkedin's access token. It will be valid for the specific duration of time specified in the response.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-linkedin-token/)

 ```
 
$ln_Access_Token = "ln_Access_Token"; //Required 
$socialAppName = "socialAppName"; //Optional
 
$result = $nativeSocialAPI->getAccessTokenByLinkedinAccessToken($ln_Access_Token,$socialAppName);
 ```

 
<h6 id="GetAccessTokenByFoursquareAccessToken-get-">Get Access Token By Foursquare Access Token (GET)</h6>
The API is used to get LoginRadius access token by sending Foursquare's access token. It will be valid for the specific duration of time specified in the response.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-foursquare-token/)

 ```
 
$fs_Access_Token = "fs_Access_Token"; //Required
 
$result = $nativeSocialAPI->getAccessTokenByFoursquareAccessToken($fs_Access_Token);
 ```

 
<h6 id="GetAccessTokenByAppleIdCode-get-">Access Token via Apple Id Code (GET)</h6>
The API is used to get LoginRadius access token by sending a valid Apple ID OAuth Code. It will be valid for the specific duration of time specified in the response.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-apple-id-code)

 ```
 
$code = "code"; //Required 
$socialAppName = "socialAppName"; //Optional
 
$result = $nativeSocialAPI->getAccessTokenByAppleIdCode($code,$socialAppName);
 ```

 
<h6 id="GetAccessTokenByWeChatCode-get-">Access Token via WeChat Code (GET)</h6>
This API is used to retrieve a LoginRadius access token by passing in a valid WeChat OAuth Code.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-wechat-code)

 ```
 
$code = "code"; //Required
 
$result = $nativeSocialAPI->getAccessTokenByWeChatCode($code);
 ```

 
<h6 id="GetAccessTokenByVkontakteAccessToken-get-">Access Token via Vkontakte Token (GET)</h6>
The API is used to get LoginRadius access token by sending Vkontakte's access token. It will be valid for the specific duration of time specified in the response.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-vkontakte-token)

 ```
 
$vk_access_token = "vk_access_token"; //Required
 
$result = $nativeSocialAPI->getAccessTokenByVkontakteAccessToken($vk_access_token);
 ```

 
<h6 id="GetAccessTokenByGoogleAuthCode-get-">Access Token via Google AuthCode (GET)</h6>
The API is used to get LoginRadius access token by sending Google's AuthCode. It will be valid for the specific duration of time specified in the response.
 [More Info](https://www.loginradius.com/docs/api/v2/customer-identity-api/social-login/native-social-login-api/access-token-via-google-auth-code)

 ```
 
$google_authcode = "google_authcode"; //Required 
$socialAppName = "socialAppName"; //Optional
 
$result = $nativeSocialAPI->getAccessTokenByGoogleAuthCode($google_authcode,$socialAppName);
 ```

 



### WebHook API

List of APIs in this Section:<br>
[POST : Webhook Subscribe](#WebHookSubscribe-post-)<br>
[GET : Webhook Subscribed URLs](#GetWebHookSubscribedURLs-get-)<br>
[GET : Webhook Test](#WebhookTest-get-)<br>
[DELETE : WebHook Unsubscribe](#WebHookUnsubscribe-delete-)<br>

If you have not already initialized the WebHook object do so now
```
$webHookAPI = new WebHookAPI(); 
```


<h6 id="WebHookSubscribe-post-">Webhook Subscribe (POST)</h6>
API can be used to configure a WebHook on your LoginRadius site. Webhooks also work on subscribe and notification model, subscribe your hook and get a notification. Equivalent to RESThook but these provide security on basis of signature and RESThook work on unique URL. Following are the events that are allowed by LoginRadius to trigger a WebHook service call.
 [More Info](https://www.loginradius.com/docs/api/v2/integrations/webhooks/webhook-subscribe)

 ```

 $payload = '{
"event" : "<event>",
"targetUrl" : "<targetUrl>"
}';  //Required
 
$result = $webHookAPI->webHookSubscribe($payload);
 ```

 
<h6 id="GetWebHookSubscribedURLs-get-">Webhook Subscribed URLs (GET)</h6>
This API is used to fatch all the subscribed URLs, for particular event
 [More Info](https://www.loginradius.com/docs/api/v2/integrations/webhooks/webhook-subscribed-urls)

 ```
 
$event = "event"; //Required
 
$result = $webHookAPI->getWebHookSubscribedURLs($event);
 ```

 
<h6 id="WebhookTest-get-">Webhook Test (GET)</h6>
API can be used to test a subscribed WebHook.
 [More Info](https://www.loginradius.com/docs/api/v2/integrations/webhooks/webhook-test)

 ```

 
$result = $webHookAPI->webhookTest();
 ```

 
<h6 id="WebHookUnsubscribe-delete-">WebHook Unsubscribe (DELETE)</h6>
API can be used to unsubscribe a WebHook configured on your LoginRadius site.
 [More Info](https://www.loginradius.com/docs/api/v2/integrations/webhooks/webhook-unsubscribe)

 ```

 $payload = '{
"event" : "<event>",
"targetUrl" : "<targetUrl>"
}';  //Required
 
$result = $webHookAPI->webHookUnsubscribe($payload);
 ```

 


#### Implement Custom HTTP Client

- In order to implement custom HTTP client. Create the customhttpclient.php file in your project.

```
namespace LoginRadiusSDK\Clients\IHttpClient;
use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

class CustomHttpClient implements IHttpClient {

    public function request($path, $query_array = array(), $options = array()) {
    //custom HTTP client request handler code here
    }
}
```
- After that, pass the class name of your custom http client in global variable** $apiClient_class** in your project.
>Note
<br>
>If you manually added LoginRadius SDK then please make sure that customhttpclient.php file included in your project.
```
global $apiClient_class;
$apiClient_class = 'CustomHttpClient';
```

>Now your Custom HTTP client library will be used to handle LoginRadius APIs.

## Demo

Check out the demo and get the full SDK on our [Github](https://github.com/LoginRadius/php-sdk)

## Reference Manual
Please find the reference manual [here](http://docs.lrcontent.com/apidocs/ref/php/index.html)
