<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
        <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script> 
        <script src="https://auth.lrcontent.com/v2/js/LoginRadiusV2.js"></script> 
        <script src="<?php echo base_url();?>assets/js/options.js"></script>  
        <script src="<?php echo base_url();?>assets/js/index.js"></script>  
        <script src="<?php echo base_url();?>assets/js/sociallogin.js"></script> 
        <script src="<?php echo base_url();?>assets/js/emailverification.js"></script> 
    </head>
    <body>
        <div class="section-menu">
            <div class="menu-header">
                <a href="">
                    <img src="<?php echo base_url();?>assets/images/lr-logo.png"/>
                </a>
                <span style="display:block;margin-left:70px">CodeIgniter Web Demo</span>
                <div class="button-group">
                    <a href="<?php echo base_url();?>minimal">Minimal</a>
                    <a href="<?php echo base_url();?>loginscreen">LoginScreen</a>
                </div>
            </div>
            <div class="vertical-menu">
                <a href="<?php echo base_url();?>minimal" id="menu-login">Login</a>
                <a href="<?php echo base_url();?>signup" id="menu-signup">Register</a>
                <a href="<?php base_url();?>forgot" id="menu-forgotpassword">Forgot Password</a>
            </div>
        </div>
        <div class="overlay" id="lr-loading" style="display: none;">
            <div class="lr_loading_screen">
                <div class="lr_loading_screen_center" style="position: fixed;">
                    <div class="lr_loading_screen_spinner"></div> 
                    <div class="lr_loading-phrases-container">
                        <div class="lr_loading-phrases_wrap">
                            <div class="lr_loading_phrase">Please wait...</div>                      
                        </div>              
                    </div>                                   
                </div>     
            </div>
        </div>
        <div class="section-main section-minimal">       
            <center><span id="emailverification-message"></span>
                <div class="container">
                    <center><table>
                            <tr><th colspan="2">Traditional Login</th></tr>
                            <tr><td>Email Address: </td><td><input name="email" type='text' id='minimal-login-email'/></td></tr>
                            <tr><td>Password: </td><td><input name="password" type='password' id='minimal-login-password'/></td></tr>
                        </table></center>
                    <button id="btn-minimal-login">Login</button><br/>
                    <span style="color:red" id="minimal-login-errorMsg"></span>
                    <br></br>

                    <center><table>
                            <tr><th colspan="2">Multi-Factor Login</th></tr>
                            <tr><td>Email Address: </td><td><input name="email" type='text' id='minimal-mfalogin-email'/></td></tr>
                            <tr><td>Password: </td><td><input name="password" type='password' id='minimal-mfalogin-password'/></td></tr>
                        </table>
                    </center>
                    <button id="btn-minimal-mfalogin-next">Next</button><br/>
                    <div id="minimal-mfalogin-login"></div>
                    <span style="color:red" id="minimal-mfalogin-errorMsg"></span>
                    <br></br>
                    <center>
                        <table>
                            <tr><th colspan="2">Passwordless Login</th></tr>
                            <tr><td>Email Address: </td><td><input name="email" type='text' id='minimal-pwless-email'/></td></tr>
                        </table>
                    </center>
                    <button id="btn-minimal-pwless">Email me a link to sign in</button><br/>
                    <span style="color:red" id="minimal-pwless-errorMsg"></span>
                    <span style="color:green" id="minimal-pwless-successMsg"></span>
                    <br></br>

                    <b>Social Login</b><br/>                            
                    <script type="text/html" id="loginradiuscustom_tmpl">
                        <a class="lr-provider-label" href="javascript:void(0)" onclick="return LRObject.util.openWindow('<#= Endpoint #>');" title="<#= Name #>" alt="Sign in with <#=Name#>">
                            <span class="lr-ls-icon lr-ls-icon-<#= Name #>"></span>
                        </a>&nbsp;&nbsp;&nbsp;
                        </script>

                        <div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
                        <div id="sociallogin-container"></div>

                    </div><br></br><br></br><br></br>
                </center>
            </div>
        </body>
    </html>