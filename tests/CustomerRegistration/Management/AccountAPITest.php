<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AccountAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\CustomerRegistration\Management;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\CustomerRegistration\Management\AccountAPI;
/**
 * Account API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Account API.
 */
class AccountAPITest extends \PHPUnit_Framework_TestCase
{

    protected $accountapi;
    public function __construct()
    {
        $this->accountapi = new AccountAPI(API_KEY, API_SECRET);
    }
    public function testCreate()
    {
        $result = (array)json_decode($this->accountapi->create(User_Profile_object));

        $this->assertArrayHasKey('Provider',  $result);
    }

   public function testUpdate()
    {
        $result = (array)json_decode($this->accountapi->update(ACCOUNT_ID, Update_User_Profile_object));
        $this->assertArrayHasKey('Provider',  $result);
    }

   public function testDelete()
    {
        $result = (array)json_decode($this->accountapi->delete(ACCOUNT_ID));
        $this->assertArrayHasKey('isDeleted',  $result);
    }

    public function testSetPassword()
    {
        $result = (array)json_decode($this->accountapi->setPassword(ACCOUNT_ID, NEW_PASSWORD));
        $this->assertArrayHasKey('PasswordHash',  $result);
    }


    public function testGetHashPassword()
    {
        $result = (array)json_decode($this->accountapi->getHashPassword(ACCOUNT_ID));
        $this->assertArrayHasKey('PasswordHash',  $result);
    }


    public function testGetProfileByEmail()
    {
        $result = (array)json_decode($this->accountapi->getProfileByEmail(EMAIL));

        $this->assertArrayHasKey('Provider',  $result);
    }


    public function testGetProfileByUsername()
    {
        $result = (array)json_decode($this->accountapi->getProfileByUsername(USERNAME));

        $this->assertArrayHasKey('UserName',  $result);
    }


    public function testGetProfileByPhone()
    {
        $result = (array)json_decode($this->accountapi->getProfileByPhone(PHONE_ID));

        $this->assertArrayHasKey('UserName',  $result);
    }


    public function testGetProfileByUid()
    {
        $result = (array)json_decode($this->accountapi->getProfileByUid(ACCOUNT_ID));

        $this->assertArrayHasKey('Uid',  $result);
    }
    
    public function testGetAccessTokenByUid()
    {
        $result = (array)json_decode($this->accountapi->getAccessTokenByUid(UID));

        $this->assertArrayHasKey('Uid',  $result);
    }
    
    public function testRemoveOrResetGoogleAuthenticator()
    {
        $result = (array)json_decode($this->accountapi->removeOrResetGoogleAuthenticator(UID, true, false));
        $this->assertArrayHasKey('Uid',  $result);
    } 
   
    
    public function testGetBackupCodeForLoginbyUID()
    {
        $result = (array)json_decode($this->accountapi->getBackupCodeForLoginbyUID(UID));
        $this->assertArrayHasKey('Uid',  $result);
    }
    
    public function testResetBackupCodeForLoginbyUID()
    {
        $result = (array)json_decode($this->accountapi->resetBackupCodeForLoginbyUID(UID));
        $this->assertArrayHasKey('Uid',  $result);
    }

    public  function testApiClientHandler()
    {
        $reflection = new \ReflectionClass(get_class($this->accountapi));
        $method = $reflection->getMethod('apiClientHandler');
        $method->setAccessible(true);
        $path = "/" . ACCOUNT_ID . "/password";
        $result =  (array)json_decode($method->invokeArgs($this->accountapi, array($path)));

        $this->assertArrayHasKey('PasswordHash',  $result);
    }

}
