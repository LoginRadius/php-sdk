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
	 */ 
	function __construct($Secret){
		parent::__construct($Secret);
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
		$Url = 'https://hub.loginradius.com/status/update/' . $this->LRSecret . '/' . $this->LRToken . '?' . http_build_query(array(
			'to' => $to,
			'title' => $title,
			'url' => $url,
			'imageurl' => $imageurl,
			'status' => $status,
			'caption' => $caption,
			'description' => $description
		));
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>