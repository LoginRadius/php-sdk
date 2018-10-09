var stringVariable = window.location.href;
domainName = stringVariable.substring(0, stringVariable.lastIndexOf('/'));
$(function () {

    handleLogout();
    var accesstoken = localStorage.getItem("LRTokenKey");
    var lruseruid = localStorage.getItem("LRUserID");
    var emailId = localStorage.getItem("EmailId");
    var username = localStorage.getItem("UserName");
    var lastlogintime = localStorage.getItem("LastLoginTime");

    if (accesstoken != "" && accesstoken !== null) {
        if(username!= "" && username != null){
          jQuery('.lr-user-name').text(username);
        }
        jQuery('.emailid').text(emailId);
        jQuery('.useruid').text(lruseruid);
        jQuery('.lastlogin').text(lastlogintime);
    } else {
        window.location.href = domainName + "/index.html";
    }
});

function handleLogout() {
    $('#menu-user-logout').on('click', function () {
        localStorage.setItem("LRTokenKey", "");
        localStorage.setItem("LRUserID", "");
        localStorage.setItem("EmailId", "");
        localStorage.setItem("UserName", "");
        localStorage.setItem("ImageUrl", "");
        localStorage.setItem("LastLoginTime", "");
    });
}