const url = window.location.href;
const domainName = url.substring(0, url.lastIndexOf("/"));
let update = {};

$( "#btn-user-changepassword" ).click(function() {
    $("#user-changepassword-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            token: localStorage.getItem("LRTokenKey"),
            oldpassword: $("#user-changepassword-oldpassword").val(),
            newpassword: $("#user-changepassword-newpassword").val(),
            action: "changePassword"
        }),
        error: function(xhr) {
            $("#user-changepassword-message").text(xhr.responseJSON);
            $("#user-changepassword-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-changepassword-oldpassword").val("");
            $("#user-changepassword-newpassword").val("");
            $("#user-changepassword-message").text(ret.message);
            $("#user-changepassword-message").attr("class", "success-message");
        } else if (ret.status == "error") {
            $("#user-changepassword-message").text(ret.message);
            $("#user-changepassword-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-setpassword").click(function() {
    $("#user-setpassword-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            uid: localStorage.getItem("lr-user-uid"),
            newpassword: $("#user-setpassword-password").val(),
            action: "setPassword"
        }),
        error: function(xhr){
            $("#user-setpassword-message").text(xhr.responseJSON);
            $("#user-setpassword-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-setpassword-password").val("");
            $("#user-setpassword-message").text(ret.message);
            $("#user-setpassword-message").attr("class", "success-message");
        } else if (ret.status == "error") {
            $("#user-setpassword-message").text(ret.message);
            $("#user-setpassword-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-updateaccount").click(function() {
    $("#user-updateaccount-message").text("");

    let data = {};
    let dataFields = {
        "FirstName": $("#user-updateaccount-firstname").val().trim(),
        "LastName": $("#user-updateaccount-lastname").val().trim(),
        "About": $("#user-updateaccount-about").val().trim()
    }

    for (let key in dataFields) {
        if (dataFields[key] !== "") {
            data[key] = dataFields[key];
        } else {
            data[key] = update[key];
        }
    }

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            token: localStorage.getItem("LRTokenKey"),
            firstname: data["FirstName"],
            lastname: data["LastName"],
            about: data["About"],
            action: "updateAccount"
        }),
        error: function(xhr) {
            $("#user-updateaccount-message").text(xhr.responseJSON);
            $("#user-updateaccount-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-updateaccount-message").text(ret.message);
            $("#user-updateaccount-message").attr("class", "success-message");
            profileUpdate();
        } else if (ret.status == "error") {
            $("#user-updateaccount-message").text(ret.message);
            $("#user-updateaccount-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-createcustomobj").click(function() {
    $("#user-createcustomobj-message").text("");

    let data;
    try {
        data = JSON.parse($("#user-createcustomobj-data").val());
    } catch(e) {
        $("#user-createcustomobj-message").text("Please input a valid JSON object in the data field.");
        $("#user-createcustomobj-message").attr("class", "error-message");
        return;
    }

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            token: localStorage.getItem("LRTokenKey"),
            objectName: $("#user-createcustomobj-objectname").val(),
            payload: JSON.stringify(data),
            action: "createCustomObjects"
        }),
        error: function(xhr) {
            $("#user-createcustomobj-message").text(xhr.responseJSON);
            $("#user-createcustomobj-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-createcustomobj-objectname").val("");              
            $("#user-createcustomobj-data").val("");
            $("#user-createcustomobj-message").text(ret.message);
            $("#user-createcustomobj-message").attr("class", "success-message");
        } else if (ret.status == "error") {
            $("#user-createcustomobj-message").text(ret.message);
            $("#user-createcustomobj-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-updatecustomobj").click(function() {    
    $("#user-updatecustomobj-message").text("");

    let data = {};

    try {
        data = JSON.parse($("#user-updatecustomobj-data").val());
    } catch(e) {
        $("#user-updatecustomobj-message").text("Please input a valid JSON object in the data field.");
        $("#user-updatecustomobj-message").attr("class", "error-message");
        return;
    }

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            token: localStorage.getItem("LRTokenKey"),
            objectName: $("#user-updatecustomobj-objectname").val(),
            objectRecordId: $("#user-updatecustomobj-objectrecordid").val(),
            payload: JSON.stringify(data),
            action: "updateCustomObjects"
        }),
        error: function(xhr) {
            $("#user-updatecustomobj-message").text(xhr.responseJSON);
            $("#user-updatecustomobj-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-updatecustomobj-objectname").val("");
            $("#user-updatecustomobj-objectrecordid").val("");
            $("#user-updatecustomobj-data").val("");
            $("#user-updatecustomobj-message").text(ret.message);
            $("#user-updatecustomobj-message").attr("class", "success-message");
        } else if (ret.status == "error") {
            $("#user-updatecustomobj-message").text(ret.message);
            $("#user-updatecustomobj-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-deletecustomobj").click(function() {
    $("#user-deletecustomobj-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            token: localStorage.getItem("LRTokenKey"),
            objectName: $("#user-deletecustomobj-objectname").val(),
            objectRecordId: $("#user-deletecustomobj-objectrecordid").val(),
            action: "deleteCustomObjects"
        }),
        error: function(xhr) {
            $("#user-deletecustomobj-message").text(xhr.responseJSON);
            $("#user-deletecustomobj-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-deletecustomobj-objectname").val("");
            $("#user-deletecustomobj-objectrecordid").val("");   
            $("#user-deletecustomobj-message").text(ret.message);
            $("#user-deletecustomobj-message").attr("class", "success-message");
        } else if (ret.status == "error") {
            $("#user-deletecustomobj-message").text(ret.message);
            $("#user-deletecustomobj-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-getcustomobj").click(function() {
    $("#user-getcustomobj-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            token: localStorage.getItem("LRTokenKey"),
            objectName: $("#user-getcustomobj-objectname").val(),
            action: "getCustomObjects"
        }),
        error: function(xhr) {
            $('#table-customobj tr').remove();

            $("#user-getcustomobj-message").text(xhr.responseJSON);
            $("#user-getcustomobj-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        $('#table-customobj tr').remove();

        if (ret.status == "success") {
            $("#user-getcustomobj-objectname").val(""); 
            $("#user-getcustomobj-message").text("");
            $("#user-getcustomobj-message").attr("class", "success-message");
            $('<tr>' +
                '<th>Object ID</th><th>Custom Object</th>' +
                '<tr>').appendTo("#table-customobj > tbody:last-child");
    
            for (let i = 0; i < ret.result.data.length; i++) {
                $("<tr><td>" + ret.result.data[i].Id + "</td></tr>").appendTo("#table-customobj > tbody:last-child");
                $("<td>", {
                    text: JSON.stringify(ret.result.data[i].CustomObject)
                }).appendTo("#table-customobj > tbody:last-child > tr:last-child");
            }
        } else if (ret.status == "error") {
            $("#user-getcustomobj-message").text(ret.message);
            $("#user-getcustomobj-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-mfa-resetgoogle").click(function() {
    $("#user-mfa-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            token: localStorage.getItem("LRTokenKey"),
            action: "resetMultifactor"
        }),
        error: function(xhr) {
            $("#user-mfa-message").text(xhr.responseJSON);
            $("#user-mfa-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-mfa-message").text(ret.message);
            $("#user-mfa-message").attr("class", "success-message");
        } else if (ret.status == "error") {
            $("#user-mfa-message").text(ret.message);
            $("#user-mfa-message").attr("class", "error-message");
        }
    });
});

$( "#btn-user-createrole" ).click(function() {
    $("#user-createrole-message").text("");

    let data = {
        "roles" : [
            { "Name": $("#user-roles-createrole").val().trim() }
        ]
    }

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            roles: JSON.stringify(data),
            action: "handleCreateRole"
        }),
        error: function(xhr) {
            $("#user-createrole-message").text(xhr.responseJSON);
            $("#user-createrole-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-roles-createrole").val('');
            $("#user-createrole-message").text(ret.message);
            $("#user-createrole-message").attr("class", "success-message");
            roleUpdate();
        } else if (ret.status == "error") {
            $("#user-createrole-message").text(ret.message);
            $("#user-createrole-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-deleterole").click(function() {
    $("#user-deleterole-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            roles: $("#user-roles-deleterole").val().trim(),
            action: "handleDeleteRole"
        }),
        error: function(xhr) {
            $("#user-deleterole-message").text(xhr.responseJSON);
            $("#user-deleterole-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-roles-deleterole").val('');
            $("#user-deleterole-message").text(ret.message);
            $("#user-deleterole-message").attr("class", "success-message");
            roleUpdate();
        } else if (ret.status == "error") {
            $("#user-deleterole-message").text(ret.message);
            $("#user-deleterole-message").attr("class", "error-message");
        }
    });
});

$("#btn-user-assignrole").click(function() {
    $("#user-assignrole-message").text("");

    let data = {
        "Roles": [
            $("#user-roles-assignrole").val().trim()
        ]
    }

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            uid: localStorage.getItem("lr-user-uid"),
            roles: JSON.stringify(data),
            action: "handleAssignUserRole"
        }),
        error: function(xhr) {
            $("#user-assignrole-message").text(xhr.responseJSON);
            $("#user-assignrole-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#user-roles-assignrole").val('');
            $("#user-assignrole-message").text(ret.message);
            $("#user-assignrole-message").attr("class", "success-message");
            roleUpdate();
        } else if (ret.status == "error") {
            $("#user-assignrole-message").text(ret.message);
            $("#user-assignrole-message").attr("class", "error-message");
        }
    });
});

$("#menu-logout").click(function() {
    localStorage.removeItem("LRTokenKey");
    localStorage.removeItem("LrEmailStatus");
    localStorage.removeItem("lr-user-uid");
    window.location.replace("index.html");
});

let profileUpdate = function() {
    if(localStorage.getItem("LRTokenKey") === null) {
        window.location.replace("index.html");
        return;
    }

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            token: localStorage.getItem("LRTokenKey"),
            action: "getProfileByToken"
        }),
        error: function() {
            localStorage.removeItem("LRTokenKey");
            localStorage.removeItem("lr-user-uid");
            window.location.replace("index.html");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            if (typeof (ret.data.FullName) != "undefined" && ret.data.FullName != null) {
                $("#profile-name").html("<b>" + ret.data.FullName + "</b>");
            }
            $("#profile-provider").text("Provider: " + ret.data.Provider);
            $("#profile-email").text(ret.data.Email[0].Value);
            $("#profile-lastlogin").text("Last Login Date: " + ret.data.LastLoginDate);            
            
            if (typeof (ret.data.FirstName) != "undefined" && ret.data.FirstName !== null) {
                $("#user-updateaccount-firstname").val(ret.data.FirstName);
            }
            if (typeof (ret.data.LastName) != "undefined" && ret.data.LastName !== null) {
                $("#user-updateaccount-lastname").val(ret.data.LastName);
            }
            if (typeof (ret.data.About) != "undefined" && ret.data.About !== null) {
                $("#user-updateaccount-about").val(ret.data.About);
            }            
            update.FirstName = ret.data.FirstName;
            update.LastName = ret.data.LastName;
            update.About = ret.data.About;
        } else if (ret.status == "error") {
            localStorage.removeItem("LRTokenKey");
            localStorage.removeItem("lr-user-uid");
            window.location.replace("index.html");
        }
    });
}

