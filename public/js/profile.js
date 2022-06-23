var stringVariable = window.location.href;
var currentToken = $('meta[name="csrf-token"]').attr('content');
domainName = stringVariable.substring(0, stringVariable.lastIndexOf('/'));
$(function () {
    handleSetPassword();
    handleChangePassword();
    resetMultifactor();

    createCustomObjects();
    getCustomObjects();
    updateCustomObjects();
    deleteCustomObjects();
    
    getAllRoles();
    getUserRoles();
    handleCreateRole();
    handleDeleteRole();
    handleAssignUserRole();
});

function handleSetPassword() {
    $('#btn-user-setpassword').on('click', function () {
        $("#user-setpassword-errorMsg").text("");
        $("#user-setpassword-successMsg").text("");
        if ($('#user-setpassword-password').val().trim() == '') {
            $("#user-setpassword-errorMsg").text("The password field is required.");
            return;
        } else if ($('#user-setpassword-password').val().trim().length < '6') {
            $("#user-setpassword-errorMsg").text("The Password field must be at least 6 characters in length.");
            return;
        }
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url:'/profile',
            dataType: "json",
            data: $.param({
                uid: localStorage.getItem("LRUserID"),
                newpassword: $("#user-setpassword-password").val(),
                action: "setPassword",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-setpassword-errorMsg").text(res.message);
                } else if (res.status == 'success') {
                    $("#user-setpassword-password").val("");
                    $("#user-setpassword-successMsg").text(res.message);
                }
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-setpassword-errorMsg").text(xhr.responseText);
            }
        });

    });
}

function handleChangePassword() {
    $('#btn-user-changepassword').on('click', function () {
        $("#user-changepassword-errorMsg").text("");
        $("#user-changepassword-successMsg").text("");
        if ($('#user-changepassword-oldpassword').val().trim() == '' || $('#user-changepassword-newpassword').val().trim() == '') {
            $("#user-changepassword-errorMsg").text("The password field is required.");
            return;
        } else if ($('#user-changepassword-newpassword').val().trim().length < '6') {
            $("#user-changepassword-errorMsg").text("The New Password field must be at least 6 characters in length.");
            return;
        }
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url:'/profile',
            dataType: "json",
            data: $.param({
                token: localStorage.getItem("LRTokenKey"),
                oldpassword: $("#user-changepassword-oldpassword").val(),
                newpassword: $("#user-changepassword-newpassword").val(),
                action: "changePassword",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-changepassword-errorMsg").text(res.message);
                } else if (res.status == 'success') {
                    $("#user-changepassword-oldpassword").val("");
                    $("#user-changepassword-newpassword").val("");
                    $("#user-changepassword-successMsg").text(res.message);
                }
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-changepassword-errorMsg").text(xhr.responseText);
            }
        });
    });
}

function createCustomObjects() {
    $('#btn-user-createcustomobj').on('click', function () {
        $("#user-createcustomobj-successMsg").text("");
        $("#user-createcustomobj-errorMsg").text("");
        var input = $("#user-createcustomobj-data").val();
        if ($('#user-createcustomobj-objectname').val().trim() == '') {
            $("#user-createcustomobj-errorMsg").text("The Object Name field is required.");
            return;
        } else if ($('#user-createcustomobj-data').val().trim() == '') {
            $("#user-createcustomobj-errorMsg").text("The Data field is required.");
            return;
        } else if (!IsJsonString(input)) {
            $("#user-createcustomobj-errorMsg").text("Invalid json in Data field.");
            return;
        }
      
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url: '/profile',
            dataType: "json",
            data: $.param({
                token: localStorage.getItem("LRTokenKey"),
                objectName: $("#user-createcustomobj-objectname").val(),
                payload: input,
                action: "createCustomObjects",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-createcustomobj-errorMsg").text(res.message);
                } else if (res.status == 'success') {
                        $("#user-createcustomobj-objectname").val("");              
                        $("#user-createcustomobj-data").val("");
                    $("#user-createcustomobj-successMsg").text(res.message);
                }
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-createcustomobj-errorMsg").text(xhr.responseText);
            }
        });
    });
}

