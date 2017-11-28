<?php
//load up your config file

include "config.php";
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

$user_data = ($_SESSION['userprofile']);
$_SESSION['Uid'] = $user_data->Uid;
$_SESSION['provider'] = isset($user_data->Identities) ? $user_data->Identities[0]->Provider : '';
include_once 'header.php';
?>
<div class="main">
    <?php
    echo '<div id="messageinfo" class="messageinfo" style="display:none;">';
    echo '<p class="messages"></p>';
    echo '</div>';
    $image_url = isset($user_data->ImageUrl) && !empty($user_data->ImageUrl) ? $user_data->ImageUrl : "assets/images/user-blank.png";
    ?>
    <!-- Add Profile page content-->
    <div class="lr-profile-frame lr-input-style">
        <div class="lr-profile-header">

            <span class="lr-image-frame">
                <img src="<?php echo $image_url; ?>"/>
            </span>

            <div class="lr-heading">Hello, <span class="lr-user-name"><?php echo $user_data->UserName; ?></span></div>
            <div class="lr-profile-info">
                <?php if (isset($user_data->Email[0]->Value)) { ?> 
                    <div class="lr-email-info">
                        <span class="lr-value lr-em"><?php echo $user_data->Email[0]->Value; ?></span>
                    </div>
                <?php } ?>
                <div class="lr-uid-info">
                    <span class="lr-label" style="font-size: 12px;">UID: </span>
                    <span class="lr-value" style="font-size: 12px;"><?php echo $user_data->Uid; ?></span>
                </div>
            </div>

            <!-- Add Menu tab items -->
            <div class="lr-menu-buttons">
                <span class="lr-buttons lr-tab-active" data-tab="lr-profile" style="font-size: 14px;">Profile</span>
                <span class="lr-buttons" id="lr-password-tab" data-tab="lr-set-pw" style="font-size: 14px;">Change Password</span>
                <span class="lr-logout" onclick='profileLogout();' style="font-size: 14px;">Logout</span>
            </div>
        </div>
        <div id="lr-profile" class="form-signin lr-frame lr-align-left lr-tab-active">
            <div class ="row">
                <?php include("common.php"); ?>

                <div class="col-lg-6">
                    <center>
                        <h5>------------<b>My Profile</b>------------</h5>
                    </center><br><br><br><br>
                    <div id="profileeditor-container"></div>
                    <hr>
                    <script>
                        var profileeditor_options = {};
                        profileeditor_options.container = "profileeditor-container";
                        profileeditor_options.onSuccess = function (response) {
                            handleResponse("Profile updated successfully", "success");
                            window.setTimeout(function () {
                                jQuery('.messageinfo').hide();
                                jQuery('.messages').text("");
                            }, 5000);
                        };
                        profileeditor_options.onError = function (errors) {
                            handleResponse(errors[0].Description, "error");
                            window.setTimeout(function () {
                                jQuery('.messageinfo').hide();
                                jQuery('.messages').text("");
                            }, 5000);
                        };

                        LRObject.util.ready(function () {
                            LRObject.init("profileEditor", profileeditor_options);
                            show_birthdate_date_block();
                        });


                        function show_birthdate_date_block() {
                            var maxYear = new Date().getFullYear();
                            var minYear = maxYear - 100;
                            if (jQuery('body').on) {
                                jQuery('body').on('focus', '.loginradius-birthdate', function () {
                                    jQuery('.loginradius-birthdate').datepicker({
                                        dateFormat: 'mm-dd-yy',
                                        maxDate: new Date(),
                                        minDate: "-100y",
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: (minYear + ":" + maxYear)
                                    });
                                });
                            } else {
                                jQuery(".loginradius-birthdate").live("focus", function () {
                                    jQuery('.loginradius-birthdate').datepicker({
                                        dateFormat: 'mm-dd-yy',
                                        maxDate: new Date(),
                                        minDate: "-100y",
                                        changeMonth: true,
                                        changeYear: true,
                                        yearRange: (minYear + ":" + maxYear)
                                    });
                                });
                            }
                        }

                    </script>
                </div>

                <div class="col-lg-6">
                    <script type="text/javascript">
                        var la_options = {};
                        la_options.container = "interfacecontainerdiv";
                        la_options.templateName = 'loginradiuscustom_tmpl_link';
                        la_options.onSuccess = function (response) {
                            if (response.IsPosted != true) {
                                raasRedirect(response);
                            } else {
                                handleResponse("Account linked successfully", "success");
                                window.setTimeout(function () {
                                    jQuery('.messageinfo').hide();
                                    jQuery('.messages').text("");
                                    window.location.href = window.location.href;
                                }, 5000);
                            }
                        };
                        la_options.onError = function (errors) {
                            if (errors[0].Description != null) {
                                handleResponse(errors[0].Description, "error");
                                window.setTimeout(function () {
                                    jQuery('.messageinfo').hide();
                                    jQuery('.messages').text("");
                                }, 5000);
                            }
                        }

                        var unlink_options = {};
                        unlink_options.onSuccess = function (response) {
                            if (response.IsDeleted == true) {
                                handleResponse("Account unlinked successfully", "success");
                                window.setTimeout(function () {
                                    jQuery('.messageinfo').hide();
                                    jQuery('.messages').text("");
                                    window.location.href = window.location.href;
                                }, 5000);
                            }
                        };
                        unlink_options.onError = function (errors) {
                            handleResponse(errors[0].Description, "error");
                            window.setTimeout(function () {
                                jQuery('.messageinfo').hide();
                                jQuery('.messages').text("");                              
                            }, 5000);
                        }

                        LRObject.util.ready(function () {
                            LRObject.init("linkAccount", la_options);
                            LRObject.init("unLinkAccount", unlink_options);
                        });
                    </script>
                    <center>
                        <h5>------------<b>Account Linking</b>------------</h5>
                    </center><br><br><br><br>
                    <div class="col-sm-12">
                        <div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="linked-account" align="left">
                            <script type="text/html" id="loginradiuscustom_tmpl_link">
                                <# if(isLinked) { #>
                                <div class="lr-linked">
                                    <span style="font-size: 12px;" class="lr-provider-label" href="javascript:void(0)" title="<#= Name #>" alt="Connected">
                                        <#=Name#> is 
                                        <# if(<?php
                                        $value = isset($_SESSION['provider']) ? $_SESSION['provider'] : '';
                                        echo "'" . $value . "'"
                                        ?> == Name.toLowerCase()) { #>
                                    </span> <span style="color:green; font-size: 12px;"> <?php echo 'currently connected' ?>
                                        <# } else { #>
                                    </span> <span style="color:green; font-size: 12px;"> <?php echo 'connected' ?></span>                                    
                                    <a style="cursor: pointer; font-size:12px;" onclick='return  <#=ObjectName#>.util.unLinkAccount(\"<#= Name.toLowerCase() #>\",\"<#= providerId #>\")'>Unlink</a>
                                    <# }  #>	
                                </div>
                                <# }  else {#>
                                <div class="lr-unlinked">
                                    <div class="lr-icon-box">  
                                        <span class="lr-provider-label lr-sl-shaded-brick-button lr-flat-<#=Name.toLowerCase()#>"
                                              onclick="return  <#=ObjectName#>.util.openWindow('<#= Endpoint #>');" 
                                              title="Link with <#=Name#>" alt="Link with <#=Name#>">  
                                            <span class="lr-sl-icon lr-sl-icon-<#=Name.toLowerCase()#>"></span>  
                                            Link with <#=Name#>                 
                                        </span>
                                    </div>
                                </div>
                                <# } #>
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="lr-set-pw" class="lr-frame lr-set-pw lr-align-left">
                <?php
                include_once "set_password.php";
                include_once "redirect.php";
                ?>
            </div>
        </div>
    </div>



