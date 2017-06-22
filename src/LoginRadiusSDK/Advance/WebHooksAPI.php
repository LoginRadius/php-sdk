<?php
/**
 * @link                : http://www.loginradius.com
 * @category            : Advance
 * @package             : WebHooksAPI
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
class WebHooksAPI
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
     * Test WebHooks settings on your LoginRadius site.
     * @return type
     */
    public function webHooksSettings()
    {
        return $this->apiClientHandler('webhook/test', array('apikey' => Functions::getApiKey(), 'apisecret' => Functions::getApiSecret()));
    }
    
     /**
     * This API allow you to subscribe WebHook on your LoginRadius site.
     *
     * @param $target_url //URL where trigger will send data when it invoke
     * @param $event //Name of event, Login, Register, UpdateProfile, ResetPassword, ChangePassword, emailVerification, AddEmail, RemoveEmail, BlockAccount, DeleteAccount, SetUsername, CreateTraditionalAccount, AssignRoles, UnassignRoles, SetPassword, LinkAccount, UnlinkAccount, UpdatePhoneId, VerifyPhoneNumber
     * @return type
     */
    public function subscribeWebHooks($target_url, $event = 'Login')
    {
        return $this->apiClientHandler('webhook', array('apikey' => Functions::getApiKey(), 'apisecret' => Functions::getApiSecret()), array('method' => 'post', 'post_data' => json_encode(array('TargetUrl' => $target_url, 'Event' => $event)), 'content_type' => 'json'));
    }
    

    /**
     * This API retrieves all of the Urls subscribed to a given WebHook event
     *
     * @param string $event
     * @return type
     */
    public function getWebHooksSubscribedUrls($event = 'Login')
    {
        return $this->apiClientHandler('webhook', array('apikey' => Functions::getApiKey(), 'apisecret' => Functions::getApiSecret(), 'event' => $event));
    }
   

    /**
     * This API allow you to unsubscribe WebHook on your LoginRadius site.
     *
     * @param $target_url //URL where trigger will send data when it invoke
     * @return type 
     */
    public function unsubscribeWebHooks($target_url, $event = 'Login')
    {
        return $this->apiClientHandler('webhook', array('apikey' => Functions::getApiKey(), 'apisecret' => Functions::getApiSecret()), array('method' => 'delete', 'post_data' => json_encode(array('TargetUrl' => $target_url, 'Event' => $event)), 'content_type' => 'json'));
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
