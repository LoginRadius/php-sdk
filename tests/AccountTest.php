<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;

final class AccountTest extends TestCase {
  private static $accountApi;

  private $testerUid;
  private $testerEmail;
  private $testerEmailSecondary;
  private $testerUsername;
  private $testerPhoneId;

  public static function setUpBeforeClass() {
    self::$accountApi = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
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
          "Value": "phpunittester96secondary@mailinator.com"
        }
      ],
      "UserName": "put96",
      "PhoneId": "12016768877",
      "Password": "password"
    }';
    $result = self::$accountApi->create($data);
    $this->testerUid = $result->Uid;
    $this->testerEmail = $result->Email[0]->Value;
    $this->testerEmailSecondary = $result->Email[1]->Value;
    $this->testerUsername = $result->UserName;
    $this->testerPhoneId = $result->PhoneId;
  }

  public function tearDown() {
    self::$accountApi->delete($this->testerUid);
  }

  public function testAccountCreate() {
    $this->assertNotNull($this->testerUid);
  }

  public function testGetEmailVerificationToken() {
    $result = self::$accountApi->getEmailVerificationToken($this->testerEmail);
    $this->assertObjectHasAttribute("VerificationToken", $result);
  }

  public function testGetForgotPasswordToken() {
    $result = self::$accountApi->getForgotPasswordToken($this->testerEmail);
    $this->assertObjectHasAttribute("ForgotToken", $result);
  }

  public function testGetIdentitiesByEmail() {
    $result = self::$accountApi->getIdentitiesByEmail($this->testerEmail);
    $this->assertObjectHasAttribute("Data", $result);
  }

  public function testAccountImpersonation() {
    $result = self::$accountApi->getAccessTokenByUid($this->testerUid);
    $this->assertObjectHasAttribute("access_token", $result);
  }

  public function testAccountGetPassword() {
    $result = self::$accountApi->getHashPassword($this->testerUid);
    $this->assertObjectHasAttribute("PasswordHash", $result);
  }

  public function testAccountProfileByEmail() {
    $result = self::$accountApi->getProfileByEmail($this->testerEmail);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testAccountProfileByUsername() {
    $result = self::$accountApi->getProfileByUsername($this->testerUsername);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testAccountProfileByPhoneId() {
    $result = self::$accountApi->getProfileByPhone($this->testerPhoneId);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testAccountProfileByUid() {
    $result = self::$accountApi->getProfileByUid($this->testerUid);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testAccountSetPassword() {
    $result = self::$accountApi->setPassword($this->testerUid, "password1");
    $this->assertObjectHasAttribute("PasswordHash", $result);
  }

  public function testAccountUpdate() {
    $data = '{
      "Gender": "M"
    }';

    $result = self::$accountApi->update($this->testerUid, $data);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testAccountUpdateSecurityQuestionConfiguration() {
    if (SECURITY_QUESTION_ID === "") {
      $this->markTestSkipped("Security Question ID in config.php needs to be defined.");
    } else { 
      $data = '{
        "securityquestionanswer": {
          "' . SECURITY_QUESTION_ID . '": "Answer"
        }
      }';
      $result = self::$accountApi->updateSecurityQuestionByUid($this->testerUid, $data);
      $this->assertObjectHasAttribute("Uid", $result);
    }
  }

  public function testAccountInvalidateVerificationEmail() {
    $data = '{
      "EmailVerified": true
    }';
    self::$accountApi->update($this->testerUid, $data);
    $result = self::$accountApi->invalidateEmail($this->testerUid, true);
    $this->assertObjectHasAttribute("IsPosted", $result);
  }

  public function testAccountEmailDelete() {
    $result = self::$accountApi->removeEmailByUidAndEmail($this->testerUid, $this->testerEmailSecondary);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testAccountDelete() {
    print_r("testAccountDelete passes if tests are being taken down properly.");
    $this->assertTrue(true);
  }
}
