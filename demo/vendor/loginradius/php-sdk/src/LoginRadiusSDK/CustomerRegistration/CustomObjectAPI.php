<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : CustomObjectAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration;

use LoginRadiusSDK\LoginRadius;

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
        $options = array_merge(array('authentication'=>true),$customize_options);
        new LoginRadius($apikey, $apisecret, $options);
    }

    /**
     * This API is used to retrieve all of the custom objects by account ID (UID).
     *
     * $objectId = 'xxxxxxxxxxxx',
     * $accountId = 'xxxxxxxxxxxx'
     *
     * return all custom field
     * {
     *     "Id": "53e31d61164ff214a0814327",
     *     "IsActive": true,
     *     "DateCreated": "2014-08-07T06:32:01.016Z",
     *     "DateModified": "2014-08-07T09:09:21.08Z",
     *     "IsDeleted": true,
     *     "Uid": "676d5049aba24314b8a5c5af1b80c0cb",
     *     "CustomObject": {
     *         "Id": "53e30b2c164ff114a044f3f4",
     *         "IsActive": true,
     *         "DateCreated": "2014-08-07T05: 14: 20.573Z",
     *         "DateModified": "2014-08-07T05: 14: 20.573Z",
     *         "IsDeleted": false,
     *         "Uid": "81ef41c461aa4a5eacba0a06f10c1481",
     *         "CustomObject": {
     *             "Industry": "chemical",
     *             "website": "http: //localhost23423423",
     *             "lastname": "",
     *             "RelationshipStatus": "married",
     *             "customfield1": {
     *                 "field1": "1",
     *                 "field2": "2",
     *                 "field5": "5",
     *                 "field6": "6"
     *             }
     *         }
     *     }
     * }
     *
     */
    public function getObjectByAccountid($object_id, $account_id)
    {
        return $this->apiClientHandler('', array('objectid' => $object_id, 'accountid' => $account_id));
    }

    /**
     * This API is used to retrieve all of the custom objects via a list of account IDs(UID) separated by , (Max 20).
     *
     * $objectId = 'xxxxxxxxxxxx';
     * $accountIds = 'xxxxxxxxxxxx,xxxxxxxxxxxx,xxxxxxxxxxxx';
     *
     * return all custom field
     * [{
     *     "Id": "53e31d61164ff214a0814327",
     *     "IsActive": true,
     *     "DateCreated": "2014-08-07T06:32:01.016Z",
     *     "DateModified": "2014-08-07T09:09:21.08Z",
     *     "IsDeleted": true,
     *     "Uid": "676d5049aba24314b8a5c5af1b80c0cb",
     *     "CustomObject": {
     *         "Id": "53e30b2c164ff114a044f3f4",
     *         "IsActive": true,
     *         "DateCreated": "2014-08-07T05: 14: 20.573Z",
     *         "DateModified": "2014-08-07T05: 14: 20.573Z",
     *         "IsDeleted": false,     *
     *         "Uid": "81ef41c461aa4a5eacba0a06f10c1481",
     *         "CustomObject": {
     *             "Industry": "chemical",
     *             "website": "http: //localhost23423423",
     *             "lastname": "",     *
     *             "RelationshipStatus": "married",
     *             "customfield1": {
     *                 "field1": "1",
     *                 "field2": "2",
     *                 "field5": "5",
     *                 "field6": "6"
     *             }
     *         }
     *     }
     * },
     * {
     *     "Id": "53e31d61164ff214a0814327",
     *     "IsActive": true,
     *     "DateCreated": "2014-08-07T06:32:01.016Z",
     *     "DateModified": "2014-08-07T09:09:21.08Z",
     *     "IsDeleted": true,
     *     "Uid": "676d5049aba24314b8a5c5af1b80c0cb",
     *     "CustomObject": {
     *         "Id": "53e30b2c164ff114a044f3f4",
     *         "IsActive": true,
     *         "DateCreated": "2014-08-07T05: 14: 20.573Z",
     *         "DateModified": "2014-08-07T05: 14: 20.573Z",
     *         "IsDeleted": false,
     *         "Uid": "81ef41c461aa4a5eacba0a06f10c1481",
     *         "CustomObject": {
     *             "Industry": "chemical",
     *             "website": "http: //localhost23423423",
     *             "lastname": "",
     *             "RelationshipStatus": "married",
     *             "customfield1": {
     *                 "field1": "1",
     *                 "field2": "2",
     *                 "field5": "5",
     *                 "field6": "6"
     *             }
     *         }
     *     }
     * }]
     *
     */
    public function getObjectByAccountIds($object_id, $account_ids)
    {
        return $this->apiClientHandler('', array('objectid' => $object_id, 'accountids' => $account_ids));
    }

    /**
     * This API is used to retrieve all of the custom objects by an object’s unique ID and filtered by a query
     *
     * $objectId = 'xxxxxxxxxx';
     * $query = "<Expression LogicalOperation='AND'>
     *              <Field Name='Provider' ComparisonOperator='Equal'>facebook</Field>
     *              <Expression LogicalOperation='OR'>
     *                  <Field Name='Gender' ComparisonOperator='Equal'>M</Field>
     *                  <Field Name='Gender' ComparisonOperator='Equal'>U</Field>
     *              </Expression>
     *          </Expression>";
     * ------------------ OR ------------------
     * $query = "<Field Name='Gender' ComparisonOperator='Equal'>F</Field>";
     *
     * $nextCursor=>[1]; (optional)
     * );
     *
     * return all custom field
     * {
     *     "Id": "53e31d61164ff214a0814327",
     *     "IsActive": true,
     *     "DateCreated": "2014-08-07T06:32:01.016Z",
     *     "DateModified": "2014-08-07T09:09:21.08Z",
     *     "IsDeleted": true,
     *     "Uid": "676d5049aba24314b8a5c5af1b80c0cb",
     *     "CustomObject": {
     *         "Id": "53e30b2c164ff114a044f3f4",
     *         "IsActive": true,
     *         "DateCreated": "2014-08-07T05: 14: 20.573Z",
     *         "DateModified": "2014-08-07T05: 14: 20.573Z",
     *         "IsDeleted": false,
     *         "Uid": "81ef41c461aa4a5eacba0a06f10c1481",
     *         "CustomObject": {
     *             "Industry": "chemical",
     *             "website": "http: //localhost23423423",
     *             "lastname": "",
     *             "RelationshipStatus": "married",
     *             "customfield1": {
     *                 "field1": "1",
     *                 "field2": "2",
     *                 "field5": "5",
     *                 "field6": "6"
     *             }
     *         }
     *     }
     * }
     */
    public function getObjectByQuery($object_id, $query, $next_cursor = 1)
    {
        return $this->apiClientHandler('', array('objectid' => $object_id, 'q' => $query, 'cursor' => $next_cursor));
    }

    /**
     * This API is used to retrieve all records from a custom object.
     *
     * $obejctId = 'xxxxxxxxxx';
     * $nextCursor = [1]; (optional)
     *
     * return
     * {
     *     "Id": "53e31d61164ff214a0814327",
     *     "IsActive": true,
     *     "DateCreated": "2014-08-07T06:32:01.016Z",
     *     "DateModified": "2014-08-07T09:09:21.08Z",
     *     "IsDeleted": true,
     *     "Uid": "676d5049aba24314b8a5c5af1b80c0cb",
     *     "CustomObject": {
     *         "Id": "53e30b2c164ff114a044f3f4",
     *         "IsActive": true,
     *         "DateCreated": "2014-08-07T05: 14: 20.573Z",
     *         "DateModified": "2014-08-07T05: 14: 20.573Z",
     *         "IsDeleted": false,
     *         "Uid": "81ef41c461aa4a5eacba0a06f10c1481",
     *         "CustomObject": {
     *             "Industry": "chemical",
     *             "website": "http: //localhost23423423",
     *             "lastname": "",
     *             "RelationshipStatus": "married",
     *             "customfield1": {
     *                 "field1": "1",
     *                 "field2": "2",
     *                 "field5": "5",
     *                 "field6": "6"
     *             }
     *         }
     *     }
     * }
     */
    public function getAllObjects($object_id, $next_cursor = 1)
    {
        return $this->apiClientHandler('', array('objectid' => $object_id, 'cursor' => $next_cursor));
    }

    /**
     * This API is used to retrieve stats associated with a custom object
     *
     * $objectId = 'xxxxxxxxxx';
     *
     * return
     * {
     *     "TotalUsedMemory": 0.01,
     *     "RemainingMemory": 9.99,
     *     "TotalRecords": 7
     * }
     *
     */
    public function getStats($object_id)
    {
        return $this->apiClientHandler('stats', array('objectid' => $object_id));
    }

    /**
     * This API is used to save custom objects, by providing ID of object, to a specified account if the object is not exist it will create a new object.
     *
     * $objectId = 'xxxxxxxxxx';
     * $accountId = 'xxxxxxxxxx';
     * $data = array(
     *  firstname => 'first name',
     *  lastname => 'last name',
     *  gender => 'm',
     *  birthdate => 'MM-DD-YYYY',
     *  ....................
     *  ....................
     * );
     *
     * return { “isPosted�? : true }
     */
    public function upsert($object_id, $account_id, $data)
    {
        return $this->apiClientHandler("upsert", array('objectid' => $object_id, 'accountid' => $account_id), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to block Custom Object.
     *
     * $objectId = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
     * $accountId = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
     * $action = true/false(boolean)
     *
     * return { “isPosted�? : true }
     */
    public function setStatus($object_id, $account_id, $action = true)
    {
        return $this->apiClientHandler("status", array('objectid' => $object_id, 'accountid' => $account_id), array('method' => 'post', 'post_data' => array('isblock' => $action), 'content_type' => 'json'));
    }

    /**
     * This API is used to check the existence of a custom object under an account id.
     *
     * $objectId = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
     * $accountId = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
     *
     * return { "IsExists" : true }
     */
    public function checkObject($object_id, $account_id)
    {
        return $this->apiClientHandler("check", array('objectid' => $object_id, 'accountid' => $account_id));
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
        return LoginRadius::apiClient("/raas/v1/user/customObject/" . $path, $query_array, $options);
    }

}
