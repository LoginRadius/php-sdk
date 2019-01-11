<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;

final class OneTouchLoginTest extends TestCase {
  private static $accountApi;
  private static $userApi;

  private static $testerUid;
  private static $testerEmail;
  private static $testerPhone;

  public static function setUpBeforeClass() {
    $data = '{
      "Email": [
        {
          "Type": "Primary",
          "Value": "phpunittester96@mailinator.com"
        },
        {
          "Type": "Secondary",
          "Value": "phpunittester96secondary@mailinator.com"
        }
      ],
      "UserName": "put96",
      "PhoneId": "16135550185",
      "Password": "password",
      "EmailVerified": true
    }';

    self::$accountApi = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    self::$userApi = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));

    $createResult = self::$accountApi->create($data);
    self::$testerUid = $createResult->Uid;
    self::$testerEmail = $createResult->Email[0]->Value;
    self::$testerPhone = $createResult->PhoneId;
  }

  public static function tearDownAfterClass() {
    self::$accountApi->delete(self::$testerUid);
  }

  public function testOneTouchLoginByEmail() {
    $data = '{
      "email": "' . self::$testerEmail . '",
      "clientguid": "testguid' . rand() . '",
      "g-recaptcha-response": "abcd"
    }';

    try {
      $result = self::$userApi->oneTouchLoginByEmail($data);
      $this->assertObjectHasAttribute("IsPosted", $result);
    } catch (Exception $e) {
      $this->assertEquals("CAPTCHA is invalid", $e->getMessage());
    }
  }

  public function testOneTouchLoginByPhone() {
    $data = '{
      "phone": "' . self::$testerPhone . '",
      "g-recaptcha-response": "abcd"
    }';

    try {
      $result = self::$userApi->oneTouchLoginByPhone($data);
      $this->assertObjectHasAttribute("IsPosted", $result);
    } catch (Exception $e) {
      $this->assertEquals("CAPTCHA is invalid", $e->getMessage());
    }
  }

  public function testOneTouchLoginVerifyByOtp() {
    try {
      $result = self::$userApi->oneTouchOtpVerification("99999", "16135550185");
      $this->assertObjectHasAttribute("Profile", $result);
    } catch (Exception $e) {
      $this->assertEquals("Invalid OTP Code", $e->getMessage());
    }
  }

  public function testOneTouchLoginVerifyOtpByEmail() {
    try {
      $result = self::$userApi->smartLoginVerifyToken("abc");
      $this->assertObjectHasAttribute("IsVerified", $result);
    } catch (Exception $e) {
      $this->assertEquals("Verification token (vtoken) is invalid", $e->getMessage());
    }
  }
}
