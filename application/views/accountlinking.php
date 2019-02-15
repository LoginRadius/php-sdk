<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
        <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script> 
        <script src="<?php echo base_url();?>assets/js/logout.js"></script> 
        <script type="text/javascript" src="https://auth.lrcontent.com/v2/js/LoginRadiusV2.js"></script>
        <script src="<?php echo base_url();?>assets/js/options.js"></script>  
        <script src="<?php echo base_url();?>assets/js/accountlinking.js"></script>  
    </head>
    <body>
        <div class="section-menu">
            <div class="menu-header">
                <a href="">
                    <img src="<?php echo base_url();?>assets/images/lr-logo.png"/>
                </a>CodeIgniter Web Demo</span>
                <div class="button-group">
                    <a href="<?php echo base_url();?>minimal">Minimal</a>
                    <a href="<?php echo base_url();?>login">LoginScreen</a>
                </div>
            </div>
            <div class="vertical-menu">
                <a href="<?php echo base_url();?>profile" id="menu-profile">Profile</a>
                <a href="<?php echo base_url();?>changepassword" id="menu-changepassword">Change Password</a>
                <a href="<?php echo base_url();?>setpassword" id="menu-setpassword">Set Password</a>
                <a href="<?php echo base_url();?>account" id="menu-account">Update Account</a>
                <a href="<?php echo base_url();?>accountlinking" id="menu-accountlinking">Account Linking</a>
                <a href="<?php echo base_url();?>customobjects" id="menu-customobjects">Custom Object Management</a>
                <a href="<?php echo base_url();?>multifactor" id="menu-multifactor">Reset MultiFactor</a>
                <a href="<?php echo base_url();?>roles" id="menu-roles">Roles Management</a>
                <a href="" id="menu-user-logout">Logout</a>
            </div>
        </div>
        <div class="section-main section-minimal">
            <center><span id="accountlinking-message"></span>
                <div class="container">
                    <div class="col-sm-12">
                        <div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="linked-account" align="left">
                            <script type="text/html" id="loginradiuscustom_tmpl_link">
                                <# if(isLinked) { #>
                                <div class="lr-linked">
                                    <a class="lr-provider-label" href="javascript:void(0)" title="<#= Name #>" alt="Connected">
                                        <#=Name#> is connected
                                    </a>
                                    <a onclick='return <#=ObjectName#>.util.unLinkAccount(\"<#= Name.toLowerCase() #>\",\"<#= providerId #>\")' style="cursor: pointer;">Unlink</a>
                                </div>
                                <# }  else {#>
                                <div class="lr-unlinked">
                                    <a class="lr-provider-label" href="javascript:void(0)" onclick="return <#=ObjectName#>.util.openWindow('<#= Endpoint #>');" title="<#= Name #>" alt="Sign in with <#=Name#>">
                                        <#=Name#></a>    </div>
                                <# } #>
                                </script>
                            </div>
                        </div>
                    </div>
                </center>                
            </div>       
        </body>
    </html>