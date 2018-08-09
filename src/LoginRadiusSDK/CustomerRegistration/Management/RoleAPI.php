<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : RoleAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Management;

use LoginRadiusSDK\Utility\Functions;

/**
 * Role API
 *
 * This is the main class to communicate with LoginRadius Customer Registration Role API.
 */
class RoleAPI {

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
     * Get Role of customer.
     *
     * @return type
     */
    public function get($fields = '*') {
        return $this->apiClientHandler("role", array('fields' => $fields));
    }

    /**
     * Get Context with Roles and Permissions.
     *
     * @param $uid = xxxxxxxxxxxxxxxxxxxxx;
     *
     * @return type
     */
    public function getContext($uid, $fields = '*') {
        return $this->apiClientHandler("account/" . $uid . "/rolecontext", array('fields' => $fields));
    }

    /**
     * Add/Update Roles Context.
     *
     * @param $uid = xxxxxxxxxxxxxxxxxxxxx;
     * @param $rolesContext Json data
     *
     * {
     * "RoleContext": [
     * {
     * "Context": "Home",
     * "Roles": ["admin","user"],
     * "AdditionalPermissions": ["X","Y","Z"]
     * },
     * {
     * "Context": "Work",
     * "Roles": ["admin"],
     * "AdditionalPermissions": ["X","Y","Z"]
     *  }
     *  ]
     *  }
     * @return type
     */
    public function upsertContext($uid, $rolesContext, $fields = '*') {
        return $this->apiClientHandler("account/" . $uid . "/rolecontext", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $rolesContext, 'content_type' => 'json'));
    }

    /**
     * Delete Roles Context by Role Context Name
     *
     * @param $uid = xxxxxxxxxxxxxxxxxxxxx;
     * @param $roleContextName String data
     * @return type
     */
    public function deleteContextbyContextName($uid, $roleContextName, $fields = '*') {
        return $this->apiClientHandler("account/" . $uid . "/rolecontext/" . $roleContextName, array('fields' => $fields), array('method' => 'DELETE', 'post_data' => true));
    }    
    /**
     * Delete Roles From Context
     * @param type $uid
     * @param type $roles
     * {
     * "Role" : ["admin"]
     * }
     * @return type
     */
    public function deleteRoleFromContext($uid, $roleContextName, $roles, $fields = '*') {
        return $this->apiClientHandler("account/" . $uid . "/rolecontext/" . $roleContextName. "/role", array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $roles, 'content_type' => 'json'));
    }
    /**
     * Delete Additional Permission by Role Context Name
     * 
     * @param type $uid
     * @param type $roleContextName
     * @param type $additionalPermission Json data
     * * {
     * "AdditionalPermissions": ["X"]
     * }
     * @return type
     */
    public function deleteAdditionalPermissionFromContext($uid, $roleContextName, $additionalPermission, $fields = '*') {
        return $this->apiClientHandler("account/" . $uid . "/rolecontext/" . $roleContextName. "/additionalpermission", array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $additionalPermission, 'content_type' => 'json'));
    }

    /**
     * Create Roles.
     *
     * @param $roles json data
     *
     * {
     * "Roles":[
     *   {
     *     "Name":"Administrator",
     *   "Permissions":{
     *     "Edit":true,
     *     "Manage":true
     *    }
     *  }
     * ]
     * }

     * @return type
     */
    public function create($roles, $fields = '*') {
        return $this->apiClientHandler("role", array('fields' => $fields), array('method' => 'POST', 'post_data' => $roles, 'content_type' => 'json'));
    }

    /**
     * Delete role.
     *
     * $role = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'; //Name of Role
     *
     * return {�IsDeleted� : true}
     */
    public function delete($role, $fields = '*') {
        return $this->apiClientHandler('role/' . $role, array('fields' => $fields), array('method' => 'delete', 'post_data' => true));
    }

    /**
     * This API is used to add permission to role..
     *
     * $role = 'xxxxxx'; // role name
     * $permissions = {
     * �Permissions� :[
     * {�Permission� : true},
     * {�Permission� : true}
     * ]
     * }
     *
     * return {�isPosted�: �true�}
     */
    public function addPermission($role, $permissions, $fields = '*') {
        return $this->apiClientHandler("role/" . $role . "/permission", array('fields' => $fields), array('method' => 'PUT', 'post_data' => $permissions, 'content_type' => 'json'));
    }

    /**
     * This API is used to remove permission to role.
     *
     * $role = 'xxxxxx'; // role name
     * $permissions = {
     * �Permissions� :[
     * {�Permission� : true},
     * {�Permission� : true}
     * ]
     * }
     *
     * return { �Name� : �<name of role>�,�Permissions� :[{�Permission� : true},{�Permission� : true}]}
     */
    public function removePermission($role, $permissions, $fields = '*') {
        return $this->apiClientHandler('role/' . $role . '/permission', array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $permissions, 'content_type' => 'json'));
    }

    /**
     * Get Account Role by uid.
     *
     * @param $uid
     * @return type
     */
    public function getAccountRolesByUid($uid, $fields = '*') {
        return $this->apiClientHandler('account/' . $uid . '/role', array('fields' => $fields));
    }

    /**
     * Insert role to account.
     *
     * @param $uid
     * @param $data = {�Roles� : [�Role1�,�Role2�]}
     * @return type
     */
    public function assignRolesByUid($uid, $data, $fields = '*') {
        return $this->apiClientHandler('account/' . $uid . '/role', array('fields' => $fields), array('method' => 'PUT', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * Delete role.
     *
     * @param $uid
     * @param $data = {�Roles� : [�Role1�,�Role2�]}
     * @return type
     */
    public function deleteAccountRoles($uid, $data, $fields = '*') {
        return $this->apiClientHandler('account/' . $uid . '/role', array('fields' => $fields), array('method' => 'DELETE', 'post_data' => $data, 'content_type' => 'json'));
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
