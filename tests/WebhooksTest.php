<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\Advance\WebHooksAPI;

final class WebhooksTest extends TestCase {
  private static $webHooksApi;

  public static function setUpBeforeClass() {
    self::$webHooksApi = new WebHooksAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
  }

  public function testWebhooks() {
    // Subscribe Webhooks
    $subscribeResult = self::$webHooksApi->subscribeWebHooks("https://www.testphpsdk.com", "Login");
    $this->assertObjectHasAttribute("IsPosted", $subscribeResult);

    // Webhooks Test
    $testResult = self::$webHooksApi->webHooksSettings();
    $this->assertObjectHasAttribute("IsAllowed", $testResult);

    // Webhooks Subscribed Urls
    $subscribedUrlsResult = self::$webHooksApi->getWebHooksSubscribedUrls("Login");
    $this->assertObjectHasAttribute("data", $subscribedUrlsResult);

    // Webhooks Unsubscribe
    $unsubscribeResult = self::$webHooksApi->unsubscribeWebHooks("https://www.testphpsdk.com", "Login");
    $this->assertObjectHasAttribute("IsDeleted", $unsubscribeResult);
  }
}
