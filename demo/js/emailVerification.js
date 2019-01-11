const url = window.location.href;
const params = url.split("?")[1];
const domainName = url.substring(0, url.lastIndexOf("/"));

let paramsObj = {};

if (params) {
    paramsObj = JSON.parse('{"' + decodeURI(params.replace(/&/g, "\",\"").replace(/=/g,"\":\"")) + '"}');

    if (paramsObj.vtype === "emailverification") {
        $.ajax({
            method: "POST",
            url: domainName + "/ajax_handler/login",
            dataType: "json",
            data: $.param({
                vtoken: paramsObj.vtoken,
                action: "emailVerify"
            }),
            error: function(xhr){
                $("#minimal-verification-message").text(xhr.responseJSON);
                $("#minimal-verification-message").attr("class", "error-message");
            }
        }).done(function(ret) {
            if (ret.status == "success") {
                localStorage.setItem("LrEmailStatus", "verified");
                $("#minimal-verification-message").text(ret.message);
                $("#minimal-verification-message").attr("class", "success-message");
            } else if (ret.status == "error") {
                $("#minimal-verification-message").text(ret.message);
                $("#minimal-verification-message").attr("class", "error-message");
            }
        });
    } else if (paramsObj.vtype === "oneclicksignin") {
        $.ajax({
            method: "POST",
            url: domainName + "/ajax_handler/login",
            data: $.param({
                token: paramsObj.vtoken,
                action: "pwLessLinkVerify"
            }),
            dataType: "json",
            error: function(xhr) {
                $("#minimal-verification-message").text(xhr.responseJSON);
                $("#minimal-verification-message").attr("class", "error-message");
            }
        }).done(function(ret) {
            if (ret.status == "success") {
                localStorage.setItem("LRTokenKey", ret.data.access_token);
                localStorage.removeItem("LrEmailStatus");
                localStorage.setItem("lr-user-uid", ret.data.Profile.Uid);
                window.location.replace("profile.html");
            } else if (ret.status == "error") {
                $("#minimal-verification-message").text(ret.message);
                $("#minimal-verification-message").attr("class", "error-message");
            }
        });
    } else {
        window.location.replace("index.html");
    }
} else {
    window.location.replace("index.html");
}
