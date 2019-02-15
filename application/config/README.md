CodeIgniter Demo

Disclaimer
This guide assumes you have some sort of web server set up.

If you don't know how to set up a local server read these guides here or set up a small GitHub webserver here

Setup
Download our Codeigniter demo project from Github here and put it in your root directory on your server.

Open api_helper.php (File Location application\helpers\api_helper.php)  and put in your apikey, sitename and sott
       
        define('API_KEY', ''); // Pass API Key
        define('API_SECRET', '');  // Pass API Secret Key
        define('API_REQUEST_SIGNING', false); // Pass boolean true/false for enable/disable
        define('AUTH_FLOW', '');

Then open the option.js(File Location \assets\js\option.js) and put in your apikey, sitename and sott
       
        var commonOptions = {};
        commonOptions.apiKey = "";
        commonOptions.appName = "internal-apeksha";
        commonOptions.hashTemplate = true;
        commonOptions.sott = "<SOTT>";
        commonOptions.formValidationMessage = true;
        commonOptions.verificationUrl = domainName+"/login";
        commonOptions.resetPasswordUrl = domainName+"/login";
        var LRObject = new LoginRadiusV2(commonOptions);

After configuring the options, go to your web browser and type in the root directory URL that your server is hosting.

You would be good to go and start playing with the demo.



        
       