let roleUpdate = function() {
    $("#user-allroles-message").text("");
    $("#user-userroles-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        dataType: "json",
        data: $.param({
            action: "getAllRoles"
        }),
        error: function(xhr) {
            $("#user-allroles-message").text(xhr.responseJSON);
            $("#user-allroles-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $('#table-allroles tr:not(:first)').remove();
            if (typeof(ret.result.data) != "undefined" && ret.result.data != null) {
                for (let i = 0; i < ret.result.data.length; i++) {
                    $("<tr></tr>").appendTo("#table-allroles > tbody:last-child");
                    $("<td>", {
                        text: ret.result.data[i].Name
                    }).appendTo('#table-allroles > tbody:last-child > tr:last-child');
                }
            }
        } else if (ret.status == "error") {
            $("#user-allroles-message").text(ret.message);
            $("#user-allroles-message").attr("class", "error-message");
        }
    });

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/profile",
        data: $.param({
            uid: localStorage.getItem("lr-user-uid"),
            action: "getUserRoles"
        }),
        dataType: "json",
        error: function(xhr) {
            $("#user-userroles-message").text(xhr.responseJSON);
            $("#user-userroles-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $('#table-userroles tr:not(:first)').remove();
            if (typeof(ret.data.Roles) != "undefined" && ret.data.Roles != null) {
                for (let i = 0; i < ret.data.Roles.length; i++) {
                    $("<tr></tr>").appendTo("#table-userroles > tbody:last-child");
                    $("<td>", {
                        text: ret.data.Roles[i]
                    }).appendTo('#table-userroles > tbody:last-child > tr:last-child');
                }
            }
        } else if (ret.status == "error") {
            $("#user-userroles-message").text(ret.message);
            $("#user-userroles-message").attr("class", "error-message");
        }
    });
}

