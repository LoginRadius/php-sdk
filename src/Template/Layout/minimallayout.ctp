<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://auth.lrcontent.com/v2/js/LoginRadiusV2.js"></script> 
        <?= $this->Html->css('stylelr.css') ?>
        <?= $this->Html->script('jquery.min.js') ?>
        <?= $this->Html->script('options.js') ?>
        <?= $this->Html->script('index.js') ?>
        <?= $this->Html->script('sociallogin.js') ?>
        <?= $this->Html->script('emailverification.js') ?>
        <?= $this->Html->script('LoginRadiusLoginScreen.1.0.0.js') ?>
        
       
        
    </head>
    <body>
    
        <div class="section-menu">
        <div class="menu-header">
                <a href="">
                    <?=$this->Html->image('lr-logo.png')?>
                </a>
                <span style="display:block;margin-left:70px">CakePhp Web Demo</span>
                <div class="button-group">
                    <a href="minimal">Minimal</a>
                    <a href="loginscreen" >LoginScreen</a>
                </div>
            </div>


            <div class="vertical-menu">
                <a href="minimal" id="menu-login">Login</a>
                <a href="signup" id="menu-signup">Register</a>
                <a href="forgot" id="menu-forgotpassword">Forgot Password</a>
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
        <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken'); ?>" />
        <?= $this->fetch('content') ?>


        </body>
    </html>