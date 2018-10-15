<?php

define('API_KEY', ''); // Pass API Key
define('API_SECRET', '');  // Pass API Secret Key
define('API_REQUEST_SIGNING', ''); // Pass boolean true/false for enable/disable
define('AUTH_FLOW', '');   // Pass optional/disabled, if email verification flow optional or disabled, no need to mention if required flow

//If you have Custom API Domain then define 'API_DOMAIN' then replaced it with your custom API domain,
//otherwise no need to define these option in configuration.
//define('API_DOMAIN', 'https://api.example.com'); 

require_once "/../../src/LoginRadiusSDK/Utility/Functions.php";
require_once "/../../src/LoginRadiusSDK/LoginRadiusException.php";
require_once "/../../src/LoginRadiusSDK/Clients/IHttpClient.php";
require_once "/../../src/LoginRadiusSDK/Clients/DefaultHttpClient.php";
require_once "/../../src/LoginRadiusSDK/CustomerRegistration/Social/SocialLoginAPI.php";
require_once "/../../src/LoginRadiusSDK/CustomerRegistration/Account/AccountAPI.php";
require_once "/../../src/LoginRadiusSDK/CustomerRegistration/Account/CustomObjectAPI.php";
require_once "/../../src/LoginRadiusSDK/CustomerRegistration/Account/RoleAPI.php";
require_once "/../../src/LoginRadiusSDK/CustomerRegistration/Authentication/UserAPI.php";
