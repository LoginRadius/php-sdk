<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;

final class SmartLoginTest extends TestCase {
  private static $accountApi;
  private static $userApi;

  private static $testerUid;
  private static $testerEmail;
  private static $testerUsername;

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
    self::$testerUsername = $createResult->UserName;
  }

  public static function tearDownAfterClass() {
    self::$accountApi->delete(self::$testerUid);
  }

  public function testSmartLoginByEmailAndPing() {
    $clientGuid = "testguid" . rand();
    $result = self::$userApi->smartLoginByEmail($clientGuid, self::$testerEmail);
    $this->assertObjectHasAttribute("IsPosted", $result);

    try {
      $pingResult = self::$userApi->smartLoginPing($clientGuid);
      $this->assertObjectHasAttribute("access_token", $result);
    } catch (Exception $e) {
      $this->assertEquals("The smart login link has not been verified", $e->getMessage());
    }
  }

  public function testSmartLoginByUsername() {
    $result = self::$userApi->smartLoginByUserName("testguid" . rand(), self::$testerUsername);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testSmartLoginVerifyToken() {
    try {
      $result = self::$userApi->smartLoginVerifyToken("1234567890");
      $this->assertObjectHasAttribute("Profile", $result);
    } catch (Exception $e) {
      $this->assertEquals("Verification token (vtoken) is invalid", $e->getMessage());
    }
  }
}
