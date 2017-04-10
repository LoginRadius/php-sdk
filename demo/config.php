<?php
if(session_id() == '') {
    session_start();
}
define('API_KEY','<API Key>');
define('API_SECRET','<API Secret>');
define( 'DEMO_ROOT_DIR',dirname(__FILE__) );
include 'LoginRadiusSDK/Utility/Functions.php';
include 'LoginRadiusSDK/LoginRadiusException.php';
include 'LoginRadiusSDK/Utility/SOTT.php';
include 'LoginRadiusSDK/Clients/IHttpClient.php';
include 'LoginRadiusSDK/Clients/DefaultHttpClient.php';
include "LoginRadiusSDK/CustomerRegistration/Social/SocialLoginAPI.php";
include "LoginRadiusSDK/CustomerRegistration/Management/AccountAPI.php";
include "LoginRadiusSDK/CustomerRegistration/Authentication/UserAPI.php";