<?php

/**
 * @link : http://www.loginradius.com
 * @category : LoginRadiusSDK
 * @package : LoginRadius
 * @author : LoginRadius Team
 * @version : 3.0.0
 * @license : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK;

use LoginRadiusSDK\Clients\IHttpClient;

define('API_DOMAIN', 'https://api.loginradius.com');
define('LR_CDN_ENDPOINT', 'https://cdn.loginradius.com');

/**
 * Class For LoginRadius
 * This is the Loginradius class to handle response of LoginRadius APIs.
 *
 * Copyright 2016 LoginRadius Inc. - www.LoginRadius.com
 */
class LoginRadius
{

    const version = '3.0.0';

    private static $apikey;
    private static $apisecret;
    private static $options = array();

    /**
     * Validate and set API credentials and set options.
     *
     * @param string $apikey
     * @param string $apisecret
     * @param array $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {

        if (!empty($apikey) && !empty($apisecret)) {
            self::setDefaultApplication($apikey, $apisecret);
        } elseif (empty($apikey) || empty($apisecret)) {
            if (empty(self::$apikey) || empty(self::$apisecret)) {
                if (defined('LR_API_KEY') && defined('LR_API_SECRET')) {
                    self::setDefaultApplication(LR_API_KEY, LR_API_SECRET);
                } else {
                    throw new LoginRadiusException('Required "LoginRadius" API Key and API Secret in valid guid format');
                }
            }
        }

        self::$options = array_merge(self::$options, $customize_options);
    }

    /**
     * Set API key and API secret.
     *
     * @param type $apikey
     * @param type $apisecret
     */
    public static function setDefaultApplication($apikey, $apisecret)
    {
        self::checkAPIValidation($apikey, $apisecret);
        self::$apikey = $apikey;
        self::$apisecret = $apisecret;
    }

    /**
     * Check API Key and Secret in valid Guid format.
     *
     * @param type $apikey
     * @param type $apisecret
     * @throws LoginRadiusException
     */
    private static function checkAPIValidation($apikey, $apisecret)
    {

        if (empty($apikey) || !self::isValidGuid($apikey)) {
            throw new LoginRadiusException('Required "LoginRadius" API key in valid guid format.');
        }
        if (empty($apisecret) || !self::isValidGuid($apisecret)) {
            throw new LoginRadiusException('Required "LoginRadius" API secret in valid guid format.');
        }
    }

    /**
     * Get api key that you set.
     *
     * @return string
     */
    public static function getApiKey()
    {
        if (empty(self::$apikey) && defined('LR_API_KEY')) {
            self::$apikey = LR_API_KEY;
        }
        return self::$apikey;
    }

    /**
     * Get options that you set.
     *
     * @return string
     */
    public static function getCustomizeOptions()
    {
        return self::$options;
    }

    /**
     * Set options that you set.
     *
     * @return string
     */
    public static function setCustomizeOptions($customize_options = array())
    {
        self::$options = $customize_options;
    }

    /**
     * Get API Secret that you set.
     *
     * @return string
     */
    public static function getApiSecret()
    {
        if (empty(self::$apisecret) && defined('LR_API_SECRET')) {
            self::$apisecret = LR_API_SECRET;
        }
        return self::$apisecret;
    }

    /**
     *  Check valid Guid format.
     *
     * @param type $value
     * @return type
     */
    public static function isValidGuid($value)
    {
        return preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $value);
    }

    /**
     * Access LoginRadius API server by External library
     *
     * @global type $apiClient_class
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    public static function apiClient($path, $query_array = array(), $options = array())
    {

        global $apiClient_class;

        $merge_options = array_merge($options, self::$options);

        if (isset($apiClient_class) && class_exists($apiClient_class)) {
            $client = new $apiClient_class();
        } else {
            $client = new Clients\DefaultHttpClient();
        }

        $output_format = isset($merge_options['output_format']) && $merge_options['output_format'] == 'json' ? true : false;
        $response = $client->request($path, $query_array, $merge_options);

        return $output_format && (is_object(json_decode($response)) || is_array(json_decode($response))) ? json_decode($response) : $response;
    }

    /**
     * Manage LoginRadius Authentication
     *
     * @param type $array
     * @return type
     */
    public static function authentication($array = array())
    {

        $result = array(
            "appkey" => LoginRadius::getApiKey(),
            "appsecret" => LoginRadius::getApiSecret()
        );

        if (is_array($array) && sizeof($array) > 0) {
            $result = array_merge($result, $array);
        }

        return $result;
    }

    /**
     * Build Query string
     *
     * @param type $data
     * @return type
     */
    public static function queryBuild($data = array())
    {
        if (is_array($data) && sizeof($data) > 0) {
            return http_build_query($data);
        } else {
            return $data;
        }
    }

}