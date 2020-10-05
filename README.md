# LoginRadius Laravel Demo

** Disclaimer:
This guide assumes you have some basic knowledge of PHP and Laravel.

# Setup

 1. Download our Laravel demo project.

 2. After Downloading laravel-demo, you need to update composer to download required library using the following command:

        composer update

 3. Open constants.php (File Location: bootstrap\constants.php) and fill your LoginRadius credentials
       
      define('LR_API_KEY', '<LR_API_KEY>'); // Pass API Key
      define('LR_API_SECRET', '<LR_API_SECRET>');  // Pass API Secret Key
      define('API_REQUEST_SIGNING', ''); // Pass boolean true/false for enable/disable
      define('AUTH_FLOW', '');   // Pass optional/disabled, if email verification flow optional or disabled, no need to mention if required flow

 4. Then open the option.js(File Location: public\js\option.js) and fill your LoginRadius credentials
       
        var commonOptions = {};
        commonOptions.apiKey = "";
        commonOptions.appName = "";
        commonOptions.hashTemplate = true;
        commonOptions.sott = "<SOTT>";
        commonOptions.formValidationMessage = true;
        commonOptions.verificationUrl = domainName+"/login";
        commonOptions.resetPasswordUrl = domainName+"/login";
        var LRObject = new LoginRadiusV2(commonOptions);

 5. After configuring the options, run following commands:

        cp .env.example .env
	php artisan key:generate
        php artisan serve

 6. Open the browser and hit the url: http://127.0.0.1:8000/. You would be good to go and start playing with the demo.


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


        
       