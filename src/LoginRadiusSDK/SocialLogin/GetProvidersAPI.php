<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : SocialLogin
 * @package             : GetProviders
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */


namespace LoginRadiusSDK\SocialLogin;

use LoginRadiusSDK\LoginRadius;
use LoginRadiusSDK\LoginRadiusException;

/**
 * Class for GetProvidersAPI
 *
 * This is the main class to communicate with LoginRadius to get Social Login Providers.
 */
class GetProvidersAPI
{
    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {
        $options = array_merge(array('authentication'=>false),$customize_options);
        new LoginRadius($apikey, $apisecret, $options);
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
        $url = LR_CDN_ENDPOINT . "/interface/json/" . LoginRadius::getApiKey() . ".json";
        $response = LoginRadius::apiClient($url);
        $jsonResponse = explode('(', $response);
        if ($jsonResponse[0] == 'loginRadiusAppJsonLoaded') {
            return str_replace(')', '', $jsonResponse[1]);
        }
        throw new LoginRadiusException('Error Retrieving Providers List');
    }
}
