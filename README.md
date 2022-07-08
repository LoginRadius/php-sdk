# LoginRadius Symfony Demo

## Overview
This demo is meant to help you with a quick implementation of the LoginRadius platform with Symfony framework.
It presumes you have basic knowledge of PHP.

## Getting Started
**Required: Composer needs to be installed**

1. Download our Symfony demo project.

2. Install the dependencies.
```
        composer update
```

3. Configure your LoginRadius credentials in "src/Controller/ApiController.php" 
```       
        define('LR_API_KEY', ''); // Pass API Key
        define('LR_API_SECRET', '');  // Pass API Secret Key
        define('API_REQUEST_SIGNING', false); // Pass boolean true/false for enable/disable
        define('AUTH_FLOW', '');
```

4. Also configure your LoginRadius credentials in "/public/assets/js/option.js" 
```    
        var commonOptions = {};
        commonOptions.apiKey = "";
        commonOptions.appName = "internal-apeksha";
        commonOptions.hashTemplate = true;
        commonOptions.sott = "<SOTT>";
        commonOptions.formValidationMessage = true;
        commonOptions.verificationUrl = domainName+"/login";
        commonOptions.resetPasswordUrl = domainName+"/login";
        var LRObject = new LoginRadiusV2(commonOptions);
```

5. After configuring the options, run following command: 
```     
        php bin/console server:run
```

6. Open the browser and hit the url: http://127.0.0.1:8000/

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
       