<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Social\AdvanceSocialLoginAPI;

final class TokenManagementTest extends TestCase {
  private static $accountApi;
  private static $advancedSocialApi;

  private static $testerUid;
  private static $testerAccessToken;

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
    self::$advancedSocialApi = new AdvanceSocialLoginAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));

    $createResult = self::$accountApi->create($data);
    self::$testerUid = $createResult->Uid;
    self::$testerAccessToken = self::$accountApi->getAccessTokenByUid(self::$testerUid)->access_token;
  }

  public static function tearDownAfterClass() {
    self::$accountApi->delete(self::$testerUid);
  }

  public function testAccessTokenViaFacebookAccessToken() {
    if (FACEBOOK_ACCESS_TOKEN === "") {
      $this->markTestSkipped("Facebook Access Token in config.php needs to be defined.");
    } else {
      $result = self::$advancedSocialApi->getAccessTokenByPassingFacebookToken(FACEBOOK_ACCESS_TOKEN);
      $this->assertObjectHasAttribute("access_token", $result);
    }
  }

  public function testAccessTokenViaTwitterToken() {
    if (TWITTER_ACCESS_TOKEN === "" || TWITTER_TOKEN_SECRET === "") {
      $this->markTestSkipped("Twitter Access Token and Token Secret in config.php needs to be defined.");
    } else {
      $result = self::$advancedSocialApi->getAccessTokenByPassingTwitterToken(TWITTER_ACCESS_TOKEN, TWITTER_TOKEN_SECRET);
      $this->assertObjectHasAttribute("access_token", $result);
    }
  }

  public function testAccessTokenViaVkontakteToken() {
    $this->markTestIncomplete("testAccessTokenViaVkontakteToken not implemented.");
  }

  public function testAccessTokenViaGoogleToken() {
    $this->markTestIncomplete("testAccessTokenViaGoogleToken not implemented.");
  }

  public function testRefreshUserProfile() {
    $result = self::$advancedSocialApi->refreshUserProfile(self::$testerAccessToken);
    $this->assertObjectHasAttribute("Uid", $result);
  }

  public function testRefreshToken() {
    $result = self::$advancedSocialApi->refreshAccessToken(self::$testerAccessToken);
    $this->assertObjectHasAttribute("access_token", $result);
  }

  public function testGetActiveSessions() {
    $result = self::$advancedSocialApi->getActiveSessionByToken(self::$testerAccessToken);
    $this->assertObjectHasAttribute("data", $result);
  }
}
