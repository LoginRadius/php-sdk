<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : CustomObjectAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Management;

use LoginRadiusSDK\Utility\Functions;

/**
 * Class CustomObjectAPI
 *
 * This is the main class to communicate with LoginRadius Custom Object APIs.
 */
class CustomObjectAPI
{

    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {
        $options = array_merge(array('authentication' => 'secret'), $customize_options);
        new Functions($apikey, $apisecret, $options);
    }

    /**
     * This API is used to create custom objects.
     *
     * @param $uid='xxxxxx';//// UID, the identifier for each user account
     * @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
     * @param $data='{"objectdata":"field1"}';
     * @return type
     */
    public function insert($uid, $object_name, $data, $fields = '*')
    {
        return $this->apiClientHandler($uid . '/customObject/', array('ObjectName' => $object_name, 'fields' => $fields), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to retrieve the Custom Object for the specified account based on the account ID(UID).
     *
     * @param $uid='xxxxxx';//// UID, the identifier for each user account
     * @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
     * @return type
     */
    public function getObjectByAccountid($uid, $object_name, $fields = '*')
    {
        return $this->apiClientHandler($uid . '/customObject/', array('ObjectName' => $object_name, 'fields' => $fields));
    }

    /**
     * This API is used to update  the Custom Object for the specified account based on the record ID($object_record_id).
     *
     * @param $uid='xxxxxx';//// UID, the identifier for each user account
     * @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
     * @param $object_record_id='xxxxxxxxx';//Unique identifier of the user's record in Custom Object
     * @param $update_type='xxxxxxxxx';
     * @param $data='{
     * "field1": "Store my field1 value",
     * "field2": "Store my field2 value"
     * }';
     * @return type
     */
    public function updateObjectByRecordID($uid, $object_name, $object_record_id, $update_type, $data, $fields = '*')
    {
        return $this->apiClientHandler($uid . '/customObject/' . $object_record_id, array('ObjectName' => $object_name, 'updatetype'=> $update_type, 'fields' => $fields), array('method' => 'put', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to retrieve the Custom Object for the specified account based on the record ID($object_record_id).
     *
     * @param $uid='xxxxxx';//// UID, the identifier for each user account
     * @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
     * @param $object_record_id='xxxxxxxxx';//Unique identifier of the user's record in Custom Object
     * @return type
     */
    public function getObjectByRecordID($uid, $object_name, $object_record_id, $fields = '*')
    {
        return $this->apiClientHandler($uid . '/customObject/' . $object_record_id, array('ObjectName' => $object_name, 'fields' => $fields));
    }

    /**
     * This API is used to remove the specified Custom Object based on the account ID(UID).
     *
     * @param $uid='xxxxxx';//// UID, the identifier for each user account
     * @param $object_name= 'xxxxxxxxxxxx';//LoginRadius Custom Object name
     * @param $object_record_id='xxxxxxxxx';//Unique identifier of the user's record in Custom Object
     * @return type
     */
    public function delete($uid, $object_name, $object_record_id, $fields = '*')
    {
        return $this->apiClientHandler($uid . '/customObject/' . $object_record_id, array('ObjectName' => $object_name, 'fields' => $fields), array('method' => 'delete', 'post_data' => true));
    }

    /**
     * Custom Object API handler
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $options = array())
    {
        return Functions::apiClient("/identity/v2/manage/account/" . $path, $query_array, $options);
    }
}
