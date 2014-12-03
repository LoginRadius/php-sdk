<?php

require_once __DIR__ . '/vendor/autoload.php';

use LoginRadiusSDK\LoginRadius;

$api_secret = 'your_api_secret';

if( LoginRadius::loginradius_is_callback() ) {
	/* This will not be triggered since there is not _REQUEST['token']*/
	echo "call back succeed";
} else {
	/* Will run this*/
	echo "Call back failed, but class is found.";
}
