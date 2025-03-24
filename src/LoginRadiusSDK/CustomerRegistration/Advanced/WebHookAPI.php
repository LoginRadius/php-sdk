<?php
 /**
 * @category            : CustomerRegistration
 * @link                : http://www.loginradius.com
 * @package             : WebHookAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Advanced;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

class WebHookAPI extends Functions
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }
       


    /**
     * This API is used to get details of a webhook subscription by Id
     * @param hookId Unique ID of the webhook
     * @return Response containing Definition for Complete WebHook data
     * 40.1
    */

    public function getWebhookSubscriptionDetail($hookId)
    {
        $resourcePath = "/v2/manage/webhooks/$hookId";
        $queryParam = [];
        $queryParam['apikey'] = Functions::getApiKey();
        $queryParam['apisecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to create a new webhook subscription on your LoginRadius site.
     * @param webHookSubscribeModel Model Class containing Definition of payload for Webhook Subscribe API
     * @return Response containing Definition for Complete WebHook data
     * 40.2
    */

    public function createWebhookSubscription($webHookSubscribeModel)
    {
        $resourcePath = "/v2/manage/webhooks";
        $queryParam = [];
        $queryParam['apikey'] = Functions::getApiKey();
        $queryParam['apisecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('POST', $resourcePath, $queryParam, $webHookSubscribeModel);
    }
       


    /**
     * This API is used to delete webhook subscription
     * @param hookId Unique ID of the webhook
     * @return Response containing Definition of Delete Request
     * 40.3
    */

    public function deleteWebhookSubscription($hookId)
    {
        $resourcePath = "/v2/manage/webhooks/$hookId";
        $queryParam = [];
        $queryParam['apikey'] = Functions::getApiKey();
        $queryParam['apisecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('DELETE', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to update a webhook subscription
     * @param hookId Unique ID of the webhook
     * @param webHookSubscriptionUpdateModel Model Class containing Definition for WebHookSubscriptionUpdateModel Property
     * @return Response containing Definition for Complete WebHook data
     * 40.4
    */

    public function updateWebhookSubscription($hookId, $webHookSubscriptionUpdateModel)
    {
        $resourcePath = "/v2/manage/webhooks/$hookId";
        $queryParam = [];
        $queryParam['apikey'] = Functions::getApiKey();
        $queryParam['apisecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('PUT', $resourcePath, $queryParam, $webHookSubscriptionUpdateModel);
    }
       


    /**
     * This API is used to get the list of all the webhooks
     * @return Response Containing List of Webhhook Data
     * 40.5
    */

    public function listAllWebhooks()
    {
        $resourcePath = "/v2/manage/webhooks";
        $queryParam = [];
        $queryParam['apikey'] = Functions::getApiKey();
        $queryParam['apisecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to retrieve all the webhook events.
     * @return Model Class containing Definition for WebHookEventModel Property
     * 40.6
    */

    public function getWebhookEvents()
    {
        $resourcePath = "/v2/manage/webhooks/events";
        $queryParam = [];
        $queryParam['apikey'] = Functions::getApiKey();
        $queryParam['apisecret'] = Functions::getApiSecret();
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }

}