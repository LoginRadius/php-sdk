var stringVariable = window.location.href;
domainName = stringVariable.substring(0, stringVariable.lastIndexOf('/'));
$(function () {
    getProfileByUid();
    handleUpdateAccount();   
});

function getProfileByUid() {

    var token = localStorage.getItem("LRTokenKey");
    $.ajax({
        url: "profile",
        type: 'POST',
        dataType: "json",
        data: $.param({
            token: token,   
            action: "getProfile"
        }),
        success: function (response) {
            if (response.status == "success") {
                if (typeof (response.data.FirstName) != "undefined" && response.data.FirstName !== null) {
                   $("#user-updateaccount-firstname").val(response.data.FirstName);  
                    localStorage.setItem('UserName', response.data.FullName);
                }
                if (typeof (response.data.LastName) != "undefined" && response.data.LastName !== null) {
                   $("#user-updateaccount-lastname").val(response.data.LastName);   
                    localStorage.setItem('UserName', response.data.FullName);
                }
                if (typeof (response.data.About) != "undefined" && response.data.About !== null) {
                   $("#user-updateaccount-about").val(response.data.About);                
                }
            } 
            else if(response.status == "error"){
                window.location.href = domainName + "/login";
                localStorage.setItem("LRTokenKey", "");
                localStorage.setItem("LRUserID", "");
                localStorage.setItem("EmailId", "");
                localStorage.setItem("UserName", "");
                localStorage.setItem("ImageUrl", "");
                localStorage.setItem("LastLoginTime", "");
            }
        }
    });
}

function handleUpdateAccount() {
    $('#btn-user-updateaccount').on('click', function () {
        $("#user-updateaccount-errorMsg").text("");
        $("#user-updateaccount-successMsg").text("");

        $("#lr-loading").show();
        $.ajax({
            type: "POST",
            url:  "profile",
            dataType: "json",
            data: $.param({
                token: localStorage.getItem("LRTokenKey"),
                firstname: $("#user-updateaccount-firstname").val(),
                lastname: $("#user-updateaccount-lastname").val(),
                about: $("#user-updateaccount-about").val(),
                action: "updateAccount"
            }),
            success: function (res) {

                $("#lr-loading").hide();
                if (res.status == 'error') {
                    $("#user-updateaccount-errorMsg").text(res.message);            
                } else if (res.status == 'success') {
                    $("#user-updateaccount-successMsg").text(res.message);
                    getProfileByUid();
                }
            },
            error: function (xhr, status, error) {
                $("#lr-loading").hide();
                $("#user-updateaccount-errorMsg").text(xhr.responseText);
            }
        });
    });
}