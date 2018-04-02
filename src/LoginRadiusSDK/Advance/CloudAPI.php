<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : ProvidersAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */


namespace LoginRadiusSDK\Advance;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

/**
 * Class for GetProvidersAPI
 *
 * This is the main class to communicate with LoginRadius to get Social Login Providers.
 */
class CloudAPI
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
     * LoginRadius function - To fetch options enabled on dashboard
     *
     * @param string $apikey data to validate.
     *
     * @return object options/error messages.
     *
     * try {
     *   $response = $cloudObject->getConfigurationList();
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    public function getConfigurationList()
    {
        $options = array('authentication' => 'key');
        $url = LR_CLOUD_ENDPOINT . "/ciam/appInfo";
        return Functions::apiClient($url, '', $options);
    }
    
     /**
     * LoginRadius function -  allows you to query your LoginRadius Cloud Storage.
     *
     * @param string $apikey and $apisecret data to validate.
     *
     * @return object options/error messages.
     *
     * try {
     *   $response = $cloudObject->getUserIdentity($data);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    public function getUserIdentity($data)
    {
        return $this->apiClientHandler("/identity", array(), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }
    
    /**
     * LoginRadius function -  allows you to get subsequent batchs of results after calling the initial POST user Identity API
     *
     * @param string $apikey and $apisecret data to validate.
     *
     * @return object options/error messages.
     *
     * try {
     *   $response = $cloudObject->getUserIdentity($data);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    public function getIdentityPagination($next)
    {
        return $this->apiClientHandler("/identity", array('next' => $next));
    }
    
    /**
     * LoginRadius function -   allows you to query your LoginRadius Cloud Storage.
     *
     * @param string $apikey and $apisecret data to validate.
     *
     * @return object options/error messages.
     *
     * try {
     *   $response = $cloudObject->getCustomObject($customObjectName,$data);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    
    public function getCustomObject($customObjectName,$data)
    {
        return $this->apiClientHandler("/customobject", array('customObject' => $customObjectName), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }
    
     /**
     * LoginRadius function -   allows you to get subsequent batchs of results after calling the initial POST Custom Object API
     *
     * @param string $apikey and $apisecret data to validate.
     *
     * @return object options/error messages.
     *
     * try {
     *   $response = $cloudObject->getCustomObjectPagination($customObjectName,$next);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    
    public function getCustomObjectPagination($customObjectName,$next)
    {
        return $this->apiClientHandler("/customobject", array('customObject' => $customObjectName,'next' => $next));
    }
    
    
    
    private function apiClientHandler($path, $query_array = array(), $customize_options = array()) {
        $options = array_merge(array('authentication' => 'secret'), $customize_options);
        $url = LR_CLD_STORAGE_ENDPOINT;
        return Functions::apiClient($url.$path, $query_array, $options);
    }
    
}
