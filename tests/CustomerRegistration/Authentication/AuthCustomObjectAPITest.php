<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AuthenticationAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\CustomerRegistration\Authentication;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\Utility\SOTT;
use LoginRadiusSDK\CustomerRegistration\Authentication\AuthCustomObjectAPI;

/**
 * Account API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Authentication API.
 */
class AuthCustomObjectAPITest extends \PHPUnit_Framework_TestCase {

    protected $authcustomobjapi;

    public function __construct() {
        $this->authcustomobjapi = new AuthCustomObjectAPI(API_KEY, API_SECRET);
   }

    public function testCreateCustomObject() {

        $result = (array) json_decode($this->authcustomobjapi->createCustomObject(ACCESS_TOKEN, OBJECT_NAME, CUSTOM_OBJECT_JSON));
        $this->assertArrayHasKey('CustomObject', $result);
    }

    public function testUpdateCustomObjectData() {
        $result = (array) json_decode($this->authcustomobjapi->updateCustomObjectData(ACCESS_TOKEN, OBJECT_NAME, OBJECT_RECORD_ID, UPDATE_CUSTOM_OBJECT_JSON));

        $this->assertArrayHasKey('CustomObject', $result);
    }

    public function testGetCustomObjectSetsByToken() {
        $result = (array) json_decode($this->authcustomobjapi->getCustomObjectSetsByToken(ACCESS_TOKEN, OBJECT_NAME));
        $this->assertArrayHasKey('Count', $result);
    }

    public function testGetCustomObjectSetByID() {
        $result = (array) json_decode($this->authcustomobjapi->getCustomObjectSetByID(ACCESS_TOKEN, OBJECT_NAME, OBJECT_RECORD_ID));

        $this->assertArrayHasKey('CustomObject', $result);
    }

    public function testDeleteCustomObjectSet() {
        $result = (array) json_decode($this->authcustomobjapi->deleteCustomObjectSet(ACCESS_TOKEN, OBJECT_NAME, OBJECT_RECORD_ID));

        $this->assertArrayHasKey('isDeleted', $result);
    }

    public function testApiClientHandler() {
        $reflection = new \ReflectionClass(get_class($this->authcustomobjapi));
        $method = $reflection->getMethod('apiClientHandler');
        $method->setAccessible(true);
        $path = 'username';
        $query_array = array('username' => USERNAME);
        $result = (array) json_decode($method->invokeArgs($this->authcustomobjapi, array($path, $query_array)));
        $this->assertArrayHasKey('isExist', $result);
    }

}
