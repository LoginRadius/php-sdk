<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AccountAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Management;

use LoginRadiusSDK\Utility\Functions;

/**
 * Account API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Account API.
 */
class CustomRegistrationDataAPI {

    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array()) {        
        new Functions($apikey, $apisecret, $customize_options);
    }

    /**
     * This API is create account.
     *
     * @param json $data
     * @return type
     * {
     * "Data": [
     *  {
     * "type": "",
     * "key": "",
     * "value": "",
     * "parentid": "",
     *  "code": "",
     *  "isactive": true
     *  }
     *  ]     
     * }
     */
    public function addRegistrationData($data, $fields = '*') {
        return $this->apiClientHandler("registrationdata", array('fields' => $fields), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to retrieve dropdown data.
     *
     * @param $type  
     * @param string $parentid    
     * @param string $skip    
     * @param string $limit    
     * @return type json object
     */
    public function getRegistrationData($type, $parent_id = '', $skip = '', $limit = '', $fields = '*') {
        return $this->apiClientHandler("registrationdata/" . $type, array('parentid' => $parent_id, 'skip' => $skip, 'limit' => $limit, 'fields' => $fields));
    }

    /**
     * This API allows you to update member of dropDown.
     * @param $recordid 
     * {
     * "IsActive": true,
     * "Type": "",
     * "Key": "",
     * "Value": "",
     * "ParentId": "",
     * "Code": ""
     * }
     *
     * return type
     */
    public function updateRegistrationData($recordid, $data, $fields = '*') {
        return $this->apiClientHandler("registrationdata/" . $recordid, array('fields' => $fields), array('method' => 'put', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API allows you to delete a member from dropDownList.
     * @param $recordid    
     *
     * return {"IsDeleted": "true"}
     */
    public function deleteRegistrationData($recordid, $fields = '*') {
        return $this->apiClientHandler('registrationdata/' . $recordid, array('fields' => $fields), array('method' => 'delete', 'post_data' => true));
    }

    /**
     * handle account APIs
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $customize_options = array()) {
        $options = array_merge(array('authentication' => 'secret'), $customize_options);
        return Functions::apiClient("/identity/v2/manage/" . $path, $query_array, $options);
    }

}