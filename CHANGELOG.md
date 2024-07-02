> **LoginRadius PHP SDK Change Log** provides information regarding what has changed, more specifically what changes, improvements and bug fix has been made to the SDK. For more details please refer to the [LoginRadius API Documention](https://www.loginradius.com/docs/api/v2/deployment/sdk-libraries/php-library/)


# Version 11.6.0

Release on **July 02, 2024**

## Added following APIs:
- `MFAValidateAuthenticatorCode`
- `MFAVerifyAuthenticatorCode`
- `RevokeAllRefreshToken `
- `MultipurposeEmailTokenGeneration`
- `MultipurposeSMSOTPGeneration`
- `MFAReAuthenticateByAuthenticatorCode`
- `AuthSendVerificationEmailForLinkingSocialProfiles `
- `SlidingAccessToken`
- `AccessTokenViaCustomJWTToken`
- `MFAResetAuthenticatorByToken`
- `MFAResetAuthenticatorByUid`

## Enhancements
- Added `isVoiceOtp` parameter in `ResetPhoneIDVerificationByUid` API
- Added `isVoiceOtp` parameter in `MFAConfigureByAccessToken` API
- Added `isVoiceOtp` and `options` parameter in `MFAUpdatePhoneNumberByToken` API
- Added `isVoiceOtp`, `emailTemplate2FA` and `options` parameter in `MFALoginByEmail` API
- Added `isVoiceOtp` and `emailTemplate2FA` parameter in `MFALoginByUserName` API
- Added `isVoiceOtp` , `emailTemplate2FA` and `options` parameter in `MFALoginByPhone` API
- Added `isVoiceOtp` and `options` parameter in `MFAUpdatePhoneNumber` API
- Added `isVoiceOtp` parameter in `MFAResendOTP` API
- Added `isVoiceOtp` parameter in `MFAReAuthenticate` API
- Added `isVoiceOtp` and `options` parameter in `UpdateProfileByAccessToken` API
- Added `isVoiceOtp` parameter in `UserRegistrationByEmail` API
- Added `isVoiceOtp` parameter in `UserRegistrationByCaptcha` API
- Added `isVoiceOtp` parameter in `OneTouchLoginByPhone` API
- Added `isVoiceOtp` parameter in `PasswordlessLoginPhoneVerification` API
- Added `isVoiceOtp` parameter in `PasswordlessLoginByPhone` API
- Added `isVoiceOtp` parameter in `ForgotPasswordByPhoneOTP` API
- Added `isVoiceOtp` parameter in `PhoneVerificationByOTP` API
- Added `isVoiceOtp` parameter in `PhoneVerificationOTPByAccessToken` API
- Added `isVoiceOtp` parameter in `PhoneResendVerificationOTP` API
- Added `isVoiceOtp` parameter in `UpdatePhoneNumber` API
- Added `isVoiceOtp` and `emailTemplate` parameter in `UserRegistrationByPhone` API
- Added `isVoiceOtp` parameter in `SendForgotPINSMSByPhone` API
- Added `uuid` parameter in `VerifyEmail` API

## Removed the following parameter

-`smsTemplate2FA` parameter in `MFAConfigureByAccessToken` API



## Removed (Deprecated) APIs:
- `MFAValidateGoogleAuthCode`
- `MFAReAuthenticateByGoogleAuth`
- `MFAResetGoogleAuthByToken `
- `MFAResetGoogleAuthenticatorByUid`
- `MFAUpdateByAccessToken`

# Version 11.5.0

Release on **January 20, 2023**

## Removed (Deprecated) APIs:
- `AuthGetRegistrationData`
- `ValidateRegistrationDataCode`
- `GetRegistrationData`
- `AddRegistrationData`
- `UpdateRegistrationData`
- `DeleteRegistrationData`
- `DeleteAllRecordsByDataSource`
- `GetAccessTokenByVkontakteAccessToken`
- `GetAlbum`
- `GetAlbumsWithCursor`
- `GetAudios`
- `GetAudiosWithCursor`
- `GetCheckIns`
- `GetCheckInsWithCursor`
- `GetContacts`
- `GetEvents`
- `GetEventsWithCursor`
- `GetFollowings`
- `GetFollowingsWithCursor`
- `GetGroups`
- `GetGroupsWithCursor`
- `GetLikes`
- `GetLikesWithCursor`
- `GetMentions`
- `PostMessage`
- `GetPage`
- `GetPhotos`
- `GetPosts`
- `StatusPosting`
- `TrackableStatusPosting`
- `GetTrackableStatusStats`
- `TrackableStatusFetching`
- `GetVideos`
- `GetRefreshedSocialUserProfile`


# Version 11.4.2

Release on **September 28, 2022**

## Enhancements

- Added Referer Header Feature


# Version 11.4.1

Release on **June 15, 2022**

## Enhancements

- Added emailTemplate parameter in userRegistrationByPhone Api

# Version 11.4.0

Release on **June 02, 2022**

## Enhancements

- Removed the additional version name from multiple files in SDK.
- We are introducing a new manual Sott generation method `getSott()` with additional parameter `startTime` & `endTime` , we recomend using this method to generate SOTT manually , the old function `encrypt()` will also exist but it is deprecated and will be removed in a future version of SDK.

# Version 11.3.0

Release on **January 27, 2022**

## Enhancements

- Added a feature to add ApiKey and ApiSecret directly in LoginRadius manual SOTT generation method.
- Added Licence and Contribution Guideline files.

## Breaking Changes

For developers migrating from v11.2.0, there will be 1 minor breaking change in terms of SDK implementation. In this version, we have added a feature to add ApiKey & ApiSecret directly into the manual SOTT generation method `encrypt()`.


# Version 11.2.0

Release on **September 6, 2021**

## Enhancements

- Updated Jquery with latest version(3.6.0) in SDK Demo


## Added new multiple APIs for better user experience


- MFAEmailOtpByAccessToken
- MFAValidateEmailOtpByAccessToken
- MFAResetEmailOtpAuthenticatorByAccessToken
- MFASecurityQuestionAnswerByAccessToken
- MFAResetSecurityQuestionAuthenticatorByAccessToken
- MFAEmailOTP
- MFAValidateEmailOtp
- MFASecurityQuestionAnswer
- MFASecurityQuestionAnswerVerification
- MFAResetEmailOtpAuthenticatorByUid
- MFAResetSecurityQuestionAuthenticatorByUid
- ReAuthValidateEmailOtp
- ReAuthSendEmailOtp
- ReAuthBySecurityQuestion

## Removed APIs:

- GetSocialUserProfile

#### Added `EmailTemplate2FA` parameter in the following API 
- MFALoginByEmail
- MFALoginByUserName
- MFALoginByPhone

#### Added 	`RbaBrowserEmailTemplate`, `RbaCityEmailTemplate` ,`RbaCountryEmailTemplate` , `RbaIpEmailTemplate` parameter in the following API 
- MFAValidateOTPByPhone
- MFAValidateGoogleAuthCode
- MFAValidateBackupCode

#### Added 	`emailTemplate`, `verificationUrl` ,`welcomeEmailTemplate`  parameter in the following API 

- GetProfileByAccessToken

#### Removed `smsTemplate2FA ` parameter from the following API 
- mfaValidateGoogleAuthCode


# Version 11.1.1
Release on **June 11, 2021**



## Bug Fixed
- fixed API Key Validation issue


# Version 11.1.0
Release on **March 25, 2021**

## Enhancements
- Added X-Origin-IP header support.
- Added 429 error code handling for "Too Many Request in a particular time frame".


## Added new multiple APIs for better user experience
- Get Profile By Ping.
- Passwordless Login Verification By Email And OTP.
- Passwordless Login Verification By User Name And OTP.




# Version 11.0.0
Release on **July 28, 2020**

## Enhancements
- Added a parameter isWeb in "RefreshAccessToken" API.
- Added a parameter SocialAppName in "getAccessTokenByFacebookAccessToken,  getAccessTokenByTwitterAccessToken,
  getAccessTokenByGoogleAccessToken, getAccessTokenByLinkedinAccessToken, getAccessTokenByAppleIdCode, 
  getAccessTokenByGoogleAuthCode" Native Social login APIs.

## Added new multiple APIs for better user experience
 - Added linkSocialIdentities(POST) API.
 - Added linkSocialIdentitiesByPing(POST) API.
 - Added getAccessTokenByAppleIdCode API.
 - Added getAccessTokenByWeChatCode API.

## Removed APIs:
 - linkSocialIdentity API(PUT)
 - getSocialIdentity API(GET)


# Version 10.0.0
Release on **September 26, 2019**

## Enhancements
This full version release includes major changes with several improvements and optimizations :

 - Enhanced the coding standards of SDK to follow industry programming styles and best practices.
 - Enhanced security standards of SDK.
 - Reduced code between the business layer and persistence layer for optimization of SDK performance.
 - Added internal parameter validations in the API function.
 - ApiKey and ApiSecret usage redundancy removed.
 - All LoginRadius related features need to be defined once only and SDK will handle them automatically.
 - Improved the naming conventions of API functions for better readability.
 - Better Error and Exception Handling for LoginRadius API Response in SDK.
 - Revamped complete SDK and restructured it with latest API function names and parameters.
 - Added detailed description to API functions and parameters for better understanding.
 - Updated the demo according to latest SDK changes.
 - Implemented API Region Feature.
 - Added Functionality to generate SOTT locally in Utility folder, compatible with latest version of PHP.


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
 - Pin Login
 - Forgot Pin By Email
 - Forgot Pin By UserName
 - Reset PIN By ResetToken
 - Reset PIN By SecurityAnswer And Email
 - Reset PIN By SecurityAnswer And Username
 - Reset PIN By SecurityAnswer And Phone
 - Forgot Pin By Phone
 - Change Pin By Token
 - Reset PIN by Phone and OTP
 - Reset PIN by Email and OTP
 - Reset PIN by Username and OTP
 - Set Pin By PinAuthToken
 - Invalidate Pin Session Token
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
 


 