function getCustomObjects() {
    $('#btn-user-getcustomobj').on('click', function () {
        $("#user-getcustomobj-errorMsg").text("");
        $("#user-getcustomobj-successMsg").text("");
        if ($("#user-getcustomobj-objectname").val().trim() == ''){
            $("#user-getcustomobj-errorMsg").text("The Object Name field is required.");
            return;
        }
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url: '/profile',
            dataType: "json",
            data: $.param({
                token: localStorage.getItem("LRTokenKey"),
                objectName: $("#user-getcustomobj-objectname").val(),
                action: "getCustomObjects",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                $("#user-getcustomobj-errorMsg").text("");
                if (res.status == 'error') {
                    $("#user-getcustomobj-errorMsg").text(res.message);
                    $('#customobj-table').html('');
                } else if (res.status == 'success') {
                    $("#user-getcustomobj-objectname").val("");       
                    
                    $('#customobj-table').html('');
                    $('#customobj-table').append('<tr><th>Object ID</th><th>Custom Object</th></tr>');
                    for (var i = 0; i < res.result.data.length; i++) {
                        var id = res.result.data[i].Id;
                        var custobj = res.result.data[i].CustomObject;
                        $('#customobj-table').append('<tr><td>' + id + '</td><td>' + JSON.stringify(custobj) + '</td></tr>');
                    }
                }
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-getcustomobj-errorMsg").text(xhr.responseText);
            }
        });
    });
}

function updateCustomObjects() {
    $('#btn-user-updatecustomobj').on('click', function () {       
        $("#user-updatecustomobj-errorMsg").text("");
        $("#user-updatecustomobj-successMsg").text("");
        var input = $("#user-updatecustomobj-data").val();
        if ($('#user-updatecustomobj-objectname').val().trim() == '') {
            $("#user-updatecustomobj-errorMsg").text("The Object Name field is required.");
            return;
        } else if ($('#user-updatecustomobj-objectrecordid').val().trim() == '') {
            $("#user-updatecustomobj-errorMsg").text("The Object Record Id field is required.");
            return;
        }else if ($('#user-updatecustomobj-data').val().trim() == '') {
            $("#user-updatecustomobj-errorMsg").text("The Data field is required.");
            return;
        } else if (!IsJsonString(input)) {
            $("#user-updatecustomobj-errorMsg").text("Invalid json in Data field");
            return;
        }
        
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url: '/profile',
            dataType: "json",
            data: $.param({
                token: localStorage.getItem("LRTokenKey"),
                objectName: $("#user-updatecustomobj-objectname").val(),
                objectRecordId: $("#user-updatecustomobj-objectrecordid").val(),
                payload: input,
                action: "updateCustomObjects",
                _token: currentToken
            }),

            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-updatecustomobj-errorMsg").text(res.message);
                } else if (res.status == 'success') { 
                    $("#user-updatecustomobj-objectname").val("");
                    $("#user-updatecustomobj-objectrecordid").val("");
                    $("#user-updatecustomobj-data").val("");
                    $("#user-updatecustomobj-successMsg").text(res.message);
                }
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-updatecustomobj-errorMsg").text(xhr.responseText);             
            }
        });
    });
}

function deleteCustomObjects() {
    $('#btn-user-deletecustomobj').on('click', function () {
        $("#user-deletecustomobj-errorMsg").text(""); 
        $("#user-deletecustomobj-successMsg").text(""); 
        if ($('#user-deletecustomobj-objectname').val().trim() == '') {
            $("#user-deletecustomobj-errorMsg").text("The Object Name field is required.");
            return;
        } else if ($('#user-deletecustomobj-objectrecordid').val().trim() == '') {
            $("#user-deletecustomobj-errorMsg").text("The Object Record Id is required.");
            return;
        }
        
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url:'/profile',
            dataType: "json",
            data: $.param({
                token: localStorage.getItem("LRTokenKey"),
                objectName: $("#user-deletecustomobj-objectname").val(),
                objectRecordId: $("#user-deletecustomobj-objectrecordid").val(),
                action: "deleteCustomObjects",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-deletecustomobj-errorMsg").text(res.message);
                } else if (res.status == 'success') {
                    $("#user-deletecustomobj-objectname").val("");   
                    $("#user-deletecustomobj-objectrecordid").val("");   
                    $("#user-deletecustomobj-successMsg").text(res.message);
                }
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-deletecustomobj-errorMsg").text(xhr.responseText); 
            }
        });
    });
}

function resetMultifactor() {
    $('#btn-user-mfa-resetgoogle').on('click', function () {
        $("#user-mfa-successMsg").text("");
        $("#user-mfa-errorMsg").text("");
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url:'/profile',
            dataType: "json",
            data: $.param({
                token: localStorage.getItem("LRTokenKey"),
                action: "resetMultifactor",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-mfa-errorMsg").text(res.message);
                } else if (res.status == 'success') {
                    $("#user-mfa-successMsg").text(res.message);
                }
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-mfa-errorMsg").text(xhr.responseText);        
            }
        });
    });
}

