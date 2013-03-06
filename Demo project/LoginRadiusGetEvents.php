<?php
/**
 * Class to get user's facebook events.
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusGetEvents extends LoginRadius{
	/**
	 * Constructor. Calls parent class constructor.
	 * 
	 * @param string $Secret LoginRadius API Secret.
	 */ 
	function __construct($Secret){
		parent::__construct($Secret);
	}
	
    /**
	 * Get user's facebook events
	 *
	 * @return array User's facebook events information.
	 */ 
	public function loginradius_get_events(){
		$Url = "https://hub.loginradius.com/GetEvents/". $this->LRSecret ."/".$this->LRToken;
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>