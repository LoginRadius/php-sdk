<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : SocialLogin
 * @package             : SocialLoginAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\CustomerRegistration\Social;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;
use LoginRadiusSDK\CustomerRegistration\Social\AdvanceSocialLoginAPI;
/**
 * Class for AdvanceSocialLoginAPI.
 *
 * This is the main class to communicate with LoginRadius Unified Advance Social API.
 */
class AdvanceSocialLoginAPITest extends \PHPUnit_Framework_TestCase
{

    protected $advancesocial;
    public function __construct()
    {
        $this->advancesocial = new AdvanceSocialLoginAPI(API_KEY, API_SECRET);
    }
    public function testGetAccessTokenByPassingFacebookToken()
    {
        $result = json_decode($this->advancesocial->getAccessTokenByPassingFacebookToken(FB_ACCESS_TOKEN), true);
        $this->assertArrayHasKey('access_token',  $result);
    }

    /**
     * Get LoginRadius Access token by Passing Twitter token
     *
     * @param $tw_access_token
     * @param $tw_token_secret
     * @return type
     */
    public function testGetAccessTokenByPassingTwitterToken()
    {
        $result = json_decode($this->advancesocial->getAccessTokenByPassingTwitterToken(TW_ACCESS_TOKEN, TW_TOKEN_SECRET), true);
      
        $this->assertArrayHasKey('access_token',  $result);
    }
    
    public function testRefreshUserProfile()
    {
        $result = json_decode($this->advancesocial->refreshUserProfile(ACCESS_TOKEN), true);
        $this->assertArrayHasKey('Provider',  $result);
    }
    
    public function testRefreshAccessToken()
    {
        $result = json_decode($this->advancesocial->refreshAccessToken(ACCESS_TOKEN), true);
        $this->assertArrayHasKey('access_token',  $result);
    }

    public function testTrackableStatus()
    {
        $result = json_decode($this->advancesocial->trackableStatus(POST_ID), true);
        $this->assertArrayHasKey('Shares',  $result);
    }

 public function testPostMessage()
    {
      $result = json_decode($this->advancesocial->postMessage(ACCESS_TOKEN, TO_MESSAGE, SUBJECT_MESSAGE, SEND_MESSAGE), true);
        $this->assertArrayHasKey('isPosted',  $result);
  }
  public function testPostStatus()
    {
      $result = json_decode($this->advancesocial->postStatus(ACCESS_TOKEN, POST_STATUS), true);
        $this->assertArrayHasKey('isPosted',  $result);
  }
    public function testTrackableStatusStats()
    {
        $result = json_decode($this->advancesocial->trackableStatusStats(ACCESS_TOKEN, POST_STATUS), true);
        $this->assertArrayHasKey('Id',  $result);
    }

     public function testTrackableStatusPosting()
    {
        $result = json_decode($this->advancesocial->trackableStatusPosting(ACCESS_TOKEN, POST_STATUS), true);
        $this->assertArrayHasKey('Id',  $result);
    }

     public function testShortenUrl()
    {
        $result = json_decode($this->advancesocial->shortenUrl(URL), true);
        $this->assertArrayHasKey('ShortUrl',  $result);
    }


    public  function testApiClientHandler()
    {

        $reflection = new \ReflectionClass(get_class($this->advancesocial));
        $method = $reflection->getMethod('apiClientHandler');
        $method->setAccessible(true);
        $path = 'access_token/facebook';
        $query_array = array("key" => Functions::getApiKey(), "fb_access_token" => FB_ACCESS_TOKEN);
        $result =  json_decode($method->invokeArgs($this->advancesocial, array($path, $query_array)), true);

        $this->assertArrayHasKey('access_token',  $result);
    }

}
