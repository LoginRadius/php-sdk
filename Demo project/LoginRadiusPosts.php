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
	 */ 
	function __construct($Secret){
		parent::__construct($Secret);
	}
	
    /**
	 * Get facebook posts of the user.
	 * 
	 * @return array User's facebook posts information.
	 */
	public function loginradius_get_posts(){
		$Url = 'http://hub.loginradius.com/GetPosts/'. $this->LRSecret ."/".$this->LRToken;
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>