<?php

/**
 * @link : http://www.loginradius.com
 * @category : Clients
 * @package : DefaultHttpClient
 * @author : LoginRadius Team
 * @version : 5.0.2
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
        if (isset($options['api_region']) && !empty($options['api_region'])) {
            $query_array['region'] = $options['api_region'];
        }
        if (!isset($options['api_request_signing']) || empty($options['api_request_signing'])) {
            $options['api_request_signing'] = false;
        }
        if ($query_array !== false) {
            if (isset($options['authentication']) && $options['authentication'] == 'secret') {
                if (($options['api_request_signing'] === false) || ($options['api_request_signing'] === 'false')) {
                    $options = array_merge($options, Functions::authentication(array(), $options['authentication']));
                }
                $query_array = isset($options['authentication']) ? Functions::authentication($query_array) : $query_array;
            } else {
                $query_array = isset($options['authentication']) ? Functions::authentication($query_array, $options['authentication']) : $query_array;
            }
            $request_url .= (strpos($request_url, "?") === false) ? "?" : "&";
            $request_url .= Functions::queryBuild($query_array);

            if (isset($options['authentication']) && $options['authentication'] == 'secret') {
                if (($options['api_request_signing'] === true) || ($options['api_request_signing'] === 'true')) {
                    $options = array_merge($options, Functions::authentication($options, 'hashsecret', $request_url));
                }
            }
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
        $method = isset($options['method']) ? strtoupper($options['method']) : 'GET';
        $data = isset($options['post_data']) ? $options['post_data'] : array();
        $content_type = isset($options['content_type']) ? trim($options['content_type']) : 'x-www-form-urlencoded';
        $auth_access_token = isset($options['access-token']) ? trim($options['access-token']) : '';
        $sott_header_content = isset($options['X-LoginRadius-Sott']) ? trim($options['X-LoginRadius-Sott']) : '';
        $secret_header_content = isset($options['X-LoginRadius-ApiSecret']) ? trim($options['X-LoginRadius-ApiSecret']) : '';
        $expiry_time = isset($options['X-Request-Expires']) ? trim($options['X-Request-Expires']) : '';
        $digest = isset($options['digest']) ? trim($options['digest']) : '';

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $request_url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl_handle, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, $ssl_verify);
        $optionsArray = array('Content-type: application/' . $content_type);
        if ($auth_access_token != '') {
            $optionsArray[] = 'Authorization:' . $auth_access_token;
        }
        if ($sott_header_content != '') {
            $optionsArray[] = 'X-LoginRadius-Sott:' . $sott_header_content;
        }
        if ($secret_header_content != '') {
            $optionsArray[] = 'X-LoginRadius-ApiSecret:' . $secret_header_content;
        }
        if ($expiry_time != '') {
            $optionsArray[] = 'X-Request-Expires:' . $expiry_time;
        }
        if ($digest != '') {
            $optionsArray[] = 'digest:' . $digest;
        }
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $optionsArray);

        if (isset($options['proxy']) && $options['proxy']['host'] != '' && $options['proxy']['port'] != '') {
            curl_setopt($curl_handle, CURLOPT_PROXY, $options['proxy']['protocol'] . '://' . $options['proxy']['user'] . ':' . $options['proxy']['password'] . '@' . $options['proxy']['host'] . ':' . $options['proxy']['port']);
        }

        if (!empty($data) || $data === true) {
            if (($content_type == 'json') && (is_array($data) || is_object($data))) {
                $data = json_encode($data);
            }

            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, (($content_type == 'json') ? $data : Functions::queryBuild($data)));

            if (in_array($method, array('POST', 'PUT', 'DELETE'))) {
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, $method);
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
        $method = isset($options['method']) ? strtoupper($options['method']) : 'GET';
        $data = isset($options['post_data']) ? $options['post_data'] : array();
        $content_type = isset($options['content_type']) ? $options['content_type'] : 'form_params';
        $auth_access_token = isset($options['access-token']) ? trim($options['access-token']) : '';
        $sott_header_content = isset($options['X-LoginRadius-Sott']) ? trim($options['X-LoginRadius-Sott']) : '';
        $secret_header_content = isset($options['X-LoginRadius-ApiSecret']) ? trim($options['X-LoginRadius-ApiSecret']) : '';
        $expiry_time = isset($options['X-Request-Expires']) ? trim($options['X-Request-Expires']) : '';
        $digest = isset($options['digest']) ? trim($options['digest']) : '';

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
            $optionsArray['http']['header'] .= "\r\n" . 'Content-Length:' . (($data === true) ? '0' : strlen($data));
            $optionsArray['http']['header'] .= "\r\n" . 'Accept-Encoding: gzip';
            $optionsArray['http']['content'] = (($content_type == 'json') ? $data : Functions::queryBuild($data));
        }
        if ($auth_access_token != '') {
            $optionsArray['http']['header'] .= "\r\n" . 'Authorization: ' . $auth_access_token;
        }
        if ($sott_header_content != '') {
            $optionsArray['http']['header'] .= "\r\n" . 'X-LoginRadius-Sott: ' . $sott_header_content;
        }
        if ($secret_header_content != '') {
            $optionsArray['http']['header'] .= "\r\n" . 'X-LoginRadius-ApiSecret: ' . $secret_header_content;
        }
        if ($expiry_time != '') {
            $optionsArray['http']['header'] .= "\r\n" . 'X-Request-Expires: ' . $expiry_time;
        }
        if ($digest != '') {
            $optionsArray['http']['header'] .= "\r\n" . 'digest: ' . $digest;
        }

        $context = stream_context_create($optionsArray);
        $json_response = file_get_contents($request_url, false, $context);
        if (!$json_response) {
            throw new LoginRadiusException('file_get_contents error');
        }
        return $json_response;
    }
}
