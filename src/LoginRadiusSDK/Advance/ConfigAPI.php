<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : ConfigAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */


namespace LoginRadiusSDK\Advance;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

/**
 * Class for ConfigAPI
 *
 * This is the main class to communicate with LoginRadius to get configuration list.
 */
class ConfigAPI
{
    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $options
     */
    public function __construct($apikey = '', $apisecret = '', $options = array())
    {
        new Functions($apikey, $apisecret, $options);
    }

    /**
     * To fetch Configuration list
     *
     * @return Configuration Object
     */
    public function getConfigurationList()
    {
        return Functions::apiClient(API_CONFIG_DOMAIN . "/ciam/appInfo", '', array('authentication' => 'key'));
    }     
    
    
    /**
     * This API allows you to query your LoginRadius account for basic server information and server time information which is useful when generating an SOTT token.
     *
     * @param $time_difference = "10";  
     * @return Serverinfo Object
     */
    public function getServerTime($time_difference = '10') {
        return Functions::apiClient(API_DOMAIN. "/identity/v2/serverinfo", array("timedifference" => $time_difference), array('authentication' => 'key'));
    } 
    
}
