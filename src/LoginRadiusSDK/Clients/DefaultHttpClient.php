<?php

/**
 * @link : http://www.loginradius.com
 * @category : Clients
 * @package : DefaultHttpClient
 * @author : LoginRadius Team
 * @version : 4.5.1
 * @license : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Clients;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;
use LoginRadiusSDK\Clients\IHttpClient;

/**
 * Class DefaultHttpClient
 *
 * Use default Curl/fsockopen to get response from LoginRadius APIs.
 *
 * @package LoginRadiusSDK\Clients
 */
class DefaultHttpClient implements IHttpClient {

    /**
     * @param $path
     * @param array $query_array
     * @param array $options
     * @return type
     * @throws \LoginRadiusSDK\LoginRadiusException
     */
    public function request($path, $query_array = array(), $options = array()) {
        $parse_url = parse_url($path);
        $request_url = '';
        if (!isset($parse_url['scheme']) || empty($parse_url['scheme'])) {
            $request_url .= API_DOMAIN;
        }
        $request_url .= $path;
        if ($query_array !== false) {
            if (isset($options['authentication']) && $options['authentication'] == 'headsecure') {
                $options = array_merge($options, Functions::authentication(array(), $options['authentication']));
                $query_array = isset($options['authentication']) ? $query_array : $query_array;
            }
            else {
                $query_array = isset($options['authentication']) ? Functions::authentication($query_array, $options['authentication']) : $query_array;
            }
            if (strpos($request_url, "?") === false) {
                $request_url .= "?";
            }
            else {
                $request_url .= "&";
            }
            $request_url .= Functions::queryBuild($query_array);
        }

        if (in_array('curl', get_loaded_extensions())) {
            $response = $this->curlApiMethod($request_url, $options);
        }
        elseif (ini_get('allow_url_fopen')) {
            $response = $this->fsockopenApiMethod($request_url, $options);
        }
        else {
            throw new LoginRadiusException('cURL or FSOCKOPEN is not enabled, enable cURL or FSOCKOPEN to get response from LoginRadius API.');
        }

        if (!empty($response)) {
            $result = json_decode($response);
            if (isset($result->ErrorCode) && !empty($result->ErrorCode)) {
                throw new LoginRadiusException($result->Message, $result);
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
    private function curlApiMethod($request_url, $options = array()) {
        $ssl_verify = isset($options['ssl_verify']) ? $options['ssl_verify'] : false;
        $method = isset($options['method']) ? strtolower($options['method']) : 'get';
        $data = isset($options['post_data']) ? $options['post_data'] : array();
        $content_type = isset($options['content_type']) ? trim($options['content_type']) : 'x-www-form-urlencoded';
        $sott_header_content = isset($options['X-LoginRadius-Sott']) ? trim($options['X-LoginRadius-Sott']) : '';
        $apikey_header_content = isset($options['X-LoginRadius-ApiKey']) ? trim($options['X-LoginRadius-ApiKey']) : '';
        $secret_header_content = isset($options['X-LoginRadius-ApiSecret']) ? trim($options['X-LoginRadius-ApiSecret']) : '';

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $request_url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, $ssl_verify);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Content-type: application/' . $content_type, 'X-LoginRadius-Sott:' . $sott_header_content, 'X-LoginRadius-ApiKey:' . $apikey_header_content, 'X-LoginRadius-ApiSecret:' . $secret_header_content));
        if (isset($options['proxy']) && $options['proxy']['host'] != '' && $options['proxy']['port'] != '') {
            curl_setopt($curl_handle, CURLOPT_PROXY, 'http://' . $options['proxy']['user'] . ':' . $options['proxy']['password'] . '@' . $options['proxy']['host'] . ':' . $options['proxy']['port']);
        }

        if (!empty($data) || $data === true) {
            if (($content_type == 'json') && (is_array($data) || is_object($data))) {
                $data = json_encode($data);
            }

            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, (($content_type == 'json') ? $data : Functions::queryBuild($data)));

            if ($method == 'post') {
                curl_setopt($curl_handle, CURLOPT_POST, 1);
            }
            elseif ($method == 'delete') {
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "delete");
            }
            elseif ($method == 'put') {
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, "PUT");
            }
        }
        curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);

        $json_response = curl_exec($curl_handle);
        if (curl_error($curl_handle)) {
            $json_response = curl_error($curl_handle);
        }

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
    private function fsockopenApiMethod($request_url, $options = array()) {
        $ssl_verify = isset($options['ssl_verify']) ? $options['ssl_verify'] : false;
        $method = isset($options['method']) ? strtolower($options['method']) : 'get';
        $data = isset($options['post_data']) ? $options['post_data'] : array();
        $content_type = isset($options['content_type']) ? $options['content_type'] : 'form_params';
        $sott_header_content = isset($options['X-LoginRadius-Sott']) ? trim($options['X-LoginRadius-Sott']) : '';
        $apikey_header_content = isset($options['X-LoginRadius-ApiKey']) ? trim($options['X-LoginRadius-ApiKey']) : '';
        $secret_header_content = isset($options['X-LoginRadius-ApiSecret']) ? trim($options['X-LoginRadius-ApiSecret']) : '';
        
        $optionsArray = array('http' =>
          array(
            'method' => strtoupper($method),
            'timeout' => 50,
            'ignore_errors' => true,            
            'header' => 'Content-Type: application/' . $content_type
            ),
            "ssl" => array(
                    "verify_peer" => $ssl_verify
            )
        );
        if (!empty($data) || $data === true) {
            if (($content_type == 'json') && (is_array($data) || is_object($data))) {
                $data = json_encode($data);
            }
            $optionsArray['http']['header'] .= "\r\n".'Content-Length:' .(($data === true)?'0':strlen($data));
            $optionsArray['http']['content'] = (($content_type == 'json') ? $data : Functions::queryBuild($data));
        }
        if ($sott_header_content != '') {
            $optionsArray['http']['header'] .= "\r\n" . 'X-LoginRadius-Sott: ' . $sott_header_content;
        }
        if ($apikey_header_content != '') {
            $optionsArray['http']['header'] .= "\r\n" . 'X-LoginRadius-ApiKey: ' . $apikey_header_content;
        }
        if ($secret_header_content != '') {
            $optionsArray['http']['header'] .= "\r\n" . 'X-LoginRadius-ApiSecret: ' . $secret_header_content;
        }        
          
        $context = stream_context_create($optionsArray);
        $json_response = file_get_contents($request_url, false, $context);
        if (!$json_response) {
            throw new LoginRadiusException('file_get_contents error');
        }
        return $json_response;
    }
}