function handleCreateRole() {
    $('#btn-user-createrole').on('click', function () {
        $("#user-createrole-errorMsg").text("");
        $("#user-createrole-successMsg").text("");
        if ($("#user-roles-createrole").val().trim() == '') {
            $("#user-createrole-errorMsg").text("The Role field is required.");
            return;
        }
        var input = $("#user-roles-createrole").val();
        if (!IsJsonString(input)) {
            $("#user-createrole-errorMsg").text("Invalid json in Role field.");
            return;
        }
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url: '/profile',
            dataType: "json",
            data: $.param({
                roles: $("#user-roles-createrole").val(),
                action: "handleCreateRole",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-createrole-errorMsg").text(res.message);
                } else if (res.status == 'success') {
                    $("#user-createrole-successMsg").text(res.message);
                    $("#user-roles-createrole").val('');
                }
                getAllRoles(); // re-render table
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-createrole-errorMsg").text(xhr.responseText);         
            }
        });
    });
}

function handleDeleteRole() {
    $('#btn-user-deleterole').on('click', function () {
        $("#user-deleterole-errorMsg").text("");
        $("#user-deleterole-successMsg").text("");
        if ($("#user-roles-deleterole").val().trim() == '') {
            $("#user-deleterole-errorMsg").text("The Role field is required.");
            return;
        }
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url: '/profile',
            dataType: "json",
            data: $.param({
                roles: $("#user-roles-deleterole").val(),
                action: "handleDeleteRole",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-deleterole-errorMsg").text(res.message);
                } else if (res.status == 'success') {
                    $("#user-deleterole-successMsg").text(res.message);   
                    $("#user-roles-deleterole").val('');
                }
                getAllRoles();
                getUserRoles();
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-deleterole-errorMsg").text(xhr.responseText);
                $("#user-deleterole-successMsg").text("");
            }
        });
    });
}

function handleAssignUserRole() {
    $('#btn-user-assignrole').on('click', function () {
        $("#user-assignrole-errorMsg").text("");
        $("#user-assignrole-successMsg").text("");        
        if ($("#user-roles-assignrole").val().trim() == '') {
            $("#user-assignrole-errorMsg").text("The Role field is required.");
            return;
        }
        var input = $("#user-roles-assignrole").val();
        if (!IsJsonString(input)) {
            $("#user-assignrole-errorMsg").text("Invalid json in Role field.");
            return;
        }
        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url:'/profile',
            dataType: "json",
            data: $.param({
                uid: localStorage.getItem("LRUserID"),
                roles: $("#user-roles-assignrole").val(),
                action: "handleAssignUserRole",
                _token: currentToken
            }),
            success: function (res) {
                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-assignrole-errorMsg").text(res.message);
                } else if (res.status == 'success') {
                    $("#user-assignrole-successMsg").text(res.message);
                    $("#user-roles-assignrole").val('');
                }
                getUserRoles();
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-assignrole-errorMsg").text(xhr.responseText);                
            }
        });
    });
}

function getAllRoles() {
    $.ajax({
        type: "POST",
        url:'/profile',
        dataType: "json",
        data: $.param({
            action: "getAllRoles",
            _token: currentToken
        }),
        success: function (res) {
            if (res.status == 'error') {
                console.log("Get All Roles err::", res.message);
            } else if (res.status == 'success') {
                $('#table-allroles').html('');
                $('#table-allroles').append('<tr><th>Role</th></tr>');

                if (res.result.data == null)
                    return;
                for (var i = 0; i < res.result.data.length; i++) {
                    var name = res.result.data[i].Name;
                    $('#table-allroles').append('<tr><td>' + name + '</td></tr>');
                }
            } else if (res.status == 'rolesempty') {
                $('#table-allroles').html('');
            }
        },
        error: function (xhr, status, error) {
            console.log("Get All Roles err::", xhr.responseText);
        }
    });
}

function getUserRoles() {
    $.ajax({
        type: "POST",
        url: '/profile',
        data: $.param({
            uid: localStorage.getItem("LRUserID"),
            action: "getUserRoles",
            _token: currentToken
        }),
        dataType: "json",
        success: function (res) {
            if (res.status == 'error') {
                console.log("Get User Roles success::", res.message);
            } else if (res.status == 'success') {
                $('#table-userroles').html('');
                $('#table-userroles').append('<tr><th>Role</th></tr>');

                if (res.data.Roles == null)
                    return;
                for (var i = 0; i < res.data.Roles.length; i++) {
                    var name = res.data.Roles[i];
                    $('#table-userroles').append('<tr><td>' + name + '</td></tr>');
                }
            } else if (res.status == 'userrolesempty') {
                $('#table-userroles').html('');
            }
        },
        error: function (xhr, status, error) {
            console.log("Get User Roles err::", xhr.responseText);
        }
    });
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}