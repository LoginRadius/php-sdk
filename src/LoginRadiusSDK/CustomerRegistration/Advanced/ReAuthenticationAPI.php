<?php
 /**
 * @category            : CustomerRegistration
 * @link                : http://www.loginradius.com
 * @package             : ReAuthenticationAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Advanced;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

class ReAuthenticationAPI extends Functions
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }
       


    /**
     * This API is used to trigger the Multi-Factor Autentication workflow for the provided access token
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param smsTemplate2FA SMS Template Name
     * @param isVoiceOtp Boolean, pass true if you wish to trigger voice OTP
     * @return Response containing Definition of Complete Multi-Factor Authentication Settings data
     * 14.3
    */

    public function mfaReAuthenticate($accessToken, $smsTemplate2FA = null,
        $isVoiceOtp = false)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/2fa";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        if ($isVoiceOtp != '') {
            $queryParam['isVoiceOtp'] = $isVoiceOtp;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to re-authenticate via Multi-factor authentication by passing the One Time Password received via SMS
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param reauthByOtpModel Model Class containing Definition for MFA Reauthentication by OTP
     * @return Complete user Multi-Factor Authentication Token data
     * 14.4
    */

    public function mfaReAuthenticateByOTP($accessToken, $reauthByOtpModel)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/2fa/otp";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $reauthByOtpModel);
    }
       


    /**
     * This API is used to re-authenticate by set of backup codes via access token on the site that has Multi-factor authentication enabled in re-authentication for the user that does not have the device
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param reauthByBackupCodeModel Model Class containing Definition for MFA Reauthentication by Backup code
     * @return Complete user Multi-Factor Authentication Token data
     * 14.5
    */

    public function mfaReAuthenticateByBackupCode($accessToken, $reauthByBackupCodeModel)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/2fa/backupcode";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $reauthByBackupCodeModel);
    }
       


    /**
     * This API is used to re-authenticate via Multi-factor-authentication by passing the password
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param passwordEventBasedAuthModelWithLockout Model Class containing Definition of payload for PasswordEventBasedAuthModel with Lockout API
     * @param smsTemplate2FA SMS Template Name
     * @return Complete user Multi-Factor Authentication Token data
     * 14.7
    */

    public function mfaReAuthenticateByPassword($accessToken, $passwordEventBasedAuthModelWithLockout,
        $smsTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/password";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $passwordEventBasedAuthModelWithLockout);
    }
       


    /**
     * This API is used on the server-side to validate and verify the re-authentication token created by the MFA re-authentication API. This API checks re-authentications created by OTP.
     * @param eventBasedMultiFactorToken Model Class containing Definition for SecondFactorValidationToken
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Complete Validation data
     * 18.38
    */

    public function verifyMultiFactorOtpReauthentication($eventBasedMultiFactorToken, $uid)
    {
        $resourcePath = "/identity/v2/manage/account/$uid/reauth/2fa";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $eventBasedMultiFactorToken);
    }
       


    /**
     * This API is used on the server-side to validate and verify the re-authentication token created by the MFA re-authentication API. This API checks re-authentications created by password.
     * @param eventBasedMultiFactorToken Model Class containing Definition for SecondFactorValidationToken
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Complete Validation data
     * 18.39
    */

    public function verifyMultiFactorPasswordReauthentication($eventBasedMultiFactorToken, $uid)
    {
        $resourcePath = "/identity/v2/manage/account/$uid/reauth/password";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $eventBasedMultiFactorToken);
    }
       


    /**
     * This API is used on the server-side to validate and verify the re-authentication token created by the MFA re-authentication API. This API checks re-authentications created by PIN.
     * @param eventBasedMultiFactorToken Model Class containing Definition for SecondFactorValidationToken
     * @param uid UID, the unified identifier for each user account
     * @return Response containing Definition of Complete Validation data
     * 18.40
    */

    public function verifyMultiFactorPINReauthentication($eventBasedMultiFactorToken, $uid)
    {
        $resourcePath = "/identity/v2/manage/account/$uid/reauth/pin";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['apiSecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $eventBasedMultiFactorToken);
    }
       


    /**
     * This API is used to validate the triggered MFA authentication flow with a password.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param pinAuthEventBasedAuthModelWithLockout Model Class containing Definition of payload for PIN
     * @param smsTemplate2FA SMS Template Name
     * @return Response containing Definition response of MFA reauthentication
     * 42.13
    */

    public function verifyPINAuthentication($accessToken, $pinAuthEventBasedAuthModelWithLockout,
        $smsTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/pin";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($smsTemplate2FA != '') {
            $queryParam['smsTemplate2FA'] = $smsTemplate2FA;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $pinAuthEventBasedAuthModelWithLockout);
    }
       


    /**
     * This API is used to validate the triggered MFA authentication flow with an Email OTP.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param reauthByEmailOtpModel payload
     * @return Response containing Definition response of MFA reauthentication
     * 42.14
    */

    public function reAuthValidateEmailOtp($accessToken, $reauthByEmailOtpModel)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/2fa/otp/email/verify";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $reauthByEmailOtpModel);
    }
       


    /**
     * This API is used to send the MFA Email OTP to the email for Re-authentication
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param emailId EmailId
     * @param emailTemplate2FA EmailTemplate2FA
     * @return Response containing Definition of Complete Validation data
     * 42.15
    */

    public function reAuthSendEmailOtp($accessToken, $emailId,
        $emailTemplate2FA = null)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/2fa/otp/email";
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
     * This API is used to validate the triggered MFA re-authentication flow with security questions answers.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param securityQuestionAnswerUpdateModel payload
     * @return Response containing Definition response of MFA reauthentication
     * 42.16
    */

    public function reAuthBySecurityQuestion($accessToken, $securityQuestionAnswerUpdateModel)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/2fa/securityquestionanswer/verify";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $securityQuestionAnswerUpdateModel);
    }
       


    /**
     * This API is used to validate the triggered MFA authentication flow with the Authenticator Code.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param multiFactorAuthModelByAuthenticatorCode Model Class containing Definition of payload for MultiFactorAuthModel By Authenticator Code API
     * @return Complete user Multi-Factor Authentication Token data
     * 44.6
    */

    public function mfaReAuthenticateByAuthenticatorCode($accessToken, $multiFactorAuthModelByAuthenticatorCode)
    {
        $resourcePath = "/identity/v2/auth/account/reauth/2fa/authenticatorcode";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $multiFactorAuthModelByAuthenticatorCode);
    }

}