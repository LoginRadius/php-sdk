<?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'login') {
    header("Location: profile.php");
    exit();
}
include "config.php";
include("header.php");
?>
<div class="lr-form">
    <h2 class="text-center">LoginRadius Demo</h2><br/>
    <?php
    echo '<div id="messageinfo" class="messageinfo" style="display:none;">';
    echo '<p class="messages"></p>';
    echo '</div>';
    ?>   
   <h3>Registration</h3>         
            <?php include "login.php"; ?>
            <?php include "popup.php"; ?>    
            <div style="clear: both;"></div>
            <div class="OR"></div>
            <div id="registration-container"></div>   
            <div class="row">
                <div class="authLinks col-xs-9 col-sm-9 col-md-9">
                    <a href="forgot_password.php">Forgot password?</a>&nbsp;|&nbsp;<a href="index.php">Login</a>
                </div>
            </div>        
        <hr>
</div>
<script type="text/javascript">
    var registration_options = {};
    var sl_options = {};

    var registration_options = {}
    registration_options.onSuccess = function (response) {    
        handleResponse("An email has been sent to " + jQuery("#loginradius-registration-emailid").val() + ". Please verify your email address", 'success');
        jQuery('input[type="text"],input[type="password"],textarea,select').val(''); 
    };
    registration_options.onError = function (errors) {
        handleResponse(errors[0].Description, "error");
    };
    registration_options.container = "registration-container";       

    sl_options.onSuccess = function (response) {
        if (response.IsPosted) {
            handleResponse("An email has been sent to " + jQuery("#loginradius-socialRegistration-emailid").val() + ".Please verify your email address.", "success");
            jQuery('#social-registration-form').hide();
            jQuery('.OR, .interfacecontainerdiv').show();
        } else {      
            raasRedirect(response.access_token);
        }
    };
    sl_options.onError = function (errors) {
        handleResponse(errors[0].Description, "error");
        jQuery('#social-registration-form').hide();
    };
    sl_options.container = "social-registration-container";

    LRObject.util.ready(function () {
        LRObject.init("registration", registration_options);
        LRObject.init("socialLogin", sl_options);
        show_birthdate_date_block();
    });

</script>
<?php include("redirect.php"); ?> 
</body>
</html>