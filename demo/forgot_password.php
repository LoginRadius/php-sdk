<?php
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
include "config.php";
include_once "functions.php";
use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use LoginRadiusSDK\LoginRadiusException;
$authenticationapi = new UserAPI(API_KEY, API_SECRET);
$flag = '';
if(isset($_POST) && !empty($_POST)){

    if (isset($_POST['forget-submit'])) {
        try {
            $result = json_decode($authenticationapi->forgotPassword($_POST['email'], $actual_link));
            if($result->IsPosted){
                $message = 'Forgot password link has been send to '.$_POST['email'];
                $flag = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $message = $e->getMessage();
            $flag = 'error';
        }
    }
    elseif(isset($_POST['reset-submit'])){
     try {
        $result = json_decode($authenticationapi->resetPassword($_POST['vtoken-submit'], $_POST['password'])); 
        if($result->IsPosted){
            $message = 'Password Reset Successfully';
            $flag = 'success';
        }
     }catch (LoginRadiusException $e) {
           $message = $e->getMessage();
            $flag = 'error';
          }
    }
}
include("header.php");
   if(isset($_GET['vtype']) && $_GET['vtype'] == 'reset'){
        if(isset($_GET['vtoken'])){
            
        ?>
            <div class="lr-form">
                <h2 class="text-center">LoginRadius Demo</h2>
                <?php
                echo '<div id="messageinfo" class="messageinfo '.$flag .'" >';
                if(isset($message) && !empty($message)){
                    echo $message;
                }
                echo '</div>';
                ?>
                <div class="form-header">
                     <h4> Reset Password</h4>
                </div>
                <form id="lr-form" method="post" class="form-signin" role="form" onsubmit="return validateResetForm()">
                    <div class="form-group">
                        <input name="password" id="password" type="password" class="form-control" placeholder="Password">
                        <span class="error-message-reset-password" style="display:none; color: red;"></span>
                    </div>
                    <div class="form-group">
                        <input name="confirmpassword" id="confirmpassword" type="password" class="form-control" placeholder="Confirm Password">
                         <span class="error-message-reset-confirm" style="display:none; color: red;"></span>
                    </div>
                        <input type="hidden" name = "vtoken-submit" value="<?php echo $_GET['vtoken']; ?>" />
                    <button class="btn btn-block bt-login" name="reset-submit" type="submit">Submit</button>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <i class="fa fa-lock"></i>
                            <a href="signup.php"> Sign Up </a>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <i class="fa fa-check"></i>
                            <a href="index.php"> Sign in </a>
                        </div>
                    </div>
                </form>
            </div>
        <?php
      }

    }
    else{
   
    
?>
<div class="lr-form">
    <h2 class="text-center">LoginRadius Demo</h2><br/>
    <?php
        echo '<div id="messageinfo" class="messageinfo '.$flag .'" >';
        if(isset($message) && !empty($message)){
            echo $message;
        }
        echo '</div>';
    ?>
    <div class="form-header">
       <h4> Forgot Password</h4>
    </div>
    <form id="lr-form" method="post" class="form-signin" role="form" action="">
        <input name="email" id="email" type="email" class="form-control" placeholder="Email address" required="required" autofocus>

        <button class="btn btn-block bt-login" name="forget-submit" type="submit">Submit</button>
        <hr>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <i class="fa fa-lock"></i>
                <a href="signup.php"> Sign Up </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <i class="fa fa-check"></i>
                <a href="index.php"> Sign in </a>
            </div>
        </div>
    </form>
    <br/>
</div>
    <?php } ?>
 <p>&nbsp; </p>
</body>
</html>
<script>
    function validateResetForm() {
   
        var newPassword = document.getElementById("password").value;       
        var confirmPassword = document.getElementById("confirmpassword").value;        
                 
                    $('.error-message-reset-password').hide();
                    $('.error-message-reset-confirm').hide();        
                   
                    if (newPassword == null || newPassword == "") {
                        var message = "The password field is required";
                        $('.error-message-reset-password').html(message).show();
                        return false;
                    } else if(newPassword.length < '6'){
                        var message = "The Password field must be at least 6 characters in length.";
                        $('.error-message-reset-password').html(message).show();
                        return false;
                    }
                    if (confirmPassword == null || confirmPassword == "") {
                        var message = "The confirm password field is required";
                        $('.error-message-reset-confirm').html(message).show();
                        return false;
                    } else if(confirmPassword.length < '6'){
                        var message = "The confirm password field must be at least 6 characters in length.";
                        $('.error-message-reset-confirm').html(message).show();
                        return false;
                    } else if(newPassword != confirmPassword){
                        var message = "Passwords do not match!";
                        $('.error-message-reset-confirm').html(message).show();
                        return false;
                    }
    }
</script>  
