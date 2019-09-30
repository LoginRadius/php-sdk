> **LoginRadius PHP SDK Change Log** provides information regarding what has changed, more specifically what changes, improvements and bug fix has been made to the SDK. For more details please refer to the [LoginRadius API Documention](https://www.loginradius.com/docs/api/v2/deployment/sdk-libraries/php-library/)

# Version 10.0.0
Release on **September 30, 2019**

## Enhancements
This full version release includes major changes with several improvements and optimizations :

 - Enhanced the coding standards of SDK to follow industry programming styles and best practices.
 - Enhanced security standards of SDK.
 - Reduced code between the business layer and persistence layer for optimization of SDK performance.
 - Added internal parameter validations in the API function.
 - ApiKey and ApiSecret usage redundancy removed.
 - All LoginRadius related features need to be defined once only and SDK will handle them automatically.
 - Improved the naming conventions of API functions for better readability.
 - Better Exception Handling for LoginRadius API Response in SDK.
 - Revamped complete SDK and restructured it with latest API function names and parameters.
 - Added detailed description to API functions and parameters for better understanding.
 - Updated the demo according to latest SDK changes.
 - Implemented API Region Feature.
 - Added PIN Authentication feature APIs.
 - Added Consent Management feature APIs.
 - Added Local SOTT generation

## Added new multiple APIs for better user experience

 - Update Phone ID by UID
 - Upsert Email
 - Role Context profile
 - MFA Resend OTP
 - User Registration By Captcha
 - Get Access Token via Linkedin Token
 - Get Access Token By Foursquare Access Token
 - Get Active Session By Account Id
 - Get Active Session By Profile Id
 - Delete User Profiles By Email
 - Verify Multifactor OTP Authentication
 - Verify Multifactor Password Authentication
 - Verify Multifactor PIN Authentication
 - Update UID
 - MFA Re-authentication by PIN
 - PIN Login
 - Forgot PIN By Email
 - Forgot PIN By UserName
 - Reset PIN By ResetToken
 - Reset PIN By SecurityAnswer And Email
 - Reset PIN By SecurityAnswer And Username
 - Reset PIN By SecurityAnswer And Phone
 - Forgot PIN By Phone
 - Change PIN By Token
 - Reset PIN by Phone and OTP
 - Reset PIN by Email and OTP
 - Reset PIN by Username and OTP
 - Set PIN By PinAuthToken
 - Invalidate PIN Session Token
 - Submit Consent By ConsentToken
 - Get Consent Logs
 - Submit Consent By AccessToken
 - Verify Consent By AccessToken
 - Update Consent Profile By AccessToken
 - Get Consent Logs By Uid
 - Album With Cursor
 - Audio With Cursor
 - Check In With Cursor
 - Event With Cursor
 - Following With Cursor
 - Group With Cursor
 - Like With Cursor


## Removed APIs:

 - GetCompanies API
 - Getstatus API


# Version 10.0.0-beta
Released on **August 05, 2019**

## Enhancements
This beta version release includes major changes with several improvements and optimizations :
 - Enhanced the coding standards of SDK to follow industry programming styles and best practices.
 - Enhanced security standards of SDK.
 - Reduced code between the business layer and persistence layer for optimization of SDK  performance.
 - Added internal parameter validations in the API function.
 - ApiKey and ApiSecret usage redundancy removed.
 - All LoginRadius related features need to be defined once only and SDK will handle them automatically.
 - Improved the naming conventions of API functions for better readability.
 - Better Error and Exception Handling for LoginRadius API Response in SDK.
 - Revamped complete SDK and restructured it with latest API function names and parameters.
 - Added detailed description to API functions and parameters for better understanding.
 - Updated the demo according to latest SDK changes.

## Added new multiple APIs for better user experience
 - Update Phone ID by UID
 - Upsert Email
 - Role Context profile
 - MFA Resend OTP
 - User Registration By Captcha
 - Get Access Token via Linkedin Token
 - Get Access Token By Foursquare Access Token
 - Get Active Session By Account Id
 - Get Active Session By Profile Id

## Removed APIs:
- GetCompanies API
- shortenUrl API

# Version 5.0.2
Released on **January 11, 2019**
## Enhancements
  -  Added API Region Option in SDK.
  -  Added gzip encoding in api request.
## Bug Fixed
  -  Defined urlReplacement function statically in functions.php file.

# Version 5.0.1
Released on **October 15, 2018**
## Bug Fixed
  -  Remove dependency of json option.
  
# Version 5.0.0
Released on **October 9, 2018**
## Enhancements
  -  API Request signing: Passed hash value instead of API Secret Key.
  -  API's Route changed.
  -  Access Token is added as header in all Authentication APIs
  -  Implemented Custom Domain option.
  -  Added preventEmailVerification (Boolean) option to prevent email verification flow in Auth Login and Registration APIs (where optional email is enabled). 

## Breaking Changes
  For developers migrating from v4.5.3 or older ones, there are following breaking changes in terms of SDK implementation. 
  -  register()  replaced with registerByEmail()
  -  loginByEmail() replaced with authLoginByEmail()
  -  loginByUsername() replaced with authLoginByUsername()
  -  loginByPhone() replaced with authLoginByPhone
  -  instantLinkLoginByEmail() replaced with  passwordLessLoginByEmail()
  -  instantLinkLoginByUserName() replaced with  passwordLessLoginByUserName()
  -  instantLinkLoginVerification() replaced with  passwordLessLoginVerification()
  -  emailPromptAutoLoginbyEmail() replaced with  smartLoginByEmail()
  -  emailPromptAutoLoginbyUserName() replaced with  smartLoginByUserName() 
  -  emailPromptAutoLoginPing() replaced with  smartLoginPing()
  -  verifyAutoLoginEmailForLogin() replaced with  smartLoginVerifyToken() 
  -  simplifiedInstantRegistrationByEmail() replaced with  oneTouchLoginByEmail()
  -  simplifiedInstantRegistrationByPhone() replaced with   oneTouchLoginByPhone() 
  -  simplifiedInstantRegistrationOTPVerification() replaced with  oneTouchOtpVerification()
  -  twoFALoginByEmail()  replaced with  mfaEmailLogin()
  -  twoFALoginByUsername()  replaced with  mfaUserNameLogin()
  -  twoFALoginByPhone() replaced with  mfaPhoneLogin()
  -  configureTwoFAByToken()  replaced with  mfaValidateAccessToken()
  -  verifyTwoFAByGoogleAuthCodeOrOtp()  replaced with  updateMfaByGoogleAuthCode() and  updateMfaByOtp()
  -  removeOrResetGoogleAuthenticatorByToken()  replaced with  resetGoogleAuthenticatorByToken() and  resetSMSAuthenticatorByToken()  
  -  removeOrResetGoogleAuthenticator()  replaced with  mfaResetGoogleAuthenticatorByUid() and  mfaResetSMSAuthenticatorByUid() 
  -  Removed CloudAPI  replaced with ConfigAPI
  -  Removed ProvidersAPI and SchemaAPI
  -  Removed SOTT from utility.
  -  Directory name \LoginRadiusSDK\CustomerRegistration\Management -> replaced with \LoginRadiusSDK\CustomerRegistration\Account

# Version 4.5.3
Released on **August 9, 2018**
## Bug Fixed
  -  HTTP method request bug fixing

# Version 4.5.2
Released on **April 3, 2018**
## Bug Fixed
  -  SOTT was not generating properly in PHP SDK demo

# Version 4.5.1
Released on **January 24, 2018**
## Enhancements
  - Change configuration API endpoint url. 

# Version 4.5.0
Released on **Novemeber 28, 2017**
## Enhancements
  - Added API to get Identities
  - Added API to invalidate email
  - Added API to get email verification token
  - Added API to get forgot password token  
  - Passed APIkey and APISecret key in header for management Api's
  - Removed mcrypt dependency (function deprecated in php 7)


# Version 4.4.0 
Released on **Novemeber 7, 2017**
## Enhancements
  - Added Configuration API
  - Added API to get all active session details  
  - Added Reset password by Security Answer API
  - Added Remove Email Management API
  
# Version 4.3.0 
Released on **September 15, 2017**
## Enhancements
  - Ability to support proxy server
  - Projection of fields in api's
  - Added management api to generate a new SOTT
  - Custom object edit API enhancements
  - Added security questions api's
  - Added invalidate phone api
  - Added instant link login api
  - Added simplified instant registration data api's
  - Auto login api enhancement

# Version 4.2.0 
Released on **June 20, 2017**
## Enhancements
  - Added Roles API's
  - Added Web hooks API's
  - Added Email Prompt Auto Login API's

# Version 4.1.0 
Released on **April 10, 2017**
## Enhancements
  - Added user impersonation API
  - Added Check token validity and invalidate token API
  - Added Two-Factor authentication API's

# 4.0.0
## Enhancements
Released on **February 28, 2017**
  - Significantly improved code performance.
  - Wrapper methods for latest LoginRadius APIs have been added in Account API and User API
  - Added email,username and phone login api's
  - Added advance social login api's
  - Added resthooks api's
  - Added role api's
  - Added add or remove email api's
  - Added Custom object api's
 


 
