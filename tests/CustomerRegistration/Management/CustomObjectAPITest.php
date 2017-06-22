<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : CustomObjectAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\CustomerRegistration\Management;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\CustomerRegistration\Management\CustomObjectAPI;
/**
 * Class CustomObjectAPI
 *
 * This is the main class to communicate with LoginRadius Custom Object APIs.
 */
class CustomObjectAPITest extends \PHPUnit_Framework_TestCase
{

    protected $customobjectapi;
    public function __construct()
    {
        $this->customobjectapi = new CustomObjectAPI(API_KEY, API_SECRET);
    }

   public function testInsert()
    {
        $result = (array)json_decode($this->customobjectapi->insert(ACCOUNT_ID, OBJECT_NAME, CUSTOM_OBJECT_JSON));
        $this->assertArrayHasKey('CustomObject',  $result);
    }

    public function testGetObjectByAccountid()
    {
        $result = (array)json_decode($this->customobjectapi->getObjectByAccountid(ACCOUNT_ID, OBJECT_NAME));

        $this->assertArrayHasKey('Count',  $result);
    }

    public function testUpdateObjectByRecordID()
    {
        $result = (array)json_decode($this->customobjectapi->updateObjectByRecordID(ACCOUNT_ID, OBJECT_NAME, OBJECT_RECORD_ID,  UPDATE_CUSTOM_OBJECT_JSON));
        $this->assertArrayHasKey('CustomObject',  $result);
    }

    public function testGetObjectByRecordID()
    {
        $result = (array)json_decode($this->customobjectapi->getObjectByRecordID(ACCOUNT_ID, OBJECT_NAME, OBJECT_RECORD_ID));
        $this->assertArrayHasKey('CustomObject',  $result);
    }


    public function testDelete()
    {
        $result = (array)json_decode($this->customobjectapi->delete(ACCOUNT_ID, OBJECT_NAME, OBJECT_RECORD_ID));
        $this->assertArrayHasKey('isDeleted',  $result);
    }

    public  function testApiClientHandler()
    {

        $reflection = new \ReflectionClass(get_class($this->customobjectapi));
        $method = $reflection->getMethod('apiClientHandler');
        $method->setAccessible(true);
        $path = ACCOUNT_ID . '/customObject/';
        $query_array =  array('ObjectName' => OBJECT_NAME);
        $result =  (array)json_decode($method->invokeArgs($this->customobjectapi, array($path, $query_array)));

        $this->assertArrayHasKey('Count',  $result);
    }

}
