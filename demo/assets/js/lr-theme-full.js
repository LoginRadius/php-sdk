function getAjaxRequest(id, postData) {
    $("#" + id).html('<img src="assets/images/waiting.gif" style="margin: 0 auto;"/>');
    if (postData.func == 'photos'){
        $("#" + id).show();
    }
    $.ajax({url: "ajax.php", type: "POST", data: postData, success: function (result) {
            jsonobj = $.parseJSON(result);
            if (typeof jsonobj.errorCode != 'undefined' || jsonobj.length < 1 || jsonobj == false) {
                if (postData.func == 'photos'){
                    $("#" + id).html('<div class="Error">Unable to get profile images.</div><br>');
                }else{
                    $("#" + id).hide();
                    $("#" + id.replace('lr-', "lr-tab-")).hide();
                }
            } else {
                var tabledata = true;
                var htmlData = '';
                if (postData.func == 'photos') {
                    htmlData = '<thead><tr><td>ID</td><td>AlbumId</td><td>OwnerId</td><td>OwnerName</td><td>Name</td><td>DirectUrl</td><td>ImageUrl</td><td>Location</td><td>Link</td><td>Description</td><td>Height</td><td>Width</td><td>CreatedDate</td><td>UpdatedDate</td></tr></thead>';
                } else if (postData.func == 'following') {
                    htmlData = '<thead><tr><td>ID</td><td>CreatedDate</td><td>OwnerId</td><td>OwnerName</td><td>Latitude</td><td>Longitude</td><td>Message</td><td>PlaceTitle</td><td>Address</td><td>Distance</td><td>Type</td><td>ImageUrl</td><td>City</td><td>Country</td></tr></thead>';
                } else if (postData.func == 'events') {
                    htmlData = '<thead><tr><td>ID</td><td>CreatedDate</td><td>OwnerId</td><td>OwnerName</td><td>Latitude</td><td>Longitude</td><td>Message</td><td>PlaceTitle</td><td>Address</td><td>Distance</td><td>Type</td><td>ImageUrl</td><td>City</td><td>Country</td></tr></thead>';
                } else if (postData.func == 'posts') {
                    htmlData = '<thead><tr><td>ID</td><td>Name</td><td>Title</td><td>StartTime</td><td>UpdateTime</td><td>Message</td><td>Place</td><td>Picture</td><td>Likes</td><td>Share</td><td>Type</td></tr></thead>';
                } else if (postData.func == 'companies') {
                    htmlData = '<thead><tr><td>ID</td><td>Name</td></tr></thead>';
                } else if (postData.func == 'groups') {
                    htmlData = '<thead><tr><td>ID</td><td>CreatedDate</td><td>OwnerId</td><td>OwnerName</td><td>Latitude</td><td>Longitude</td><td>Message</td><td>PlaceTitle</td><td>Address</td><td>Distance</td><td>Type</td><td>ImageUrl</td><td>City</td><td>Country</td></tr></thead>';
                } else if (postData.func == 'status') {
                    htmlData = '<thead><tr><td>Id</td><td>Text</td><td>DateTime</td><td>Likes</td><td>Place</td><td>Source</td><td>ImageUrl</td><td>LinkUrl</td><td>Name</td></tr></thead>';
                } else if (postData.func == 'videos') {
                    htmlData = '<thead><tr><td>ID</td><td>Description</td><td>Name</td><td>Image</td><td>Source</td><td>CreatedDate</td><td>OwnerId</td><td>OwnerName</td><td>EmbedHtml</td><td>UpdatedDate</td><td>Duration</td><td>DirectLink</td></tr></thead>';
                } else if (postData.func == 'checkins') {
                    htmlData = '<thead><tr><td>ID</td><td>CreatedDate</td><td>OwnerId</td><td>OwnerName</td><td>Latitude</td><td>Longitude</td><td>Message</td><td>PlaceTitle</td><td>Address</td><td>Distance</td><td>Type</td><td>ImageUrl</td><td>City</td><td>Country</td></tr></thead>';
                } else if (postData.func == 'audio') {
                    htmlData = '<thead><tr><td>Name</td><td>EmailID</td><td>PhoneNumber</td><td>ID</td><td>ProfileUrl</td><td>ImageUrl</td><td>Status</td><td>Industry</td><td>Country</td><td>Location</td><td>Gender</td><td>DateOfBirth</td></tr></thead>';
                } else if (postData.func == 'mentions') {
                    htmlData = '<thead><tr><td>Name</td><td>EmailID</td><td>PhoneNumber</td><td>ID</td><td>ProfileUrl</td><td>ImageUrl</td><td>Status</td><td>Industry</td><td>Country</td><td>Location</td><td>Gender</td><td>DateOfBirth</td></tr></thead>';
                } else if (postData.func == 'albums') {
                    htmlData = '<thead><tr><td>View Photos</td><td>ID</td><td>OwnerId</td><td>OwnerName</td><td>Title</td><td>Description</td><td>Location</td><td>Type</td><td>CreatedDate</td><td>UpdatedDate</td><td>CoverImageUrl</td><td>ImageCount</td><td>DirectoryUrl</td></tr></thead>';
                } else if (postData.func == 'contact') {
                    htmlData = '<thead><tr><td>Name</td><td>EmailID</td><td>PhoneNumber</td><td>ID</td><td>ProfileUrl</td><td>ImageUrl</td><td>Status</td><td>Industry</td><td>Country</td><td>Location</td><td>Gender</td><td>DateOfBirth</td></tr></thead>';
                    jsonobj = jsonobj.Data;
                } else if (postData.func == 'likes') {
                    htmlData = '<thead><tr><td>ID</td><td>Name</td><td>Category</td><td>CreatedDate</td><td>Website</td><td>Description</td></tr></thead>';
                } else if (postData.func == 'extendedProfile'){
                    tabledata = false;
                }
                if(tabledata){                    
                    if(postData.func == 'albums'){
                        htmlData = '<div id="showalbumphoto"></div><table>'+htmlData;
                    }else{
                        htmlData = '<table>'+htmlData;
                    }                            
                    for (var key in jsonobj) {
                        htmlData += createHorizontalTable(jsonobj[key], key + 1, postData.func);
                        if (postData.func == 'contact' && postData.poststatus == true) {
                            $('#sendto').append('<option value="' + jsonobj[key].ID + '">' + jsonobj[key].Name + '</option>');
                        }
                    }
                    htmlData += '</table>';
                }else{
                    htmlData = getTable(jsonobj);
                }
                $("#" + id).html(htmlData);
                $('iframe').css({"width": "70px", "height": "70px"});
            }
        },
        error: function () {
            $("#" + id).hide();
            $("#" + id.replace('lr-', "lr-tab-")).hide();
        }});
}
function sendMessage() {
    $("#sendmessage").html('<img src="assets/images/waiting.gif"/>');
    var to = $("#sendto").val();
    var subject = $("#sendsub").val();
    var message = $("#sendstatus").val();
    if (to == '') {
        $("#sendmessage").html('<div class="Error">Please enter send email</div>');
        return false;
    }
    else if (subject == '') {
        $("#sendmessage").html('<div class="Error">Please enter Subject</div>');
        return false;
    }
    else if (message == '') {
        $("#sendmessage").html('<div class="Error">Please enter Message</div>');
        return false;
    }

    $.ajax({
        url: "ajax.php",
        type: "POST",
        data: {
            "func": 'sendmessage',
            "to": to,
            "subject": subject,
            "message": message,
        },
        success: function (result) {
            jsonobj = $.parseJSON(result);
            if (jsonobj.isPosted == true) {
                $("#sendmessage").html('<div class="Success">Message has been Posted</div>');
                $('input[type=text],textarea').val('');
            } else {
                if(typeof jsonobj.errorCode == 'undefined'){
                    jsonobj.errorCode = 'An error has occurred.';
                }
                $("#sendmessage").html('<div class="Error">' + jsonobj.errorCode + '</div>');
            }            
        }
    });
}
function postStatus(provider) {
    $("#postmessage").html('<img src="assets/images/waiting.gif"/>');

    var title = $("#posttitle").val();
    var url = '';
    var imageurl = '';
    var description = '';
    if (provider != 'twitter') {
        url = $("#posturl").val();
        imageurl = $("#postimageurl").val();
        description = $("#postdescription").val();
    }
    var status = $("#poststatus").val();
   /* if (title == '') {
        $("#postmessage").html('<div class="Error">Please enter Post Title</div>');
        return false;
    }
    if (provider != 'twitter') {
        if (url == '') {
            $("#postmessage").html('<div class="Error">Please enter Post URL</div>');
            return false;
        }
        if (imageurl == '') {
            $("#postmessage").html('<div class="Error">Please enter Image URL</div>');
            return false;
        }
        if (description == '') {
            $("#postmessage").html('<div class="Error">Please enter Description</div>');
            return false;
        }
    }*/
    if (status == '') {
        $("#postmessage").html('<div class="Error">Please enter Message</div>');
        return false;
    }

    $.ajax({
        url: "ajax.php",
        type: "POST",
        data: {
            "func": 'poststatus',
            "title": title,
            "url": url,
            "imageurl": imageurl,
            "status": status,
            "description": description
        },
        success: function (result) {
            jsonobj = $.parseJSON(result);
            if (jsonobj.isPosted == true) {
                $("#postmessage").html('<div class="Success">Message has been Posted</div>');
                $('input[type=text],textarea').val('');
            } else {
                if(typeof jsonobj.errorCode == 'undefined'){
                    jsonobj.errorCode = 'An error has occurred.';
                }
                $("#postmessage").html('<div class="Error">' + jsonobj.errorCode + '</div>');
            }
        }
    });
}
function getTable(profile) {
    var data = '<table>';
    for (var key in profile) {
        data += '<tr><td class="profileLabel">' + key + '</td>';
        var value = (profile[key] != null) ? profile[key] : '';
        if (typeof value == "object") {
            data += '<td class="profileValue">' + createHorizontalTable(value) + '</td>';
        } else {
            data += '<td class="profileValue">' + value + '</td>';
        }
        data += '</tr>';
    }
    data += '</table>';
    return data;
}
function photoProfile(albumid) {
    getAjaxRequest('showalbumphoto', {"func": 'photos', "id": albumid});
}
function createHorizontalTable(profile, count, table) {
    var data = '';
    if (typeof count == "undefined") {
        count = 0
    }
    if (count == '0') {
        data += '<table><tr>';
        for (var key in profile) {
            var value = (profile[key] != null) ? profile[key] : '';
            if (typeof value == "object") {
                data = '';
                return createHorizontalTable(value);
            }
            data += '<td class="profileLabel">' + key + '</td>';
        }
        data += '</tr>';
    }
    data += '<tr>';
    if (table == 'albums') {
        data += '<td><a onclick="photoProfile(&quot;' + profile['ID'] + '&quot;)">View Photos</a></td>';
    }
    for (var key in profile) {
        var value = (profile[key] != null) ? profile[key] : '';
        if (typeof value == "object") {
            data += '<td>' + createHorizontalTable(value) + '</td>';
        } else {
            if (key == 'ImageUrl' || key == 'Small' || key == 'Square' || key == 'Large' || key == 'Profile' || key == 'Image' || key == 'Picture') {
                data += '<td><img style="width:70px;" src="' + value + '"/></td>';
            } else {
                data += '<td>' + value + '</td>';
            }
        }
    }

    data += '</tr>';
    if (count == '0') {
        data += '</table>';
    }
    return data;
}
function showDateBlock() {
    var maxYear = new Date().getFullYear();
    var minYear = maxYear - 100;
    $('body').on('focus', ".loginradius-raas-birthdate", function () {
        $('.loginradius-raas-birthdate').datepicker({
            dateFormat: 'mm-dd-yy',
            maxDate: new Date(),
            minDate: "-100y",
            changeMonth: true,
            changeYear: true,
            yearRange: (minYear + ":" + maxYear)
        });
    });
}
function redirect(token, name) {
    var token_name = name ? name : 'token';
    var form = document.createElement('form');
    form.action = LocalDomain;
    form.method = 'POST';

    var hiddenToken = document.createElement('input');
    hiddenToken.type = 'hidden';
    hiddenToken.value = token;
    hiddenToken.name = token_name;
    form.appendChild(hiddenToken);

    document.body.appendChild(form);
    form.submit();
}
function formForAccountLinking(array) {
    var form = document.createElement('form');
    var key;
    form.action = '';
    form.method = 'POST';
    for (key in array) {
        var hiddenToken = document.createElement('input');
        hiddenToken.type = 'hidden';
        hiddenToken.value = array[key];
        hiddenToken.name = key;
        form.appendChild(hiddenToken);
    }
    document.body.appendChild(form);
    form.submit();
}
function linking() {
    $(".lr-linked-data, .lr-unlinked-data").html('');
    $(".lr-linked").each(function () {
        $(".lr-linked-data").append($(this).html());
    });
    $(".lr-unlinked").each(function () {
        $(".lr-unlinked-data").append($(this).html());
    });
    var linked_val = $('.lr-linked-data').html();
    var unlinked_val = $('.lr-unlinked-data').html();
    if (linked_val != '') {

        $(".lr-linked-data").prepend('<div class="lr-heading">Linked Accounts</div>');
    }
    if (unlinked_val != '') {
        $(".lr-unlinked-data").prepend('<div class="lr-heading lr-heading-small">Choose a social account to link</div>');
    }
    $('#interfacecontainerdiv').hide();
}
function unLinkAccount(name, id) {
    handleResponse(true, "");
    if (confirm('Are you sure you want to unlink!')) {
        $('#fade').show();
        var array = {};
        array['value'] = 'accountUnLink';
        array['provider'] = name;
        array['providerId'] = id;
        formForAccountLinking(array);
    }
    else {
        $('#fade').hide();
    }
}
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
        window.location = LocalDomain;
    });
}
function handleResponse(isSuccess, message, show) {
    if (show) {

    }
    else {
        $('#fade').show();
    }
    if (message != null && message != "") {
        $('#messageinfo').text(message);
        $(".messagediv").show();
        $('#messageinfo').show();
        $(".lr-profile-frame.lr-input-style").css({"margin-top": "0px"});
        if (isSuccess) {
            $('form').each(function () {
                this.reset();
            });
        }
    } else {
        $(".messagediv").hide();
        $('#messageinfo').hide();
        $(".lr-profile-frame.lr-input-style").css({"margin-top": "85px"});
        $('#messageinfo').text("");
    }
}

