<?php
/**
 * Class for Social Authentication.
 *
 * This is the main class to communicate with LogiRadius Unified Social API. It contains functions for Social Authentication with User Profile Data (Basic and 
 * Extended).
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */

// Define LoginRadius domain
define('LR_DOMAIN', 'hub.loginradius.com');

class LoginRadius{
public $IsAuthenticated, $LRToken, $LRSecret;

/**
 * Constructor - It validates LoginRadius API Secret and Session Token. If valid, assigns them to class members; else prints error message.
 * 
 * @param string $Secret LoginRadius API Secret
 * @param string $Token  LoginRadius authentication token
 */ 
public function __construct($Secret, $Token){
	try{
		if(!$this->loginradius_is_valid_guid($Token)){
			// if token is invalid, show error message.
			throw new Exception('Error: Invalid Token');
		}elseif(!$this->loginradius_is_valid_guid($Secret)){
			// if API secret is invalid, show error message.
			throw new Exception('Error: Invalid LoginRadius API Secret');
		}else{
			$this->LRSecret = $Secret;
			$this->LRToken = $Token;
		}
	}catch(Exception $e){
		$this -> loginradius_log_error($e -> getMessage());
	}
}

/**
 * LoginRadius function - It validate against GUID format of keys.
 * 
 * @param string $value data to validate.
 *
 * @return boolean. If valid - true, else - false.
 */ 
private function loginradius_is_valid_guid($value){
	return preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $value);
}

/**
 * LoginRadius function - To fetch user profile data from LoginRadius SaaS.
 * 
 * @param string $ApiSecrete LoginRadius API Secret
 *
 * @return object User profile data.
 */ 
public function loginradius_get_data(){
	$this->IsAuthenticated = false;
	$ValidateUrl = "https://" . LR_DOMAIN . "/userprofile.ashx?token=".$this->LRToken."&apisecrete=".$this->LRSecret."";
	$JsonResponse = $this->loginradius_call_api($ValidateUrl);
	$UserProfile = json_decode($JsonResponse);
	if(isset($UserProfile->ID) && $UserProfile->ID != ''){
		$this->IsAuthenticated = true;
		return $UserProfile;
	}
}

/**
 * LoginRadius function - To log error(exception) in "error.txt" file.
 * 
 * @param string $error - Error message to log.
 *
 */
protected function loginradius_log_error($error){
	ob_start();
	debug_print_backtrace();
	$trace = ob_get_contents();
	ob_end_clean();
	error_log(PHP_EOL.'['.date('m/d/Y h:i:s a', time()).']  '.$error.PHP_EOL.str_replace('#', PHP_EOL.'#', $trace).PHP_EOL, 3, 'error.txt');
}

/**
 * LoginRadius function - To fetch data from the LoginRadius API URL.
 * 
 * @param string $ValidateUrl - Target URL to fetch data from.
 *
 * @return string - data fetched from the LoginRadius API.
 */ 
protected function loginradius_call_api($ValidateUrl){
	try{
		if(in_array('curl', get_loaded_extensions())){
			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $ValidateUrl);
			curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($curl_handle, CURLOPT_TIMEOUT, 15); 
			curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
			if(ini_get('open_basedir') == '' && (ini_get('safe_mode') == 'Off' or !ini_get('safe_mode'))){
				curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
			}else{
				curl_setopt($curl_handle, CURLOPT_HEADER, 1);
				$url = curl_getinfo($curl_handle, CURLINFO_EFFECTIVE_URL);
				curl_close($curl_handle);
				$curl_handle = curl_init();
				$url = str_replace('?','/?',$url);
				curl_setopt($curl_handle, CURLOPT_URL, $url);
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
			}
			$JsonResponse = curl_exec($curl_handle);
			$httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);
			if(in_array($httpCode, array(400, 401, 403, 404, 500, 503)) && $httpCode != 200){
				throw new Exception('Uh oh, looks like something went wrong. Try again in a sec!');
			}else{
				if(curl_errno($curl_handle) == 28){
					throw new Exception('Uh oh, looks like something went wrong. Try again in a sec!');
				}
			}
			curl_close($curl_handle);
		}else{
			$JsonResponse = @file_get_contents($ValidateUrl);
			if(strpos(@$http_response_header[11], "400") !== false || strpos(@$http_response_header[11], "401") !== false || strpos(@$http_response_header[11], "403") !== false || strpos(@$http_response_header[11], "404") !== false || strpos(@$http_response_header[11], "500") !== false || strpos(@$http_response_header[11], "503") !== false){
				throw new Exception('Uh oh, looks like something went wrong. Try again in a sec!');
			}
		}
	}catch(Exception $e){
		$this -> loginradius_log_error($e -> getMessage());
	}
	return $JsonResponse;
}
}
?>