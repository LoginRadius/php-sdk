<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : RoleAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\CustomerRegistration\Management\RoleAPI;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\CustomerRegistration\Management\RoleAPI;
/**
 * Role API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Role API.
 */
class RoleAPITest extends \PHPUnit_Framework_TestCase
{

    protected $roleapi;
    public function __construct()
    {
        $this->roleapi = new RoleAPI(API_KEY, API_SECRET);
    }

    /**
     * Get Role of customer.
     *
     * @return type
     */
    public function testGet()
    {
        $result = (array)json_decode($this->roleapi->get());

        $this->assertArrayHasKey('data',  $result);
    }
    
    public function testGetContext()
    {
        $result = (array)json_decode($this->roleapi->getContext(UID));

        $this->assertArrayHasKey('data',  $result);
    }
    
    public function testUpsertContext()
    {
        $result = (array)json_decode($this->roleapi->upsertContext(UID, ROLE_CONTEXT));

        $this->assertArrayHasKey('data',  $result);
    }
    
    public function testDeleteContextbyContextName()
    {
        $result = (array)json_decode($this->roleapi->deleteContextbyContextName(UID, ROLES_CONTEXT_NAME));

        $this->assertArrayHasKey('IsDeleted',  $result);
    }
    
    public function testDeleteRoleFromContext()
    {
        $result = (array)json_decode($this->roleapi->deleteRoleFromContext(UID, ROLES_CONTEXT_NAME, ROLES));

        $this->assertArrayHasKey('IsDeleted',  $result);
    }
    
    public function testDeleteAdditionalPermissionFromContext()
    {
        $result = (array)json_decode($this->roleapi->deleteAdditionalPermissionFromContext(UID, ROLES_CONTEXT_NAME, ADDITIONAL_PERMISSION));

        $this->assertArrayHasKey('IsDeleted',  $result);
    }

    public function testCreate()
    {
        $result = (array)json_decode($this->roleapi->create(CREATE_ROLE));
        $this->assertArrayHasKey('data',  $result);
    }


    public function testDelete()
    {
        $result = (array)json_decode($this->roleapi->delete(ROLE_NAME));
        $this->assertArrayHasKey('isDeleted',  $result);
    }


    public function testAddPermission()
    {
        $result = (array)json_decode($this->roleapi->addPermission(ROLE_NAME, ROLE_PERMISSIONS));

        $this->assertArrayHasKey('Name',  $result);
    }


    public function testRemovePermission()
    {

        $result = (array)json_decode($this->roleapi->removePermission(ROLE_NAME, ROLE_PERMISSIONS));
        $this->assertArrayHasKey('Name',  $result);
    }


    public function testGetAccountRolesByUid()
    {
        $result = (array)json_decode($this->roleapi->getAccountRolesByUid(ACCOUNT_ID));

        $this->assertArrayHasKey('Roles',  $result);
    }



    public function testAssignRolesByUid()
    {
        $result = (array)json_decode($this->roleapi->assignRolesByUid(ACCOUNT_ID, ASSIGN_ROLES));

        $this->assertArrayHasKey('Roles',  $result);
    }

    public function testDeleteAccountRoles()
    {
        $result = (array)json_decode($this->roleapi->deleteAccountRoles(ACCOUNT_ID, ASSIGN_ROLES));

        $this->assertArrayHasKey('Roles',  $result);
    }

    public  function testApiClientHandler()
    {

        $reflection = new \ReflectionClass(get_class($this->roleapi));
        $method = $reflection->getMethod('apiClientHandler');
        $method->setAccessible(true);
        $path = 'role';
        $result =  (array)json_decode($method->invokeArgs($this->roleapi, array($path)));
        $this->assertArrayHasKey('data',  $result);
    }


}
