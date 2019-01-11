<?php

use PHPUnit\Framework\TestCase;
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use LoginRadiusSDK\CustomerRegistration\Account\CustomRegistrationDataAPI;

final class CustomRegistrationDataTest extends TestCase {
  private static $userApi;
  private static $customRegistrationDataApi;

  public static function setUpBeforeClass() {
    self::$userApi = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    self::$customRegistrationDataApi = new CustomRegistrationDataAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
  }

  public function testCustomRegistrationData() {
    if (CUSTOM_REGISTRATION_DATA_TYPE === "") {
      $this->markTestSkipped("Custom Registration Data Type needs to be defined in config.php.");
    } else {
      // Add Registration Data
      $registrationData = '{
        "Data": [
          {
            "type": "' . CUSTOM_REGISTRATION_DATA_TYPE . '",
            "key": "example1",
            "value": "value1",
            "parentid": "",
            "code": "examplecode",
            "isactive": true
          }
        ]
      }';

      $addDataResult = self::$customRegistrationDataApi->addRegistrationData($registrationData);
      $this->assertObjectHasAttribute("IsPosted", $addDataResult);

      // Get Registration Data
      $getDataResult = self::$customRegistrationDataApi->getRegistrationData(CUSTOM_REGISTRATION_DATA_TYPE, "", "0", "50");
      $this->assertNotEmpty($getDataResult);

      // Auth Get Registration Data
      $authGetDataResult = self::$userApi->authGetRegistrationDataServer(CUSTOM_REGISTRATION_DATA_TYPE, "", "0", "50");
      $this->assertNotEmpty($authGetDataResult);

      $lastRecord = end($getDataResult);
      $rdRecordId = $lastRecord->Id;
      $rdCode = $lastRecord->Code;

      // Validate Code
      $validateData = '{
        "recordid": "' . $rdRecordId . '",
        "code": "' . $rdCode . '"
      }';
      $validateResult = self::$userApi->validateRegistrationDataCode($validateData);
      $this->assertObjectHasAttribute("IsValid", $validateResult);

      // Update Registration Data
      $updateData = '{
        "IsActive": true,
        "Type": "' . CUSTOM_REGISTRATION_DATA_TYPE . '",
        "Key": "Key",
        "Value": "A value",
        "ParentId": "",
        "Code": "' . $rdCode . '"
      }';
      $updateResult = self::$customRegistrationDataApi->updateRegistrationData($rdRecordId, $updateData);
      $this->assertObjectHasAttribute("IsPosted", $updateResult);

      // Delete Registration Data
      $deleteResult = self::$customRegistrationDataApi->deleteRegistrationData($rdRecordId);
      $this->assertObjectHasAttribute("IsDeleted", $deleteResult);
    }
  }
}
