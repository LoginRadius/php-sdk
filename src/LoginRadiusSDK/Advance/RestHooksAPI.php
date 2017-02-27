<?php
/**
 * @link                : http://www.loginradius.com
 * @category            : Advance
 * @package             : UserAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Advance;

use LoginRadiusSDK\Utility\Functions;

/**
 * Class UserAPI
 *
 * This is the main class to communicate with User APIs.
 */
class RestHooksAPI
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
     * This API allows you to query your LoginRadius Cloud Storage and retrieve up to 20 user records.
     *
     * @param $select Fields included in the Query, default all fields (optional)
     * @param $from  LoginRadius Table that details are being retrieved from, for now users only supported by this API. (example: users)
     * @param $where Filter for data based on condition. (optional)
     * @param string $orderby Determines ascending order of returned data,(optional)
     * @param string $skip Ignores the specified amount of values used to page through responses, value must be positive and default value is 0. (optional)
     * @param string $limit Determines size of dataset returned. default value is 20 and max value is 20 (optional)
     * @return type
     */
    public function userList($from = 'users', $select = '', $where = '', $orderby = '', $skip = '', $limit = '')
    {
        $data = array('select' => $select, 'from' => $from, 'where' => $where , 'orderby' => $orderby, 'skip' => $skip, 'limit' => $limit);
        return $this->apiClientHandler('identity', array('key'=> Functions::getApiKey(), 'secret' => Functions::getApiSecret()), array('method' => 'post', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }

    /**
     * This API is used to query the aggregation data from your LoginRadius cloud storage.
     *
     * @param $from From Date
     * @param $to To Date
     * @param $first_data_point Aggregation Field
     * @param $stats_type Type of users should apply to
     * @return type
     */
    public function insights($from = '09/20/2015', $to = '09/20/2016', $first_data_point = 'provider', $stats_type = 'Login')
    {
        $data = array('firstDatapoint' => $first_data_point, 'statsType' => $stats_type);
        return $this->apiClientHandler('insights', array('from' => $from, 'to' => $to), array('method' => 'post', 'post_data' => json_encode($data), 'content_type' => 'json'));
    }
    
    /**
     * Test RestHooks settings on your LoginRadius site.
     * @return type
     */
    public function restHooksSettings()
    {
        return $this->apiClientHandler('resthook/test', array('api_key' => Functions::getApiKey(), 'api_secret' => Functions::getApiSecret()));
    }
    
    /**
     * Get list of fields which are available on your LoginRadius for RestHook
     * @return type
     */
    public function fieldList()
    {
        return $this->apiClientHandler('resthook/fields', array('api_key' => Functions::getApiKey(), 'api_secret' => Functions::getApiSecret()));
    }
    

    /**
     * This API retrieves all of the Urls subscribed to a given RESTHook event
     *
     * @param string $event
     * @return type
     */
    public function getRestHooksSubscribedUrls($event = 'login')
    {

        return $this->apiClientHandler('resthook/subscription', array('api_key' => Functions::getApiKey(), 'api_secret' => Functions::getApiSecret(), 'event' => $event));
    }

    /**
     * This API allow you to subscribe RestHook on your LoginRadius site.
     *
     * @param $target_url //URL where trigger will send data when it invoke
     * @param $event //Name of event, login or register are two events allowed
     * @return type
     */
    public function subscribeRestHooks($target_url, $event = 'login')
    {

        return $this->apiClientHandler('resthook/subscribe', array('api_key' => Functions::getApiKey(), 'api_secret' => Functions::getApiSecret()), array('method' => 'post', 'post_data' => json_encode(array('target_url' => $target_url, 'event' => $event)), 'content_type' => 'json'));
    }

    /**
     * This API allow you to unsubscribe RestHook on your LoginRadius site.
     *
     * @param $target_url //URL where trigger will send data when it invoke
     * @return type 
     */
    public function unsubscribeRestHooks($target_url)
    {

        return $this->apiClientHandler('resthook/unsubscribe', array('api_key' => Functions::getApiKey(), 'api_secret' => Functions::getApiSecret()), array('method' => 'post', 'post_data' => json_encode(array('target_url' => $target_url)), 'content_type' => 'json'));
    }


    /**
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $options = array())
    {
        return Functions::apiClient("/api/v2/" . $path, $query_array, $options);
    }
}
