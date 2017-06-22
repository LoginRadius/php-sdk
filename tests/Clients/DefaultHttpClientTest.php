<?php

/**
 * @link : http://www.loginradius.com
 * @category : LoginRadiusSDK
 * @package : LoginRadius
 * @author : LoginRadius Team
 * @version : 3.5.0
 * @license : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\Clients;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;
use LoginRadiusSDK\Clients\DefaultHttpClient;
/**
 * Class DefaultHttpClient
 *
 * Use default Curl/fsockopen to get response from LoginRadius APIs.
 *
 * @package LoginRadiusSDK\Clients
 */
class DefaultHttpClientTest extends \PHPUnit_Framework_TestCase
{
    protected $httpclient;

    public function __construct()
    {

        new Functions(API_KEY, API_SECRET);
        $this->httpclient = new DefaultHttpClient();
    }
    /**
     * @param $path
     * @param array $query_array
     * @param array $options
     * @return type
     * @throws \LoginRadiusSDK\LoginRadiusException
     */
   public function testRequest()
    {
        $path ='/identity/v2/manage/account';
        $query_array = array('apikey' => Functions::getApiKey(), 'apisecret' => Functions::getApiSecret(),'email' => 'fadsf@sthus.com');
        $result = (array)json_decode($this->httpclient->request($path, $query_array));
        $this->assertArrayHasKey('Identities',  $result);
    }

    /**
     * Access LoginRadius API server by curl method
     *
     * @param type $request_url
     * @param type $options
     * @return type
     */
//    public function testCurlApiMethod()
//    {
//        $reflection = new \ReflectionClass(get_class($this->httpclient));
//        $method = $reflection->getMethod('curlApiMethod');
//        $method->setAccessible(true);
//        $path = API_DOMAIN . '/identity/v2/manage/account';
//        $query_array = array('apikey' => Functions::getApiKey(), 'apisecret' => Functions::getApiSecret(),'email' => 'fadsf@sthus.com');
//        $request_url  =  $path . '?' . http_build_query($query_array);
//        $result =  (array)json_decode($method->invokeArgs($this->httpclient, array($request_url)));
//        $this->assertArrayHasKey('Identities',  $result);
//    }

    /**
     * Access LoginRadius API server by fsockopen method
     *
     * @param type $request_url
     * @param type $options
     * @return type
     */
//    public function testFsockopenApiMethod()
//    {
//        $reflection = new \ReflectionClass(get_class($this->httpclient));
//        $method = $reflection->getMethod('fsockopenApiMethod');
//        $method->setAccessible(true);
//        $path = API_DOMAIN . '/identity/v2/manage/account';
//        $query_array = array('apikey' => Functions::getApiKey(), 'apisecret' => Functions::getApiSecret(),'email' => 'fadsf@sthus.com');
//        $request_url  =  $path . '?' . http_build_query($query_array);
//        $result =  (array)json_decode($method->invokeArgs($this->httpclient, array($request_url)));
//
//        $this->assertArrayHasKey('Identities',  $result);
//    }

}
