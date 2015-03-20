<?php

include_once('config.php');
include_once('LoginRadius_functions.php');
include_once('LoginRadiusSDK.php');
if (!isset($_REQUEST['title']) || !isset($_REQUEST['status'])) {
    die;
}
$lrpost = $_REQUEST;
$lrpost['lraccesstoken'] = (!empty($lrpost['lraccesstoken']) ? $lrpost['lraccesstoken'] : '');
$lrpost['url'] = (!empty($lrpost['url']) ? $lrpost['url'] : '');
$lrpost['imageurl'] = (!empty($lrpost['imageurl']) ? $lrpost['imageurl'] : '');
$lrpost['status'] = (!empty($lrpost['status']) ? $lrpost['status'] : '');
$lrpost['title'] = (!empty($lrpost['title']) ? $lrpost['title'] : '');
$lrpost['description'] = (!empty($lrpost['description']) ? $lrpost['description'] : '');

$loginradius = new LoginRadius();
try {
    $PostStatus = $loginradius->loginradius_post_status($lrpost['lraccesstoken'], $lrpost['title'], $lrpost['url'], $lrpost['imageurl'], $lrpost['status'], $lrpost['title'], $lrpost['description']);
} catch (LoginRadiusException $e) {
    die('<div id="Error">' . $e->getMessage() . '</div>');
}
if (isset($PostStatus->isPosted) && $PostStatus->isPosted == true) {
    die('<div id="Success">Message has been Posted</div>');
}
?>