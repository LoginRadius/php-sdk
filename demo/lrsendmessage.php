<?php
	if(!isset($_REQUEST['to']) || !isset($_REQUEST['subject']) || !isset($_REQUEST['message'])){die;}
	$lrsendmessage = $_REQUEST;	
	include_once('LoginRadiusSDK.php');
	$loginradius = new LoginRadius();
	$SendMessage = $loginradius->loginradius_send_message($lrsendmessage['lraccesstoken'],$lrsendmessage['to'], $lrsendmessage['subject'], $lrsendmessage['message']);
	if(isset($SendMessage->Message) && !empty($SendMessage->Message)){
		die('<div id="Error">'.$SendMessage->Message.'</div>');
	}
	elseif(isset($SendMessage->isPosted) && $SendMessage->isPosted == true){
		die('<div id="Success">Message has been Posted</div>');
	}
?>