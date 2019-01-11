<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\Advance\ConfigAPI;

final class ConfigurationTest extends TestCase {
  private static $accountApi;
  private static $configApi;

  public static function setUpBeforeClass() {
    self::$accountApi = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    self::$configApi = new ConfigAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
  }

  public function testGetConfigurations() {
    $result = self::$configApi->getConfigurationList();
    $this->assertObjectHasAttribute("AppName", $result);
  }

  public function testGetServerTime() {
    $result = self::$configApi->getServerTime();
    $this->assertObjectHasAttribute("ServerName", $result);
  }

  public function testGenerateSott() {
    $result = self::$accountApi->generateSOTT();
    $this->assertObjectHasAttribute("Sott", $result);
  }
}
