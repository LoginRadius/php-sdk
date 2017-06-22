<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : ProvidersAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */


namespace LoginRadiusSDK\CustomerRegistration\Social;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

/**
 * Class for GetProvidersAPI
 *
 * This is the main class to communicate with LoginRadius to get Social Login Providers.
 */
class ProvidersAPI
{
    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {
        $options = array_merge(array('authentication' => ''), $customize_options);
        new Functions($apikey, $apisecret, $options);
    }

    /**
     * LoginRadius function - To fetch social login providers
     *
     * @param string $apikey data to validate.
     *
     * @return object Social Login Providers/error messages.
     *
     * try{
     *   $providers = $GetProvidersAPIObject->getProvidersList();
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    public function getProvidersList()
    {
        $url = LR_CDN_ENDPOINT . "/interface/json/" . Functions::getApiKey() . ".json";
        $response = Functions::apiClient($url, false);
        $json_response = explode('(', $response);
        if ($json_response[0] == 'loginRadiusAppJsonLoaded') {
            return str_replace(')', '', $json_response[1]);
        }
        throw new LoginRadiusException('Error Retrieving Providers List');
    }
}
