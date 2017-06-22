<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : Advance
 * @package             : UserAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\Advance;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\Advance\WebHooksAPI;

class WebHooksAPITest extends \PHPUnit_Framework_TestCase {

    protected $webhookapi;

    public function __construct() {
        $this->webhookapi = new WebHooksAPI(API_KEY, API_SECRET);
    }


    public function testWebHooksSettings() {
        $result = (array) json_decode($this->webhookapi->webHooksSettings());       
      
        $this->assertArrayHasKey('IsAllowed', $result);
    }
    
    public function testSubscribeWebHooks() {
        $result = (array) json_decode($this->webhookapi->subscribeWebHooks(TARGET_URL, EVENT));
       
        $this->assertArrayHasKey('IsPosted', $result);
    }

    public function testGetWebHooksSubscribedUrls() {
        $result = (array) json_decode($this->webhookapi->getWebHooksSubscribedUrls(EVENT));
  
        if (count($result) > 0) {

            $this->assertArrayHasKey('TargetUrl', $result);
        }
        else {
            $this->assertTrue(count($result) == 0);
        }
    }

   

    public function testUnsubscribeWebHooks() {
        $result = (array) json_decode($this->webhookapi->unsubscribeWebHooks(TARGET_URL, EVENT));
      
        $this->assertArrayHasKey('IsDeleted', $result);
    }

    public function testApiClientHandler() {
        $reflection = new \ReflectionClass(get_class($this->webhookapi));
        $method = $reflection->getMethod('apiClientHandler');
        $method->setAccessible(true);
        $path = 'webhook/test';
        $query_array = array('api_key' => Functions::getApiKey(), 'api_secret' => Functions::getApiSecret());
        $result = (array) json_decode($method->invokeArgs($this->webhookapi, array($path, $query_array)));
        $this->assertArrayHasKey('isPosted', $result);
    }

}
