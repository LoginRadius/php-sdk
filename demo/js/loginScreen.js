LRObject.util.ready(function() {
  LRObject.loginScreen("loginscreen-container", options)
});

let options = {
  redirecturl: {
    afterlogin: "profile.html",
    afterreset: "index.html"
  }
}

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
