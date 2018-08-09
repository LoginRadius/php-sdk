<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : ProvidersAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */


namespace LoginRadiusSDK\Advance;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

/**
 * Class for GetProvidersAPI
 *
 * This is the main class to communicate with LoginRadius to get Social Login Providers.
 */
class CloudAPI
{
    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {
        new Functions($apikey, $apisecret, $customize_options);
    }

    /**
     * LoginRadius function - To fetch options enabled on dashboard
     *
     * @param string $apikey data to validate.
     *
     * @return object options/error messages.
     *
     * try {
     *   $response = $cloudObject->getConfigurationList();
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    public function getConfigurationList()
    {
        $options = array('authentication' => 'key');
        $url = LR_CLOUD_ENDPOINT . "/ciam/appInfo";
        return Functions::apiClient($url, '', $options);
    }  
    
}
