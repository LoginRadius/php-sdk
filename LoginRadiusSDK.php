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
class LoginRadius{
public $IsAuthenticated, $LRToken, $LRSecret;

/**
 * Constructor - It validates LoginRadius API Secret and Session Token. If valid, assigns them to class members; else prints error message.
 * 
 * @param string $Secret LoginRadius API Secret.
 */ 
public function __construct($Secret){
	if(!isset($_REQUEST['token'])){
		// if token is not set
		echo "<p style ='color:red;'>Invalid Request</p>";
	}elseif(!$this->loginradius_is_valid_guid($_REQUEST['token'])){
		// if token is invalid, show error message.
		echo "<p style ='color:red;'>Invalid Token</p>";
	}elseif(!$this->loginradius_is_valid_guid($Secret)){
		// if API secret is invalid, show error message.
		echo "<p style ='color:red;'>Invalid LoginRadius API Secret</p>";
	}else{
		$this->LRSecret = $Secret;
		$this->LRToken = $_REQUEST['token'];
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
 * LoginRadius funtion - To fetch user profile data from LoginRadius SaaS.
 * 
 * @param string $ApiSecrete LoginRadius API Secret
 *
 * @return object User profile data.
 */ 
public function loginradius_get_data(){
	$this->IsAuthenticated = false;
	$ValidateUrl = "https://hub.loginradius.com/userprofile.ashx?token=".$this->LRToken."&apisecrete=".$this->LRSecret."";
	$JsonResponse = $this->loginradius_call_api($ValidateUrl);
	$UserProfile = json_decode($JsonResponse);
	if(isset($UserProfile->ID) && $UserProfile->ID != ''){
		$this->IsAuthenticated = true;
		return $UserProfile;
	}
}

/**
 * This function is use to fetch data from the LoginRadius API URL.
 * 
 * @param string $ValidateUrl - Target URL to fetch data from.
 *
 * @return string - data fetched from the LoginRadius API.
 */ 
protected function loginradius_call_api($ValidateUrl){
	if(in_array('curl', get_loaded_extensions())){
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $ValidateUrl);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl_handle, CURLOPT_TIMEOUT, 15); 
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
		if(ini_get('open_basedir') == '' && (ini_get('safe_mode') == 'Off' or !ini_get('safe_mode'))){
			curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
			$JsonResponse = curl_exec($curl_handle);
		}else{
			curl_setopt($curl_handle, CURLOPT_HEADER, 1);
			$url = curl_getinfo($curl_handle, CURLINFO_EFFECTIVE_URL);
			curl_close($curl_handle);
			$ch = curl_init();
			$url = str_replace('?','/?',$url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$JsonResponse = curl_exec($ch);
			curl_close($ch);
		}
	}else{
		$JsonResponse = file_get_contents($ValidateUrl);
	}
	return $JsonResponse;
}
}
?>