let script = $(
    '<script type="text/html" id="loginradiuscustom_tmpl_link">' +
    '<# if(isLinked) { #>' +
    '<div class="lr-linked">' +
    '<a class="lr-provider-label" href="javascript:void(0)" title="<#= Name #>" alt="Connected" onclick=\'return LRObject.util.unLinkAccount(\"<#= Name.toLowerCase() #>\",\"<#= providerId #>\")\'><#=Name#> is connected | Delete</a>' +
    '</div>' +
    '<# }  else {#>' +
    '<div class="lr-unlinked">' +
    '<a class="lr-provider-label" href="javascript:void(0)" onclick="return LRObject.util.openWindow(\'<#= Endpoint #>\');" title="<#= Name #>" alt="Sign in with <#=Name#>">' +
    '<#=Name#></a></div>' +
    '<# } #>' +
    '</script>'
);

$("#script-accountlinking").append(script);

let la_options = {};
la_options.container = "interfacecontainerdiv";
la_options.templateName = 'loginradiuscustom_tmpl_link';
la_options.onSuccess = function() {
    $("#interfacecontainerdiv").empty();
    LRObject.util.ready(function() {
        LRObject.init("linkAccount", la_options);
    });
}
la_options.onError = function(errors) {
    $("#user-accountlinking-message").text(errors[0].Description);
    $("#user-accountlinking-message").attr("class", "error-message");
}

let unlink_options = {};
unlink_options.onSuccess = function() {
    $("#interfacecontainerdiv").empty();
    LRObject.util.ready(function() {
        LRObject.init("linkAccount", la_options);
    });
}
unlink_options.onError = function(errors) {
    $("#user-accountlinking-message").text(errors[0].Description);
    $("#user-accountlinking-message").attr("class", "error-message");
}

LRObject.util.ready(function() {
    LRObject.init("linkAccount", la_options);
    LRObject.init("unLinkAccount", unlink_options);
});

profileUpdate();
roleUpdate();
