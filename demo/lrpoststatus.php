<?php
	if(!isset($_REQUEST['title']) || !isset($_REQUEST['status'])){die;}
	$lrpost = $_REQUEST;
        $lrpost['lraccesstoken']=(!empty($lrpost['lraccesstoken'])?$lrpost['lraccesstoken']:'');
        $lrpost['url']=(!empty($lrpost['url'])?$lrpost['url']:'');
        $lrpost['imageurl']=(!empty($lrpost['imageurl'])?$lrpost['imageurl']:'');
        $lrpost['status']=(!empty($lrpost['status'])?$lrpost['status']:'');
        $lrpost['title']=(!empty($lrpost['title'])?$lrpost['title']:'');
        $lrpost['description']=(!empty($lrpost['description'])?$lrpost['description']:'');
	include_once('LoginRadiusSDK.php');
	$loginradius = new LoginRadius();
	$PostStatus = $loginradius->loginradius_post_status($lrpost['lraccesstoken'], $lrpost['title'], $lrpost['url'], $lrpost['imageurl'], $lrpost['status'], $lrpost['title'], $lrpost['description']);
	if(isset($PostStatus->Message) && !empty($PostStatus->Message)){
		die('<div id="Error">'.$SendMessage->Message.'</div>');
	}
	elseif(isset($PostStatus->isPosted) && $PostStatus->isPosted == true){
		die('<div id="Success">Message has been Posted</div>');
	}
?>