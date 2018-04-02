<?php
include "config.php";
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'login') {
    header("Location: profile.php");
    exit();
}

use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use LoginRadiusSDK\CustomerRegistration\Social\SocialLoginAPI;

$message = '';
$flag = '';
include("header.php");


if (isset($_REQUEST) && !empty($_REQUEST)) {
    
    $post_value = $_REQUEST;
    try {
        $socialObject = new SocialLoginAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
    }
    catch (LoginRadiusException $e) {
        $message = 'Api key & secret key are required parameter';
        $flag = 'error';
    }
    try {
        $authenticationapi = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
    }
    catch (LoginRadiusException $e) {
        $message = 'Api key & secret key are required parameter';
        $flag = 'error';
    }

    if (isset($post_value['token'])) {
        $accesstoken = $socialObject->exchangeAccessToken($post_value['token']);
        try {

            $result = $authenticationapi->getProfile($accesstoken->access_token);
            $_SESSION['access_token'] = $accesstoken->access_token;

            if ((isset($result->EmailVerified) && $result->EmailVerified)|| AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                $_SESSION['userprofile'] = $result;
                $_SESSION['mainprovider'] = $result->Identities ? $result->Identities[0]->Provider : '';
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
?>
<div class="lr-form">
    <h2 class="text-center">LoginRadius Demo</h2>
    <?php
    echo '<div id="messageerror" class="messageerror ' . $flag . '" >';
    if (isset($message) && !empty($message)) {
        echo $message;
    }
    echo '</div>';
    ?>
    <?php
    echo '<div id="messageinfo" class="messageinfo" style="display:none;">';
    echo '<p class="messages"></p>';
    echo '</div>';
    ?>
    <h3> Login</h3>
    <?php include "login.php"; ?>
    <?php include "popup.php"; ?>    
    <div style="clear: both;"></div>
    <div class="OR"></div>
    <div id="login-container"></div>
    <div id="resetpassword-container" style="display: block"></div>
    <div class="row">
        <div class="authLinks col-xs-9 col-sm-9 col-md-9">
            <a href="forgot_password.php">Forgot password?</a>&nbsp;|&nbsp;<a href="signup.php">Sign Up</a>
        </div>
    </div>
    <hr>
</div>
<script type="text/javascript">

    var login_options = {};
    var sl_options = {};

    login_options.onSuccess = function (response) {
        raasRedirect(response.access_token);
    };
    login_options.onError = function (errors) {
        handleResponse(errors[0].Description, "error");
    };
    login_options.container = "login-container";

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
        LRObject.init("login", login_options);
        LRObject.init('socialLogin', sl_options);
    });


    var vtype = LRObject.util.getQueryParameterByName("vtype");
    if (vtype != null && vtype != "") {
        if (vtype == "reset") {
            var resetpassword_options = {};
            resetpassword_options.container = "resetpassword-container";
            resetpassword_options.onSuccess = function (response) {
                handleResponse("Password reset successfully", "success");
            };
            resetpassword_options.onError = function (errors) {
                handleResponse(errors[0].Description, "error");
            }
            LRObject.util.ready(function () {
                LRObject.init("resetPassword", resetpassword_options);
            });
        } else if (vtype == "emailverification") {
            var verifyemail_options = {};
            verifyemail_options.onSuccess = function (response) {
                if (response.access_token != null && response.access_token != "") {
                    raasRedirect(response.access_token);
                } else {
                    handleResponse("Your email has been verified successfully", "success");
                }
            };
            verifyemail_options.onError = function (errors) {
                handleResponse(errors[0].Description, "error");
            }

            LRObject.util.ready(function () {
                LRObject.init("verifyEmail", verifyemail_options);
            });
        }
    }
</script>
<?php include("redirect.php"); ?>
</body>
</html>