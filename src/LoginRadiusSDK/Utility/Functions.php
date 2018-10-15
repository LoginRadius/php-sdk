<?php

/**
 * @link : http://www.loginradius.com
 * @category : Utility
 * @package : Functions
 * @author : LoginRadius Team
 * @version : 5.0.1
 * @license : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Utility;

use LoginRadiusSDK\Clients\IHttpClient;
use LoginRadiusSDK\Clients\DefaultHttpClient;
use LoginRadiusSDK\LoginRadiusException;

if (!defined('API_DOMAIN')) {
    define('API_DOMAIN', 'https://api.loginradius.com');
}
if (!defined('API_CONFIG_DOMAIN')) {
    define('API_CONFIG_DOMAIN', 'https://config.lrcontent.com');
}

/**
 * Class For LoginRadius
 * This is the Loginradius class to handle response of LoginRadius APIs.
 *
 */
class Functions {

    const version = '5.0.1';

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
    public function __construct($apikey = '', $apisecret = '', $customize_options = array()) {

        if (!empty($apikey) && !empty($apisecret)) {
            self::setDefaultApplication($apikey, $apisecret);
        } elseif (empty($apikey) || empty($apisecret)) {
            if (empty(self::$apikey) || empty(self::$apisecret)) {
                if (defined('LR_API_KEY') && defined('LR_API_SECRET')) {
                    self::setDefaultApplication(LR_API_KEY, LR_API_SECRET);
                } else {
                    throw new LoginRadiusException('Required "LoginRadius" API Key and API Secret.');
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
    public static function setDefaultApplication($apikey, $apisecret) {
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
    private static function checkAPIValidation($apikey, $apisecret) {
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
    public static function getApiKey() {
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
    public static function getCustomizeOptions() {
        return self::$options;
    }

    /**
     * Set options that you set.
     *
     * @return string
     */
    public static function setCustomizeOptions($options = array()) {
        self::$options = $options;
    }

    /**
     * Get API Secret that you set.
     *
     * @return string
     */
    public static function getApiSecret() {
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
    public static function isValidGuid($value) {
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
    public static function apiClient($path, $query_array = array(), $options = array()) {
        global $apiClient_class;
        $merge_options = array_merge($options, self::$options);
        if (isset($apiClient_class) && class_exists($apiClient_class)) {
            $client = new $apiClient_class();
        } else {
            $client = new DefaultHttpClient();
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
    public static function authentication($array = array(), $secure = 'key', $request_url = '') {
        $result = array();
        if ($secure == 'key') {
            $result = array('apikey' => Functions::getApiKey());
        } else if ($secure == 'secret') {
            $result = array('X-LoginRadius-ApiSecret' => Functions::getApiSecret());
        } else if ($secure == 'hashsecret') {
            $expiry_time = gmdate("Y-m-d H:i:s", strtotime('1 hour'));
            $encoded_url = self::urlReplacement(urlencode(urldecode($request_url)));

            if (isset($array['method']) && (($array['method'] == 'POST') || ($array['method'] == 'PUT') || ($array['method'] == 'DELETE')) && $array['post_data'] !== true) {
                $post_data = $array['post_data'];              
                if ((is_array($array['post_data']) || is_object($array['post_data']))) {
                   $post_data = json_encode($array['post_data']);
                }              
                $string_to_hash = $expiry_time . ':' . strtolower($encoded_url) . ':' . $post_data;
            } else {
                $string_to_hash = $expiry_time . ':' . strtolower($encoded_url);
            }
            $sha_hash = hash_hmac('sha256', $string_to_hash, Functions::getApiSecret(), true);
            $result = array('X-Request-Expires' => $expiry_time, 'digest' => "SHA-256=" . base64_encode($sha_hash));
        }

        return (is_array($array) && sizeof($array) > 0) ? array_merge($result, $array) : $result;
    }
    
    
    /**
     * Url replacement
     *
     * @param type $decoded_url
     * @return type
     */

    public function urlReplacement($decoded_url) {
        $replacementArray = array('%2A' => '*','%28' => '(','%29' => ')');
        return str_replace(array_keys($replacementArray), array_values($replacementArray), $decoded_url);
    }

    /**
     * Build Query string
     *
     * @param type $data
     * @return type
     */
    public static function queryBuild($data = array()) {
        if (is_array($data) && sizeof($data) > 0) {
            return http_build_query($data);
        }
        return '';
    }
}
