<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;

final class MultiFactorAuthenticationTest extends TestCase {
  private static $accountApi;
  private static $userApi;

  private $testerUid;
  private $testerEmail;
  private $testerUsername;
  private $testerPhoneId;

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
    $this->testerEmail = $resultCreate->Email[0]->Value;
    $this->testerUsername = $resultCreate->UserName;
    $this->testerPhoneId = $resultCreate->PhoneId;
  }

  public function tearDown() {
    self::$accountApi->delete($this->testerUid);
  }

  public function testMfaEmailLogin() {
    $loginData = '{
      "email": "' . $this->testerEmail . '",
      "password": "password"
    }';

    $result = self::$userApi->mfaEmailLogin($loginData);
    $this->assertObjectHasAttribute("SecondFactorAuthentication", $result);
  }

  public function testMfaUsernameLogin() {
    $loginData = '{
      "username": "' . $this->testerUsername . '",
      "password": "password"
    }';

    $result = self::$userApi->mfaUserNameLogin($loginData);
    $this->assertObjectHasAttribute("SecondFactorAuthentication", $result);
  }

  public function testMfaPhoneLogin() {
    $loginData = '{
      "phone": "' . $this->testerPhoneId . '",
      "password": "password"
    }';

    $result = self::$userApi->mfaPhoneLogin($loginData);
    $this->assertObjectHasAttribute("SecondFactorAuthentication", $result);
  }

  public function testMfaValidateAccessToken() {
    $impersonationResult = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $access_token = $impersonationResult->access_token;
    $result = self::$userApi->mfaValidateAccessToken($access_token);
    $this->assertObjectHasAttribute("QRCode", $result);
  }

  public function testMfaBackupCodeByAccessToken() {
    $impersonationResult = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $access_token = $impersonationResult->access_token;
    try {
      $result = self::$userApi->getBackupCodeForLoginbyAccessToken($access_token);
      $this->assertObjectHasAttribute("BackUpCodes", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication client is not configured", $e->getMessage());
    }
  }

  public function testMfaResetBackupCodeByAccessToken() {
    $impersonationResult = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $access_token = $impersonationResult->access_token;
    try {
      $result = self::$userApi->resetBackupCodebyAccessToken($access_token);
      $this->assertObjectHasAttribute("BackUpCodes", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication client is not configured", $e->getMessage());
    }
  }

  public function testMfaBackupCodeByUid() {
    try {
      $result = self::$accountApi->mfaGetBackupCodeByUid($this->testerUid);
      $this->assertObjectHasAttribute("BackUpCodes", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication client is not configured", $e->getMessage());
    }
  }

  public function testMfaResetBackupCodeByUid() {
    try {
      $result = self::$accountApi->mfaResetBackupCodeByUid($this->testerUid);
      $this->assertObjectHasAttribute("BackUpCodes", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication client is not configured", $e->getMessage());
    }
  }

  public function testMfaValidateBackupCode() {
    $loginData = '{
      "email": "' . $this->testerEmail . '",
      "password": "password"
    }';

    $loginResult = self::$userApi->mfaEmailLogin($loginData);
    $secondFactorAuthToken = $loginResult->SecondFactorAuthentication->SecondFactorAuthenticationToken;
    try {
      $result = self::$userApi->getLoginbyBackupCode($secondFactorAuthToken, "9999999");
      $this->assertObjectHasAttribute("access_token", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication backup code is not configured", $e->getMessage());
    }
  }

  public function testMfaValidateOtp() {
    $loginData = '{
      "email": "' . $this->testerEmail . '",
      "password": "password"
    }';

    $loginResult = self::$userApi->mfaEmailLogin($loginData);
    $secondFactorAuthToken = $loginResult->SecondFactorAuthentication->SecondFactorAuthenticationToken;
    try {
      $otpData = '{
        "otp": "99999"
      }';

      $result = self::$userApi->mfaValidateOtp($secondFactorAuthToken, $otpData);
      $this->assertObjectHasAttribute("access_token", $result);
    } catch (Exception $e) {
      $this->assertEquals("Invalid OTP Code", $e->getMessage());
    }
  }

  public function testMfaValidateGoogleAuthCode() {
    $loginData = '{
      "email": "' . $this->testerEmail . '",
      "password": "password"
    }';

    $loginResult = self::$userApi->mfaEmailLogin($loginData);
    $secondFactorAuthToken = $loginResult->SecondFactorAuthentication->SecondFactorAuthenticationToken;
    try {
      $result = self::$userApi->mfaValidateGoogleAuthCode($secondFactorAuthToken, "999999999");
      $this->assertObjectHasAttribute("access_token", $result);
    } catch (Exception $e) {
      $this->assertEquals("Google two factor authentication code is incorrect", $e->getMessage());
    }
  }

  public function testMfaUpdatePhoneNumber() {
    $loginData = '{
      "email": "' . $this->testerEmail . '",
      "password": "password"
    }';

    $loginResult = self::$userApi->mfaEmailLogin($loginData);
    $secondFactorAuthToken = $loginResult->SecondFactorAuthentication->SecondFactorAuthenticationToken;
    $result = self::$userApi->mfaUpdatePhoneNo($secondFactorAuthToken, "12016768877");
    $this->assertObjectHasAttribute("AccountSid", $result);
  }

  public function testMfaUpdatePhoneNumberByToken() {
    $impersonationResult = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $access_token = $impersonationResult->access_token;
    $result = self::$userApi->mfaUpdatePhoneNoByToken($access_token, "12016768877");
    $this->assertObjectHasAttribute("AccountSid", $result);
  }

  public function testMfaResetGoogleAuthenticatorByToken() {
    $impersonationResult = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $access_token = $impersonationResult->access_token;
    try {
      $result = self::$userApi->resetGoogleAuthenticatorByToken($access_token, true);
      $this->assertObjectHasAttribute("IsDeleted", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication client is not configured", $e->getMessage());
    }
  }

  public function testMfaResetSmsAuthenticatorByToken() {
    $impersonationResult = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $access_token = $impersonationResult->access_token;
    try {
      $result = self::$userApi->resetSMSAuthenticatorByToken($access_token, true);
      $this->assertObjectHasAttribute("IsDeleted", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication client is not configured", $e->getMessage());
    }
  }

  public function testMfaResetGoogleAuthenticatorByUid() {
    try {
      $result = self::$accountApi->mfaResetGoogleAuthenticatorByUid($this->testerUid, true);
      $this->assertObjectHasAttribute("IsDeleted", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication client is not configured", $e->getMessage());
    }
  }

  public function testMfaResetSmsAuthenticatorByUid() {
    try {
      $result = self::$accountApi->mfaResetSMSAuthenticatorByUid($this->testerUid, true);
      $this->assertObjectHasAttribute("IsDeleted", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication client is not configured", $e->getMessage());
    }
  }

  public function testMfaUpdateByAccessToken() {
    $impersonationResult = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $access_token = $impersonationResult->access_token;
    try {
      $result = self::$userApi->updateMfaByGoogleAuthCode($access_token, "999999");
      $this->assertObjectHasAttribute("Uid", $result);
    } catch (Exception $e) {
      $this->assertEquals("Two factor authentication is not enabled", $e->getMessage());
    }
  }

  public function testMfaUpdateSetting() {
    $otpData = '{
      "otp": "999999"
    }';
    $impersonationResult = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $access_token = $impersonationResult->access_token;
    try {
      $result = self::$userApi->updateMfaByOtp($access_token, $otpData);
      $this->assertObjectHasAttribute("Uid", $result);
    } catch (Exception $e) {
      $this->assertEquals("Invalid OTP Code", $e->getMessage());
    }
  }
}
