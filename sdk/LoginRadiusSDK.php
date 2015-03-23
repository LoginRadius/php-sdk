<?php

// Define LoginRadius domain
define('LR_API_ENDPOINT', 'https://api.loginradius.com/api/v2');

// Define LoginRadius CDN domain
define('LR_CDN_ENDPOINT', 'https://cdn.loginradius.com');

/**
 * Class for Social Authentication.
 *
 * This is the main class to communicate with LoginRadius Unified Social API. It contains functions for Social Authentication with User Profile Data (Basic and Extended)
 *
 * Copyright 2015 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */
class LoginRadius {

    /**
     * LoginRadius function - It validates against GUID format of keys.
     *
     * @param string $value data to validate.
     *
     * @return boolean If valid - true, else - false
     */
    private function loginradius_is_valid_guid($value) {
        return preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $value);
    }

    /**
     * LoginRadius function - Check, if it is a valid callback i.e. LoginRadius authentication token is set
     *
     * @return boolean true, if a valid callback.
     */
    public function loginradius_is_callback() {
        return isset($_REQUEST['token']) ? true : false;
    }

    /**
     *
     * LoginRadius function - Fetch LoginRadius access token after authentication. It will be valid for the specific duration of time specified in the response.
     * @deprecated use loginradius_exchange_access_token instead of this method
     *
     * @param string LoginRadius API Secret
     * @param boolean if true then return object with expiry time and token else only token
     *
     * @return mixed string|object LoginRadius access token.
     *
     * try{
     *   $accesstoken = $loginradiusObject->loginradius_fetch_access_token($secret);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_fetch_access_token($secret, $isAccessTokenObjectReturn = false) {

        if (empty($secret) || !$this->loginradius_is_valid_guid($secret)) {
            // Invalid API secret
            throw new LoginRadiusException('Invalid API secret');
        }

        $requestToken = '';
        if (isset($_REQUEST['token'])) {
            $requestToken = $_REQUEST['token'];
        } else {
            throw new LoginRadiusException('Request token require to access LoginRadius access token API');
        }

        $url = LR_API_ENDPOINT . "/access_token?token=" . $requestToken . "&secret=" . $secret;
        $response = json_decode($this->loginradius_api_client($url));


        if ($isAccessTokenObjectReturn) {
            return $response;
        }

        return $response->access_token;

    }

    /**
     *
     * LoginRadius function - Fetch LoginRadius access token after authentication. It will be valid for the specific duration of time specified in the response.
     * @param string LoginRadius API Secret
     * @param string LoginRadius API token
     *
     * @return mixed string|object LoginRadius access token.
     *
     * try{
     *   $accesstoken = $loginradiusObject->loginradius_exchange_access_token($secret);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_exchange_access_token($secret, $requestToken = false) {
        if (!$this->loginradius_is_valid_guid($secret)) {
            throw new LoginRadiusException('Invalid API secret');
        }

        if (!$requestToken) {
            if (isset($_REQUEST['token'])) {
                $requestToken = $_REQUEST['token'];
            } else {
                throw new LoginRadiusException('Request token require to access LoginRadius access token API');
            }
        }

        $url = LR_API_ENDPOINT . "/access_token?token=" . $requestToken . "&secret=" . $secret;
        return json_decode($this->loginradius_api_client($url));
    }

    /**
     * LoginRadius function - To fetch social login providers
     *
     * @param string $apikey data to validate.
     *
     * @return object Social Login Providers/error messages.
     *
     * try{
     *   $providers = $loginradiusObject->loginradius_get_providers($apikey);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     * }
     */
    public function loginradius_get_providers($apikey) {
        // Check for valid GUID format and not empty API Key
        if (empty($apikey) || !$this->loginradius_is_valid_guid($apikey)) {
            throw new LoginRadiusException('API Key is not valid');
        }

        $url = LR_CDN_ENDPOINT . "/interface/json/" . $apikey . ".json";

        // providers from API - string
        $response = $this->loginradius_api_client($url);

        $jsonResponse = explode('(', $response);

        if ($jsonResponse[0] == 'loginRadiusAppJsonLoaded') {
            $providers = str_replace(')', '', $jsonResponse[1]);
            return json_decode($providers, TRUE);
        }

        throw new LoginRadiusException('Error Retrieving Providers List');
    }

    /**
     * LoginRadius function - To fetch social profile data from the user's social account after authentication. The social profile will be retrieved via oAuth and OpenID protocols. The data is normalized into LoginRadius' standard data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw        If true, raw data is fetched
     *
     * @return object User profile data.
     *
     * try{
     *   $userProfileData = $loginradiusObject->loginradius_get_user_profiledata($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_user_profiledata($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/userprofile" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get the Albums data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object User's albums data.
     *
     * try{
     *   $photoAlbums = $loginradiusObject->loginradius_get_photo_albums($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_photo_albums($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/album" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To fetch photo data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param string $albumId ID of the album to fetch photos from
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object User's photo data.
     *
     * try{
     *   $photos = $loginradiusObject->loginradius_get_photos($accessToken, $albumId);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_photos($accessToken, $albumId, $raw = false) {
        $url = LR_API_ENDPOINT . "/photo" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken . "&albumid=" . $albumId;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To fetch check-ins data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object User's check-ins.
     *
     * try{
     *   $checkins = $loginradiusObject->loginradius_get_checkins($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_checkins($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/checkin" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To fetch user's audio files data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object User's audio files data.
     *
     * try{
     *   $audio = $loginradiusObject->loginradius_get_audio($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_audio($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/audio" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - Post messages to the user's contacts. After using the Contact API, you can send messages to the retrieved contacts.
     *
     * @param string $accessToken LoginRadius access token
     * @param string $to          Social ID of the receiver
     * @param string $subject     Subject of the message
     * @param string $message     Message
     *
     * @return bool True on success, false otherwise
     *
     * try{
     *  $result = $loginradiusObject->loginradius_send_message($accessToken, $to, $subject, $message);
     * }
     * catch (LoginRadiusException $e){
     *    $e->getMessage();
     *    $e->getErrorResponse();
     * }
     */
    public function loginradius_send_message($accessToken, $to, $subject, $message) {
        $url = LR_API_ENDPOINT . "/message?" . http_build_query(array(
                    'access_token' => $accessToken,
                    'to' => $to,
                    'subject' => $subject,
                    'message' => $message
        ));
        return json_decode($this->loginradius_api_client($url, true));
    }

    /**
     * LoginRadius function - To fetch user's contacts/friends/connections data from the user's social account. The data will normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param integer $nextCursor Offset to start fetching contacts from
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object User's contacts/friends/followers.
     *
     * try{
     *   $contacts = $loginradiusObject->loginradius_get_contacts($accessToken, $nextCursor);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_contacts($accessToken, $nextCursor = '', $raw = false) {
        $url = LR_API_ENDPOINT . "/contact" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken . "&nextcursor=" . $nextCursor;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get mention data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object User's twitter mentions.
     *
     * try{
     *   $mentions = $loginradiusObject->loginradius_get_mentions($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_mentions($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/mention" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To fetch information of the people, user is following on Twitter.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object Information of the people, user is following.
     *
     * try{
     *   $following = $loginradiusObject->loginradius_get_following($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_following($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/following" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get the event data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object User's event data.
     *
     * try{
     *   $events = $loginradiusObject->loginradius_get_events($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_events($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/event" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get posted messages from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object User's posted messages.
     *
     * try{
     *   $posts = $loginradiusObject->loginradius_get_posts($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_posts($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/post" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get the followed company's data in the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object Companies followed by user.
     *
     * try{
     *   $companies = $loginradiusObject->loginradius_get_followed_companies($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_followed_companies($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/company" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get group data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object Group data.
     *
     * try{
     *   $groups = $loginradiusObject->loginradius_get_groups($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_groups($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/group" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get the status messages from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object Status messages.
     *
     * try{
     *   $status = $loginradiusObject->loginradius_get_status($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_status($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/status" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To update the status on the user's wall.
     *
     * @param string $accessToken LoginRadius access token
     * @param string $title       Title for status message (Optional).
     * @param string $url         A web link of the status message (Optional).
     * @param string $imageurl    An image URL of the status message (Optional).
     * @param string $status      The status message text (Required).
     * @param string $caption     Caption of the status message (Optional).
     * @param string $description Description of the status message (Optional).
     *
     * @return boolean Returns true if successful, false otherwise.
     *
     * try{
     *  $result = $loginradiusObject->loginradius_post_status($accessToken, $title, $url, $imageurl, $status, $caption, $description);
     * }
     * catch (LoginRadiusException $e){
     *    $e->getMessage();
     *    $e->getErrorResponse();
     * }
     *
     */
    public function loginradius_post_status($accessToken, $title, $url, $imageurl, $status, $caption, $description) {
        $url = LR_API_ENDPOINT . "/status?" . http_build_query(array(
                    'access_token' => $accessToken,
                    'title' => $title,
                    'url' => $url,
                    'imageurl' => $imageurl,
                    'status' => $status,
                    'caption' => $caption,
                    'description' => $description
        ));
        return json_decode($this->loginradius_api_client($url, true));
    }

    /**
     * LoginRadius function - To get videos data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object Videos data.
     *
     * try{
     *   $videos = $loginradiusObject->loginradius_get_videos($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_videos($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/video" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get likes data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object likes data.
     *
     * try{
     *   $likes = $loginradiusObject->loginradius_get_likes($accessToken);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_likes($accessToken, $raw = false) {
        $url = LR_API_ENDPOINT . "/like" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To get the page data from the user's social account. The data will be normalized into LoginRadius' data format.
     *
     * @param string $accessToken LoginRadius access token
     * @param string $pageName Page name
     * @param boolean $raw If true, raw data is fetched
     *
     * @return object Page data.
     *
     * try{
     *   $pages = $loginradiusObject->loginradius_get_pages($accessToken, $pageName);
     * }
     * catch (LoginRadiusException $e){
     *   $e->getMessage();
     *   $e->getErrorResponse();
     * }
     */
    public function loginradius_get_pages($accessToken, $pageName, $raw = false) {
        $url = LR_API_ENDPOINT . "/page" . $this->loginradius_get_raw_data($raw) . "?access_token=" . $accessToken . "&pagename=" . $pageName;
        $result = $this->loginradius_api_client($url);
        return $raw ? $result : json_decode($result);
    }

    /**
     * LoginRadius function - To fetch data from the LoginRadius API URL.
     *
     * @param string $url Target URL to fetch data from.
     *
     * @return string Data fetched from the LoginRadius API.
     */
    private function loginradius_api_client($url, $post = false) {
        if (in_array('curl', get_loaded_extensions())) {
            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, $url);
            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 15);
            curl_setopt($curlHandle, CURLOPT_ENCODING, 'json');
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            if ($post) {
                curl_setopt($curlHandle, CURLOPT_POST, 1);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, '');
            }
            if (ini_get('open_basedir') == '' && (ini_get('safe_mode') == 'Off' or ! ini_get('safe_mode'))) {
                curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle,CURLOPT_FAILONERROR,true);
                $jsonResponse = curl_exec($curlHandle);
                if (curl_errno($curlHandle)) {
                    throw new LoginRadiusException('cURL Error:  ' . curl_error($curlHandle));
                }
                curl_close($curlHandle);
            } else {
                curl_setopt($curlHandle, CURLOPT_HEADER, 1);
                $url = curl_getinfo($curlHandle, CURLINFO_EFFECTIVE_URL);
                curl_close($curlHandle);
                $ch = curl_init();
                $url = str_replace('?', '/?', $url);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch,CURLOPT_FAILONERROR,true);
                $jsonResponse = curl_exec($ch);
                if (curl_errno($ch)) {
                    throw new LoginRadiusException('cURL Error:  ' . curl_error($ch));
                }
                curl_close($ch);
            }
        } elseif (ini_get('allow_url_fopen')) {
            $context = NULL;
            if ($post) {
                $options = array('http' =>
                    array(
                        'method' => 'POST',
                        'timeout' => 10,
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => '',
                    )
                );
                $context = stream_context_create($options);
            }
            $jsonResponse = @file_get_contents($url, false, $context);
            if(strpos(@$http_response_header[0], "400") !== false || strpos(@$http_response_header[0], "401") !== false || strpos(@$http_response_header[0], "403") !== false || strpos(@$http_response_header[0], "404") !== false || strpos(@$http_response_header[0], "500") !== false || strpos(@$http_response_header[0], "503") !== false) {
                throw new loginradiusException('file_get_contents error:  ' . $http_response_header[0]);
            }
            elseif (!$jsonResponse) {
                throw new LoginRadiusException('file_get_contents error');
            }
        } else {
            throw new LoginRadiusException('cURL or FSOCKOPEN is not enabled, enable cURL or FSOCKOPEN to get response from LoginRadius API.');
        }

        $result = json_decode($jsonResponse);
        if (isset($result->errorCode) && !empty($result->errorCode)) {
            throw new LoginRadiusException($result->message, $result);
        }

        return $jsonResponse;
    }

    /**
     * LoginRadius function - To fetch data from the LoginRadius Raw API URL.
     *
     * @param boolean $raw If true, raw data is fetched
     *
     * @return string Data to add in API URL.
     */
    private function loginradius_get_raw_data($raw) {
        return $raw ? '/raw' : '';
    }

}

/**
 * Class For LoginRadius Exception
 *
 * This is the Loginradius Exception class to handle exception when you access LoginRadius APIs.
 *
 * Copyright 2015 LoginRadius Inc. - www.LoginRadius.com
 */
class LoginRadiusException extends Exception {

    public $errorResponse;

    public function __construct($message, $errorResponse = array()) {
        parent::__construct($message);

        $this->errorResponse = $errorResponse;
    }

    public function getErrorResponse() {
        return $this->errorResponse;
    }
}

?>