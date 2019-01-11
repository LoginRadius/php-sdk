const url = window.location.href;
const params = url.split("?")[1];
const domainName = url.substring(0, url.lastIndexOf("/"));
let paramsObj = {};

$("#btn-minimal-resetpassword").click(function() {
  $("#minimal-resetpassword-message").text("");

  if($("#minimal-resetpassword-password").val() !== $("#minimal-resetpassword-confirmpassword").val()) {
    $("#minimal-resetpassword-message").text("Passwords do not match!");
    $("#minimal-resetpassword-message").attr("class", "error-message");
    return;
  }
  
  $.ajax({
    method: "POST",
    url: domainName + "/ajax_handler/login",
    dataType: "json",
    data: $.param({
      resettoken: paramsObj.vtoken,
      password: $("#minimal-resetpassword-password").val(),
      action: "resetPassword"
    }),
    error: function(xhr) {
      $("#minimal-resetpassword-message").text(xhr.responseJSON);
      $("#minimal-resetpassword-message").attr("class", "error-message");
    }
  }).done(function(ret) {
    if (ret.status == "success") {
      $("#minimal-resetpassword-password").val("");
      $("#minimal-resetpassword-confirmpassword").val("");
      $("#minimal-resetpassword-message").text(ret.message);
      $("#minimal-resetpassword-message").attr("class", "success-message");
    } else if (ret.status == "error") {
      $("#minimal-resetpassword-message").text(ret.message);
      $("#minimal-resetpassword-message").attr("class", "error-message");
    }
  });
});

if (params) {
  paramsObj = JSON.parse('{"' + decodeURI(params.replace(/&/g, "\",\"").replace(/=/g,"\":\"")) + '"}');

  if (paramsObj.vtype != "reset") {
    window.location.replace("index.html");
  }
} else {
  window.location.replace("index.html");
}
