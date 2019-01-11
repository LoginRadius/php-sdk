<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;

final class AuthenticationTest extends TestCase {
  private static $accountApi;
  private static $userApi;

  private $testerUid;
  private $testerPhoneId;
  private $testerAccessToken;

  public static function setUpBeforeClass() {
    self::$accountApi = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    self::$userApi = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
  }

  public function setUp() {
    $data = '{
      "Email": [
        {
          "Type": "Primary",
          "Value": "phpunittester96@mailinator.com"
        },
        {
          "Type": "Secondary",
          "Value": "phpunittester96secondary2@mailinator.com"
        }
      ],
      "UserName": "put96",
      "PhoneId": "12016768877",
      "Password": "password",
      "EmailVerified": true,
      "PhoneIdVerified": true
    }';
    $resultCreate = self::$accountApi->create($data);
    $this->testerUid = $resultCreate->Uid;
    $this->testerPhoneId = $resultCreate->PhoneId;

    $loginData = '{
      "phone": "' . $this->testerPhoneId . '",
      "password": "password"
    }';
    $resultLogin = self::$userApi->authLoginByPhone($loginData);
    $this->testerAccessToken = $resultLogin->access_token;
  }

  public function tearDown() {
    self::$accountApi->delete($this->testerUid);
  }

  public function testPhoneLogin() {
    $this->assertNotNull($this->testerAccessToken);
  }

  public function testPhoneForgotPasswordByOtp() {
    $result = self::$userApi->forgotPasswordByOtp($this->testerPhoneId);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testPhoneResendVerificationOtp() {
    $updateData = '{
      "PhoneIdVerified": false
    }';
    self::$accountApi->update($this->testerUid, $updateData);
    
    $result = self::$userApi->resendOTP($this->testerPhoneId);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testPhoneResendVerificationOtpByToken() {
    $updateData = '{
      "PhoneIdVerified": false
    }';
    self::$accountApi->update($this->testerUid, $updateData);

    $result = self::$userApi->resendOTPByToken($this->testerAccessToken, $this->testerPhoneId);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testPhoneUserRegistrationBySms() {
    $testPhoneId = "12368008106";
    $registerData = '{
      "Email": [
        {
          "Type": "Primary",
          "Value": "phpunittester90@mailinator.com"
        }
      ],
      "PhoneId": "' . $testPhoneId . '",
      "Password": "password",
      "EmailVerified": true,
      "PhoneIdVerified": true
    }';

    $result = self::$userApi->registerByPhone($registerData);
    $this->assertObjectHasAttribute("IsPosted", $result);

    $profileData = self::$accountApi->getProfileByPhone($testPhoneId);
    $profileUid = $profileData->Uid;
    $deleteResult = self::$accountApi->delete($profileUid);
    $this->assertObjectHasAttribute("IsDeleted", $deleteResult);
  }

  public function testPhoneNumberAvailability() {
    $result = self::$userApi->checkAvailablityOfPhone($this->testerPhoneId);
    $this->assertObjectHasAttribute("IsExist", $result);
  }

  public function testPhoneNumberUpdate() {
    $testPhoneId = "12368008106";
    $result = self::$userApi->updatePhone($this->testerAccessToken, $testPhoneId);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testPhoneResetPasswordByOtp() {
    try {
      $result = self::$userApi->phoneResetPasswordByOtp($this->testerPhoneId, "99999", "password");
      $this->assertObjectHasAttribute("IsPosted", $result);
    } catch (Exception $e) {
      $this->assertEquals("Invalid OTP Code", $e->getMessage());
    }
  }

  public function testPhoneVerificationByOtp() {
    try {
      $result = self::$userApi->verifyOTP("99999", $this->testerPhoneId);
      $this->assertObjectHasAttribute("Profile", $result);
    } catch (Exception $e) {
      $this->assertEquals("This phone number has already been confirmed", $e->getMessage());
    }
  }

  public function testPhoneVerificationOtpByToken() {
    try {
      $result = self::$userApi->verifyOTPByToken($this->testerAccessToken, "99999");
      $this->assertObjectHasAttribute("Profile", $result);
    } catch (Exception $e) {
      $this->assertEquals("Invalid OTP Code", $e->getMessage());
    }
  }

  public function testResetPhoneIdVerification() {
    $result = self::$accountApi->resetPhoneIdVerification($this->testerUid, true);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testRemovePhoneIdByAccessToken() {
    $result = self::$userApi->deletePhoneIdByAccessToken($this->testerAccessToken);
    $this->assertObjectHasAttribute("IsDeleted", $result);
  }

  public function testPhoneSendOtp() {
    $result = self::$userApi->phoneSendOtp($this->testerPhoneId);
    $this->assertObjectHasAttribute("Data", $result);
  }

  public function testPhoneLoginUsingOtp() {
    $loginData = '{
      "phone": "' . $this->testerPhoneId . '",
      "otp": "99999"
    }';

    try {
      $result = self::$userApi->phoneLoginByOtp($loginData);
    } catch (Exception $e) {
      $this->assertEquals("Invalid OTP Code", $e->getMessage());
    }
  }
}
