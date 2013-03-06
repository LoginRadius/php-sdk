<?php
/**
 * Class to send direct message to user's contacts(LinkedIn)/followers(twitter).
 *
 * Copyright 2013 LoginRadius Inc. - www.LoginRadius.com
 *
 * This file is part of the LoginRadius SDK package.
 *
 */ 
class LoginRadiusMessage extends LoginRadius{
	/**
	 * Constructor. Calls parent class constructor.
	 * 
	 * @param string $Secret LoginRadius API Secret.
	 */ 
	function __construct($Secret){
		parent::__construct($Secret);
	}
	
    /**
	 * Send direct message.
	 *
	 * @param string $to          Social ID of the receiver.
	 * @param string $subject     Subject of the message.
	 * @param string $message     Message.
	 *
	 * @return bool - true on success, false otherwise.
	 */ 
	public function loginradius_send_message($to,$subject,$message){
		$Url = 'https://hub.loginradius.com/directmessage/'.  $this->LRSecret .'/'.$this->LRToken.'?'.http_build_query(array(
			'sendto' => $to,
			'subject' => $subject,
			'message' => $message
		));
		$Response = $this->loginradius_call_api($Url);
		return json_decode($Response);
	}
}
?>