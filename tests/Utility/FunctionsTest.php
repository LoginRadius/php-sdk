<?php

/**
 * @link : http://www.loginradius.com
 * @category : LoginRadiusSDK
 * @package : LoginRadius
 * @author : LoginRadius Team
 * @version : 3.5.0
 * @license : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\Utility;

use LoginRadiusSDK\Clients\IHttpClient;
use LoginRadiusSDK\Clients\DefaultHttpClient;
use LoginRadiusSDK\Utility\Functions;



/**
 * Class For LoginRadius
 * This is the Loginradius class to handle response of LoginRadius APIs.
 *
 * Copyright 2016 LoginRadius Inc. - www.LoginRadius.com
 */
class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    protected $functions;
    public function __construct()
    {
        $this->functions = new Functions(API_KEY, API_SECRET, array('output_format' => 'json'));
    }

    public function testSetDefaultApplication()
    {

        $this->functions->setDefaultApplication(API_KEY, API_SECRET);

        $this->assertEquals(Functions::getApiKey(), API_KEY);
        $this->assertEquals(Functions::getApiSecret(), API_SECRET);
    }
    /**
     * @expectedException \LoginRadiusSDK\LoginRadiusException
     */
    public  function testCheckAPIValidation()
    {

        $reflection = new \ReflectionClass(get_class($this->functions));
        $method = $reflection->getMethod('checkAPIValidation');
        $method->setAccessible(true);
        $method->invokeArgs($this->functions, array('fgw', 'dgad'));

    }

    public function testGetApiKey()
    {
        $this->assertEquals($this->functions->getApiKey(), API_KEY);
    }

    /**
     * Get options that you set.
     *
     * @return string
     */
    public  function testGetCustomizeOptions()
    {
        $this->assertArrayHasKey('output_format', $this->functions->getCustomizeOptions());
    }
    
    public  function testSetCustomizeOptions()
    {
        $this->functions->setCustomizeOptions(array('content-type' => 'application/json'));
        $this->assertArrayHasKey('content-type', Functions::getCustomizeOptions());
    }

    public  function getApiSecret()
    {
        $this->assertEquals($this->functions->getApiSecret(), API_SECRET);
    }
    
    public function testIsValidGuid()
    {
        $this->assertTrue((boolean)$this->functions->isValidGuid(API_KEY));
    }
    
    public function testApiClient()
    {
        $path = LR_CDN_ENDPOINT . "/raas/regSchema/" . Functions::getApiKey() . ".json";

        $this->assertRegexp('/loginRadiusAppRaasSchemaJsonLoaded/', $this->functions->apiClient($path));
    }
    
    public function testAuthentication()
    {
        $this->assertArrayHasKey('apikey', $this->functions->authentication(array(), 'key'));
        $this->assertArrayHasKey('apisecret', $this->functions->authentication(array(), 'secret'));
        $this->assertArrayHasKey('value', $this->functions->authentication(array('value' => 'test'), 'key'));

    }
    
    public  function testQueryBuild()
    {
        $this->assertRegexp('/test_key/', $this->functions->queryBuild(array('test_key' => '757575', 'test_secret' => '656565656565')));

    }

}