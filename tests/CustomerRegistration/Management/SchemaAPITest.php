<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : SocialLogin
 * @package             : GetProviders
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */


namespace LoginRadiusSDK\Tests\CustomerRegistration\Management\SchemaAPITest;


use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;
use LoginRadiusSDK\CustomerRegistration\Management\SchemaAPI;

/**
 * Class for GetSchemaAPI
 *
 * This is the main class to communicate with LoginRadius Registration Form.
 */
class SchemaAPITest extends \PHPUnit_Framework_TestCase
{

    protected $schemaapi;
    public function __construct()
    {
        $this->schemaapi = new SchemaAPI(API_KEY, API_SECRET);
    }

    public function testGetSchemaList()
    {
        $result = json_decode($this->schemaapi->getSchemaList(), true);
        $this->assertGreaterThanOrEqual(1,  count($result));

    }
}
