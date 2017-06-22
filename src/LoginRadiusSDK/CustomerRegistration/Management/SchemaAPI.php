<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : SchemaAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */


namespace LoginRadiusSDK\CustomerRegistration\Management;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

/**
 * Class for GetSchemaAPI
 *
 * This is the main class to communicate with LoginRadius Registration Form.
 */
class SchemaAPI
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
     * Get USer Registration Schema.
     *
     * @return mixed
     * @throws \LoginRadiusSDK\LoginRadiusException
     */
    public function getSchemaList()
    {
        $url = LR_CDN_ENDPOINT . "/raas/regSchema/" . Functions::getApiKey() . ".json";
        $response = Functions::apiClient($url);
        $json_response = explode('(', $response);
        if ($json_response[0] == 'loginRadiusAppRaasSchemaJsonLoaded') {
            return str_replace(')', '', $json_response[1]);
        }
        throw new LoginRadiusException('Error Retrieving Registration Schema');
    }
}
