<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : AdvanceSocialLoginAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Social;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

/**
 * Class for AdvanceSocialLoginAPI.
 *
 * This is the main class to communicate with LoginRadius Unified Advance Social API.
 */
class AdvanceSocialLoginAPI
{

    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {
        $options = array_merge(array('authentication' => true), $customize_options);
        new Functions($apikey, $apisecret, $options);
    }

    /**
     * Get LoginRadius Access token by Passing Facebook token
     *
     * @param $fb_access_token
     * @return type
     */
    public function getAccessTokenByPassingFacebookToken($fb_access_token)
    {
        return $this->apiClientHandler('access_token/facebook', array("key" => Functions::getApiKey(), "fb_access_token" => $fb_access_token));
    }

    /**
     * Get LoginRadius Access token by Passing Twitter token
     *
     * @param $tw_access_token
     * @param $tw_token_secret
     * @return type
     */
    public function getAccessTokenByPassingTwitterToken($tw_access_token, $tw_token_secret)
    {
        return $this->apiClientHandler('access_token/twitter', array("key" => Functions::getApiKey(), "tw_access_token" => $tw_access_token, 'tw_token_secret' => $tw_token_secret));
    }

    /**
     * The User Profile API is used to get the latest updated social profile data from the user’s social account after authentication.
     * The social profile will be retrieved via oAuth and OpenID protocols.
     * The data is normalized into LoginRadius’ standard data format.
     * This API should be called using the access token retrieved from the refresh access token API.
     *
     * @param $access_token
     * @return type
     */
    public function refreshUserProfile($access_token)
    {
        return $this->apiClientHandler('userprofile/refresh', array('access_token' => $access_token));
    }
    /**
     * The Refresh Access Token API is used to refresh the provider access token after authentication.
     * It will be valid for 60 days on LoginRadius' side but it also depends on the provider side.
     * In order to use the access token in other APIs always refresh the token with this API.
     * Supported Providers : Facebook,Yahoo,Google,Twitter, Linkedin Contact LoginRadius support team to enable this API.
     *
     * @param $access_token
     * @return type
     */
    public function refreshAccessToken($access_token)
    {
        return $this->apiClientHandler('access_token/refresh', array('access_token' => $access_token, "secret" => Functions::getApiSecret()));
    }


    /**
     * This API is used to retrieve a tracked post based on the passed in post ID value. This API requires setting permissions in your LoginRadius Dashboard.
     *
     * @param $postid
     * @return type
     */
    public function trackableStatus($postid)
    {
        return $this->apiClientHandler('status/trackable', array('postid' => $postid, "secret" => Functions::getApiSecret()));
    }

    /**
     * The Message API is used to post messages to the user’s contacts. Supported Providers: LinkedIn, Twitter.
     *
     * @param $access_token
     * @param $to
     * @param $subject
     * @param $message
     * @return type
     */
    public function postMessage($access_token, $to, $subject, $message)
    {
        return $this->apiClientHandler('message/js', array('access_token' => $access_token, "to" => $to, 'subject' => $subject, 'message' => $message));
    }
    /**
     * The Status API is used to update the status on the user’s wall. It is commonly referred to as Permission based sharing or Push notifications. 
     * This API requires setting permissions in your LoginRadius Dashboard.
     *
     * @param $access_token
     * @param $title
     * @param $url
     * @param $imageurl
     * @param $status
     * @param $caption
     * @param $description
     * @return type
     */
    public function postStatus($access_token, $status, $title = '', $url = '', $imageurl = '', $caption = '', $description = '')
    {
        return $this->apiClientHandler('status/js', array('access_token' => $access_token, "title" => $title, 'url' => $url, 'imageurl' => $imageurl, 'status' => $status, 'caption' => $caption, 'description' => $description));
    }

        /**
     * The Shorten URL API is used to convert your URLs to the LoginRadius short URL - ish.re
     *
     * @param $url
     * @return type
     */
    public function shortenUrl($url)
    {
        return Functions::apiClient('/sharing/v1/shorturl/', array('key' => Functions::getApiKey(), "url" => $url));
    }

        /**
     * The Trackable status API works very similar to the Status API but it returns a Post id that you can use to track the stats(shares, likes, comments) for a specific share/post/status update.
     * This API requires setting permissions in your LoginRadius Dashboard.
     *
     * @param $access_token
     * @param $title
     * @param $url
     * @param $imageurl
     * @param $status
     * @param $caption
     * @param $description
     * @return type
     */
    public function trackableStatusStats($access_token, $status, $title = '', $url = '', $imageurl = '', $caption = '', $description = '')
    {
        return $this->apiClientHandler('status/trackable/js', array('access_token' => $access_token, "title" => $title, 'url' => $url, 'imageurl' => $imageurl, 'status' => $status, 'caption' => $caption, 'description' => $description));
    }
    /**
     * The Trackable Status API is used to update the status on the user’s wall and return an Post ID value. It is commonly referred to as Permission based sharing or Push notifications.
     *
     * @param $access_token
     * @param $title
     * @param $url
     * @param $imageurl
     * @param $status
     * @param $caption
     * @param $description
     * @return type
     */
    public function trackableStatusPosting($access_token, $status, $title = '', $url = '', $imageurl = '', $caption = '', $description = '')
    {
        $data = array(
            'title' => $title,
            'url' => $url,
            'imageurl' => $imageurl,
            'status' => $status,
            'caption' => $caption,
            'description' => $description
        );
        return $this->apiClientHandler("status/trackable", array('access_token' => $access_token), array('method' => 'post', 'post_data' => json_encode($data), 'content_type' => 'json'));
  
    }


    /**
     * Social API handler
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
