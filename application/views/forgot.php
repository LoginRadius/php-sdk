<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
        <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script> 
        <script src="<?php echo base_url();?>assets/js/index.js"></script>  
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
                    <a href="<?php echo base_url();?>login">LoginScreen</a>
                </div>
            </div>
            <div class="vertical-menu">
                <a href="<?php echo base_url();?>minimal" id="menu-login">Login</a>
                <a href="<?php echo base_url();?>signup" id="menu-signup">Register</a>
                <a href="<?php echo base_url();?>forgot" id="menu-forgotpassword">Forgot Password</a>
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
            <center>
                <div class="container-small lrforgotpassword" style="display:block;">
                    <center><table>
                            <tr><td>Email Address: </td><td><input name="email" type='text' id='minimal-forgotpassword-email'/></td></tr>
                        </table></center>
                    <button id="btn-minimal-forgotpassword">Send</button><br/>
                    <span style="color:red" id="minimal-forgotpassword-errorMsg"></span>
                    <span style="color:green" id="minimal-forgotpassword-successMsg"></span>
                </div>

                <div class="container-small lrrestpassword" style="display:none;">
                    Password: <input name="email" type='password' id='minimal-resetpassword-password'/><br/>
                    Confirm Password: <input name="email" type='password' id='minimal-resetpassword-confirmpassword'/><br/>
                    <button id="btn-minimal-resetpassword">Reset Password</button><br/>
                    <span style="color:red" id="minimal-resetpassword-errorMsg"></span>
                    <span style="color:green" id="minimal-resetpassword-successMsg"></span>
                </div>
            </center>                
        </div>       
    </body>
</html>