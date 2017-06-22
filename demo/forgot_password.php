<?php
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
    <h3> Forgot Password</h3>
    <div id="forgotpassword-container"></div>
    <div class="row">
        <div class="authLinks col-xs-9 col-sm-9 col-md-9">
            <a href="signup.php">Sign Up</a>&nbsp;|&nbsp;<a href="index.php">Login</a>
        </div>
    </div>      
    <hr>     
</div>
<?php include("common.php"); ?>
<script type="text/javascript">
    var forgotpassword_options = {};
    forgotpassword_options.container = "forgotpassword-container";
    forgotpassword_options.onSuccess = function (response) {
        handleResponse("An email has been sent to " + jQuery("#loginradius-forgotpassword-emailid").val() + " with reset Password link", "success");
        jQuery('input[type="text"]').val(''); 
    };
    forgotpassword_options.onError = function (errors) {
        handleResponse(errors[0].Description, "error");
    }

    LRObject.util.ready(function () {
        LRObject.init("forgotPassword", forgotpassword_options);
    });

</script>
<?php include("redirect.php"); ?>
</body>
</html>
