<!DOCTYPE html>
<html>
<head>
    <title>LoginRadius | Customer Registration Demo</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="LoginRadius Customer Registration Popup Theme project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/css/lr-raas.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/customize.css">
    <link rel="stylesheet" type="text/css" href="assets/css/custom-social.css">
    <link rel="stylesheet" type="text/css" href="assets/css/social-icons.css">

    <!-- Customizing -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

    <!-- LoginRadius JS -->
    <script>
        var LocalDomain = '<?php echo PAGEPATH ?>';
        var lrThemeSettings = {
            raasoption: {
                apikey: "<?php echo LR_API_KEY;?>",
                appname: "<?php echo LR_APP_NAME;?>",
                forgotPasswordUrl: LocalDomain,
                emailVerificationUrl: LocalDomain
            },
            logo: {
                logo_image_path: "", /* Your logo image path, must be 28px * 28px */
                logo_alt_text: "" /* Alternative text for Image */
            },
            caption_message: {
                register: "Register",
                login: "Login",
                forgot_password: "Forgot Password",
                reset_password: "Reset Password",
                fields_missing: "One Step Left"
            },
            success_message: {
                register: "Succeed, a verification email has been sent to your email address",
                login: "Login succeed",
                social_login: "Social login succeed", /* Or maybe go check your emails to verify for Twitter */
                email_verified: "Email verified successfully, you can login now",
                forgot_password: "A reset link has been sent to your email address, click to reset your email",
                reset_password: "Your password has been reset",
                verify_email:"Email verified successfully, you can login now"
            },
            success_function: {
                register: function () {
                    //alert('register succeed!');
                },
                login: function () {
                    //alert('login succeed!');
                },
                social_login: function () {
                    //alert('social login succeed!')
                },
                forgot_password: function () {
                    //alert('reset link has been sent');
                },
                reset_password: function () {
                    //alert('you have successfully reset your password');
                }
            },
            form_render_submit_hook: {
                start: function () {
                    //console.log( 'start' );
                },
                end: function () {
                    //console.log( 'end' );
                }
            },
            reset_form_after_close_popup: false,
            auto_login_after_verify_email: false
        }
    </script>


    <script src="//hub.loginradius.com/include/js/LoginRadius.js"></script>
    <script src="//cdn.loginradius.com/hub/prod/js/LoginRadiusRaaS.js"></script>
    <?php if (isset($_SESSION['user_id'])) {
        echo '<script type="text/javascript">isloggedin = "true";</script>';
    } else {
        echo '<script type="text/javascript">isloggedin = "false";</script>';
    }?>
    <!-- Developement -->
    <script type="text/javascript" src="assets/js/lr-theme-full.js"></script>

    <!-- Production -->
    <?php if (!isset($_SESSION['user_id'])) { ?>
        <script type="text/html" id="loginradiuscustom_tmpl">
            <span class="lr-provider-label lr-sl-shaded-brick-button lr-flat-<#=Name.toLowerCase()#>"
                  onclick="return $SL.util.openWindow('<#= Endpoint #>&is_access_token=true&callback=<#= window.location #>');"
                  title="Sign up with <#= Name #>" alt="Sign in with <#=Name#>">
                  <span class="lr-sl-icon lr-sl-icon-<#=Name.toLowerCase()#>"></span>
                  Sign up with <#=Name#>
            </span>
        </script>
    <?php
    }
    ?>
    <script type="text/html" id="loginradiuscustom_tmpl_IOS">
        <span class="lr-provider-label lr-sl-shaded-brick-button lr-flat-<#=Name.toLowerCase()#>"
              onclick="return $SL.util.openWindow('<#= Endpoint #>&is_access_token=true&callback=<#= window.location #>&callbacktype=hash');"
              title="Sign up with <#= Name #> IOS" alt="Sign in with <#=Name#> IOS">
                  <span class="lr-sl-icon lr-sl-icon-<#=Name.toLowerCase()#>"></span>
                  Sign up with <#=Name#> IOS
            </span>
    </script>
</head>
<body>
<div class="main-nav">
    <div class="container"></div>
</div>
<!-- Start Things -->
<div class="main">
    <div class="messagediv" style="display:none">
        <ul>
            <li class="top-tootip" style="width:96%">
                <p id="messageinfo"></p>
                <span> </span>
            </li>
            <div class="clear"></div>
        </ul>
    </div>
    <!-- Add Logo Here -->
    <nav class="main-nav sticky-nav">
        <div class="container cf">
            <div class="logo no-text">
                <div class="logo-box">
                    <h1 class="logo">
                        <a href="/">LoginRadius</a>
                    </h1>

                    <div class="site-description">Customer registration php demo</div>
                </div>
            </div>

            <?php if (!isset($_SESSION['user_id'])) { ?>
                <!-- Add Login/Register Link -->
                <div class="secondary-menu">
                    <ul id="menu-top-menu" class="menu">
                        <li id="menu-item-92"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-92"><a
                                class="lr-raas-button lr-raas-theme-login">Login</a></li>
                        /
                        <li id="menu-item-93"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-93"><a
                                class="lr-raas-button lr-raas-theme-register">Register</a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </nav>
