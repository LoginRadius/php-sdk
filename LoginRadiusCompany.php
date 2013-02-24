<?php
/**
 * Class to get companies followed by user from LinkedIn ID provider.
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusCompany extends LoginRadius{
	/**
	 * Constructor. Calls parent class constructor.
	 * 
	 * @param string $Secret LoginRadius API Secret.
	 */ 
	function __construct($Secret){
		parent::__construct($Secret);
	}
	
    /**
	 * Get companies followed by user from linkedin account.
	 * 
	 * @return array Followed companies' information.
	 */ 
	public function loginradius_get_company(){
		$Url = "https://hub.loginradius.com/GetCompany/". $this->LRSecret ."/". $this->LRToken;
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>