<?php
if(session_id() == '') {
    session_start();
}
define('API_KEY','d41926c6-25cb-4f20-a7d1-a333403cb8d9');
define('API_SECRET','781c3979-0e42-4a2e-bd80-2ff5f9c0d8fa');
define( 'DEMO_ROOT_DIR',dirname(__FILE__) );
include 'LoginRadiusSDK/Utility/Functions.php';
include 'LoginRadiusSDK/LoginRadiusException.php';
include 'LoginRadiusSDK/Utility/SOTT.php';
include 'LoginRadiusSDK/Clients/IHttpClient.php';
include 'LoginRadiusSDK/Clients/DefaultHttpClient.php';
include "LoginRadiusSDK/CustomerRegistration/Social/SocialLoginAPI.php";
include "LoginRadiusSDK/CustomerRegistration/Management/AccountAPI.php";
include "LoginRadiusSDK/CustomerRegistration/Authentication/UserAPI.php";