<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use LoginRadiusSDK\CustomerRegistration\Authentication\AuthCustomObjectAPI;
use LoginRadiusSDK\CustomerRegistration\Account\CustomObjectAPI;

final class CustomObjectManagementTest extends TestCase {
  private static $accountApi;
  private static $authCustomObjApi;
  private static $customObjApi;

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
    self::$authCustomObjApi = new AuthCustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    self::$customObjApi = new CustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
  
    $createResult = self::$accountApi->create($data);
    self::$testerUid = $createResult->Uid;
    self::$testerAccessToken = self::$accountApi->getAccessTokenByUid(self::$testerUid)->access_token;
  }

  public static function tearDownAfterClass() {
    self::$accountApi->delete(self::$testerUid);
  }

  public function testCustomObjectManagement() {
    if (CUSTOM_OBJECT_NAME === "") {
      $this->markTestSkipped("Custom Object Name in config.php needs to be defined.");
    } else {
      $createData1 = '{
        "testKey1": "testValue1"
      }';
      $createData2 = '{
        "testKey2": "testValue2"
      }';
      $updateData1 = '{
        "testKey12": "testValue12"
      }';
      $updateData2 = '{
        "testKey22": "testValue22"
      }';

      // Create Custom Object by UID
      $createByUidResult = self::$customObjApi->insert(self::$testerUid, CUSTOM_OBJECT_NAME, $createData1);
      $this->assertObjectHasAttribute("Id", $createByUidResult);
      $customObjId1 = $createByUidResult->Id;

      // Create Custom Object by Token
      $createByTokenResult = self::$authCustomObjApi->createCustomObject(self::$testerAccessToken, CUSTOM_OBJECT_NAME, $createData2);
      $this->assertObjectHasAttribute("Id", $createByTokenResult);
      $customObjId2 = $createByTokenResult->Id;

      // Get Custom Object by ObjectRecordId and UID
      $getByUidAndRecordId = self::$customObjApi->getObjectByRecordID(self::$testerUid, CUSTOM_OBJECT_NAME, $customObjId1);
      $this->assertObjectHasAttribute("Id", $getByUidAndRecordId);

      // Get Custom Object by ObjectRecordId and Token
      $getByTokenAndRecordId = self::$authCustomObjApi->getCustomObjectSetByID(self::$testerAccessToken, CUSTOM_OBJECT_NAME, $customObjId2);
      $this->assertObjectHasAttribute("Id", $getByTokenAndRecordId);

      // Get Custom Object by Token
      $getByTokenResult = self::$authCustomObjApi->getCustomObjectSetsByToken(self::$testerAccessToken, CUSTOM_OBJECT_NAME);
      $this->assertObjectHasAttribute("data", $getByTokenResult);

      // Get Custom Object by UID
      $getByUidResult = self::$customObjApi->getObjectByAccountid(self::$testerUid, CUSTOM_OBJECT_NAME);
      $this->assertObjectHasAttribute("data", $getByUidResult);

      // Update Custom Object by ObjectRecordId and UID
      $updateByUid = self::$customObjApi->updateObjectByRecordID(self::$testerUid, CUSTOM_OBJECT_NAME, $customObjId1, "replace", $updateData1);
      $this->assertObjectHasAttribute("Id", $updateByUid);

      // Update Custom Object by ObjectRecordId and Access Token
      $updateByAccessToken = self::$authCustomObjApi->updateCustomObjectData(self::$testerAccessToken, CUSTOM_OBJECT_NAME, $customObjId2, "replace", $updateData2);
      $this->assertObjectHasAttribute("Id", $updateByAccessToken);

      // Delete Custom Object by ObjectRecordId and UID
      $deleteByUidResult = self::$customObjApi->delete(self::$testerUid, CUSTOM_OBJECT_NAME, $customObjId1);
      $this->assertObjectHasAttribute("IsDeleted", $deleteByUidResult);

      // Delete Custom Object by ObjectRecordId and Token
      $deleteByTokenResult = self::$authCustomObjApi->deleteCustomObjectSet(self::$testerAccessToken, CUSTOM_OBJECT_NAME, $customObjId2);
      $this->assertObjectHasAttribute("IsDeleted", $deleteByTokenResult);
    }
  }
}
