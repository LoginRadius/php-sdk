<?php
/**
 * Class to post status to facebook wall.
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusStatusUpdate extends LoginRadius{
	/**
	 * Constructor. Calls parent class constructor.
	 * 
	 * @param string $Secret LoginRadius API Secret.
         * @param string $Token  LoginRadius authentication token
	 */ 
	function __construct($Secret, $Token){
		parent::__construct($Secret, $Token);
	}

   /**
	* Post status on facebook wall.
	* 
	* @param string $to          Social ID of the receiver (if blank, status will be posted to the user's wall who is logging in through facebook).
	* @param string $title       Title of the post (Optional).
	* @param string $url         Link to which user will get redirected after clicking post (Optional).
	* @param string $imageurl    URL of the image to show in the post (Optional).
	* @param string $status      Status.
	* @param string $caption     Caption of the post (Optional).
	* @param string $description Description of the post (Optional).
	*
	* @return bool Returns true if successful, false otherwise.
	*/ 
	public function loginradius_post_status($to, $title, $url, $imageurl, $status, $caption, $description){
		$Url = 'https://' . LR_DOMAIN . '/status/update/' . $this->LRSecret . '/' . $this->LRToken . '?' . http_build_query(array(
			'to' => $to,
			'title' => $title,
			'url' => $url,
			'imageurl' => $imageurl,
			'status' => $status,
			'caption' => $caption,
			'description' => $description
		));
		$Response = $this->loginradius_call_api($Url);
		$Response = json_decode($Response);
		try{
			if($Response === true){
				return true;
			}elseif(isset($Response->errormessage)){
				throw new exception($Response->errormessage);
			}else{
				throw new exception('Error in sending message');
			}
		}catch(Exception $e){
			$this -> loginradius_log_error($e -> getMessage());
			return false;
		}
	}
}
?>