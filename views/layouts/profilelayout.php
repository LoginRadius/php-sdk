<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\ProfileAsset;


ProfileAsset::register($this);
//$this->registerAssetBundle(yii\web\JqueryAsset::className(), View::POS_HEAD);

?>
<?php $this->beginPage() ?>
<html lang="en">
    <head>
        <title>profile</title>
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
                <span style="display:block;margin-left:70px">YII Web Demo</span>
            </div>
            <div class="vertical-menu">
                <a href="profileview" id="menu-profile">Profile</a>
                <a href="changePassword" id="menu-changepassword">Change Password</a>
                <a href="setPassword" id="menu-setpassword">Set Password</a>
                <a href="account" id="menu-account">Update Account</a>
                <a href="accountLinking" id="menu-accountlinking">Account Linking</a>
                <a href="customObject" id="menu-customobjects">Custom Object Management</a>
                <a href=" resetMultifactor"id="menu-multifactor">Reset MultiFactor</a>
                <a href="role" id="menu-roles">Roles Management</a>
                <a href="" id="menu-user-logout">Logout</a>
            </div>
        </div>
       
           <?php $this->beginBody() ?>
              <?= $content?>
            <?php $this->endBody()?>
    </body>
</html>

<?php $this->endPage();






?>

