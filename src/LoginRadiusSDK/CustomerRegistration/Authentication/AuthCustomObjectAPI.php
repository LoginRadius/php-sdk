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
        new Functions($apikey, $apisecret, $customize_options);
    }
    
    /**
     * Create custom object.
     *
     * @param $data
     * @return type
     */
    public function createCustomObject($access_token, $objectname, $data, $fields = '*')
    {
        return $this->apiClientHandler("CustomObject", array('access_token' => $access_token,'ObjectName' => $objectname, 'fields' => $fields), array('method' => 'POST', 'post_data' => $data, 'content_type' => 'json'));
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
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('access_token' => $access_token,'ObjectName' => $object_name,'updatetype' => $update_type, 'fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
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
        return $this->apiClientHandler("CustomObject", array('access_token' => $access_token, 'ObjectName' => $object_name, 'fields' => $fields));
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
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('access_token' => $access_token, 'ObjectName' => $object_name, 'fields' => $fields));
    }

    /**
     * Delete custom object using ObjectRecordId.
     *
     * @param $object_record_id
     * @return type
     */
    public function deleteCustomObjectSet($access_token, $object_name, $object_record_id, $fields = '*')
    {
        return $this->apiClientHandler("CustomObject/" . $object_record_id, array('access_token' => $access_token, 'ObjectName' => $object_name, 'fields' => $fields), array('method' => 'DELETE', 'post_data' => true));
    }

    /**
     * handle CustomObject APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $customize_options = array())
    {
        $options = array_merge(array('authentication' => 'key'), $customize_options);
        return Functions::apiClient("/identity/v2/auth/" . $path, $query_array, $options);
    }
}