const url = window.location.href;
const domainName = url.substring(0, url.lastIndexOf("/"));
let multiFactorAuthToken;

let custom_interface_option = {};
custom_interface_option.templateName = 'loginradiuscustom_tmpl';
LRObject.util.ready(function() {
    LRObject.customInterface(".interfacecontainerdiv", custom_interface_option);
});

let sl_options = {};
sl_options.onSuccess = function(response) {
    localStorage.setItem("LRTokenKey", response.access_token);
    localStorage.removeItem("LrEmailStatus");
    localStorage.setItem("lr-user-uid", response.Profile.Uid);
    window.location.replace("profile.html");
};
sl_options.onError = function(errors) {
    localStorage.setItem("LrEmailStatus", 'unverified');
    $("#sociallogin-message").text(errors[0].Description);
    $("#sociallogin-message").attr("class", "error-message");
};
sl_options.container = "sociallogin-container";

LRObject.util.ready(function() {
    LRObject.init('socialLogin', sl_options);
});

$("#btn-minimal-login").click(function() {
    $("#minimal-login-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/login",
        dataType: "json",
        data: $.param({
            email: $("#minimal-login-email").val(),
            password: $("#minimal-login-password").val(),
            action: "loginByEmail"
        }),
        error: function(xhr) {
            $("#minimal-login-message").text(xhr.responseJSON);
            $("#minimal-login-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            localStorage.setItem("LRTokenKey", ret.data.access_token);
            localStorage.removeItem("LrEmailStatus");
            localStorage.setItem("lr-user-uid", ret.data.Profile.Uid);
            $("#minimal-login-email").val("");
            $("#minimal-login-password").val("");
            window.location.replace("profile.html");
        } else if (ret.status == "error") {
            $("#minimal-login-message").text(ret.message);
            $("#minimal-login-message").attr("class", "error-message");
        }
    });
});

$("#btn-minimal-mfalogin-next").click(function() {
    $("#minimal-mfalogin-message").text("");

    data = {
        "Email" : $("#minimal-mfalogin-email").val(),
        "Password" : $("#minimal-mfalogin-password").val()    
    }
    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/login",
        data: $.param({
            email: $("#minimal-mfalogin-email").val(),
            password: $("#minimal-mfalogin-password").val(),
            action: "mfaLogin"
        }),
        dataType: "json",
        error: function(xhr) {
            $("#minimal-mfalogin-message").text(xhr.responseJSON);
            $("#minimal-mfalogin-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#minimal-mfalogin-email").val("");
            $("#minimal-mfalogin-password").val("");
            if (typeof(ret.data.SecondFactorAuthentication) != "undefined" && ret.data.SecondFactorAuthentication != null) {
                if (ret.data.SecondFactorAuthentication.IsGoogleAuthenticatorVerified === false) {
                    $("#minimal-mfalogin-qrcode").append('<img src="' + ret.data.SecondFactorAuthentication.QRCode + '">');
                }
                $("#minimal-mfalogin-next")
                    .html('<table><tbody><tr>' +
                        '<td>Google Authenticator Code: </td><td><input type="text" id="minimal-mfalogin-googlecode"></td>' +
                        '</tr></tbody></table>' + 
                        '<button id="btn-minimal-mfalogin-login">Login</button>');
                multiFactorAuthToken = ret.data.SecondFactorAuthentication.SecondFactorAuthenticationToken;
            } else {
                localStorage.setItem("LRTokenKey", ret.data.access_token);
                localStorage.removeItem("LrEmailStatus");
                localStorage.setItem("lr-user-uid", ret.data.Profile.Uid);
                window.location.replace("profile.html");
            }
        } else if (ret.status == "error") {
            $("#minimal-mfalogin-message").text(ret.message);
            $("#minimal-mfalogin-message").attr("class", "error-message");
        }
    });
});

