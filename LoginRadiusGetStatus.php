<?php
/**
 * Class to get user's status from facebook.
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusGetStatus extends LoginRadius{
	/**
	 * Constructor. Calls parent class constructor.
	 * 
	 * @param string $Secret LoginRadius API Secret.
	 */ 
	function __construct($Secret){
		parent::__construct($Secret);
	}
	
    /**
	 * Get user's status from facebook
	 *
	 * @return array User's facebook status information.
	 */ 
	public function loginradius_get_status(){
		$Url = "https://hub.loginradius.com/status/get/". $this->LRSecret ."/".$this->LRToken;
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>