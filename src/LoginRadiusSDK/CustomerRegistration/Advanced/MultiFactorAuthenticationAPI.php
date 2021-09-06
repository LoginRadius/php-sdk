<?php
 /**
 * @category            : CustomerRegistration
 * @link                : http://www.loginradius.com
 * @package             : MultiFactorAuthenticationAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Advanced;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

class MultiFactorAuthenticationAPI extends Functions
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }
       


    /**
     * This API is used to configure the Multi-factor authentication after login by using the access token when MFA is set as optional on the LoginRadius site.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param smsTemplate2FA SMS Template Name
     * @return Response containing Definition of Complete Multi-Factor Authentication Settings data
     * 5.7
    */

    public function mfaConfigureByAccessToken($accessToken, $smsTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/account/2fa";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to trigger the Multi-factor authentication settings after login for secure actions
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param multiFactorAuthModelWithLockout Model Class containing Definition of payload for MultiFactorAuthModel With Lockout API
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @return Response containing Definition for Complete profile data
     * 5.9
    */

    public function mfaUpdateSetting($accessToken, $multiFactorAuthModelWithLockout,
        $fields = "")
    {
        $resourcePath = "/identity/v2/auth/account/2fa/verification/otp";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $multiFactorAuthModelWithLockout);
    }
       


    /**
     * This API is used to Enable Multi-factor authentication by access token on user login
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param multiFactorAuthModelByGoogleAuthenticatorCode Model Class containing Definition of payload for MultiFactorAuthModel By GoogleAuthenticator Code API
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @param smsTemplate SMS Template name
     * @return Response containing Definition for Complete profile data
     * 5.10
    */

    public function mfaUpdateByAccessToken($accessToken, $multiFactorAuthModelByGoogleAuthenticatorCode,
        $fields = "", $smsTemplate = null)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/verification/googleauthenticatorcode";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        if ($smsTemplate != '') {
            $queryParam['smsTemplate'] = $smsTemplate;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $multiFactorAuthModelByGoogleAuthenticatorCode);
    }
       


    /**
     * This API is used to update the Multi-factor authentication phone number by sending the verification OTP to the provided phone number
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param phoneNo2FA Phone Number For 2FA
     * @param smsTemplate2FA SMS Template Name
     * @return Response containing Definition for Complete SMS data
     * 5.11
    */

    public function mfaUpdatePhoneNumberByToken($accessToken, $phoneNo2FA,
        $smsTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/account/2fa";
        $bodyParam = [];
        $bodyParam['phoneNo2FA'] = $phoneNo2FA;
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API Resets the Google Authenticator configurations on a given account via the access token
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param googleauthenticator boolean type value,Enable google Authenticator Code.
     * @return Response containing Definition of Delete Request
     * 5.12.1
    */

    public function mfaResetGoogleAuthByToken($accessToken, $googleauthenticator)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/authenticator";
        $bodyParam = [];
        $bodyParam['googleauthenticator'] = $googleauthenticator;
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API resets the SMS Authenticator configurations on a given account via the access token.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param otpauthenticator Pass 'otpauthenticator' to remove SMS Authenticator
     * @return Response containing Definition of Delete Request
     * 5.12.2
    */

    public function mfaResetSMSAuthByToken($accessToken, $otpauthenticator)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/authenticator";
        $bodyParam = [];
        $bodyParam['otpauthenticator'] = $otpauthenticator;
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API is used to get a set of backup codes via access token to allow the user login on a site that has Multi-factor Authentication enabled in the event that the user does not have a secondary factor available. We generate 10 codes, each code can only be consumed once. If any user attempts to go over the number of invalid login attempts configured in the Dashboard then the account gets blocked automatically
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @return Response containing Definition of Complete Backup Code data
     * 5.13
    */

    public function mfaBackupCodeByAccessToken($accessToken)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/backupcode";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * API is used to reset the backup codes on a given account via the access token. This API call will generate 10 new codes, each code can only be consumed once
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @return Response containing Definition of Complete Backup Code data
     * 5.14
    */

    public function mfaResetBackupCodeByAccessToken($accessToken)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/backupcode/reset";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is created to send the OTP to the email if email OTP authenticator is enabled in app's MFA configuration.
     * @param accessToken access_token
     * @param emailId EmailId
     * @param emailTemplate2FA EmailTemplate2FA
     * @return Response containing Definition of Complete Validation data
     * 5.17
    */

    public function mfaEmailOtpByAccessToken($accessToken, $emailId,
        $emailTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/otp/email";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($emailId === '' || ctype_space($emailId)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('emailId'));
        }
        if ($emailTemplate2FA != '') {
            $queryParam['emailTemplate2FA'] = $emailTemplate2FA;
        }
        $queryParam['access_token'] = $accessToken;
        $queryParam['emailId'] = $emailId;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to set up MFA Email OTP authenticator on profile after login.
     * @param accessToken access_token
     * @param multiFactorAuthModelByEmailOtpWithLockout payload
     * @return Response containing Definition for Complete profile data
     * 5.18
    */

    public function mfaValidateEmailOtpByAccessToken($accessToken, $multiFactorAuthModelByEmailOtpWithLockout)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/verification/otp/email";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $multiFactorAuthModelByEmailOtpWithLockout);
    }
       


    /**
     * This API is used to reset the Email OTP Authenticator settings for an MFA-enabled user
     * @param accessToken access_token
     * @return Response containing Definition of Delete Request
     * 5.19
    */

    public function mfaResetEmailOtpAuthenticatorByAccessToken($accessToken)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/authenticator/otp/email";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to set up MFA Security Question authenticator on profile after login.
     * @param accessToken access_token
     * @param securityQuestionAnswerModelByAccessToken payload
     * @return Response containing Definition of Complete Validation data
     * 5.20
    */

    public function mfaSecurityQuestionAnswerByAccessToken($accessToken, $securityQuestionAnswerModelByAccessToken)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/securityquestionanswer";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $securityQuestionAnswerModelByAccessToken);
    }
       


    /**
     * This API is used to Reset MFA Security Question Authenticator By Access Token
     * @param accessToken access_token
     * @return Response containing Definition of Delete Request
     * 5.21
    */

    public function mfaResetSecurityQuestionAuthenticatorByAccessToken($accessToken)
    {
        $resourcePath = "/identity/v2/auth/account/2fa/authenticator/securityquestionanswer";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam);
    }
       


    /**
     * This API can be used to login by emailid on a Multi-factor authentication enabled LoginRadius site.
     * @param email user's email
     * @param password Password for the email
     * @param emailTemplate Email template name
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @param loginUrl Url where the user is logging from
     * @param smsTemplate SMS Template name
     * @param smsTemplate2FA SMS Template Name
     * @param verificationUrl Email verification url
     * @param emailTemplate2FA 2FA Email Template name
     * @return Complete user UserProfile data
     * 9.8.1
    */

    public function mfaLoginByEmail($email, $password,
        $emailTemplate = null, $fields = "",
        $loginUrl = null, $smsTemplate = null, $smsTemplate2FA = null,
        $verificationUrl = null, $emailTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa";
        $bodyParam = [];
        $bodyParam['email'] = $email;
        $bodyParam['password'] = $password;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($emailTemplate != '') {
            $queryParam['emailTemplate'] = $emailTemplate;
        }
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        if ($loginUrl != '') {
            $queryParam['loginUrl'] = $loginUrl;
        }
        if ($smsTemplate != '') {
            $queryParam['smsTemplate'] = $smsTemplate;
        }
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        if ($verificationUrl != '') {
            $queryParam['verificationUrl'] = $verificationUrl;
        }
        if ($emailTemplate2FA != '') {
            $queryParam['emailTemplate2FA'] = $emailTemplate2FA;
        }
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API can be used to login by username on a Multi-factor authentication enabled LoginRadius site.
     * @param password Password for the email
     * @param username Username of the user
     * @param emailTemplate Email template name
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @param loginUrl Url where the user is logging from
     * @param smsTemplate SMS Template name
     * @param smsTemplate2FA SMS Template Name
     * @param verificationUrl Email verification url
     * @param emailTemplate2FA 2FA Email Template name
     * @return Complete user UserProfile data
     * 9.8.2
    */

    public function mfaLoginByUserName($password, $username,
        $emailTemplate = null, $fields = "",$loginUrl = null,
        $smsTemplate = null, $smsTemplate2FA = null,
        $verificationUrl = null, $emailTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa";
        $bodyParam = [];
        $bodyParam['password'] = $password;
        $bodyParam['username'] = $username;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($emailTemplate != '') {
            $queryParam['emailTemplate'] = $emailTemplate;
        }
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        if ($loginUrl != '') {
            $queryParam['loginUrl'] = $loginUrl;
        }
        if ($smsTemplate != '') {
            $queryParam['smsTemplate'] = $smsTemplate;
        }
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        if ($verificationUrl != '') {
            $queryParam['verificationUrl'] = $verificationUrl;
        }
        if ($emailTemplate2FA != '') {
            $queryParam['emailTemplate2FA'] = $emailTemplate2FA;
        }
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API can be used to login by Phone on a Multi-factor authentication enabled LoginRadius site.
     * @param password Password for the email
     * @param phone New Phone Number
     * @param emailTemplate Email template name
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @param loginUrl Url where the user is logging from
     * @param smsTemplate SMS Template name
     * @param smsTemplate2FA SMS Template Name
     * @param verificationUrl Email verification url
     * @param emailTemplate2FA 2FA Email Template name
     * @return Complete user UserProfile data
     * 9.8.3
    */

    public function mfaLoginByPhone($password, $phone,
        $emailTemplate = null, $fields = "",
        $loginUrl = null, $smsTemplate = null, $smsTemplate2FA = null,
        $verificationUrl = null, $emailTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa";
        $bodyParam = [];
        $bodyParam['password'] = $password;
        $bodyParam['phone'] = $phone;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($emailTemplate != '') {
            $queryParam['emailTemplate'] = $emailTemplate;
        }
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        if ($loginUrl != '') {
            $queryParam['loginUrl'] = $loginUrl;
        }
        if ($smsTemplate != '') {
            $queryParam['smsTemplate'] = $smsTemplate;
        }
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        if ($verificationUrl != '') {
            $queryParam['verificationUrl'] = $verificationUrl;
        }
        if ($emailTemplate2FA != '') {
            $queryParam['emailTemplate2FA'] = $emailTemplate2FA;
        }
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API is used to login via Multi-factor authentication by passing the One Time Password received via SMS
     * @param multiFactorAuthModelWithLockout Model Class containing Definition of payload for MultiFactorAuthModel With Lockout API
     * @param secondFactorAuthenticationToken A Uniquely generated MFA identifier token after successful authentication
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @param smsTemplate2FA SMS Template Name
     * @param rbaBrowserEmailTemplate 
     * @param rbaCityEmailTemplate 
     * @param rbaCountryEmailTemplate 
     * @param rbaIpEmailTemplate 
     * @return Complete user UserProfile data
     * 9.12
    */

    public function mfaValidateOTPByPhone($multiFactorAuthModelWithLockout, $secondFactorAuthenticationToken,
        $fields = "", $smsTemplate2FA = null, $rbaBrowserEmailTemplate = null, $rbaCityEmailTemplate = null,
        $rbaCountryEmailTemplate = null, $rbaIpEmailTemplate = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa/verification/otp";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        if ($rbaBrowserEmailTemplate != '') {
            $queryParam['rbaBrowserEmailTemplate'] = $rbaBrowserEmailTemplate;
        }
        if ($rbaCityEmailTemplate != '') {
            $queryParam['rbaCityEmailTemplate'] = $rbaCityEmailTemplate;
        }
        if ($rbaCountryEmailTemplate != '') {
            $queryParam['rbaCountryEmailTemplate'] = $rbaCountryEmailTemplate;
        }
        if ($rbaIpEmailTemplate != '') {
            $queryParam['rbaIpEmailTemplate'] = $rbaIpEmailTemplate;
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $multiFactorAuthModelWithLockout);
    }
       


    /**
     * This API is used to login via Multi-factor-authentication by passing the google authenticator code.
     * @param googleAuthenticatorCode The code generated by google authenticator app after scanning QR code
     * @param secondFactorAuthenticationToken SecondFactorAuthenticationToken
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @param rbaBrowserEmailTemplate RbaBrowserEmailTemplate
     * @param rbaCityEmailTemplate RbaCityEmailTemplate
     * @param rbaCountryEmailTemplate RbaCountryEmailTemplate
     * @param rbaIpEmailTemplate RbaIpEmailTemplate
     * @return Complete user UserProfile data
     * 9.13
    */

    public function mfaValidateGoogleAuthCode($googleAuthenticatorCode, $secondFactorAuthenticationToken,
        $fields = "", $rbaBrowserEmailTemplate = null, $rbaCityEmailTemplate = null,
        $rbaCountryEmailTemplate = null, $rbaIpEmailTemplate = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa/verification/googleauthenticatorcode";
        $bodyParam = [];
        $bodyParam['googleAuthenticatorCode'] = $googleAuthenticatorCode;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        if ($rbaBrowserEmailTemplate != '') {
            $queryParam['rbaBrowserEmailTemplate'] = $rbaBrowserEmailTemplate;
        }
        if ($rbaCityEmailTemplate != '') {
            $queryParam['rbaCityEmailTemplate'] = $rbaCityEmailTemplate;
        }
        if ($rbaCountryEmailTemplate != '') {
            $queryParam['rbaCountryEmailTemplate'] = $rbaCountryEmailTemplate;
        }
        if ($rbaIpEmailTemplate != '') {
            $queryParam['rbaIpEmailTemplate'] = $rbaIpEmailTemplate;
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API is used to validate the backup code provided by the user and if valid, we return an access token allowing the user to login incases where Multi-factor authentication (MFA) is enabled and the secondary factor is unavailable. When a user initially downloads the Backup codes, We generate 10 codes, each code can only be consumed once. if any user attempts to go over the number of invalid login attempts configured in the Dashboard then the account gets blocked automatically
     * @param multiFactorAuthModelByBackupCode Model Class containing Definition of payload for MultiFactorAuth By BackupCode API
     * @param secondFactorAuthenticationToken A Uniquely generated MFA identifier token after successful authentication
     * @param fields The fields parameter filters the API response so that the response only includes a specific set of fields
     * @param rbaBrowserEmailTemplate 
     * @param rbaCityEmailTemplate 
     * @param rbaCountryEmailTemplate 
     * @param rbaIpEmailTemplate 
     * @return Complete user UserProfile data
     * 9.14
    */

    public function mfaValidateBackupCode($multiFactorAuthModelByBackupCode, $secondFactorAuthenticationToken,
        $fields = "", $rbaBrowserEmailTemplate = null, $rbaCityEmailTemplate = null,
        $rbaCountryEmailTemplate = null, $rbaIpEmailTemplate = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa/verification/backupcode";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        if ($fields != '') {
            $queryParam['fields'] = $fields;
        }
        if ($rbaBrowserEmailTemplate != '') {
            $queryParam['rbaBrowserEmailTemplate'] = $rbaBrowserEmailTemplate;
        }
        if ($rbaCityEmailTemplate != '') {
            $queryParam['rbaCityEmailTemplate'] = $rbaCityEmailTemplate;
        }
        if ($rbaCountryEmailTemplate != '') {
            $queryParam['rbaCountryEmailTemplate'] = $rbaCountryEmailTemplate;
        }
        if ($rbaIpEmailTemplate != '') {
            $queryParam['rbaIpEmailTemplate'] = $rbaIpEmailTemplate;
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $multiFactorAuthModelByBackupCode);
    }
       


    /**
     * This API is used to update (if configured) the phone number used for Multi-factor authentication by sending the verification OTP to the provided phone number
     * @param phoneNo2FA Phone Number For 2FA
     * @param secondFactorAuthenticationToken A Uniquely generated MFA identifier token after successful authentication
     * @param smsTemplate2FA SMS Template Name
     * @return Response containing Definition for Complete SMS data
     * 9.16
    */

    public function mfaUpdatePhoneNumber($phoneNo2FA, $secondFactorAuthenticationToken,
        $smsTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa";
        $bodyParam = [];
        $bodyParam['phoneNo2FA'] = $phoneNo2FA;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API is used to resending the verification OTP to the provided phone number
     * @param secondFactorAuthenticationToken A Uniquely generated MFA identifier token after successful authentication
     * @param smsTemplate2FA SMS Template Name
     * @return Response containing Definition for Complete SMS data
     * 9.17
    */

    public function mfaResendOTP($secondFactorAuthenticationToken, $smsTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa/resend";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * An API designed to send the MFA Email OTP to the email.
     * @param emailIdModel payload
     * @param secondFactorAuthenticationToken SecondFactorAuthenticationToken
     * @param emailTemplate2FA EmailTemplate2FA
     * @return Response containing Definition of Complete Validation data
     * 9.18
    */

    public function mfaEmailOTP($emailIdModel, $secondFactorAuthenticationToken,
        $emailTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa/otp/email";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        if ($emailTemplate2FA != '') {
            $queryParam['emailTemplate2FA'] = $emailTemplate2FA;
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $emailIdModel);
    }
       


    /**
     * This API is used to Verify MFA Email OTP by MFA Token
     * @param multiFactorAuthModelByEmailOtp payload
     * @param secondFactorAuthenticationToken SecondFactorAuthenticationToken
     * @param rbaBrowserEmailTemplate RbaBrowserEmailTemplate
     * @param rbaCityEmailTemplate RbaCityEmailTemplate
     * @param rbaCountryEmailTemplate RbaCountryEmailTemplate
     * @param rbaIpEmailTemplate RbaIpEmailTemplate
     * @return Response Containing Access Token and Complete Profile Data
     * 9.25
    */

    public function mfaValidateEmailOtp($multiFactorAuthModelByEmailOtp, $secondFactorAuthenticationToken,
        $rbaBrowserEmailTemplate = null, $rbaCityEmailTemplate = null, $rbaCountryEmailTemplate = null,
        $rbaIpEmailTemplate = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa/verification/otp/email";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        if ($rbaBrowserEmailTemplate != '') {
            $queryParam['rbaBrowserEmailTemplate'] = $rbaBrowserEmailTemplate;
        }
        if ($rbaCityEmailTemplate != '') {
            $queryParam['rbaCityEmailTemplate'] = $rbaCityEmailTemplate;
        }
        if ($rbaCountryEmailTemplate != '') {
            $queryParam['rbaCountryEmailTemplate'] = $rbaCountryEmailTemplate;
        }
        if ($rbaIpEmailTemplate != '') {
            $queryParam['rbaIpEmailTemplate'] = $rbaIpEmailTemplate;
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $multiFactorAuthModelByEmailOtp);
    }
       


    /**
     * This API is used to set the security questions on the profile with the MFA token when MFA flow is required.
     * @param securityQuestionAnswerUpdateModel payload
     * @param secondFactorAuthenticationToken SecondFactorAuthenticationToken
     * @return Response Containing Access Token and Complete Profile Data
     * 9.26
    */

    public function mfaSecurityQuestionAnswer($securityQuestionAnswerUpdateModel, $secondFactorAuthenticationToken)
    {
        $resourcePath = "/identity/v2/auth/login/2fa/securityquestionanswer";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $securityQuestionAnswerUpdateModel);
    }
       


    /**
     * This API is used to resending the verification OTP to the provided phone number
     * @param securityQuestionAnswerUpdateModel payload
     * @param secondFactorAuthenticationToken SecondFactorAuthenticationToken
     * @param rbaBrowserEmailTemplate RbaBrowserEmailTemplate
     * @param rbaCityEmailTemplate RbaCityEmailTemplate
     * @param rbaCountryEmailTemplate RbaCountryEmailTemplate
     * @param rbaIpEmailTemplate RbaIpEmailTemplate
     * @return Response Containing Access Token and Complete Profile Data
     * 9.27
    */

    public function mfaSecurityQuestionAnswerVerification($securityQuestionAnswerUpdateModel, $secondFactorAuthenticationToken,
        $rbaBrowserEmailTemplate = null, $rbaCityEmailTemplate = null, $rbaCountryEmailTemplate = null,
        $rbaIpEmailTemplate = null)
    {
        $resourcePath = "/identity/v2/auth/login/2fa/verification/securityquestionanswer";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($secondFactorAuthenticationToken === '' || ctype_space($secondFactorAuthenticationToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('secondFactorAuthenticationToken'));
        }
        if ($rbaBrowserEmailTemplate != '') {
            $queryParam['rbaBrowserEmailTemplate'] = $rbaBrowserEmailTemplate;
        }
        if ($rbaCityEmailTemplate != '') {
            $queryParam['rbaCityEmailTemplate'] = $rbaCityEmailTemplate;
        }
        if ($rbaCountryEmailTemplate != '') {
            $queryParam['rbaCountryEmailTemplate'] = $rbaCountryEmailTemplate;
        }
        if ($rbaIpEmailTemplate != '') {
            $queryParam['rbaIpEmailTemplate'] = $rbaIpEmailTemplate;
        }
        $queryParam['secondFactorAuthenticationToken'] = $secondFactorAuthenticationToken;
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $securityQuestionAnswerUpdateModel);
    }
       


    /**
     * This API resets the SMS Authenticator configurations on a given account via the UID.
     * @param otpauthenticator Pass 'otpauthenticator' to remove SMS Authenticator
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Delete Request
     * 18.21.1
    */

    public function mfaResetSMSAuthenticatorByUid($otpauthenticator, $uid)
    {
        $resourcePath = "/identity/v2/manage/account/2fa/authenticator";
        $bodyParam = [];
        $bodyParam['otpauthenticator'] = $otpauthenticator;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        if ($uid === '' || ctype_space($uid)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('uid'));
        }
        $queryParam['uid'] = $uid;
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API resets the Google Authenticator configurations on a given account via the UID.
     * @param googleauthenticator boolean type value,Enable google Authenticator Code.
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Delete Request
     * 18.21.2
    */

    public function mfaResetGoogleAuthenticatorByUid($googleauthenticator, $uid)
    {
        $resourcePath = "/identity/v2/manage/account/2fa/authenticator";
        $bodyParam = [];
        $bodyParam['googleauthenticator'] = $googleauthenticator;
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        if ($uid === '' || ctype_space($uid)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('uid'));
        }
        $queryParam['uid'] = $uid;
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam, json_encode($bodyParam));
    }
       


    /**
     * This API is used to reset the backup codes on a given account via the UID. This API call will generate 10 new codes, each code can only be consumed once.
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Complete Backup Code data
     * 18.25
    */

    public function mfaBackupCodeByUid($uid)
    {
        $resourcePath = "/identity/v2/manage/account/2fa/backupcode";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        if ($uid === '' || ctype_space($uid)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('uid'));
        }
        $queryParam['uid'] = $uid;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to reset the backup codes on a given account via the UID. This API call will generate 10 new codes, each code can only be consumed once.
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Complete Backup Code data
     * 18.26
    */

    public function mfaResetBackupCodeByUid($uid)
    {
        $resourcePath = "/identity/v2/manage/account/2fa/backupcode/reset";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        if ($uid === '' || ctype_space($uid)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('uid'));
        }
        $queryParam['uid'] = $uid;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to reset the Email OTP Authenticator settings for an MFA-enabled user.
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Delete Request
     * 18.42
    */

    public function mfaResetEmailOtpAuthenticatorByUid($uid)
    {
        $resourcePath = "/identity/v2/manage/account/2fa/authenticator/otp/email";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        if ($uid === '' || ctype_space($uid)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('uid'));
        }
        $queryParam['uid'] = $uid;
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to reset the Security Question Authenticator settings for an MFA-enabled user.
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Delete Request
     * 18.43
    */

    public function mfaResetSecurityQuestionAuthenticatorByUid($uid)
    {
        $resourcePath = "/identity/v2/manage/account/2fa/authenticator/securityquestionanswer";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        if ($uid === '' || ctype_space($uid)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('uid'));
        }
        $queryParam['uid'] = $uid;
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam);
    }

}