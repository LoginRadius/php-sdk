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
use LoginRadiusSDK\CustomerRegistration\Social\SocialLoginAPI;

/**
 * Class for SocialLoginAPI.
 *
 * This is the main class to communicate with LoginRadius Unified Social API.
 */
class SocialLoginAPITest extends \PHPUnit_Framework_TestCase
{

    protected $socialapi;
    public function __construct()
    {
        $this->socialapi = new SocialLoginAPI(API_KEY, API_SECRET);
    }

    public function testExchangeAccessToken()
    {
        $result = json_decode($this->socialapi->exchangeAccessToken(TOKEN), true);
        $this->assertArrayHasKey('access_token',  $result);
    }

    public function testGetUserProfiledata()
    {
        $result = json_decode($this->socialapi->getUserProfiledata(ACCESS_TOKEN), true);
        $this->assertArrayHasKey('Provider',  $result);
    }

    public function testTokenValidate()
    {
        $result = json_decode($this->socialapi->tokenValidate(ACCESS_TOKEN), true);
        $this->assertArrayHasKey('access_token',  $result);
    }

    public function testTokenInvalidate()
    {
        $result = json_decode($this->socialapi->tokenInvalidate(ACCESS_TOKEN), true);
        $this->assertArrayHasKey('isPosted',  $result);
    }

    public function testGetPhotoAlbums()
    {
        $result = json_decode($this->socialapi->getPhotoAlbums(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetPhotos()
    {
        $result = json_decode($this->socialapi->getPhotos(ACCESS_TOKEN, ALBUM_ID), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetCheckins()
    {
        $result = json_decode($this->socialapi->getCheckins(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetAudio()
    {
        $result = json_decode($this->socialapi->getAudio(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

     public function testGetContacts()
    {
        $result = json_decode($this->socialapi->getContacts(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetMentions()
    {
        $result = json_decode($this->socialapi->getMentions(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetFollowing()
    {
        $result = json_decode($this->socialapi->getFollowing(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetEvents()
    {
        $result = json_decode($this->socialapi->getEvents(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetPosts()
    {
        $result = json_decode($this->socialapi->getPosts(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

     public function testGetFollowedCompanies()
    {
        $result = json_decode($this->socialapi->getFollowedCompanies(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetGroups()
    {
        $result = json_decode($this->socialapi->getGroups(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetStatus()
    {
        $result = json_decode($this->socialapi->getStatus(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetVideos()
    {
        $result = json_decode($this->socialapi->getVideos(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetLikes()
    {
        $result = json_decode($this->socialapi->getLikes(ACCESS_TOKEN), true);
        $this->assertTrue(is_array($result));
    }

    public function testGetPages()
    {
        $result = json_decode($this->socialapi->getPages(ACCESS_TOKEN, PAGE_NAME), true);
        $this->assertTrue(is_array($result));
    }


    public function testPostStatus()
    {
        $result = json_decode($this->socialapi->postStatus(ACCESS_TOKEN, POST_STATUS), true);
        $this->assertArrayHasKey('isPosted',  $result);
    }

    public function testSendMessage()
    {
        $result = json_decode($this->socialapi->sendMessage(ACCESS_TOKEN, TO_MESSAGE, SUBJECT_MESSAGE, SEND_MESSAGE), true);
        $this->assertArrayHasKey('isPosted',  $result);
    }
    public  function testApiClientHandler()
    {
        $reflection = new \ReflectionClass(get_class($this->socialapi));
        $method = $reflection->getMethod('apiClientHandler');
        $method->setAccessible(true);
        $path = 'access_token';
        $query_array = array("token" => TOKEN, "secret" => Functions::getApiSecret());
        $result =  json_decode($method->invokeArgs($this->socialapi, array($path, false, $query_array)), true);

        $this->assertArrayHasKey('access_token',  $result);
    }

}