$("#minimal-mfalogin-next").on('click', "#btn-minimal-mfalogin-login", function() {
    $("#minimal-mfalogin-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/login",
        data: $.param({
            secondFactorAuthenticationToken: multiFactorAuthToken,
            googleAuthCode: $("#minimal-mfalogin-googlecode").val(),
            action: "mfaValidate"
        }),
        dataType: "json",
        error: function(xhr) {
            $("#minimal-mfalogin-message").text(xhr.responseJSON);
            $("#minimal-mfalogin-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            localStorage.setItem("LRTokenKey", ret.data.access_token);
            localStorage.removeItem("LrEmailStatus");
            localStorage.setItem("lr-user-uid", ret.data.Profile.Uid);
            window.location.replace("profile.html");
        } else if (ret.status == "error") {
            $("#minimal-mfalogin-message").text(ret.message);
            $("#minimal-mfalogin-message").attr("class", "error-message");
        }
    });
});

$("#btn-minimal-pwless").click(function() {
    $("#minimal-pwless-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/login",
        data: $.param({
            email: $("#minimal-pwless-email").val(),
            verificationurl: commonOptions.verificationUrl,
            action: "pwLessLogin"
        }),
        dataType: "json",
        error: function(xhr) {
            $("#minimal-pwless-message").text(xhr.responseJSON);
            $("#minimal-pwless-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#minimal-pwless-email").val("");
            $("#minimal-pwless-message").text(ret.message);
            $("#minimal-pwless-message").attr("class", "success-message");
        } else if (ret.status == "error") {
            $("#minimal-pwless-message").text(ret.message);
            $("#minimal-pwless-message").attr("class", "error-message");
        }
    });
});

$("#btn-minimal-signup").click(function() {
    $("#minimal-signup-message").text("");

    if($("#minimal-signup-password").val() != $("#minimal-signup-confirmpassword").val()) {
        $("#minimal-signup-message").text("Passwords do not match!");
        $("#minimal-signup-message").attr("class", "error-message");
        return
    }

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/login",
        dataType: "json",
        data: $.param({
            email: $("#minimal-signup-email").val(),
            password: $("#minimal-signup-password").val(),
            verificationurl: commonOptions.verificationUrl,
            action: "registration"
        }),
        error: function(xhr) {
            $("#minimal-signup-message").text(xhr.responseJSON);
            $("#minimal-signup-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            localStorage.setItem("LRTokenKey", ret.result.Data.access_token);
            localStorage.removeItem("LrEmailStatus");
            localStorage.setItem("lr-user-uid", ret.result.Data.Profile.Uid);
            $("#minimal-signup-email").val('');
            $("#minimal-signup-password").val('');
            $("#minimal-signup-confirmpassword").val('');
            window.location.replace("profile.html");
        } else if (ret.status == "registered") {
            $("#minimal-signup-message").text(ret.message);
            $("#minimal-signup-message").attr("class", "success-message");
            $("#minimal-signup-email").val('');
            $("#minimal-signup-password").val('');
            $("#minimal-signup-confirmpassword").val('');
            
        } else if (ret.status == "error") {
            $("#minimal-signup-message").text(ret.message);
            $("#minimal-signup-message").attr("class", "error-message");
        }
    });
});

$("#btn-minimal-forgotpassword").click(function() {
    $("#minimal-forgotpassword-message").text("");

    $.ajax({
        method: "POST",
        url: domainName + "/ajax_handler/login",
        dataType: "json",
        data: $.param({
            email: $("#minimal-forgotpassword-email").val(),
            resetPasswordUrl: commonOptions.resetPasswordUrl,
            action: "forgotPassword"
        }),
        error: function(xhr){
            $("#minimal-forgotpassword-message").text(xhr.responseJSON);
            $("#minimal-forgotpassword-message").attr("class", "error-message");
        }
    }).done(function(ret) {
        if (ret.status == "success") {
            $("#minimal-forgotpassword-email").val("");
            $("#minimal-forgotpassword-message").text(ret.message);
            $("#minimal-forgotpassword-message").attr("class", "success-message");
        } else if (ret.status == "error") {
            $("#minimal-forgotpassword-message").text(ret.message);
            $("#minimal-forgotpassword-message").attr("class", "error-message");
        }
    });
});

function checkSession() {
    var accesstoken = localStorage.getItem("LRTokenKey");
    var lremailstatus = localStorage.getItem("LrEmailStatus");
    var lruid= localStorage.getItem("lr-user-uid");    
    if (accesstoken != "" && accesstoken != null && lruid != "" && lruid != null && (lremailstatus == "" || lremailstatus == null)) {
        window.location.replace("profile.html");
        return;
    }
}

checkSession();
