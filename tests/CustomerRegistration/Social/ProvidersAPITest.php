<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : SocialLogin
 * @package             : GetProviders
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */


namespace LoginRadiusSDK\Tests\CustomerRegistration\Social;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;
use LoginRadiusSDK\CustomerRegistration\Social\ProvidersAPI;
/**
 * Class for GetProvidersAPI
 *
 * This is the main class to communicate with LoginRadius to get Social Login Providers.
 */
class ProvidersAPITest  extends \PHPUnit_Framework_TestCase
{
    protected $providers;
    public function __construct()
    {
        $this->providers = new ProvidersAPI(API_KEY, API_SECRET);
    }


    public function testGetProvidersList()
    {
        $result = json_decode($this->providers->getProvidersList(), true);       
        $this->assertGreaterThanOrEqual(1,  count($result));
    }
}
