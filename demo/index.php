<?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'login') {
    header("Location: profile.php");
    exit();
}
include "config.php";
include_once "functions.php";

use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use LoginRadiusSDK\CustomerRegistration\Social\SocialLoginAPI;
use LoginRadiusSDK\LoginRadiusException;

if (isset($_POST['action']) && $_POST['action'] == 'updateProfile') {
    $authenticationapi = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
    $data = '{
  "Email": [
    {
      "Type": "Primary",
      "Value": "' . $_POST['email'] . '"
    }
  ]  
}';

    $emailVerificationUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    $emailVerificationTemplate = '';

    try {
        $result = $authenticationapi->updateProfile($_SESSION['access_token'], $data, $emailVerificationUrl, $emailVerificationTemplate);
        if ($result->IsPosted) {
            $message = 'A verification email has been sent to ' . $_POST['email'];
            $response['status'] = 'success';
            $response['result'] = $message;
            echo json_encode($response);
            die;
        }
    }
    catch (LoginRadiusException $e) {
        $message = $e->getMessage();
        $response['status'] = 'error';
        $response['result'] = $message;
        echo json_encode($response);
        die;
    }
}

$message = '';
$flag = '';
include("header.php");
if (isset($_POST) && !empty($_POST)) {
    $socialObject = new SocialLoginAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
    $authenticationapi = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));

    if (isset($_POST['login-submit'])) {
        try {
            $result = $authenticationapi->loginByEmail($_POST['email'], $_POST['password']);
            if (isset($result->Profile)) {
                $_SESSION['access_token'] = $result->access_token;
                $_SESSION['userprofile'] = $result->Profile;
                $_SESSION['mainprovider'] = $result->Profile->Provider;
                $_SESSION['admin'] = 'login';
                $profileUrl = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
                $url = explode('/', $profileUrl);
                array_pop($url);
                $url2 = implode("/", $url);
                echo('<script>window.location.href = "' . $url2 . '/profile.php"</script>');
                exit();
            }
        }
        catch (LoginRadiusException $e) {
            $message = $e->getMessage();
            $flag = 'error';
        }
    }
    elseif (isset($_POST['token'])) {
        $accesstoken = $socialObject->exchangeAccessToken($_POST['token']);
        try {
            $result = $authenticationapi->getProfile($accesstoken->access_token);

            $_SESSION['access_token'] = $accesstoken->access_token;
            if ($result->EmailVerified) {
                $_SESSION['userprofile'] = $result;
                $_SESSION['mainprovider'] = $result->Identities[0]->Provider;
                $_SESSION['admin'] = 'login';
                $profileUrl = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
                $url = explode('/', $profileUrl);
                array_pop($url);
                $url2 = implode("/", $url);
                echo('<script>window.location.href = "' . $url2 . '/profile.php"</script>');
                exit();
            }
            else {
                if (!$result->EmailVerified || $result->Email == '') {
                    echo "<script>";
                    echo "showPopup()";
                    echo "</script>";
                }
            }
        }
        catch (LoginRadiusException $e) {
            $message = $e->getMessage();
            $flag = 'error';
        }
    }
}
if (isset($_GET['vtype']) && $_GET['vtype'] == 'emailverification' && !empty($_GET['vtoken'])) {
    $emailVerificationUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    $authenticationapi = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
    try {

        $result = $authenticationapi->verifyEmail($_GET['vtoken'], $emailVerificationUrl);
        if (isset($result->IsPosted) && $result->IsPosted) {
            $_SESSION['access_token'] = $result->Data->access_token;
            $_SESSION['userprofile'] = $result->Data->Profile;
            $_SESSION['mainprovider'] = $result->Data->Profile->Provider;
            if (isset($result->Data->access_token) && !empty($result->Data->access_token)) {
                $_SESSION['admin'] = 'login';
                $profileUrl = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
                $url = explode('/', $profileUrl);
                array_pop($url);
                $url2 = implode("/", $url);
                echo('<script>window.location.href = "' . $url2 . '/profile.php"</script>');
                exit();
            }
            else {
                $message = 'Email Verified. Please Login';
                $flag = 'success';
            }
        }
    }
    catch (LoginRadiusSDK\LoginRadiusException $e) {
        $message = $e->getErrorResponse()->Description;
        $flag = 'error';
    }
}
?>
<div class="lr-form">
    <h2 class="text-center">LoginRadius Demo</h2><br/>
    <?php
    echo '<div id="messageinfo" class="messageinfo ' . $flag . '" >';
    if (isset($message) && !empty($message)) {
        echo $message;
    }
    echo '</div>';
    ?>
    <div class="form-header">
        <h4> Login</h4>
    </div>
    <script type="text/javascript">
        var options = {};
        options.login = true;
        LoginRadius_SocialLogin.util.ready(function () {
            $ui = LoginRadius_SocialLogin.lr_login_settings;
            $ui.interfacesize = "small";
            $ui.is_access_token = true;
            $ui.apikey = '<?php echo API_KEY; ?>';
            $ui.callback = window.location;
            $ui.lrinterfacecontainer = "interfacecontainerdiv";
            LoginRadius_SocialLogin.init(options);
        });
        if (window.LoginRadiusSDK) {
            LoginRadiusSDK.setLoginCallback(function () {
                var token = LoginRadiusSDK.getToken();
                var form = document.createElement('form');
                form.action = window.location;
                form.method = 'POST';

                var hiddenToken = document.createElement('input');
                hiddenToken.type = 'hidden';
                hiddenToken.value = token;
                hiddenToken.name = 'token';
                form.appendChild(hiddenToken);

                document.body.appendChild(form);
                form.submit();
            });
        }
    </script>
    <form id="lr-form" method="post" class="form-signin" role="form" action="">
        <center><h5>------------<b>Social Login</b>------------</h5>
            <div class="interfacecontainerdiv"></div></center>

        <center><h5>------------<b>Or Login with email</b>------------</h5></center>
        <div class="form-group">
            <input name="email" id="email" type="email" class="form-control" placeholder="Email address" autofocus required>
        </div>
        <div class="form-group">
            <input name="password" id="password" type="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-block bt-login" name="login-submit" type="submit">Sign in</button>
        <hr>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <i class="fa fa-lock"></i>
                <a href="forgot_password.php"> Forgot password? </a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <i class="fa fa-check"></i>
                <a href="signup.php"> Sign Up </a>
            </div>
        </div>
    </form>
    <br/>
</div>
<div class="emailPopup" id="showEmailPopup" style="display: none;">
    <div class="popupModal-content">

        <div class="popupModal-header">
            <div onclick="closePopup();" class="close">x</div><h4>Please fill the following details to proceed</h4></div>
        <div class="messageinfo success" id="messageDiv" style="display:none;">
            <span class="message"></span>
            <div class="clear"></div>
        </div>
        <div class="popupModal-body"><br>        
            <div class="email">
                <label for="email">Email</label>
                <input type="text" id="email_popup" name="email_popup" value="" class="form-text" required>
            </div><br>
            <input type="submit" name="register-popup" onclick="addEmailPopup();" value="register" id="register" class="register">

            <div style="clear:both;"></div>                      
        </div>
        <div class="popupModal-footer"><h3>&nbsp;</h3></div>
    </div>
</div>
</body>
</html>