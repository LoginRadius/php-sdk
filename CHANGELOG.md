# LoginRadius PHP SDK Change Log

# Version 5.0.0
Released on **October 9, 2018**
## Enhancements
  -  API Request signing: Passed hash value instead of API Secret Key.
  -  API's Route changed.
  -  Access Token is added as header in all Authentication APIs
  -  Implemented Custom Domain option.
  -  Added preventEmailVerification (Boolean) option to prevent email verification flow in Auth Login and Registration APIs (where optional email is enabled). 

## Breaking Changes
  -  For developers migrating from v4.5.3 or older ones, there will be some breaking changes in terms of SDK implementation. 
     In this version, we have updated endpoints and renamed of following functions:-
     1) register() -> deprecated with registerByEmail()
     2) loginByEmail() -> deprecated with authLoginByEmail()
     3) loginByUsername() -> deprecated with authLoginByUsername()
     4) loginByPhone() -> authLoginByPhone
     5) instantLinkLoginByEmail() ->  deprecated with  passwordLessLoginByEmail()
     6) instantLinkLoginByUserName() -> deprecated with  passwordLessLoginByUserName()
     7) instantLinkLoginVerification() -> deprecated with  passwordLessLoginVerification()
     8) emailPromptAutoLoginbyEmail() -> deprecated with  smartLoginByEmail()
     9) emailPromptAutoLoginbyUserName() -> deprecated with  smartLoginByUserName() 
     10) emailPromptAutoLoginPing() -> deprecated with  smartLoginPing()
     11) verifyAutoLoginEmailForLogin() -> deprecated with  smartLoginVerifyToken() 
     12) simplifiedInstantRegistrationByEmail() ->  deprecated with  oneTouchLoginByEmail()
     13) simplifiedInstantRegistrationByPhone() ->  deprecated with   oneTouchLoginByPhone() 
     14) simplifiedInstantRegistrationOTPVerification() ->  deprecated with  oneTouchOtpVerification()
     15) twoFALoginByEmail()  ->  deprecated with  mfaEmailLogin()
     16) twoFALoginByUsername()  -> deprecated with  mfaUserNameLogin()
     17) twoFALoginByPhone() -> deprecated with  mfaPhoneLogin()
     18) configureTwoFAByToken()  -> deprecated with  mfaValidateAccessToken()
     19) verifyTwoFAByGoogleAuthCodeOrOtp()  -> deprecated with  updateMfaByGoogleAuthCode() and  updateMfaByOtp()
     20) removeOrResetGoogleAuthenticatorByToken()  -> deprecated with  resetGoogleAuthenticatorByToken() and  resetSMSAuthenticatorByToken()  
     21) removeOrResetGoogleAuthenticator()  -> deprecated with  mfaResetGoogleAuthenticatorByUid() and  mfaResetSMSAuthenticatorByUid() 
     22) Removed CloudAPI -> Replaced with ConfigAPI
     23) Removed ProvidersAPI and SchemaAPI
     24) Removed SOTT from utility.
     25) Directory name \LoginRadiusSDK\CustomerRegistration\Management -> replaced with \LoginRadiusSDK\CustomerRegistration\Account

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
 


 
