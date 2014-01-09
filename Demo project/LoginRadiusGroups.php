<?php
/**
 * Class to get facebook groups followed by the user.
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusGroups extends LoginRadius{
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
	 * Get facebook groups followed by user.
	 * 
	 * @return array Followed facebook groups information.
	 */ 
	public function loginradius_get_groups(){
		$Url = "https://" . LR_DOMAIN . "/GetGroups/". $this->LRSecret ."/".$this->LRToken;
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>