var raasoption = {};
raasoption.apikey = lrThemeSettings.raasoption.apikey;
raasoption.appname = lrThemeSettings.raasoption.appname;
raasoption.emailVerificationUrl = lrThemeSettings.raasoption.emailVerificationUrl;
raasoption.forgotPasswordUrl = lrThemeSettings.raasoption.forgotPasswordUrl;
if (navigator.userAgent.match('CriOS')) {
    raasoption.templatename = "loginradiuscustom_tmpl_IOS";
} else {
    raasoption.templatename = "loginradiuscustom_tmpl";
}
raasoption.hashTemplate = true;
raasoption.V2Recaptcha = true;

if (lrThemeSettings.auto_login_after_verify_email) {
    raasoption.enableLoginOnEmailVerification = true;
} else {
    raasoption.enableLoginOnEmailVerification = false;
}

LoginRadiusRaaS.$hooks.setProcessHook(function () {
    lrThemeSettings.form_render_submit_hook.start();
}, function () {
    lrThemeSettings.form_render_submit_hook.end();
});
if (isloggedin != "true") {
    LoginRadiusRaaS.CustomInterface(".interfacecontainerdiv", raasoption);
}


var LrRaasTheme = {
    init: function (body) {
        this.createParent();
        this.appendOverlayDiv();
        if (isloggedin != "true") {
            this.createPopup('register');
            this.createPopup('login');
            this.createPopup('forgot');
            this.raasFormInject();
            this.appendFooter();
        }

    },
    appendOverlayDiv: function () {
        var div = document.createElement('div');
        div.id = 'lr-overlay';
        document.getElementById('lr-pop-group').appendChild(div);
    },
    createParent: function () {
        var group = document.createElement('div');
        group.id = 'lr-pop-group';
        document.body.appendChild(group);
    },
    createPopup: function (action) {
        var div = document.createElement('div');
        var header_div;
        var body_div;
        var footer_div;

        switch (action) {
            case 'register':
                div.id = 'lr-register-container';
                div.className = 'lr-popup-container';
                header_div = this.createHeader(lrThemeSettings.caption_message.register);

                break;

            case 'login':
                div.id = 'lr-login-container';
                div.className = 'lr-popup-container';
                header_div = this.createHeader(lrThemeSettings.caption_message.login);

                break;

            case 'forgot':
                div.id = 'lr-fp-container';
                div.className = 'lr-popup-container';
                header_div = this.createHeader(lrThemeSettings.caption_message.forgot_password);

                break;

            case 'reset':
                div.id = 'lr-rp-container';
                div.className = 'lr-popup-container';
                header_div = this.createHeader(lrThemeSettings.caption_message.reset_password);

                break;

            case 'social':
                div.id = 'lr-social-container';
                div.className = 'lr-popup-container';
                header_div = this.createHeader(lrThemeSettings.caption_message.fields_missing);

                break;

            default:
                break;
        }

        body_div = this.createBody(action);
        div.appendChild(header_div);
        div.appendChild(body_div);

        document.getElementById('lr-pop-group').appendChild(div);
    },
    createHeader: function (message) {
        var div = document.createElement('div');
        div.className = 'lr-popup-header';
        //the close btn
        var closeSpan = document.createElement('span');
        closeSpan.className = 'lr-popup-close-span';
        closeSpan.innerHTML = '<a class="lr-popup-close-btn" onclick="LrRaasTheme.closeAllPopups()">&#215</a>';
        div.appendChild(closeSpan);
        //customizable logo section
        var logo_div = document.createElement('div');
        logo_div.className = 'lr-header-logo';
        logo_div.innerHTML = '<img src="' + lrThemeSettings.logo.logo_image_path + '" alt="' + lrThemeSettings.logo.logo_alt_text + '" class="lr-header-logo-img" />';
        logo_div.innerHTML += '<p class="lr-header-caption">' + message + '</p>';
        div.appendChild(logo_div);

        return div;
    },
    createBody: function (action) {
        var div = document.createElement('div');
        div.id = 'lr-popup-body-container';

        var message_header = document.createElement('div');
        message_header.id = 'lr-' + action + '-popup-message';
        message_header.className = 'lr-popup-message';

        div.appendChild(message_header);

        switch (action) {
            case 'register':
            case 'login':
                var social_div = document.createElement('div');
                social_div.className = 'interfacecontainerdiv lr-sl-shaded-brick-frame lr-column';
                var reg_div = document.createElement('div');
                reg_div.id = action + '-div';
                reg_div.className = 'lr-column';

                div.appendChild(social_div);
                div.appendChild(reg_div);

                break;

            case 'forgot':
            case 'reset':
                var fp_div = document.createElement('div');
                fp_div.id = action + 'password-div';
                div.appendChild(fp_div);

                break;

            case 'social':
                var social_div = document.createElement('div');
                social_div.id = 'sociallogin-container';
                div.appendChild(social_div);
                break;

            default:
                break;
        }

        return div;
    },
    createFooter: function (action) {
        var div = document.createElement('div');
        div.id = 'lr-popup-footer';
        div.className = 'lr-popup-footer';
        switch (action) {
            case 'register':
                div.innerHTML = "<a class='lr-raas-theme-fp'>Forgot Password</a> <a class='lr-raas-theme-login'>Login</a>";
                break;
            case 'forgot':
            case 'reset':
                div.innerHTML = "<a class='lr-raas-theme-login'>Login</a>";
                break;
            case 'login':
                div.innerHTML = "<a class='lr-raas-theme-fp'>Forgot Password</a> <a class='lr-raas-theme-register'>Register</a>";
                break;
            default:
                break;
        }

        return div;
    },
    raasFormInject: function () {
        $SL.util.ready(function () {
            LoginRadiusRaaS.init(raasoption, 'registration', function (response) {
                var message_header = document.getElementById('lr-register-popup-message');
                message_header.innerHTML = lrThemeSettings.success_message.register;
                $('.lr-popup-message').show();
                $('input[type=text],input[type=password],select,textarea').val('');
            }, function (errors) {
                var message_header = document.getElementById('lr-register-popup-message');
                message_header.innerHTML = errors[0].message;
                $('.lr-popup-message').show();
            }, "register-div");

            LoginRadiusRaaS.init(raasoption, 'login', function (response) {
                var message_header = document.getElementById('lr-login-popup-message');
                message_header.innerHTML = lrThemeSettings.success_message.login;
                redirect(response.access_token);
                $('input[type=text],input[type=password],select,textarea').val('');
            }, function (errors) {
                var message_header = document.getElementById('lr-login-popup-message');
                message_header.innerHTML = errors[0].message;
                $('.lr-popup-message').show();
            }, "login-div");

            LoginRadiusRaaS.init(raasoption, 'sociallogin', function (response) {
                var social_message_header = document.getElementById('lr-social-popup-message');
                if (document.getElementById('loginradius-raas-social-registration-emailid')) {
                    if (social_message_header) {
                        social_message_header.innerHTML = lrThemeSettings.success_message.register;
                        $('.lr-popup-message').show();
                    }

                } else {
                    if (social_message_header) {
                        social_message_header.innerHTML = lrThemeSettings.success_message.social_login;
                        $('.lr-popup-message').show();
                    }
                }
                if (!response.isPosted) {
                    redirect(response);
                } else {
                    var sociallogin_container = document.getElementById('sociallogin-container');
                    sociallogin_container.innerHTML = '';
                }
            }, function (errors) {

                var login_message_header = document.getElementById('lr-login-popup-message');
                var register_message_header = document.getElementById('lr-register-popup-message');
                var sociallogin_message_header = document.getElementById('lr-social-popup-message');
                if (login_message_header != null) {
                    login_message_header.innerHTML = errors[0].message;
                }
                if (register_message_header != null) {
                    register_message_header.innerHTML = errors[0].message;
                }
                if (sociallogin_message_header != null) {
                    sociallogin_message_header.innerHTML = errors[0].message;
                }
                $('.lr-popup-message').show();
            }, "sociallogin-container");

            LoginRadiusRaaS.$hooks.socialLogin.onFormRender = function () {
                LrRaasTheme.createPopup('social');
                LrRaasTheme.showPopup('lr-social-container');
            };

            LoginRadiusRaaS.init(raasoption, 'forgotpassword', function (response) {
                var message_header = document.getElementById('lr-forgot-popup-message');
                message_header.innerHTML = lrThemeSettings.success_message.forgot_password;
                lrThemeSettings.success_function.forgot_password();
                $('.lr-popup-message').show();
                $('input[type=text],input[type=password],select,textarea').val('');
            }, function (errors) {
                var message_header = document.getElementById('lr-forgot-popup-message');
                message_header.innerHTML = errors[0].message;
                $('.lr-popup-message').show();
            }, "forgotpassword-div");
            showDateBlock();
            var params = LrRaasTheme.getUrlParameters();
            for (var key in params) {
                if ('emailverification' == params[key]) {
                    LoginRadiusRaaS.init(raasoption, 'emailverification', function (response) {
                        if (raasoption.enableLoginOnEmailVerification) {
                            if (response.access_token != null && response.access_token != "") {
                                LrRaasTheme.showPopup('lr-login-container');
                                var message_header = document.getElementById('lr-login-popup-message');
                                message_header.innerHTML = lrThemeSettings.success_message.verify_email;
                                redirect(response);
                            } else {
                                LrRaasTheme.showPopup('lr-login-container');
                                var message_header = document.getElementById('lr-login-popup-message');
                                message_header.innerHTML = lrThemeSettings.success_message.email_verified;
                                $('.lr-popup-message').show();
                            }
                        } else {
                            LrRaasTheme.showPopup('lr-login-container');
                            var message_header = document.getElementById('lr-login-popup-message');
                            handleResponse(true, lrThemeSettings.success_message.verify_email);
                            message_header.innerHTML = lrThemeSettings.success_message.verify_email;
                            $('.lr-popup-message').show();
                        }
                    }, function (errors) {

                        LrRaasTheme.showPopup('lr-login-container');
                        var message_header = document.getElementById('lr-login-popup-message');
                        message_header.innerHTML = errors[0].message;
                        $('.lr-popup-message').show();
                    });
                } else if ('reset' == params[key]) {
                    LrRaasTheme.createPopup('reset');
                    LoginRadiusRaaS.init(raasoption, 'resetpassword', function (response) {
                        var message_header = document.getElementById('lr-reset-popup-message');
                        message_header.innerHTML = lrThemeSettings.success_message.reset_password;
                        lrThemeSettings.success_function.reset_password();
                        $('.lr-popup-message').show();
                        $('#resetpassword-div').hide();
                        setTimeout(function (){$('.lr-popup-message').hide();LrRaasTheme.showPopup('lr-login-container');}, 3000);
                    }, function (errors) {
                        var message_header = document.getElementById('lr-reset-popup-message');
                        message_header.innerHTML = errors[0].message;
                        $('.lr-popup-message').show();
                    }, "resetpassword-div");

                    LrRaasTheme.showPopup('lr-rp-container');
                } else {
                    return true;
                }
            }

        });
    },
    appendFooter: function () {
        var reg_form = document.getElementsByName('loginradius-raas-registration');
        var login_form = document.getElementsByName('loginradius-raas-login');
        var forgot_form = document.getElementsByName('loginradius-raas-forgotpassword');
        var reset_form = document.getElementsByName('loginradius-raas-resetpassword');

        var login_form_interval = setInterval(function () {
            if (document.readyState !== 'complete')
                return;
            clearInterval(login_form_interval);
            var registration_footer_div = LrRaasTheme.createFooter('register');
            if (reg_form[0]) {
                reg_form[0].appendChild(registration_footer_div);
            }

            var login_footer_div = LrRaasTheme.createFooter('login');
            if (login_form[0]) {
                login_form[0].appendChild(login_footer_div);
            }

            var forgot_footer_div = LrRaasTheme.createFooter('forgot');
            if (forgot_form[0]) {
                forgot_form[0].appendChild(forgot_footer_div);
            }

            var reset_footer_div = LrRaasTheme.createFooter('reset');
            if (reset_form[0]) {
                reset_form[0].appendChild(reset_footer_div);
            }
            LrRaasTheme.addClassListener();
        }, 100);
    },
    showPopup: function (popup_id) {
        console.log(popup_id);
        $('.lr-popup-message').hide();
        this.closeAllPopups();
        this.clearAllMessages();
        this.showOverlay();

        var pop = document.getElementById(popup_id);
        pop.className = pop.className + " lr-show";
    },
    hideOverlay: function () {
        document.getElementById('lr-overlay').className = '';
        document.getElementById('lr-pop-group').className = '';
    },
    showOverlay: function () {
        document.getElementById('lr-overlay').className = 'lr-show-layover';
        document.getElementById('lr-pop-group').className = 'lr-show-layover';
    },
    resetAllPopups: function () {
        var form_list = ['loginradius-raas-registration', 'loginradius-raas-login', 'loginradius-raas-forgotpassword'];
        for (var i = 0; i < form_list.length; i++) {
            var form = document.getElementsByName(form_list[i]);
            form[0].reset();
        }
    },
    closeAllPopups: function () {
        if (lrThemeSettings.reset_form_after_close_popup) {
            this.resetAllPopups;
        }
        ;
        this.hideOverlay();
        var popups = document.getElementsByClassName("lr-popup-container");
        for (var i = 0; i < popups.length; i++) {
            popups[i].className = "lr-popup-container";
        }
    },
    clearAllMessages: function () {
        var message_headers = document.getElementsByClassName('lr-popup-message');
        for (var i = 0; i < message_headers.length; i++)
        {
            message_headers[i].innerHTML = "";
        }
    },
    addClassListener: function () {
        document.getElementById('lr-overlay').addEventListener("click", function () {
            LrRaasTheme.closeAllPopups();
        });

        var closeBtnClass = document.getElementsByClassName("lr-popup-close-btn");
        for (var i = 0; i < closeBtnClass.length; i++) {
            closeBtnClass[i].addEventListener("click", function (event) {
                LrRaasTheme.closeAllPopups();
                return false;
            });
        }

        var lrSignupClass = document.getElementsByClassName("lr-raas-theme-register");
        for (var i = 0; i < lrSignupClass.length; i++) {
            lrSignupClass[i].addEventListener("click", function (event) {
                LrRaasTheme.showPopup('lr-register-container');
                return false;
            });
        }

        var lrLoginClass = document.getElementsByClassName("lr-raas-theme-login");
        for (var i = 0; i < lrLoginClass.length; i++) {
            lrLoginClass[i].addEventListener("click", function (event) {
                LrRaasTheme.showPopup('lr-login-container');
                return false;
            });
        }

        var fpClass = document.getElementsByClassName("lr-raas-theme-fp");
        for (var i = 0; i < fpClass.length; i++) {
            fpClass[i].addEventListener("click", function (event) {
                LrRaasTheme.showPopup('lr-fp-container');
                return false;
            });
        }
    },
    getUrlParameters: function () {
        var prmstr = window.location.search.substr(1);
        return prmstr != null && prmstr != "" ? this.transformToAssocArray(prmstr) : {};
    },
    transformToAssocArray: function (prmstr) {
        var params = {};
        var prm_array = prmstr.split("&");
        for (var i = 0; i < prm_array.length; i++) {
            var tmp_array = prm_array[i].split("=");
            params[tmp_array[0]] = tmp_array[1];
        }

        return params;
    }
}
$(document).ready(function () {
    $('.loginradius-raas-birthdate').datepicker("option", "dateFormat", 'mm-dd-yyyy');
    $("#fade").click(function () {
        $('#fade').hide();
    });
    $("#lr-tab-basic").show();
    showDateBlock();
    LoginRadiusRaaS.$hooks.setProcessHook(function () {
        $('.lr-popup-message').hide();
        $('#fade').show();
    }, function () {
        $('#fade').hide();
        if ($('.lr_account_linking') && $('#interfacecontainerdiv').text() != '') {
            linking();
        }
    });
    if($('#accountlinkinginterface').length > 0){
    LoginRadiusRaaS.init(raasoption, 'accountlinking', function (response) {
        if (response.isPosted) {
            window.location.href = window.location;
        } else {
            var send_data = 'value=accountLink&token=' + response;
            var handle = function (data) {

                var data = JSON.parse(data);
                if (data.status == 'success') {
                    handleResponse(true, data.message);
                }
                else if (data.status == 'error') {
                    handleResponse(true, data.message, true);
                }
                $('#fade').hide();
            }
            var array = {};
            array['value'] = 'accountLink';
            array['token'] = response;
            formForAccountLinking(array);
        }
    }, function (response) {
    }, "accountlinkinginterface");
}

if($('#changepasswordbox').length > 0 || $('#setpasswordbox').length > 0){
    LoginRadiusRaaS.passwordHandleForms("setpasswordbox", "changepasswordbox", function (israas) {
        if (israas ) {
            $('#lr-password-tab').attr("data-tab", "lr-change-pw");
            $('#lr-password-tab').html("Change Password");
            $("#changepasswordbox").show();
        } else{

            $('#lr-password-tab').attr("data-tab", "lr-set-pw");
            $('#lr-password-tab').attr("Set Password");
            $("#setpasswordbox").show();
        }
    }, function () {
        document.forms['setpassword'].action = '';
        document.forms['setpassword'].submit();
    }, function (errors) {
        var message_header = document.getElementById('lr-setpasswordbox-popup-message');
        message_header.innerHTML = errors[0].message;
    }, function () {
        document.forms['changepassword'].action = '';
        document.forms['changepassword'].submit();
    }, function (errors) {
        var message_header = document.getElementById('lr-changepasswordbox-popup-message');
        message_header.innerHTML = errors[0].message;
    });
    }
    LrRaasTheme.init();
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
    $('.lr-show-pw').click(function () {
        var dataTab = $('.lr-tab-active').attr("data-tab");
        var placeholder = '';
        var showPass = function () {
            $('.' + dataTab).find('input:password').each(function () {

                $("<input type='text' class='showPass' />").attr({name: this.name, value: this.value}).insertBefore(this);
            }).remove();
        };
        var hidePass = function () {
            $('.' + dataTab).find('input.showPass').each(function () {

                $("<input type='Password' />").attr({name: this.name, value: this.value}).insertBefore(this);
            }).remove();
        };

        if ($('.' + dataTab + ' input:password').is(':visible')) {
            showPass();
            $('.lr-show-pw').addClass('lr-toggle');
        } else {
            hidePass();
            $('.lr-show-pw').removeClass('lr-toggle');
        }
    });
});
