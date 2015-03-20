<?php

include_once('config.php');
include_once('LoginRadius_functions.php');
include_once('LoginRadiusSDK.php');
if (!isset($_REQUEST['to']) || !isset($_REQUEST['subject']) || !isset($_REQUEST['message'])) {
    die;
}
$lrsendmessage = $_REQUEST;
$loginradius = new LoginRadius();
try {
    $SendMessage = $loginradius->loginradius_send_message($lrsendmessage['lraccesstoken'], $lrsendmessage['to'], $lrsendmessage['subject'], $lrsendmessage['message']);
} catch (LoginRadiusException $e) {
    die('<div id="Error">' . $e->getMessage() . '</div>');
}

if (isset($SendMessage->isPosted) && $SendMessage->isPosted == true) {
    die('<div id="Success">Message has been Posted</div>');
}
?>