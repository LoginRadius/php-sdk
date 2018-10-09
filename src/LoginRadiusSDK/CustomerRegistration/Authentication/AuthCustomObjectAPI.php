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

/**
 * CustomObjectAPI
 *
 * This is the main class to communicate with LoginRadius Auth Custom object API.
 */
class AuthCustomObjectAPI
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
     * Create custom object.
     *
     * @param $data
     * @return type
     */
    public function createCustomObject($access_token, $objectname, $data, $fields = '*')
    {
        return $this->apiClientHandler("CustomObject", array('ObjectName' => $objectname, 'fields' => $fields), array('method' => 'POST', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }

    /**
     * Update custom object data.
     *
     * @param $access_token
     * @param $object_name
     * @param $object_record_id
     * @param $update_type
     * @param $data
     * @return type
     */
    public function updateCustomObjectData($access_token, $object_name, $object_record_id, $update_type, $data, $fields = '*')
    {
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('ObjectName' => $object_name, 'updatetype' => $update_type, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json', 'access-token' => "Bearer ".$access_token));
    }

    /**
     * Get custom object Sets.
     *
     *
     * @param $access_token
     * @param $object_name
     * @return type
     */
    public function getCustomObjectSetsByToken($access_token, $object_name, $fields = '*')
    {
        return $this->apiClientHandler("CustomObject", array('ObjectName' => $object_name, 'fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }

    /**
     * Get custom object Set by id.
     *
     * @param $object_record_id
     * @param $object_name
     * @return type
     */
    public function getCustomObjectSetByID($access_token, $object_name, $object_record_id, $fields = '*')
    {
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('ObjectName' => $object_name, 'fields' => $fields), array('access-token' => "Bearer ".$access_token));
    }

    /**
     * Delete custom object using ObjectRecordId.
     *
     * @param $object_record_id
     * @return type
     */
    public function deleteCustomObjectSet($access_token, $object_name, $object_record_id, $fields = '*')
    {
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('ObjectName' => $object_name, 'fields' => $fields), array('method' => 'DELETE', 'post_data' => true, 'access-token' => "Bearer ".$access_token));
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
        return Functions::apiClient("/identity/v2/auth/" . $path, $query_array, array_merge(array('authentication' => 'key'), $options));
    }
}