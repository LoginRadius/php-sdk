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
        $options = array_merge(array('authentication' => 'key'), $customize_options);
        new Functions($apikey, $apisecret, $options);
    }

    /**
     * LoginRadius function - To fetch options enabled on dashboard
     *
     * @param string $apikey data to validate.
     *
     * @return object options/error messages.
     *
     * try{
     *   $response = $cloudObject->getOptionsList();
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    public function getConfigurationList()
    {
        $url = LR_CLOUD_ENDPOINT . "/configuration/ciam/appInfo";
        return Functions::apiClient($url);        
    }
}
