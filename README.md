# LoginRadius CodeIgniter Demo

## Overview
This demo is meant to help you with a quick implementation of the LoginRadius platform with CodeIgniter framework.
It presumes you have basic knowledge of PHP.


## Getting Started
**Required: Composer needs to be installed**

1. Setup a local server. If you don't know how to set up a local server read these guides [here](https://www.maketecheasier.com/setup-local-web-server-all-platforms/) or set up a small GitHub webserver [here](https://pages.github.com/)

2. Download the demo and put it in your root directory on your server. 

3. Install the dependencies.
```
        composer update
```
4. Configure your LoginRadius credentials in "application/helpers/api_helper.php" 
```       
        define('LR_API_KEY', ''); // Pass API Key
        define('LR_API_SECRET', '');  // Pass API Secret Key
        define('API_REQUEST_SIGNING', false); // Pass boolean true/false for enable/disable
        define('AUTH_FLOW', '');
```

5. Also configure your LoginRadius credentials in "/assets/js/option.js" 
```     
        var commonOptions = {};
        commonOptions.apiKey = "";
        commonOptions.appName = "";
        commonOptions.hashTemplate = true;
        commonOptions.sott = "<SOTT>";
        commonOptions.formValidationMessage = true;
        commonOptions.verificationUrl = domainName+"/login";
        commonOptions.resetPasswordUrl = domainName+"/login";
        var LRObject = new LoginRadiusV2(commonOptions);
```

6. Go to your web browser and type in the root directory URL that your server is hosting. You would be good to go and start playing with the demo.



**Features Implemented in the Demo**

1. Login
2. Register
3. Resend Email Verification
4. Social Login
5. Multi-Factor Authentication
6. Hosted Page
7. Forgot Password
8. Custom Object Management
9. Update Profile
10. Set Password
11. Account Linking
12. Roles Management
       