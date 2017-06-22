<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AuthCustomObjectAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Authentication;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\Utility\SOTT;

/**
 * CustomObjectAPI
 *
 * This is the main class to communicate with LoginRadius Customer Registration Authentication API.
 */
class AuthCustomObjectAPI
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
     * Create custom object.
     *
     * @param $data
     * @return type
     */
    public function createCustomObject($access_token, $objectname, $data)
    {
        return $this->apiClientHandler("CustomObject", array('access_token' => $access_token,'ObjectName' => $objectname), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * Update custom object data.
     *
     * @param $object_record_id
     * @param $data
     * @return type
     */
    public function updateCustomObjectData($access_token, $objectname, $object_record_id, $data)
    {
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('access_token' => $access_token,'ObjectName' => $objectname), array('method' => 'put', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * Get custom object Sets.
     *
     *
     * @param $access_token
     * @param $object_name
     * @return type
     */
    public function getCustomObjectSetsByToken($access_token, $object_name)
    {
        return $this->apiClientHandler("CustomObject", array('access_token' => $access_token, 'ObjectName' => $object_name));
    }

    /**
     * Get custom object Set by id.
     *
     * @param $object_record_id
     * @param $object_name
     * @return type
     */
    public function getCustomObjectSetByID($access_token, $object_name, $object_record_id)
    {
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('access_token' => $access_token, 'ObjectName' => $object_name));
    }

    /**
     * Delete custom object.
     *
     * @param $object_record_id
     * @return type
     */
    public function deleteCustomObjectSet($access_token, $object_name, $object_record_id)
    {
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('access_token' => $access_token, 'ObjectName' => $object_name), array('method' => 'delete', 'post_data' => true));
    }

    /**
     * handle CustomObject APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $options = array())
    {
        return Functions::apiClient("/identity/v2/auth/" . $path, $query_array, $options);
    }
}