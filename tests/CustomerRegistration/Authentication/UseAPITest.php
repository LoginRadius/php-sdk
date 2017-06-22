<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AuthenticationAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\CustomerRegistration\Authentication;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\Utility\SOTT;
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;

/**
 * Account API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Authentication API.
 */
class UserAPITest extends \PHPUnit_Framework_TestCase {

    protected $userapi;

    public function __construct() {
        $this->userapi = new UserAPI(API_KEY, API_SECRET);
   }

    public function testLoginByEmail() {
        $result = (array) json_decode($this->userapi->loginByEmail(EMAIL, CURRENT_PASSWORD));
        $this->assertArrayHasKey('Profile', $result);
    }

    public function testLoginByUsername() {
        $result = (array) json_decode($this->userapi->loginByUsername(USERNAME, CURRENT_PASSWORD));
        $this->assertArrayHasKey('Profile', $result);
    }

    public function testLoginByPhone() {

        $result = (array) json_decode($this->userapi->loginByPhone(PHONE_ID, CURRENT_PASSWORD));
        $this->assertArrayHasKey('Profile', $result);
    }

    public function testRegister() {
        $result = (array) json_decode($this->userapi->register(User_Profile_object)); 
    
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testResendEmailVerification() {
        $result = (array) json_decode($this->userapi->resendEmailVerification(EMAIL));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testGetProfile() {
        $result = (array) json_decode($this->userapi->getProfile(ACCESS_TOKEN));
        $this->assertArrayHasKey('Identities', $result);
    }

    public function testUpdateProfile() {
        $result = (array) json_decode($this->userapi->updateProfile(ACCESS_TOKEN, Update_User_Profile_object));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testDeleteAccountByEmailConfirmation() {
        $result = (array) json_decode($this->userapi->deleteAccountByEmailConfirmation(ACCESS_TOKEN));
        $this->assertArrayHasKey('isDeleteRequestAccepted', $result);
    }

    public function testForgotPassword() {
        $result = (array) json_decode($this->userapi->forgotPassword(EMAIL, RESET_PASSWORD_URL));
        $this->assertArrayHasKey('isPosted', $result);
    }
    public function testForgotPasswordByOtp() {
        $result = (array) json_decode($this->userapi->forgotPasswordByOtp(PHONE_ID, SMS_TEMPLATE));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testResetPassword() {
        $result = (array) json_decode($this->userapi->resetPassword(V_TOKEN, CURRENT_PASSWORD));
        $this->assertArrayHasKey('isPosted', $result);
    }
    public function testResetPasswordByOtp() {
        $result = (array) json_decode($this->userapi->resetPasswordByOtp(PHONE_ID, OTP, NEW_PASSWORD));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testChangeAccountPassword() {
        $result = (array) json_decode($this->userapi->changeAccountPassword(ACCESS_TOKEN, CURRENT_PASSWORD, NEW_PASSWORD));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testAddEmail() {
        $result = (array) json_decode($this->userapi->addEmail(ACCESS_TOKEN, ADD_EMAIL, ADD_EMAIL_TYPE));

        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testRemoveEmail() {

        $result = (array) json_decode($this->userapi->removeEmail(ACCESS_TOKEN, EMAIL));
        $this->assertArrayHasKey('isDeleted', $result);
    }

    public function testVerifyEmail() {
        $result = (array) json_decode($this->userapi->verifyEmail(V_TOKEN, VERIFICATION_EMAIL_PAGE));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testCheckAvailablityOfEmail() {
        $result = (array) json_decode($this->userapi->checkAvailablityOfEmail(EMAIL));
        $this->assertArrayHasKey('isExist', $result);
    }

    public function testChangeUsername() {
        $result = (array) json_decode($this->userapi->changeUsername(ACCESS_TOKEN, CHANGE_USERNAME));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testCheckUsername() {
        $result = (array) json_decode($this->userapi->checkUsername(CHANGE_USERNAME));

        $this->assertArrayHasKey('isExist', $result);
    }

    public function testAccountLink() {
        $result = (array) json_decode($this->userapi->accountLink(ACCESS_TOKEN, CANDIDATE_TOKEN));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testAccountUnlink() {
        $result = (array) json_decode($this->userapi->accountUnlink(ACCESS_TOKEN, PROVIDER_ID, PROVIDER));

        $this->assertArrayHasKey('isDeleted', $result);
    }

    public function testGetSocialProfile() {
        $result = (array) json_decode($this->userapi->getSocialProfile(ACCESS_TOKEN));

        $this->assertArrayHasKey('Profile', $result);
    }

    public function testCheckAvailablityOfPhone() {
        $result = (array) json_decode($this->userapi->checkAvailablityOfPhone(PHONE_ID));
        $this->assertArrayHasKey('isExist', $result);
    }

    public function testUpdatePhone() {
        $result = (array) json_decode($this->userapi->update
        (ACCESS_TOKEN, UPDATE_PHONE_ID));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testResendOTP() {
        $result = (array) json_decode($this->userapi->resendOTP(PHONE_ID));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testResendOTPByToken() {
        $result = (array) json_decode($this->userapi->resendOTPByToken(ACCESS_TOKEN, PHONE_ID));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testVerifyOTP() {
        $result = (array) json_decode($this->userapi->verifyOTP(OTP, PHONE_ID));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testVerifyOTPByToken() {
        $result = (array) json_decode($this->userapi->verifyOTPByToken(ACCESS_TOKEN, OTP));
        $this->assertArrayHasKey('isPosted', $result);
    }

    public function testTwoFALoginByEmail() {
        $result = (array) json_decode($this->userapi->twoFALoginByEmail(EMAIL, CURRENT_PASSWORD));
        $this->assertArrayHasKey('Profile', $result);
    }
    public function testVerifyTwoFAGoogleAuthenticatorOrOtpByToken() {
        $result = (array) json_decode($this->userapi->twoFALoginByPhone(ACCESS_TOKEN, GOOGLE_AUTH_CODE, OTP, SMS_TEMPLATE));
        $this->assertArrayHasKey('Profile', $result);
    }
    public function test2FALoginByPhone() {
        $result = (array) json_decode($this->userapi->verifyTwoFAGoogleAuthenticatorOrOtpByToken(PHONE_ID, CURRENT_PASSWORD));
        $this->assertArrayHasKey('Profile', $result);
    }
    public function testConfigureTwoFAByToken() {
        $result = (array) json_decode($this->userapi->configureTwoFAByToken(ACCESS_TOKEN, SMS_TEMPLATE_2FA));
        $this->assertArrayHasKey('Profile', $result);
    }
    public function testTwoFALoginByUsername() {
        $result = (array) json_decode($this->userapi->twoFALoginByUsername(USERNAME, CURRENT_PASSWORD));
        $this->assertArrayHasKey('Profile', $result);
    }
    public function testVerifyTwoFAByGoogleAuthCodeOrOtp() {
        $result = (array) json_decode($this->userapi->verifyTwoFAByGoogleAuthCodeOrOtp(SFAT, GOOGLE_AUTH_CODE, OTP, SMS_TEMPLATE_2FA));
        $this->assertArrayHasKey('Profile', $result);
    }
   
    public function testTwoFAUupdatePhoneNoByOtp() {        
        $result = (array) json_decode($this->userapi->twoFAUupdatePhoneNoByOtp(SFAT, UPDATE_PHONENO));
        $this->assertArrayHasKey('Profile', $result);
    }
    
    public function testTwoFAUupdatePhoneNoByToken() {
        $result = (array) json_decode($this->userapi->twoFAUupdatePhoneNoByToken(ACCESS_TOKEN, UPDATE_PHONENO));
        $this->assertArrayHasKey('Profile', $result);
    }
    
    public function testRemoveOrResetGoogleAuthenticatorOnClient() {        
        $result = (array) json_decode($this->userapi->removeOrResetGoogleAuthenticatorOnClient(ACCESS_TOKEN, true, false));
        $this->assertArrayHasKey('isDeleted', $result);
    }
    public function testEmailPromptAutoLoginbyEmail() {        
        $result = (array) json_decode($this->userapi->emailPromptAutoLoginbyEmail(CLIENT_GUID, EMAIL, AUTO_LOGIN_EMAIL_TEMPLATE, WELCOME_EMAIL_TEMPLATE));
        $this->assertArrayHasKey('IsPosted', $result);
    }
    public function testEmailPromptAutoLoginbyUserName() {        
        $result = (array) json_decode($this->userapi->emailPromptAutoLoginbyUserName(CLIENT_GUID, USERNAME, AUTO_LOGIN_EMAIL_TEMPLATE, WELCOME_EMAIL_TEMPLATE));
        $this->assertArrayHasKey('IsPosted', $result);
    }
    public function testEmailPromptAutoLoginPing() {        
        $result = (array) json_decode($this->userapi->emailPromptAutoLoginPing(CLIENT_GUID));
        $this->assertArrayHasKey('Accesstoken', $result);
    }
    public function testGetBackupCodeForLoginbyAccessToken() {        
        $result = (array) json_decode($this->userapi->getBackupCodeForLoginbyAccessToken(ACCESS_TOKEN));
        $this->assertArrayHasKey('IsPosted', $result);
    }
    public function testResetBackupCodebyAccessToken() {        
        $result = (array) json_decode($this->userapi->resetBackupCodebyAccessToken(ACCESS_TOKEN));
        $this->assertArrayHasKey('IsPosted', $result);
    }

    public function testApiClientHandler() {
        $reflection = new \ReflectionClass(get_class($this->userapi));
        $method = $reflection->getMethod('apiClientHandler');
        $method->setAccessible(true);
        $path = 'username';
        $query_array = array('username' => USERNAME);
        $result = (array) json_decode($method->invokeArgs($this->userapi, array($path, $query_array)));
        $this->assertArrayHasKey('isExist', $result);
    }

}
