<?php

/**
 * @link : http://www.loginradius.com
 * @category : LoginRadiusSDK
 * @package : LoginRadius
 * @author : LoginRadius Team
 * @version : 3.0.0
 * @license : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Clients;

use LoginRadiusSDK\LoginRadius;
use LoginRadiusSDK\LoginRadiusException;

/**
 * Class DefaultHttpClient
 *
 * Use default Curl/fsockopen to get response from LoginRadius APIs.
 *
 * @package LoginRadiusSDK\Clients
 */
class DefaultHttpClient implements IHttpClient
{

    public function request($path, $query_array = array(), $options = array())
    {
        $parse_url = parse_url($path);
        $request_url = '';
        if (!isset($parse_url['scheme']) || empty($parse_url['scheme'])) {
            $request_url .= API_DOMAIN;
        }
        $request_url .= $path;
        if ($query_array !== false) {
            $query_array = (isset($options['authentication']) && ($options['authentication'] == false)) ? $query_array : LoginRadius::authentication($query_array);
            if (strpos($request_url, "?") === false) {
                $request_url .= "?";
            } else {
                $request_url .= "&";
            }
            $request_url .= LoginRadius::queryBuild($query_array);
        }
        if (in_array('curl', get_loaded_extensions())) {
            $response = $this->curlApiMethod($request_url, $options);
        } elseif (ini_get('allow_url_fopen')) {
            $response = $this->fsockopenApiMethod($request_url, $options);
        } else {
            throw new LoginRadiusException('cURL or FSOCKOPEN is not enabled, enable cURL or FSOCKOPEN to get response from LoginRadius API.');
        }
        
        if (!empty($response)) {
            $result = json_decode($response);
            if (isset($result->errorCode) && !empty($result->errorCode)) {
                throw new LoginRadiusException($result->message, $result);
            }
        }
        return $response;
    }

    /**
     * Access LoginRadius API server by curl method
     *
     * @param type $request_url
     * @param type $options
     * @return type
     */
    private function curlApiMethod($request_url, $options = array())
    {
        $ssl_verify = isset($options['ssl_verify']) ? $options['ssl_verify'] : false;
        $method = isset($options['method']) ? strtolower($options['method']) : 'get';
        $data = isset($options['post_data']) ? $options['post_data'] : array();
        $content_type = isset($options['content_type']) ? trim($options['content_type']) : 'x-www-form-urlencoded';
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $request_url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, $ssl_verify);

        if (!empty($data) || $data === true) {
            curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-type: application/' . $content_type));
            if ($method == 'post') {
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, (($content_type == 'json') ? json_encode($data) : LoginRadius::queryBuild($data)));
            }
        }

        if (ini_get('open_basedir') == '' && (ini_get('safe_mode') == 'Off' or !ini_get('safe_mode'))) {
            curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        } else {
            curl_setopt($curl_handle, CURLOPT_HEADER, 1);
            $effectiveUrl = curl_getinfo($curl_handle, CURLINFO_EFFECTIVE_URL);
            curl_close($curl_handle);
            $curl_handle = curl_init();
            $url = str_replace('?', '/?', $effectiveUrl);
            curl_setopt($curl_handle, CURLOPT_URL, $url);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        }

        $json_response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $json_response;
    }

    /**
     * Access LoginRadius API server by fsockopen method
     *
     * @param type $request_url
     * @param type $options
     * @return type
     */
    private function fsockopenApiMethod($request_url, $options = array())
    {
        $ssl_verify = isset($options['ssl_verify']) ? $options['ssl_verify'] : false;
        $method = isset($options['method']) ? strtolower($options['method']) : 'get';
        $data = isset($options['post_data']) ? $options['post_data'] : array();
        $content_type = isset($options['content_type']) ? $options['content_type'] : 'form_params';

        if (!empty($data)) {
            $options = array('http' =>
                array(
                    'method' => strtoupper($method),
                    'timeout' => 50,
                    'header' => 'Content-type :application/' . $content_type,
                    'content' => (($content_type == 'json') ? json_encode($data) : LoginRadius::queryBuild($data))
                ),
                "ssl" => array(
                    "verify_peer" => $ssl_verify
                )
            );
            $context = stream_context_create($options);
        } else {
            $context = NULL;
        }
        $json_response = @file_get_contents($request_url, false, $context);
        if (!$json_response) {
            throw new LoginRadiusException('file_get_contents error');
        }
        return $json_response;
    }

}
