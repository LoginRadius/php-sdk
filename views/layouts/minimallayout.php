<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
    <html lang="en">
        <head>
            <title>Login</title>
            <meta charset="utf-8" />
            
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />

            <?php $this->head() ?>
        </head>
        <body>
        <div class="section-menu">
            <div class="menu-header">
                <a href="">

                  <?=Html::img('@web/images/lr-logo.png');?>
                    
                </a>
                <span style="display:block;margin-left:120px">YII Web Demo</span>
                <div class="button-group">
                    <a href="<?=Url::to(['minimal'])?>">Minimal</a>
                    <a href="loginscreen">LoginScreen</a>
                </div>
            </div>
            <div class="vertical-menu">
                <a href="<?= Url::to(['minimal'], true);?>" id="menu-login">Login</a>
                <a href="<?= Url::to(['signup'], true);?>" id="menu-signup">Register</a>
                <a href="<?= Url::to(['forgot'], true);?>" id="menu-forgotpassword">Forgot Password</a>
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
            <?php $this->beginBody() ?>
              <?= $content?>
            <?php $this->endBody()?>
    
<?php $this->endPage() ?>
</html>