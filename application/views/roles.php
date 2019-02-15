<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
        <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script> 
        <script src="<?php echo base_url();?>assets/js/logout.js"></script> 
        <script src="<?php echo base_url();?>assets/js/profile.js"></script>  
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
                <div class="container lr-roles">
                    <b>All Roles</b><br/>
                    <center><table id="table-allroles" class="table-style"></table></center>
                    <br></br>

                    <b>Create Role</b><br/>
                    Role: <textarea name="createrole" type='text' id="user-roles-createrole"></textarea><br/>
                    <button id="btn-user-createrole">Create</button><br/>
                    <span style="color:red" id="user-createrole-errorMsg"></span>
                    <span style="color:green" id="user-createrole-successMsg"></span>
                    <br></br>

                    <b>Delete Role</b><br/>
                    Role: <input name="deleterole" type='text' id='user-roles-deleterole'/><br/>
                    <button id="btn-user-deleterole">Delete</button><br/>
                    <span style="color:red" id="user-deleterole-errorMsg"></span>
                    <span style="color:green" id="user-deleterole-successMsg"></span>
                    <br></br>

                    <b>Current User Role(s)</b><br/>
                    <center><table id="table-userroles" class="table-style"></table></center>
                    <br></br>

                    <b>Assign Role to User</b><br/>
                    Role:  <textarea row="6" name="assignrole" cols="25" id="user-roles-assignrole"></textarea><br/>
                    <button id="btn-user-assignrole">Assign</button><br/>
                    <span style="color:red" id="user-assignrole-errorMsg"></span>
                    <span style="color:green" id="user-assignrole-successMsg"></span>
                    <br></br>
                </div><br></br><br></br>
            </center>                
        </div>       
    </body>
</html>