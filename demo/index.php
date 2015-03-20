<?php
include_once('config.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>LoginRadius :: SocialLogin Demo</title>
        <script src="https://hub.loginradius.com/include/js/LoginRadius.js" ></script>
        <script type="text/javascript">
            var lr_options = {};
            lr_options.login = true;
            LoginRadius_SocialLogin.util.ready(function () {
                $ui = LoginRadius_SocialLogin.lr_login_settings;
                $ui.interfacesize = "";
                $ui.apikey = "<?php echo LR_APIKEY; ?>";
                $ui.callback = "<?php echo YOUR_DOMAIN . 'callback.php'; ?>";
                $ui.lrinterfacecontainer = "interfacecontainerdiv";
                LoginRadius_SocialLogin.init(lr_options);
            });
        </script>
        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="css/styles.css" />
    </head>    
    <body>
        <div id="formContainer">
            <div style="font-size: 37px;margin-bottom: 20px;">Social Login</div>        
            <div class="interfacecontainerdiv" id="interfacecontainerdiv"></div>
        </div>
    </body>
</html>

