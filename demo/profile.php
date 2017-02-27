<?php
//load up your config file

include "config.php";
include_once 'functions.php';
$flag = '';
//If user is not logged in then return to index page
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

elseif (isset($_POST['value']) && $_POST['value'] == 'logout') {
    if (isset($_SESSION['admin'])) {
        session_destroy();
        header("Location: index.php");
    }
}

if (isset($_REQUEST['token']) && !empty($_REQUEST['token'])) {
    try {

        $socialObjects = new \LoginRadiusSDK\CustomerRegistration\Social\SocialLoginAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
        $accesstoken = $socialObjects->exchangeAccessToken($_REQUEST['token']);
        try {
            $authenticationObject = new \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
            try {
                $authenticationObject->getSocialProfile($accesstoken->access_token, 'Welcome Email');
                try {
                    $authenticationObject->accountLink($_SESSION['access_token'], $accesstoken->access_token);
                }
                catch (LoginRadiusSDK\LoginRadiusException $e) {
                    $message = $e->getErrorResponse()->Description;
                    $flag = 'error';
                }
            }
            catch (LoginRadiusSDK\LoginRadiusException $e) {
                $message = $e->getErrorResponse()->Description;
                $flag = 'error';
            }
        }
        catch (LoginRadiusSDK\LoginRadiusException $e) {
            $message = $e->getErrorResponse()->Description;
            $flag = 'error';
        }
    }
    catch (LoginRadiusSDK\LoginRadiusException $e) {
        $message = $e->getErrorResponse()->Description;
        $flag = 'error';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'accountUnLink') {    
    $authenticationObject = new \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
   try {
        $authenticationObject->accountUnlink($_SESSION['access_token'], $_POST['providerId'], $_POST['provider']);
        $message = 'Unlinked successfully';
        $response['status'] = 'success';
        $response["result"] = json_encode($message);
        echo json_encode($response);
        die;
    }
    catch (LoginRadiusSDK\LoginRadiusException $e) {
        $message = $e->getErrorResponse()->Description;    
        $response['status'] = 'error';
        $response["result"] = json_encode($message);
        echo json_encode($response);
        die;
    }
}

if (isset($_POST['update_profile']) && $_POST['update_profile'] == 'update') {
    if (isset($_POST['Country'])) {
        $coun = $_POST['Country'];
        unset($_POST['Country']);
        $count = array(
          'Code' => "",
          'Name' => $coun
        );
        $_POST['Country'] = $count;
    }
    unset($_POST['update_profile']);
    $update_profile = json_encode($_POST);
    try {
        $authenticationObject = new \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
        try {
            $authenticationObject->updateProfile($_SESSION['access_token'], $update_profile);
            try {
                $AccountObject = new \LoginRadiusSDK\CustomerRegistration\Management\AccountAPI(API_KEY, API_SECRET);
                $result = $AccountObject->getProfileByUid($_SESSION['Uid']);
                $_SESSION['userprofile'] = $result;
            }
            catch (LoginRadiusSDK\LoginRadiusException $e) {
                $message = $e->getErrorResponse()->Description;
                $flag = 'error';
            }
        }
        catch (LoginRadiusSDK\LoginRadiusException $e) {
            $message = $e->getErrorResponse()->Description;
            $flag = 'error';
        }
    }
    catch (LoginRadiusSDK\LoginRadiusException $e) {
        $message = $e->getErrorResponse()->Description;
        $flag = 'error';
    }
}
$user_data = ($_SESSION['userprofile']);
$_SESSION['Uid'] = $user_data->Uid;
include_once 'header.php';
?>
<div class="main">
    <?php
    echo '<div id="messageinfo" class="messageinfo ' . $flag . '" >';
    if (isset($message) && !empty($message)) {
        echo $message;
    }
    echo '</div>';
    ?>
    <!-- Add Profile page content-->
    <div class="lr-profile-frame lr-input-style">
        <div class="lr-profile-header">
            <?php
            $image_url = isset($user_data->ImageUrl) && !empty($user_data->ImageUrl) ? $user_data->ImageUrl : "user-blank.png";
            ?>
            <span class="lr-image-frame">
                <img src="<?php echo $image_url ?>" alt="<?php echo $user_data->UserName ?>">
            </span>

            <div class="lr-heading">Hello, <span class="lr-user-name"><?php echo $user_data->UserName; ?></span></div>

            <div class="lr-profile-info">
<?php if (isset($user_data->Email[0]->Value)) { ?> 
                    <div class="lr-email-info">
                        <span class="lr-value lr-em"><?php echo $user_data->Email[0]->Value; ?></span>
                    </div>
<?php } ?>
                <div class="lr-uid-info">
                    <span class="lr-label" style="font-size: larger;">UID: </span>
                    <span class="lr-value" style="font-size: larger;"><?php echo $user_data->Uid; ?></span>
                </div>
            </div>

            <!-- Add Menu tab items -->
            <div class="lr-menu-buttons">
                <span class="lr-buttons lr-tab-active" data-tab="lr-profile" style="font-size: larger;">Profile</span>
               <!-- <span class="lr-buttons" data-tab="lr-account-prov">Account Providers</span>-->
                <span class="lr-buttons" id="lr-password-tab" data-tab="lr-set-pw" style="font-size: larger;">Set Password</span>
                <span class="lr-logout" onclick='profileLogout();' style="font-size: larger;">Logout</span>
            </div>
        </div>
        <div id="lr-profile" class="form-signin lr-frame lr-align-left lr-tab-active">
            <div class ="row">
                <div class="col-lg-6">
                    <form  method="POST" role="form" action ="" style="width: 100%; border-right: solid #eeeeee;">
                        <center><?php echo getProfileForm($user_data); ?></center>
                    </form>
                </div>
                <div class="col-lg-6">
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
                    <center>
                        <h5>------------<b>Account Linking</b>------------</h5>
                    </center><br><br><br><br>
                    <div class="col-sm-6">
                        <div class="interfacecontainerdiv"></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="linked-account" align="left">
                            <?php
                            try {
                                $AccountObject = new \LoginRadiusSDK\CustomerRegistration\Management\AccountAPI(API_KEY, API_SECRET);
                                try {
                                    $profile_linked = $AccountObject->getProfileByUid($_SESSION['Uid']);
                                    if (is_string($profile_linked)) {
                                        $profile_linked = json_decode($profile_linked);
                                    }
                                }
                                catch (LoginRadiusSDK\LoginRadiusException $e) {
                                    $message = $e->getMessage();
                                    $flag = 'error';
                                }
                            }
                            catch (LoginRadiusSDK\LoginRadiusException $e) {
                                $message = $e->getMessage();
                                $flag = 'error';
                            }
                            $email = "";
                            if (isset($profile_linked) && !empty($profile_linked)) {

                                if (isset($profile_linked->Identities) && !empty($profile_linked->Identities)) {
                                    foreach ($profile_linked->Identities as $key => $linked_providers) {

                                        if ($_SESSION['mainprovider'] != $linked_providers->Provider) {
                                            echo '<img src= "images/mapping/' . strtolower($linked_providers->Provider) . '.png" > <h5> <b>' . ucfirst($linked_providers->Provider) . ' is Now Connected </b></h5><br>';
                                        }
                                        else {
                                            echo '<img src= "images/mapping/' . strtolower($linked_providers->Provider) . '.png" > <h5> <b style="color:green;">' . ucfirst($linked_providers->Provider) . ' is Connected </b></h5><br>';
                                        }
                                        if (isset($linked_providers->Email) && $linked_providers->Email != NULL) {
                                            $email = $linked_providers->Email[0]->Value;
                                            echo '<b>Email : </b>' . $email . '<br>';
                                        }

                                        echo '<b>User ID : </b>' . $linked_providers->ID;
                                        if ($_SESSION['mainprovider'] != $linked_providers->Provider) {
                                            echo '<span> <a style="margin-left:10px;cursor: pointer" onclick="return unLinkAccount(\''.$linked_providers->Provider.'\', \''.$linked_providers->ID.'\')">Unlink</a></span><hr>';
                                        }
                                        else {
                                            echo '<hr>';
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="lr-set-pw" class="lr-frame lr-set-pw lr-align-left">
<?php
include_once 'set_password.php';
?>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--<link rel="stylesheet" href="/resources/demos/style.css">-->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
                        $(function () {
                            $('#BirthDate').datepicker({
                                dateFormat: 'dd-mm-yy',
                                maxDate: new Date()
                            });
                        });
                        
                        
                        
                   function unLinkAccount(provider,providerId) {   
                        var url = window.location;                                           
                        $.ajax({
                            dataType: "json",
                            type: "POST",
                            url: url,
                            data: {'provider':provider, 'providerId':providerId,'action':'accountUnLink'},
                            success: function (data) {           
                               if (data.status == 'error') {
                                    alert(data.result);
                            } else if (data.status == 'success') {
                                    alert(data.result);
                                    window.location.href = window.location.href;
                            }
                            }
                        });
                        }
</script>

