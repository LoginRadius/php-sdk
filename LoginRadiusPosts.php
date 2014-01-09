<?php
/**
 * Class to get facebook posts of the user.
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusPosts extends LoginRadius{
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
	 * Get facebook posts of the user.
	 * 
	 * @return array User's facebook posts information.
	 */
	public function loginradius_get_posts(){
		$Url = 'https://' . LR_DOMAIN . '/GetPosts/'. $this->LRSecret ."/".$this->LRToken;
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>