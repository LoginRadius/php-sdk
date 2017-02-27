<?php

use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use LoginRadiusSDK\LoginRadiusException;

include_once "functions.php";

$authenticationapi = new UserAPI(API_KEY, API_SECRET);
$flag = '';

if (isset($_POST) && !empty($_POST)) {
    if (isset($_POST['setpassword-submit'])) {
        try {
            $result = json_decode($authenticationapi->changeAccountPassword($_SESSION['access_token'], $_POST['oldpassword'], $_POST['password']));
            if ($result->IsPosted) {
                $message = 'Password Set Successfully';
                $flag = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $message = $e->getMessage();
            $flag = 'error';
        }
        ?>
        <script>
            $('.lr-menu-buttons .lr-buttons').removeClass('lr-tab-active');
            $('.lr-frame').removeClass('lr-tab-active');
            $('#lr-password-tab').addClass('lr-tab-active');
            $('#lr-set-pw').addClass('lr-tab-active');
        </script>
        <?php
    }
}
?>
<div class="lr-form">
    <h2 class="text-center">LoginRadius Demo</h2>
    <?php
    echo '<div id="messageinfo" class="messageinfo ' . $flag . '" >';
    if (isset($message) && !empty($message)) {
        echo $message;
    }
    echo '</div>';
    ?>
    <div class="form-header">
        <h4> Set Password</h4>
    </div>
    <form id="lr-form" method="post" class="form-signin" role="form" onsubmit="return validateForm()">
        <div class="form-group">
            <input name="oldpassword" id="oldpassword" type="password" class="form-control" placeholder="Old Password" autofocus>
             <span class="error-message-old-password" style="display:none; color: red;"></span>
        </div>
        <div class="form-group">
            <input name="password" id="password" type="password" class="form-control" placeholder="Password">
             <span class="error-message-password" style="display:none; color: red;"></span>
        </div>
        <div class="form-group">
            <input name="confirmpassword" id="confirmpassword" type="password" class="form-control" placeholder="Confirm Password">
            <span class="error-message-confirm-password" style="display:none; color: red;"></span>
        </div>
        <button class="btn btn-block bt-login" name="setpassword-submit" type="submit">Submit</button>
    </form>    
</div>
<script>
    function validateForm() {
   
        var oldPassword = document.getElementById("oldpassword").value;
        var newPassword = document.getElementById("password").value;       
        var confirmPassword = document.getElementById("confirmpassword").value;
        
                    $('.error-message-old-password').hide();
                    $('.error-message-password').hide();
                    $('.error-message-confirm-password').hide();
        
                    if (oldPassword == null || oldPassword == "") {
                        var message = "The old password field is required";
                        $('.error-message-old-password').html(message).show();
                        return false;
                    }
                    if (newPassword == null || newPassword == "") {
                        var message = "The password field is required";
                        $('.error-message-password').html(message).show();
                        return false;
                    } else if(newPassword.length < '6'){
                        var message = "The Password field must be at least 6 characters in length.";
                        $('.error-message-password').html(message).show();
                        return false;
                    }
                    if (confirmPassword == null || confirmPassword == "") {
                        var message = "The confirm password field is required";
                        $('.error-message-confirm-password').html(message).show();
                        return false;
                    } else if(confirmPassword.length < '6'){
                        var message = "The confirm password field must be at least 6 characters in length.";
                        $('.error-message-confirm-password').html(message).show();
                        return false;
                    } else if(newPassword != confirmPassword){
                        var message = "Passwords do not match!";
                        $('.error-message-confirm-password').html(message).show();
                        return false;
                    }
    }
</script>  