   $(document).ready(function () {
   $('.lr-menu-buttons .lr-buttons').click(function () {
        var dataTab = $(this).attr("data-tab");
        $('.lr-menu-buttons .lr-buttons').removeClass('lr-tab-active');
        $('.lr-frame').removeClass('lr-tab-active');

        if (dataTab == 'lr-profile') {
            $("#lr-basic").addClass('lr-tab-active');
            $('.lr-submenu-buttons .lr-buttons').removeClass('lr-tab-active');
            $("#lr-tab-basic").addClass('lr-tab-active');
        }
        $(this).addClass('lr-tab-active');
        $("#" + dataTab).addClass('lr-tab-active');
    });
    $('.lr-submenu-buttons .lr-buttons').click(function () {
        var dataTab = $(this).attr("data-tab");
        $('.lr-submenu-buttons .lr-buttons').removeClass('lr-tab-active');
        $('.lr-frame .lr-subframe').removeClass('lr-tab-active');

        $(this).addClass('lr-tab-active');
        $("#" + dataTab).addClass('lr-tab-active');
    });
});
 function ajaxHandler(data, success) {
    $('#fade').show();
    $.ajax({
        type: "POST",
        url: '',
        data: data,
        success: success,
        error: function (jqXHR, textStatus, errorThrown) {
            $('#fade').hide();
        }
    });
}

function profileLogout() {
    var data = 'value=logout';
    ajaxHandler(data, function (data) {
        window.location = window.location.href;
    });
}

function showPopup() {
    $(document).ready(function () {
        $('#social-registration-form').show();
    });
}

function closePopup() {
    $('#social-registration-form').hide();
}

 function addEmailPopup() { 
    var url = window.location.href;
    var email = document.getElementById("email_popup").value;
    $.ajax({
        dataType: "json",
        type: "POST",
        url: url,
        data: {'email':email,'action':'updateProfile'},     
        success: function (data) {
            if (data.status == 'error') {     
                $("#messageDiv").show();
                $('.message').text(data.result);
            } else if (data.status == 'success') {
      
                $("#messageDiv").show();
                $('.message').text(data.result);
                setTimeout(function(){
                window.location.href = window.location.href;
            },5000);
            }
        }      
    });
}
