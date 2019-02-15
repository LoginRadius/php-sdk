<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
?>

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