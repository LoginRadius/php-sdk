


<html lang="en">
    <head>
        <title>profile</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <?= $this->Html->css('stylelr.css') ?>
       
        <?= $this->Html->script('jquery.min.js') ?>
        <?= $this->Html->script('logout.js') ?>
        <script type="text/javascript" src="https://auth.lrcontent.com/v2/js/LoginRadiusV2.js"></script>
        <?= $this->Html->script('options.js') ?>
        <?= $this->Html->script('profile.js') ?>
        <?= $this->Html->script('account.js') ?>
        <?= $this->Html->script('accountlinking.js') ?>

    </head>
    <body>
        <div class="section-menu">
            <div class="menu-header">
                <a href="">
                <?=$this->Html->image('lr-logo.png')?>
                </a>
                <span style="display:block;margin-left:70px">CakePhp Web Demo</span>
                
            </div>
            <div class="vertical-menu">
                <a href="profileview" id="menu-profile">Profile</a>
                <a href="changepasswordview" id="menu-changepassword">Change Password</a>
                <a href="setpasswordview" id="menu-setpassword">Set Password</a>
                <a href="accountView" id="menu-account">Update Account</a>
                <a href="accountLinkingView" id="menu-accountlinking">Account Linking</a>
                <a href="customObjectView" id="menu-customobjects">Custom Object Management</a>
                <a href=" resetMultifactorView"id="menu-multifactor">Reset MultiFactor</a>
                <a href="roleView" id="menu-roles">Roles Management</a>
                <a href="" id="menu-user-logout">Logout</a>
            </div>
        </div>
        <input type="hidden" name="_csrfToken" value="<?= $this->request->getParam('_csrfToken'); ?>" />
        <?= $this->fetch('content') ?>

    </body>
</html>