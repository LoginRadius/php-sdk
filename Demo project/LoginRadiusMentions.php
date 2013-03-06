<?php
/**
 * Class to get users's twitter mentions.
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusMentions extends LoginRadius{
	/**
	 * Constructor. Calls parent class constructor.
	 * 
	 * @param string $Secret LoginRadius API Secret.
	 */ 
	function __construct($Secret){
		parent::__construct($Secret);
	}
	
    /**
	 * Get user's twitter mentions.
	 * 
	 * @return array User's twitter mentions.
	 */ 
	public function loginradius_get_mentions(){
		$Url = 'https://hub.loginradius.com/status/mentions/'. $this->LRSecret ."/".$this->LRToken;
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>