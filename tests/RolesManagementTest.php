<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;

final class RolesManagementTest extends TestCase {
  private static $accountApi;
  private static $roleApi;

  private static $testerUid;
  private static $testerAccessToken;

  public static function setUpBeforeClass() {
    $data = '{
      "Email": [
        {
          "Type": "Primary",
          "Value": "phpunittester96@mailinator.com"
        },
        {
          "Type": "Secondary",
          "Value": "phpunittester96secondary@mailinator.com"
        }
      ],
      "UserName": "put96",
      "PhoneId": "16135550185",
      "Password": "password",
      "EmailVerified": true
    }';

    self::$accountApi = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    self::$roleApi = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
  
    $createResult = self::$accountApi->create($data);
    self::$testerUid = $createResult->Uid;
    self::$testerAccessToken = self::$accountApi->getAccessTokenByUid(self::$testerUid)->access_token;
  }

  public static function tearDownAfterClass() {
    self::$accountApi->delete(self::$testerUid);
  }

  public function testRolesManagement() {
    // Create Roles
    $roleData = '{
      "roles": [
        {
          "name": "example_test_role1",
          "permissions": {
            "pname1": true,
            "pname2": true
          }
        },
        {
          "name": "example_test_role2",
          "permissions": {
            "pname3": true,
            "pname4": true
          }
        }
      ]
    }';

    $rolesCreateResult = self::$roleApi->create($roleData);
    $this->assertObjectHasAttribute("data", $rolesCreateResult);

    // Get Roles List
    $rolesGetResult = self::$roleApi->get();
    $this->assertObjectHasAttribute("data", $rolesGetResult);

    // Add Permissions to Role
    $permissionData = '{
      "permissions": [
        "pname5",
        "pname6"
      ]
    }';

    $addPermissionResult = self::$roleApi->addPermission("example_test_role2", $permissionData);
    $this->assertObjectHasAttribute("Name", $addPermissionResult);

    // Assign Role to User
    $assignData = '{
      "roles": [
        "example_test_role1",
        "example_test_role2"
      ]
    }';

    $assignRoleResult = self::$roleApi->assignRolesByUid(self::$testerUid, $assignData);
    $this->assertObjectHasAttribute("Roles", $assignRoleResult);

    // Get Roles by Uid
    $getRolesByUidResult = self::$roleApi->getAccountRolesByUid(self::$testerUid);
    $this->assertObjectHasAttribute("Roles", $getRolesByUidResult);

    // Upsert Context
    $contextData = '{
      "rolecontext": [
        {
          "context": "example_context",
          "roles": [
            "example_test_role1",
            "example_test_role2"
          ],
          "additionalpermissions": [
            "eap1",
            "eap2"
          ],
          "expiration": "2020-10-01 8:30:00 AM"
        }
      ]
    }';

    $upsertContextResult = self::$roleApi->upsertContext(self::$testerUid, $contextData);
    $this->assertObjectHasAttribute("Data", $upsertContextResult);

    // Get Context
    $getContextResult = self::$roleApi->getContext(self::$testerUid);
    $this->assertObjectHasAttribute("Data", $getContextResult);

    // Delete Additional Permissions from Context
    $deleteAdditionalPermissionsData = '{
      "additionalpermissions": [
        "eap1",
        "eap2"  
      ]
    }';
    $deleteAPFCResult = self::$roleApi->deleteAdditionalPermissionFromContext(self::$testerUid, "example_context", $deleteAdditionalPermissionsData);
    $this->assertObjectHasAttribute("IsDeleted", $deleteAPFCResult);

    // Delete Role from Context
    $deleteRoleFromContextData = '{
      "roles": [
        "example_test_role2"
      ]
    }';

    $deleteRoleFromContextResult = self::$roleApi->deleteRoleFromContext(self::$testerUid, "example_context", $deleteRoleFromContextData);
    $this->assertObjectHasAttribute("IsDeleted", $deleteRoleFromContextResult);

    // Delete Context
    $deleteContextResult = self::$roleApi->deleteContextbyContextName(self::$testerUid, "example_context");
    $this->assertObjectHasAttribute("IsDeleted", $deleteContextResult);

    // Unassign Roles
    $unassignData = '{
      "roles": [
        "example_test_role2"
      ]
    }';

    $unassignRolesResult = self::$roleApi->deleteAccountRoles(self::$testerUid, $unassignData);
    $this->assertObjectHasAttribute("IsDeleted", $unassignRolesResult);

    // Delete Permissions from Role
    $deletePermissionData = '{
      "permissions": [
        "pname2"
      ]
    }';

    $deletePermissionsFromRoleResult = self::$roleApi->removePermission("example_test_role1", $deletePermissionData);
    $this->assertObjectHasAttribute("Name", $deletePermissionsFromRoleResult);

    // Delete Role
    $deleteRoleResult1 = self::$roleApi->delete("example_test_role1");
    $deleteRoleResult2 = self::$roleApi->delete("example_test_role2");
    $this->assertObjectHasAttribute("IsDeleted", $deleteRoleResult1);
    $this->assertObjectHasAttribute("IsDeleted", $deleteRoleResult2);
  }
}
