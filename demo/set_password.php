<div class="lr-form">
    <h3> Change Password</h3>    
    <div id="changepassword-container"></div>
  <hr>
</div>

<script>
      var changepassword_options = {};
        changepassword_options.container = "changepassword-container";
        changepassword_options.onSuccess = function (response) {
            handleResponse("Password has been updated successfully", "success");
            jQuery('input[type="text"],input[type="password"]').val('');
        };
        changepassword_options.onError = function (errors) {
            handleResponse(errors[0].Description, "error");
        };

        LRObject.util.ready(function () {
            LRObject.init("changePassword", changepassword_options);
        });
        
        LRObject.$hooks.call('customizeFormLabel',{
        "newpassword" : "New Password" 
        });
        
</script> 
<?php include("redirect.php"); ?>