<?php

if (session_id() == '') {
    session_start();
}

define('API_KEY', 'api-key');
define('API_SECRET', 'secret-key');
define('AUTH_FLOW', 'your-flow'); //optional/disabled or by default it is required
define('DEMO_ROOT_DIR', dirname(__FILE__));

if (API_KEY == 'api-key' || API_SECRET == 'secret-key') {
    die('<div style="color:red;text-align:center;">To configuration LoginRadius demo. Please Pass LoginRadius Account\'s API Key and Secret in <b>' . __FILE__ . '</b></div>');
}

require_once '../src/LoginRadiusSDK/Utility/Functions.php';
require_once '../src/LoginRadiusSDK/LoginRadiusException.php';
require_once '../src/LoginRadiusSDK/Utility/SOTT.php';
require_once '../src/LoginRadiusSDK/Clients/IHttpClient.php';
require_once '../src/LoginRadiusSDK/Clients/DefaultHttpClient.php';
require_once "../src/LoginRadiusSDK/CustomerRegistration/Social/SocialLoginAPI.php";
require_once "../src/LoginRadiusSDK/CustomerRegistration/Management/AccountAPI.php";
require_once "../src/LoginRadiusSDK/CustomerRegistration/Authentication/UserAPI.php";
