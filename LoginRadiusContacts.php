<?php
/**
 * Class to get user's contacts/friends/connections from social ID providers.
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusContacts extends LoginRadius{
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
	 * Get user's contacts/friends/connections from social ID providers
	 *
	 * @return array User's contacts information.
	 */ 
	public function loginradius_get_contacts(){
		$Url = "https://" . LR_DOMAIN . "/contacts/". $this->LRSecret ."/".$this->LRToken;
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>