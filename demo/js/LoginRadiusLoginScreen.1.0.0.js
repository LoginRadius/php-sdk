(function(win) {
  if (win.LoginRadiusV2) {
    LoginRadiusV2.prototype.loginScreen = function(container, options, cb) {
      options = options || {};
      if(options.pagesshown){
            if (options.pagesshown.length==0){
                  alert("there is nothing to display, check your options.pagesshown");
                  return;
            }
            for(var i = 0; i<options.pagesshown.length; i++){
                  options[options.pagesshown[i]] = true;
            }
      }
      cb = cb || function(response,Event){};
      var LoginScreen = document.createElement("div");
      LoginScreen.innerHTML = generateLayout(container, options);

      addHTMLContent(container, LoginScreen);
      renderJS(cb, options, this);

    };
  }

  function addHTMLContent(container, data, innerHtml) {
    innerHtml = innerHtml || false;
    var containerElem = document.getElementById(container);
    containerElem.classList.add("lr-ls-loginscreencontainer")
    if (containerElem) {
      if (!innerHtml) {
        containerElem.innerHTML = '';
      }
      containerElem.appendChild(data);
    } else {
      var containerElem = document.getElementsByClassName(container);
      if (containerElem && containerElem.length > 0) {
        for (var j = 0; j < containerElem.length; j++) {
          if (!innerHtml) {
            containerElem[j].innerHTML = '';
          }
          containerElem[j].appendChild(data);
        }
      }
    }
  }
        
  function generateLayout(container, options) {
      return '<style type="text/css"> .lr-ls-loginscreencontainer * {'+
      '    margin: 0;'+
      '    padding: 0;'+
      '    box-sizing: border-box;'+
      '    vertical-align: middle;'+
      '    border-style: hidden;'+
      '    font-family:' + ((options.body && options.body.fontFamily) ? ('"'+options.body.fontFamily+'",') : " ") + ' "-apple-system", "system-ui", "Helvetica Neue", "Helvetica", "Arial", "sans-serif";' +
      '}'+
      '@media only screen and (max-device-width: 959px) {'+
      '    .lr-ls-page {'+
      '        position: relative;'+
      '        width: 100%;'+
      '        height: 100vh;'+
      '        background-color: #FFFFFF;'+
      '        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2), 0 1px 1px 0 rgba(0, 0, 0, 0.12);'+
      '    }'+
      '    .lr-ls-logobase {'+
      '        height: 22vw;'+
      '        background-color:' + ((options.logo && options.logo.color) ? options.logo.color : " #F5F5F5") +';' +
      '    }'+
      '    #lr-ls-logo-place {'+
      '        display: block;'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '        width: 50%;'+
      '        padding-top: 5vw;'+
      '    }'+
      '    .lr-ls-tabs {'+
      '        display: block;'+
      '        position: relative;'+
      '    }'+
      '    .lr-ls-tabs .tab {'+
      '        width: 50%;'+
      '        float: left;'+
      '        display: flex;'+
      '        flex-direction: row;'+
      ((options.body && options.body.backgroundColor) ? ('background-color:' + options.body.backgroundColor +';') : ('background-color: #FFFFFF;')) +
      '    }'+
      '    .lr-ls-tabs .tab>input[type="radio"] {'+
      '        position: absolute;'+
      '        top: -9999px;'+
      '        left: -9999px;'+
      '    }'+
      '    .lr-ls-tabs .tab>label {'+
      '        width: 50vw;'+
      '        flex: 1 1 auto;'+
      '        display: block;'+
      '        cursor: pointer;'+
      '        position: relative;'+
      '        color: #384049;'+
      '        font-size: 4.28vw;'+
      '        line-height: 6.13333rem;'+
      '        text-align: center;'+
      '        vertical-align: middle;'+
      '        border-bottom: 0.5rem solid #EEEEEE;'+
      '    }'+
      '    .lr-ls-tabs .content {'+
      '        z-index: 0;'+
      '        /* or display: none; */'+
      '        overflow: hidden;'+
      '        width: 100%;'+
      '        position: absolute;'+
      '        top: 6.5rem;'+
      '        /* this field  determines the height of the line below the label*/'+
      '        left: 0;'+
      '        background-color: #FFFFFF;'+
      '        display: none;'+
      '        -webkit-transition: all linear 0.3s;'+
      '        -moz-transition: all linear 0.3s;'+
      '        -o-transition: all linear 0.3s;'+
      '        -ms-transition: all linear 0.3s;'+
      '        transition: all linear 0.3s;'+
      '        -webkit-transform: translateX(-250px);'+
      '        -moz-transform: translateX(-250px);'+
      '        -o-transform: translateX(-250px);'+
      '        -ms-transform: translateX(-250px);'+
      '        transform: translateX(-250px);'+
      '    }'+
      '    .Resetpw-content {'+
      '        display: none;'+
      ((options.singlepagestyle)? '' : ('left:360px'))+
      '    }'+
      '    .lr-ls-tabs>.tab>[id^="tab"]:checked+label {'+
      '        top: 0;'+
      '        border-bottom: 0.5rem solid #BDBDBD;'+
      '        -webkit-animation: page 0.2s linear;'+
      '        -moz-animation: page 0.2s linear;'+
      '        -ms-animation: page 0.2s linear;'+
      '        -o-animation: page 0.2s linear;'+
      '        animation: page 0.2s linear;'+
      '    }'+
      '    .lr-ls-tabs>.tab>[id^="tab"]:checked~[id^="tab-content"] {'+
            ((options.body && options.body.backgroundColor) ? ('background-color:' + options.body.backgroundColor +';') : ('')) +
      '        z-index: 1;'+
      '        /* or display: block; */'+
      '        display: block;'+
      '        -webkit-transform: translateX(0px);'+
      '        -moz-transform: translateX(0px);'+
      '        -o-transform: translateX(0px);'+
      '        -ms-transform: translateX(0px);'+
      '        transform: translateX(0px);'+
      '        -webkit-transition: all ease-out 0.8s 0.1s;'+
      '        -moz-transition: all ease-out 0.8s 0.1s;'+
      '        -o-transition: all ease-out 0.8s 0.1s;'+
      '        -ms-transition: all ease-out 0.8s 0.1s;'+
      '        transition: all ease-out 0.8s 0.1s;'+
      '        overflow: hidden;'+
      '    }'+
      '    .greeting {'+
      '        margin-top: 4vh;'+
      '        width: 91vw;'+
      '        font-size: 5vw;'+
      '        margin-bottom: 3rem;'+
      '        line-height: 4rem;'+
      '        color: #424242;'+
      '    }'+
      '    #lr-ls-sectiondivider,#lr-ls-sectiondividerL {'+
      '        margin-top: 3.2rem;'+
      '        display: block;'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '        height: 1.5rem;'+
      '        text-align: center;'+
      '        color: #424242;'+
      '        font-size: 5vw;'+
      '        line-height: 5rem;'+
      '    }'+

      (options.socialsquarestyle ? 

      '    .social-login-b-options {'+
      '        margin-top: 6vh;'+
      '        width: 91vw;'+
      '        text-align: center;'+
      '        font-size: 5vw;'+
      '        font-weight: 400;'+
      '        -webkit-animation: slide-up 1s ease-out;'+
      '        -moz-animation: slide-up 1s ease-out;'+
      '    }'+
      '    .social-login-b-options .lr-sl-shaded-brick-button {'+
      '        height: 8rem;'+
      '        width: 8rem;'+
      '        border-radius: 0.5rem;'+
      '        overflow: hidden;'+
      '        margin-top: 2.5vw;'+
      '        position: relative;'+
      '        border: 1px solid rgba(0, 0, 0, 0.1);'+
      '        text-align: left;'+
      '        text-decoration: none;'+
      '        color: white;'+
      '        box-shadow: 0 0 1px 0 rgba(0, 0, 0, 0.12), 0 1px 1px 0 rgba(0, 0, 0, 0.24), 0 0 8px 0 rgba(0, 0, 0, 0.12), 0 2px 2px 0 rgba(0, 0, 0, 0.24);'+
      '    }'+
      '    .social-login-b-options .lr-sl-shaded-brick-button .lr-sl-icon {'+
      '        top: 0;'+
      '        left: 0;'+
      '        display: inline-block;'+
      '        position: absolute;'+
      '    }'+
      '    .lr-provider-label {'+
      '        margin-top: 8px;'+
      '        display: inline-block;'+
      '    }'  

      :

      '    .social-login-b-options {'+
      '        margin-top: 6vh;'+
      '        width: 91vw;'+
      '        text-align: center;'+
      '        font-size: 5vw;'+
      '        font-weight: 400;'+
      '        -webkit-animation: slide-up 1s ease-out;'+
      '        -moz-animation: slide-up 1s ease-out;'+
      '    }'+
      '    .social-login-b-options .lr-sl-shaded-brick-button {'+
      '        height: 8rem;'+
      '        width: 100%;'+
      '        border-radius: 0.5rem;'+
      '        overflow: hidden;'+
      '        margin-top: 2.5vw;'+
      '        position: relative;'+
      '        border: 1px solid rgba(0, 0, 0, 0.1);'+
      '        text-align: left;'+
      '        text-decoration: none;'+
      '        color: white;'+
      '        padding: 2rem 0 0.8rem 8rem;'+
      '        box-shadow: 0 0 1px 0 rgba(0, 0, 0, 0.12), 0 1px 1px 0 rgba(0, 0, 0, 0.24), 0 0 8px 0 rgba(0, 0, 0, 0.12), 0 2px 2px 0 rgba(0, 0, 0, 0.24);'+
      '    }'+
      '    .social-login-b-options .lr-sl-shaded-brick-button .lr-sl-icon {'+
      '        top: 0;'+
      '        left: 0;'+
      '        display: inline-block;'+
      '        position: absolute;'+
      '    }'+
      '    .lr-provider-label {'+
      '        display: block;'+
      '    }'
      )

      +


      '    .lr-sl-icon:before {'+
      '        width: 8rem;'+
      '        height: 8rem;'+
      '        background: url("http://cdn.loginradius.com/hub/prod/v1/hosted-page-default-images/icon-sprite-32.png");'+
      '        background-image: linear-gradient(transparent, transparent), url("http://cdn.loginradius.com/hub/prod/v1/hosted-page-default-images/icon-sprite.svg"), none;'+
      '        background-size: 100% 3600%;'+
      '        background-position: 0 0;'+
      '        margin-top: -4px;'+
      '        margin-top: -0.4rem;'+
      '    }'+
      '    .lr-ls-status-area {'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '        width: 100vw;'+
      '        display: none;'+
      '        z-index: 2;'+
      '    }'+
      '    .lr-iconsuccess {'+
      '        font-family: arial;'+
      '        -ms-transform: scaleX(-1) rotate(-35deg); /* IE 9 */'+
      '        -webkit-transform: scaleX(-1) rotate(-35deg); /* Chrome, Safari, Opera */'+
      '        transform: scaleX(-1) rotate(-35deg);'+
      '        float: left;'+
      '        margin-right: 6px;'+
      '    }'+
      '    .lr-iconerror {'+
      '        text-align: center;'+
      '        font-family: sans-serif;'+
      '        float: left;'+
      '        margin-right: 6px;'+
      '    }'+
      '    .lr-ls-divsuccess {'+
      '        display: none;'+
      '        padding: 0.8rem;'+
      '        border: 1px solid #3EA34D;'+
      '        color: #FFFFFF;'+
      '        font-size: 4vw;'+
      '        line-height: 3rem;'+
      '        font-weight: 600;'+
      '        vertical-align: middle;'+
      '    }'+
      '    .lr-ls-diverror {'+
      '        display: none;'+
      '        padding: 0.8rem;'+
      '        border: 1px solid #FF1744;'+
      '        color: #FFFFFF;'+
      '        font-size: 4vw;'+
      '        line-height: 3rem;'+
      '        font-weight: 600;'+
      '        vertical-align: middle;'+
      '    }'+
      '     ::-webkit-input-placeholder {'+
      '        font-size: 4vw;'+
      '        line-height: 100%;'+
      '    }'+
      '    .loginradius--form-element-content {'+
      '        text-align: left;'+
      '        margin-bottom: 4rem;'+
      '        margin-bottom: 6.5vw;'+
      '    }'+
      '    #login-container .loginradius--form-element-content, #registration-container .loginradius--form-element-content, #forgotpassword-container .loginradius--form-element-content, #resetpassword-container .loginradius--form-element-content {'+
      '        padding-left: 3rem;'+
      '    }'+
      '    .loginradius--form-element-content label {'+
      '        color:' + ((options.body && options.body.textColor) ? options.body.textColor  : '#616161') + ';' +
      '        font-size: 5vw;'+
      '        line-height: 4rem;'+
      '    }'+
      '    #login-container,'+
      '    #registration-container,'+
      '    #forgotpassword-container {'+
      '        margin-top: 5rem;'+
      '        width: 91vw;'+
      '        z-index: 0;'+
      '    }'+
      '    #forgotpassword-container {'+
      '        margin-top: 16px;'+
      '    }'+
      '    input .invalid {'+
      '        border: 1px solid #FF1744;'+
      '        background-color: #F5F5F5;'+
      '    }'+
      '    select {'+
      '           margin-top: 4px;'+
      '           width: 91vw;'+ 
      '           height: 5rem;'+
      '           background-color:' + ((options.input && options.input.background) ? options.input.background : ' #F5F5F5') + ';' +
      '           font-size: 5vw;'+
      '           font-weight: 300;'+
      '           padding: 8px;'+
      '     }'+
      '    textarea,'+
      '    input[type="password"],'+
      '    input[type="text"] {'+
      '        margin-top: 4px;'+
      '        height: 5rem;'+
      '        width: 91vw;'+
      '        background-color:' + ((options.input && options.input.background) ? options.input.background : ' #F5F5F5') + ';' +
      '        border-style: hidden;'+
      '        font-size: 5vw;'+
      '        font-weight: 300;'+
      '        line-height: 100%;'+
      '        padding: 8px;'+
      '        -webkit-box-sizing: border-box;'+
      '        box-sizing: border-box;'+
      '    }'+
      '    input[type="submit"] {'+
      '        margin-top: 2.5rem;'+
      '        margin-top: 4.2vw;'+
      '        color: #FFFFFF;'+
      '        font-size: 5vw;'+
      '        text-align: center;'+
      '        letter-spacing: 0.2rem;'+
      '        cursor: pointer;'+
      '    }'+
      '    .content-loginradius-stayLogin {'+
      '        margin-top: 2rem;'+
      '        display: flex;'+
      '    }'+
      '    input[type="checkbox"] {'+
      '        height: 3rem;'+
      '        width: 3rem;'+
      '        border: 1px solid #9E9E9E;'+
      '        vertical-align: middle;'+
      '    }'+
      '    .content-loginradius-stayLogin label {'+
      '        height: 3rem;'+
      '        color:' + ((options.body && options.body.textColor) ? options.body.textColor  : '#616161') + ';' +
      '        font-size: 4.5vw;'+
      '        line-height: 3rem;'+
      '    }'+
      '    #lr-forgotpw-btn {'+
      '        color:' + ((options.body && options.body.textColor) ? options.body.textColor  : '#616161') + ';' +
      '        cursor: pointer;'+
      '        font-size: 4.5vw;'+
      '        line-height: 3rem;'+
      '        height: 3rem;'+
      '        right: 4.5vw;'+
      '        bottom: 26.5vw;'+
      '        float: right;'+
      '    }'+
      '    #loginradius-submit-login {'+
      '        margin-right: auto;'+
      '        height: 16vw;'+
      '        width: 91vw;'+
      '        background-color: #35a8ff;'+
      '        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);'+
      '        outline: none;'+
      '        border-radius: 1rem 1rem 1rem 1rem;' +
      '    }'+
      '    [id *= "loginradius-submit-"] {'+
      '        margin-left: 3rem;'+
      '        margin-right: auto;'+
      '        height: 16vw;'+
      '        width: 91vw;'+
      '        background-color: #35a8ff;'+
      '        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);'+
      '        outline: none;'+
      '        border-radius: 1rem 1rem 1rem 1rem;' +
      '    }'+
      '    [id *= "loginradius-submit-"]:hover,'+
      '    #loginradius-submit-reset-password:hover {'+
      '        filter: brightness(98%);'+
      '        transition: color 400ms;'+
      '    }'+
      '    [id *= "loginradius-submit-"]:active {'+
      '        filter: brightness(85%);'+
      '        transition: color 400ms;'+
      '    }'+
      '    #forgotPW {'+
      '        height: 17px;'+
      '        color: #424242;'+
      '        font-size: 4vw;'+
      '        line-height: 17px;'+
      '        text-align: center;'+
      '        text-decoration: none;'+
      '        position: absolute;'+
      '    }'+
      '    #reset-password {'+
      '        height: 5rem;'+
      '        color: #414141;'+
      '        font-size: 6vw;'+
      '        font-weight: 300;'+
      '        line-height: 37px;'+
      '    }'+
      '    .loginradius-validation-message {'+
      '        color: #FF1744;'+
      '        font-size: 3.28vw;'+
      '        line-height: 2rem;'+
      '        margin-top: 1rem;'+
      '    }'+
      '    #loginradius-showQRcode-ManualEntryCode {'+
      '        font-size: 4vw;'+
      '    }'+
      '    #loginradius-button-resendotp {'+
      '        font-size: 4vw;'+
      '    }'+
      '    #loginradius-button-changenumber {'+
      '        font-size: 4vw;'+
      '    }'+
      '    @-webkit-keyframes slide-up {'+
      '        0% {'+
      '            opacity: 0;'+
      '            -webkit-transform: translateY(-100%);'+
      '        }'+
      '        100% {'+
      '            opacity: 1;'+
      '            -webkit-transform: translateY(0);'+
      '        }'+
      '    }'+
      '    @-moz-keyframes slide-up {'+
      '        0% {'+
      '            opacity: 0;'+
      '            -moz-transform: translateY(-100%);'+
      '        }'+
      '        100% {'+
      '            opacity: 1;'+
      '            -moz-transform: translateY(0);'+
      '        }'+
      '    }'+
      '    .lr-ls-pageloader {'+
      '        display: none;'+
      '        z-index: 999;'+
      '        width: 100%;'+
      '        height: 100%;'+
      '        position: fixed;'+
      '        top: 0;'+
      '        right: 0;'+
      '        bottom: 0;'+
      '        left: 0;'+
      '        background-color: rgba(0, 0, 0, .5);'+
      '    }'+
      '    .lr-ls-page-loadwheel {'+
      '        width: 15vw;'+
      '        height: 15vw;'+
      '        margin-top: -7.5vw;'+
      '        margin-left: -7.5vw;'+
      '        position: absolute;'+
      '        top: 50%;'+
      '        left: 50%;'+
      '        border-width: 30px;'+
      '        border-radius: 50%;'+
      '        border: 10px solid #f3f3f3;'+
      '        border-radius: 50%;'+
      '        border-top: 10px solid #3498db;'+
      '        -webkit-animation: spin 2s linear infinite;'+
      '        /* Safari */'+
      '        animation: spin 2s linear infinite;'+
      '    }'+
      '    @-webkit-keyframes spin {'+
      '        0% {'+
      '            -webkit-transform: rotate(0deg);'+
      '        }'+
      '        100% {'+
      '            -webkit-transform: rotate(360deg);'+
      '        }'+
      '    }'+
      '    @keyframes spin {'+
      '        0% {'+
      '            transform: rotate(0deg);'+
      '        }'+
      '        100% {'+
      '            transform: rotate(360deg);'+
      '        }'+
      '    }'+
      '}'+
      ''+
      '@media only screen and (min-device-width: 960px) {'+
      '    .lr-ls-page {'+
      '        position: relative;'+
      '        width:' + ((options.singlepagestyle) ? "360px;" : "720px;")+
      '        border-radius: 6px 6px 0 0;'+
      '        background-color: #FFFFFF;'+
      '        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2), 0 1px 1px 0 rgba(0, 0, 0, 0.12);'+
      '        margin: 5% auto;'+
      '    }'+
      '    .lr-ls-logobase {'+
      ((options.singlepagestyle) ? 
      ('        height: 90px;')
      :
      ('        float: left;'))+
      '        width: 360px;'+
      ((options.singlepagestyle) ?
      ('        border-radius: 6px 6px 0 0;')
      :
      ('        border-radius: 6px 0 0 6px;'))+
      '        background-color:' + ((options.logo && options.logo.color) ? options.logo.color : " #F5F5F5") +';' +
      '    }'+
      '    #lr-ls-logo-place {'+
      '        display: block;'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '        width: 50%;'+
      '        padding-top: 23.67px;'+
      '    }'+
      '    .lr-ls-tabs {'+
      '        display: block;'+
      '        position: relative;'+
      '        background-color: #FFFFFF;'+
      '    }'+
      '    .lr-ls-tabs .tab {'+
      '        float: left;'+
      '        display: flex;'+
      '        flex-direction: row;'+
      ((options.body && options.body.backgroundColor) ? ('background-color:' + options.body.backgroundColor +';') : ('background-color: #FFFFFF;')) +
      '    }'+
      '    .lr-ls-tabs .tab>input[type="radio"] {'+
      '        position: absolute;'+
      '        top: -9999px;'+
      '        left: -9999px;'+
      '    }'+
      '    .lr-ls-tabs .tab>label {'+
      '        width: 180px;'+
      '        flex: 1 1 auto;'+
      '        display: block;'+
      '        cursor: pointer;'+
      '        position: relative;'+
      '        color: #384049;'+
      '        font-size: 15px;'+
      '        line-height: 38px;'+
      '        text-align: center;'+
      '        vertical-align: middle;'+
      '        border-bottom: 4px solid #EEEEEE;'+
      '    }'+
      '    .lr-ls-tabs .content {'+
      '        margin-top: 14px;'+
      '        /* this field  determines the height of the line below the label*/'+
      '        z-index: 0;'+
      '        /* or display: none; */'+
      '        overflow: hidden;'+
      '        width: 360px;'+
      '        position: absolute;'+
      '        top: 27px;'+
      ((options.singlepagestyle) ? 
      ('left: 0; border-radius: 0 0 8px 8px;')
      :
      ('left: 360px; border-radius: 0 0 8px 0;'))
      +
      '        background-color: #FFFFFF;'+
      '        display: none;'+
      '        -webkit-transition: all linear 0.3s;'+
      '        -moz-transition: all linear 0.3s;'+
      '        -o-transition: all linear 0.3s;'+
      '        -ms-transition: all linear 0.3s;'+
      '        transition: all linear 0.3s;'+
      '        -webkit-transform: translateX(-250px);'+
      '        -moz-transform: translateX(-250px);'+
      '        -o-transform: translateX(-250px);'+
      '        -ms-transform: translateX(-250px);'+
      '        transform: translateX(-10px);'+
      '    }'+
      '    .Resetpw-content {'+
      '        display: none;'+
      '    }'+
      '    .lr-ls-tabs>.tab>[id^="tab"]:checked+label {'+
      '        top: 0;'+
      '        border-bottom: 4px solid #BDBDBD;'+
      '        -webkit-animation: page 0.2s linear;'+
      '        -moz-animation: page 0.2s linear;'+
      '        -ms-animation: page 0.2s linear;'+
      '        -o-animation: page 0.2s linear;'+
      '        animation: page 0.2s linear;'+
      '    }'+
      '    .lr-ls-tabs>.tab>[id^="tab"]:checked~[id^="tab-content"] {'+
      ((options.body && options.body.backgroundColor) ? ('background-color:' + options.body.backgroundColor +';') : ('')) +
      '        z-index: 1;'+
      '        /* or display: block; */'+
      '        display: block;'+
      '        -webkit-transform: translateX(0px);'+
      '        -moz-transform: translateX(0px);'+
      '        -o-transform: translateX(0px);'+
      '        -ms-transform: translateX(0px);'+
      '        transform: translateX(0px);'+
      '        -webkit-transition: all ease-out 0.8s 0.1s;'+
      '        -moz-transition: all ease-out 0.8s 0.1s;'+
      '        -o-transition: all ease-out 0.8s 0.1s;'+
      '        -ms-transition: all ease-out 0.8s 0.1s;'+
      '        transition: all ease-out 0.8s 0.1s;'+
      '        overflow: hidden;'+
      '    }'+
      '    .greeting {'+
      '        margin-top: 24px;'+
      '        margin-bottom: 16px;'+
      (options.singlepagestyle ? ('        width: 328px;') : '')
      +
      '        font-size: 14px;'+
      '        line-height: 19px;'+
      '        color: #424242;'+
      '    }'+
      '    .lrForgotpw {'+
      '        padding-left: 16px;'+
      '    }'+
      '    #lr-ls-sectiondivider, #lr-ls-sectiondividerL {'+
      '        padding-top: 7px;'+
      '        margin-top: 16px;'+
      '        display: block;'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '        height: 39px;'+
      '        text-align: center;'+
      '        color: #424242;'+
      '        font-size: 18px;'+
      '        line-height: 19px;'+
      '    }'+
      (options.socialsquarestyle  ? 
      '    .social-login-b-options {'+
      '        margin-top: 6vh;'+
      '        width: 328px;'+
      '        text-align: center;'+
      '        font-size: 16px;'+
      '        font-weight: 200;'+
      '        -webkit-animation: slide-up 1s ease-out;'+
      '        -moz-animation: slide-up 1s ease-out;'+
      '    }'+
      '    .social-login-b-options .lr-sl-shaded-brick-button {'+
      '        height: 3.5rem;'+
      '        width: 3.5rem;'+
      '        border-radius: 4px;'+
      '        overflow: hidden;'+
      '        margin-top: 4px;'+
      '        position: relative;'+
      '        border: 1px solid rgba(0, 0, 0, 0.1);'+
      '        text-align: left;'+
      '        text-decoration: none;'+
      '        color: white;'+
      '        box-shadow: 0 0 1px 0 rgba(0, 0, 0, 0.12), 0 1px 1px 0 rgba(0, 0, 0, 0.24), 0 0 8px 0 rgba(0, 0, 0, 0.12), 0 2px 2px 0 rgba(0, 0, 0, 0.24);'+
      '    }'+
      '    .social-login-b-options .lr-sl-shaded-brick-button .lr-sl-icon {'+
      '        top: 0;'+
      '        left: 0;'+
      '        display: inline-block;'+
      '        position: absolute;'+
      '    }'+
      '    .lr-provider-label {'+
      '        margin-top: 8px;'+
      '        display: inline-block;'+
      '    }'
      :
      '    .social-login-b-options {'+
      '        margin-top: 6vh;'+
      '        width: 328px;'+
      '        text-align: center;'+
      '        font-size: 18px;'+
      '        font-weight: 200;'+
      '        -webkit-animation: slide-up 1s ease-out;'+
      '        -moz-animation: slide-up 1s ease-out;'+
      '    }'+
      '    .social-login-b-options .lr-sl-shaded-brick-button {'+
      '        line-height: normal;'+
      '        height: 3em;'+
      '        width: 100%;'+
      '        border-radius: 4px;'+
      '        overflow: hidden;'+
      '        margin-top: 4px;'+
      '        position: relative;'+
      '        border: 1px solid rgba(0, 0, 0, 0.1);'+
      '        text-align: left;'+
      '        text-decoration: none;'+
      '        color: white;'+
      '        padding: 0.8em 0 0 3em;'+
      '        box-shadow: 0 0 1px 0 rgba(0, 0, 0, 0.12), 0 1px 1px 0 rgba(0, 0, 0, 0.24), 0 0 8px 0 rgba(0, 0, 0, 0.12), 0 2px 2px 0 rgba(0, 0, 0, 0.24);'+
      '    }'+
      '    .social-login-b-options .lr-sl-shaded-brick-button .lr-sl-icon {'+
      '        top: 4px;'+
      '        left: 0;'+
      '        display: inline-block;'+
      '        position: absolute;'+
      '    }'+
      '    .lr-provider-label {'+
      '        margin-top: 8px;'+
      '        display: block;'+
      '    }') +
      '    .lr-sl-icon:before {'+
      '        width: 3.4rem;'+
      '        height: 3.2rem;'+
      '        background: url("http://cdn.loginradius.com/hub/prod/v1/hosted-page-default-images/icon-sprite-32.png");'+
      '        background-image: linear-gradient(transparent, transparent), url("http://cdn.loginradius.com/hub/prod/v1/hosted-page-default-images/icon-sprite.svg"), none;'+
      '        background-size: 100% 3600%;'+
      '        background-position: 0 0;'+
      (options.socialsquarestyle ? 
      ''
      :
      '        margin-top: -4px;'+
      '        margin-top: -0.4rem;')  +
      '    }'+
      '    .lr-ls-status-area {'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '        height: 34px;'+
      ((options.singlepagestyle)? 
      ('        width: 100%;')
      :
      ('        width: 360px;'))+
      '        display: none;'+
      '        z-index: 2;'+
      '    }'+
      '    .lr-iconsuccess {'+
      '        font-family: arial;'+
      '        -ms-transform: scaleX(-1) rotate(-35deg); /* IE 9 */'+
      '        -webkit-transform: scaleX(-1) rotate(-35deg); /* Chrome, Safari, Opera */'+
      '        transform: scaleX(-1) rotate(-35deg);'+
      '        float: left;'+
      '        margin-right: 5px;'+
      '    }'+
      '    .lr-iconerror {'+
      '        text-align: center;'+
      '        font-family: sans-serif;'+
      '        float: left;'+
      '        margin-right: 3px;'+
      '    }'+
      '    .lr-ls-divsuccess {'+
      '        display: none;'+
      '        padding: 5px;'+
      '        height: 34px;'+
      '        border: 1px solid #3EA34D;'+
      '        color: #FFFFFF;'+
      '        font-size: 12px;'+
      '        line-height: 16px;'+
      '        font-weight: 600;'+
      '        vertical-align: middle;'+
      '    }'+
      '    .lr-ls-diverror {'+
      '        display: none;'+
      '        padding: 5px;'+
      '        height: 34px;'+
      '        border: 1px solid #FF1744;'+
      '        color: #FFFFFF;'+
      '        font-size: 12px;'+
      '        line-height: 16px;'+
      '        font-weight: 600;'+
      '        vertical-align: middle;'+
      '    }'+
      '     ::-webkit-input-placeholder {'+
      '        font-size: 12px;'+
      '        line-height: 100%;'+
      '    }'+
      '    .loginradius--form-element-content {'+
      '        text-align: left;'+
      '        margin-bottom: 1.3rem;'+
      '        margin-bottom: 2.67vh;'+
      '    }'+
      '    #login-container .loginradius--form-element-content, #registration-container .loginradius--form-element-content, #forgotpassword-container .loginradius--form-element-content, #resetpassword-container .loginradius--form-element-content {'+
      '        //padding-left: 16px;'+
      '    }'+
      ((options.singlepagestyle)? "" : 
      (
            '#resetpassword-container .loginradius--form-element-content {'+
                  'padding-left: 376px;'+
            '}'
            ))+
      '    .loginradius--form-element-content label {'+
      '        color:' + ((options.body && options.body.textColor) ? options.body.textColor  : '#616161') + ';' +
      '        font-size: 14px;'+
      '        line-height: 14px;'+
      '    }'+
      '    #login-container,'+
      '    #registration-container,'+
      '    #forgotpassword-container {'+
      '        width: 329px;'+
      '        z-index: 0;'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '    }'+
      '    #forgotpassword-container {'+
      '        margin-top: 16px;'+
      '    }'+
      '    #resetpassword-container #loginradius-submit-reset-password {'+
      '        width:45% !important;'+
      '    }'+
      '    input .invalid {'+
      '        border: 1px solid #FF1744;'+
      '        background-color: #F5F5F5;'+
      '    }'+
      '    select {'+
      '           margin-top: 4px !important;'+
      '           height: 32px;'+
      '           background-color:' + ((options.input && options.input.background) ? options.input.background : ' #F5F5F5') + ';' +
      '           font-size: 15px;'+
      '           font-weight: 300;'+
      '           line-height: 16px;'+
      '           box-sizing: border-box;'+
      '           width: 326px;'+
      '     }'+
      '    textarea,'+
      '    input[type="password"],'+
      '    input[type="text"] {'+
      '        margin-top: 4px;'+
      '        height: 32px;'+
      '        width: 326px;'+
      '        background-color:' + ((options.input && options.input.background) ? options.input.background : ' #F5F5F5') + ';' +
      '        border-style: hidden;'+
      '        font-size: 16px;'+
      '        font-weight: 300;'+
      '        line-height: 16px;'+
      '        padding: 8px;'+
      '        -webkit-box-sizing: border-box;'+
      '        box-sizing: border-box;'+
      '    }'+
      '    text {'+
      '        height: 16px;'+
      '        width: 151px;'+
      '        color: #424242;'+
      '        font-size: 14px;'+
      '        line-height: 16px;'+
      '    }'+
      '    input[type="submit"] {'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '        margin-top: 2.1vh;'+
      '        color: #FFFFFF;'+
      '        font-size: 14px;'+
      '        line-height: 16px;'+
      '        text-align: center;'+
      '        letter-spacing: 2px;'+
      '        cursor: pointer;'+
      '    }'+
      '    .content-loginradius-stayLogin {'+
      '        margin-top: 8px;'+
      '        display: flex;'+
      '    }'+
      '    input[type="checkbox"] {'+
      '        height: 18px;'+
      '        width: 18px;'+
      '        border: 1px solid #9E9E9E;'+
      '        vertical-align: middle;'+
      '    }'+
      '    .content-loginradius-stayLogin label {'+
      '        height: 18px;'+
      '        width: 84px;'+
      '        color:' + ((options.body && options.body.textColor) ? options.body.textColor  : '#616161') + ';' +
      '        font-size: 12px;'+
      '        line-height: 17px;'+
      '    }'+
      '    #lr-forgotpw-btn {'+
      '        right: 16px;'+
      '        bottom: 12.77vh;'+
      '        font-size: 12px;'+
      '        line-height: 17px;'+
      '        height: 18px;'+
      '        color:' + ((options.body && options.body.textColor) ? options.body.textColor  : '#616161') + ';' +
      '        cursor: pointer;'+
      '        float: right;'+
      '    }'+
      '    [id *="loginradius-submit-"] {'+
      '        margin-bottom:10px;'+
      '        height: 75px;'+
      '        margin-left: 16px;'+
      '        /*or height:60px; */'+
      '        width: 100% !important;'+
      '        border-radius: 0 0 6px 6px;'+
      '        background-color:' + ((options.submitButton && options.submitButton.color) ? options.submitButton.color  : '#35a8ff') + ';' +
      '        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .16), 0 2px 10px 0 rgba(0, 0, 0, .12);'+
      '        outline: none;'+
      '    }'+
      '    #loginradius-submit-login {'+
      ((options.singlepagestyle) ? 
      ('        border-radius: 6px;')
      :
      ('        border-radius: 6px 6px 6px 0;')) +
      '    }'+
      '    [id *="loginradius-submit-"]:hover {'+
      '        filter: brightness(98%);'+
      '        transition: color 400ms;'+
      '    }'+
      '    [id *="loginradius-submit-"]:active {'+
      '        filter: brightness(85%);'+
      '        transition: color 400ms;'+
      '    }'+
      '    #forgotPW {'+
      '        height: 17px;'+
      '        color: #424242;'+
      '        font-size: 12px;'+
      '        line-height: 17px;'+
      '        text-align: center;'+
      '        text-decoration: none;'+
      '        position: absolute;'+
      '    }'+
      '    #reset-password {'+
      '        height: 36px;'+
      '        color: #414141;'+
      '        font-size: 32px;'+
      '        font-weight: 300;'+
      '        line-height: 37px;'+
      '    }'+
      '    .Resetpw.greeting {'+
      '        margin-bottom: 1.5rem;'+
      '    }'+
      '    #signUpopt {'+
      '        margin-top: 10px;'+
      '        display: block;'+
      '        height: 17px;'+
      '        width: 240px;'+
      '        color: #FFFFFF;'+
      '        font-size: 12px;'+
      '        line-height: 17px;'+
      '        text-align: center;'+
      '        text-decoration: none;'+
      '        margin-left: auto;'+
      '        margin-right: auto;'+
      '    }'+
      '    .loginradius-validation-message {'+
      '        margin-top: 0.3rem;'+
      '        color: #FF1744;'+
      '        font-size: 10px;'+
      '        line-height: 14px;'+
      '    }'+
      '    @-webkit-keyframes slide-up {'+
      '        0% {'+
      '            opacity: 0;'+
      '            -webkit-transform: translateY(-100%);'+
      '        }'+
      '        100% {'+
      '            opacity: 1;'+
      '            -webkit-transform: translateY(0);'+
      '        }'+
      '    }'+
      '    @-moz-keyframes slide-up {'+
      '        0% {'+
      '            opacity: 0;'+
      '            -moz-transform: translateY(-100%);'+
      '        }'+
      '        100% {'+
      '            opacity: 1;'+
      '            -moz-transform: translateY(0);'+
      '        }'+
      '    }'+
      '    .lr-ls-pageloader {'+
      '        display: none;'+
      '        z-index: 999;'+
      '        width: 100%;'+
      '        height: 100%;'+
      '        position: fixed;'+
      '        top: 0;'+
      '        right: 0;'+
      '        bottom: 0;'+
      '        left: 0;'+
      '        background-color: rgba(0, 0, 0, .5);'+
      '    }'+
      '    .lr-ls-page-loadwheel {'+
      '        width: 120px;'+
      '        height: 120px;'+
      '        margin-top: -60px;'+
      '        margin-left: -60px;'+
      '        position: absolute;'+
      '        top: 50%;'+
      '        left: 50%;'+
      '        border-width: 30px;'+
      '        border-radius: 50%;'+
      '        border: 10px solid #f3f3f3;'+
      '        border-radius: 50%;'+
      '        border-top: 10px solid #3498db;'+
      '        -webkit-animation: spin 2s linear infinite;'+
      '        /* Safari */'+
      '        animation: spin 2s linear infinite;'+
      '    }'+
      '    @-webkit-keyframes spin {'+
      '        0% {'+
      '            -webkit-transform: rotate(0deg);'+
      '        }'+
      '        100% {'+
      '            -webkit-transform: rotate(360deg);'+
      '        }'+
      '    }'+
      '    @keyframes spin {'+
      '        0% {'+
      '            transform: rotate(0deg);'+
      '        }'+
      '        100% {'+
      '            transform: rotate(360deg);'+
      '        }'+
      '    }'+
      '}'+
      '#loginradius-linksignin-email-me-a-link-to-sign-in, #lr-forgot-label{'+
      '     display: none;'+
      '}'+
      '#loginradius-button-resendotp {'+
      '     margin-right: 20px;'+
      '     margin-left: 20px;'+
      '}'+
      '#loginradius-showQRcode-qrcode {'+
      '     width: 100%;'+
      '     margin: auto;'+
      '     display: block;'+
      '}'+
      ''+
      '.content-loginradius-qrcode {'+
      '    text-align: center;'+
      '}'+
      '.lrLogin {'+
      '    margin-right: auto;'+
      '    margin-left: auto;'+
      '}'+
      ''+
      '.lrSignup {'+
      '    margin-right: auto;'+
      '    margin-left: auto;'+
      '    padding-bottom: 20px;'+
      '}'+
      ''+
      '.lrForgotpw {'+
      '    margin-right: auto;'+
      '    margin-left: auto;'+
      '}'+
      ''+
      '.lrResetpw {'+
      '    margin-right: auto;'+
      '    margin-left: auto;'+
      '}'+
      ''+
      '#lr-ls-sectiondivider:after, #lr-ls-sectiondividerL:after {'+
      '    content: '+((options.content && options.content.socialandloginDivider) ? ('"'+options.content.socialandloginDivider+'"') : '"OR"') + ';'+
      '}'+
      ''+
      ''+
      '/*'+
      '* Social Icon Style'+
      '*'+
      '**/'+
      ''+
      '.lr-sl-icon {'+
      '    display: inline-block;'+
      '    text-align: center;'+
      '}'+
      ''+
      '.lr-sl-icon:before,'+
      '.lr-sl-icon:after {'+
      '    content: "";'+
      '    display: inline-block;'+
      '    vertical-align: middle;'+
      '}'+
      ''+
      '.lr-sl-icon:after {'+
      '    height: 100%;'+
      '    width: 0;'+
      '}'+
      ''+
      '.lr-sl-icon-pinterest:before {'+
      '    background-position: 0 -0.2%;'+
      '}'+
      ''+
      '.lr-flat-line {'+
      '    background-color: #27c327;'+
      '}'+
      ''+
      '.lr-flat-pinterest {'+
      '    background-color: #cb2128;'+
      '}'+
      ''+
      '.lr-sl-icon:before {'+
      '    background-position: 0px -0.4%;'+
      '}'+
      ''+
      '.lr-sl-icon-facebook:before {'+
      '    background-position: 0 0;'+
      '}'+
      ''+
      '.lr-sl-icon-facebook:before {'+
      '    background-position: 0px 2.1%;'+
      '}'+
      ''+
      '.lr-sl-icon-googleplus:before {'+
      '    background-position: 0px 5%;'+
      '}'+
      ''+
      '.lr-sl-icon-linkedin:before {'+
      '    background-position: 0px 6.8%;'+
      '}'+
      ''+
      '.lr-sl-icon-twitter:before {'+
      '    background-position: 0px 9.2%;'+
      '}'+
      ''+
      '.lr-sl-icon-yahoo:before {'+
      '    background-position: 0px 11.6%;'+
      '}'+
      ''+
      '.lr-sl-icon-amazon:before {'+
      '    background-position: 0px 13.9%;'+
      '}'+
      ''+
      '.lr-sl-icon-aol:before {'+
      '    background-position: 0px 16.4%;'+
      '}'+
      ''+
      '.lr-sl-icon-disqus:before {'+
      '    background-position: 0px 18.85%;'+
      '}'+
      ''+
      '.lr-sl-icon-foursquare:before {'+
      '    background-position: 0px 21.3%;'+
      '}'+
      ''+
      '.lr-sl-icon-github:before {'+
      '    background-position: 0px 23.55%;'+
      '}'+
      ''+
      '.lr-sl-icon-hyves:before {'+
      '    background-position: 0px 26.1%;'+
      '}'+
      ''+
      '.lr-sl-icon-instagram:before {'+
      '    background-position: 0px 28.45%;'+
      '}'+
      ''+
      '.lr-sl-icon-kaixin:before {'+
      '    background-position: 0px 30.8%;'+
      '}'+
      ''+
      '.lr-sl-icon-live:before {'+
      '    background-position: 0px 33.3%;'+
      '}'+
      ''+
      '.lr-sl-icon-livejournal:before {'+
      '    background-position: 0px 35.55%;'+
      '}'+
      ''+
      '.lr-sl-icon-mixi:before {'+
      '    background-position: 0px 38.1%;'+
      '}'+
      ''+
      '.lr-sl-icon-odnoklassniki:before {'+
      '    background-position: 0px 40.3%;'+
      '}'+
      ''+
      '.lr-sl-icon-orange:before {'+
      '    background-position: 0px 44%;'+
      '}'+
      ''+
      '.lr-sl-icon-openid:before {'+
      '    background-position: 0px 45.3%;'+
      '}'+
      ''+
      '.lr-sl-icon-paypal:before {'+
      '    background-position: 0px 47.5%;'+
      '}'+
      ''+
      '.lr-sl-icon-persona:before {'+
      '    background-position: 0px 51.2%;'+
      '}'+
      ''+
      '.lr-sl-icon-pinterest:before {'+
      '    background-position: 0px 52.2%;'+
      '}'+
      ''+
      '.lr-sl-icon-qq:before {'+
      '    background-position: 0px 54.75%;'+
      '}'+
      ''+
      '.lr-sl-icon-renren:before {'+
      '    background-position: 0px 57.15%;'+
      '}'+
      ''+
      '.lr-sl-icon-salesforce:before {'+
      '    background-position: 0px 59.6%;'+
      '}'+
      ''+
      '.lr-sl-icon-sinaweibo:before {'+
      '    background-position: 0px 61.8%;'+
      '}'+
      ''+
      '.lr-sl-icon-stackexchange:before {'+
      '    background-position: 0px 64.3%;'+
      '}'+
      ''+
      '.lr-sl-icon-steamcommunity:before {'+
      '    background-position: 0px 66.755%;'+
      '}'+
      ''+
      '.lr-sl-icon-verisign:before {'+
      '    background-position: 0px 69.2%;'+
      '}'+
      ''+
      '.lr-sl-icon-virgilio:before {'+
      '    background-position: 0px 71.6%;'+
      '}'+
      ''+
      '.lr-sl-icon-vkontakte:before {'+
      '    background-position: 0px 73.9%;'+
      '}'+
      ''+
      '.lr-sl-icon-wordpress:before {'+
      '    background-position: 0px 76.1%;'+
      '}'+
      ''+
      '.lr-sl-icon-mailru:before {'+
      '    background-position: 0px 78.66%;'+
      '}'+
      ''+
      '.lr-sl-icon-xing:before {'+
      '    background-position: 0px 81.2%;'+
      '}'+
      ''+
      '.lr-sl-icon-delicious:before {'+
      '    background-position: 0px 85.5%;'+
      '}'+
      ''+
      '.lr-sl-icon-digg:before {'+
      '    background-position: 0px 88%;'+
      '}'+
      ''+
      '.lr-sl-icon-email:before {'+
      '    background-position: 0px 92.5%;'+
      '}'+
      ''+
      '.lr-sl-icon-google-bookmark:before {'+
      '    background-position: 0px 92.8%;'+
      '}'+
      ''+
      '.lr-sl-icon-print:before {'+
      '    background-position: 0px 95.1%;'+
      '}'+
      ''+
      '.lr-sl-icon-reddit:before {'+
      '    background-position: 0px 97.7%;'+
      '}'+
      ''+
      '.lr-sl-icon-tumblr:before {'+
      '    background-position: 0px 97.2%;'+
      '}'+
      ''+
      '.lr-sl-icon-myspace:before {'+
      '    background-position: 0px 90.3%;'+
      '}'+
      ''+
      '.lr-sl-icon-google:before {'+
      '    background-position: 0px 4.4%;'+
      '}'+
      ''+
      '.lr-sl-icon-line:before {'+
      '    background-position: 0px 100.1%;'+
      '}'+
      ''+
      '.lr-flat-amazon {'+
      '    background-color: #f90;'+
      '}'+
      ''+
      '.lr-flat-aol {'+
      '    background-color: #066cb1;'+
      '}'+
      ''+
      '.lr-flat-disqus {'+
      '    background-color: #35a8ff;'+
      '}'+
      ''+
      '.lr-flat-facebook {'+
      '    background-color: #3b5998;'+
      '}'+
      ''+
      '.lr-flat-foursquare {'+
      '    background-color: #1cafec;'+
      '}'+
      ''+
      '.lr-flat-github {'+
      '    background-color: #181616;'+
      '}'+
      ''+
      '.lr-flat-google {'+
      '    background-color: #dd4b39;'+
      '}'+
      ''+
      '.lr-flat-googleplus {'+
      '    background-color: #dd4b39;'+
      '}'+
      ''+
      '.lr-flat-hyves {'+
      '    background-color: #f9a539;'+
      '}'+
      ''+
      '.lr-flat-instagram {'+
      '    background-color: #406e94;'+
      '}'+
      ''+
      '.lr-flat-kaixin {'+
      '    background-color: #bb0e0f;'+
      '}'+
      ''+
      '.lr-flat-linkedin {'+
      '    background-color: #007bb6;'+
      '}'+
      ''+
      '.lr-flat-live {'+
      '    background-color: #004c9a;'+
      '}'+
      ''+
      '.lr-flat-livejournal {'+
      '    background-color: #3770a3;'+
      '}'+
      ''+
      '.lr-flat-mixi {'+
      '    background-color: #d1ad5a;'+
      '}'+
      ''+
      '.lr-flat-myspace {'+
      '    background-color: #313131;'+
      '}'+
      ''+
      '.lr-flat-odnoklassniki {'+
      '    background-color: #f69324;'+
      '}'+
      ''+
      '.lr-flat-openid {'+
      '    background-color: #f7921c;'+
      '}'+
      ''+
      '.lr-flat-orange {'+
      '    background-color: #f60;'+
      '}'+
      ''+
      '.lr-flat-paypal {'+
      '    background-color: #13487b;'+
      '}'+
      ''+
      '.lr-flat-persona {'+
      '    background-color: #e0742f;'+
      '}'+
      ''+
      '.lr-flat-qq {'+
      '    background-color: #29d;'+
      '}'+
      ''+
      '.lr-flat-renren {'+
      '    background-color: #005baa;'+
      '}'+
      ''+
      '.lr-flat-salesforce {'+
      '    background-color: #9cd3f2;'+
      '}'+
      ''+
      '.lr-flat-stackexchange {'+
      '    background-color: #4ba1d8;'+
      '}'+
      ''+
      '.lr-flat-steamcommunity {'+
      '    background-color: #666;'+
      '}'+
      ''+
      '.lr-flat-tumblr {'+
      '    background-color: #32506d;'+
      '}'+
      ''+
      '.lr-flat-twitter {'+
      '    background-color: #55acee;'+
      '}'+
      ''+
      '.lr-flat-verisign {'+
      '    background-color: #0261a2;'+
      '}'+
      ''+
      '.lr-flat-virgilio {'+
      '    background-color: #eb6b21;'+
      '}'+
      ''+
      '.lr-flat-vkontakte {'+
      '    background-color: #45668e;'+
      '}'+
      ''+
      '.lr-flat-sinaweibo {'+
      '    background-color: #bb3e3e;'+
      '}'+
      ''+
      '.lr-flat-wordpress {'+
      '    background-color: #21759c;'+
      '}'+
      ''+
      '.lr-flat-yahoo {'+
      '    background-color: #400090;'+
      '}'+
      ''+
      '.lr-flat-xing {'+
      '    background-color: #007072;'+
      '}'+
      ''+
      '.lr-flat-mailru {'+
      '    background-color: #1897e6;'+
      '}'+
      ''+
      ''+
      '/* not shown google recaptcha'+
      '.grecaptcha-badge {'+
      '        display: none;'+
      '    }'+
      '*/</style>'+
      '<div class="lr-ls-page">' +
      '         <div class="lr-ls-logobase">' +
      '            <img id="lr-ls-logo-place" src=' + ((options.logo && options.logo.url) ? options.logo.url : "https://docs.loginradius.com/theme/apidocs//support-assets/images/logo.svg") +'>' +
      '         </div>' +
      '         <div class = "lr-ls-status-area" id="lr-ls-status-area">' +
      '            <div class= "lr-ls-divsuccess" id= "lr-ls-divsuccess">' +
      '               <div class="lr-iconsuccess">L</div>' +
      '               <div class="lr-ls-divisionsuccess" id="lr-ls-divisionsuccess">Success!</div>' +
      '            </div>' +
      '            <div class="lr-ls-diverror" id="lr-ls-diverror">' +
      '               <div class="lr-iconerror">X</div>' +
      '               <div class = "lr-ls-divisionerror" id = "lr-ls-divisionerror"></div>' +
      '            </div>' +
      '         </div>' +
      '         <div class="lr-ls-pageloader" id= "loader">' +
      '            <div class="lr-ls-page-loadwheel"></div>' +
      '         </div>' +
      '         <ul class="lr-ls-tabs">' +
      '            <li class="tab">' +
      '               <input  id="tab1" type="radio" name="lr-ls-tabs" checked="checked">' +
      '               <label class="tab-label" for= "tab1"' + ((options.pagesshown && !options.login)? ('style="display: none"') : '')+ '>'+ ((options.content && options.content.tabLabels) ? options.content.tabLabels[0] : "Log in")+'</label>' +
      '               <div class="lrLogin content" id = "tab-content1"' + ((options.pagesshown && !options.login)? ('style="display: none"') : '')+ '>' +
      '                  <div class="lrLogin social-login-b-options">' +
      '                     <div id="interfacecontainerdivL" class="interfacecontainerdiv"></div>' +
      '                  </div>' +
      '                  <p id="lr-ls-sectiondividerL"></p>' +
      '                  <div id="login-container"></div>' +
      '                  <div id = "lr-forgotpw-btn" onclick="{document.getElementById(\'tab3\').checked = \'checked\';}"' + ((options.pagesshown && !options.forgotpassword)? ('style="display: none"') : '')+ '>'+ 
      ((options.content && options.content.tabLabels) ? options.content.tabLabels[2] : "Forgot Password?")+
      '                 </div>' +
      '               </div>' +
      '            </li>' +
      '            <li class= "tab" id = "signuptab">' +
      '               <input id="tab2" type="radio" name="lr-ls-tabs"' + ((options.pagesshown && !options.login && options.signup)? ('checked = "checked"') : '')+ '>' +
      '               <label class="tab-label" for= "tab2"' + ((options.pagesshown && !options.signup)? ('style="display: none"') : '')+ '>'+ ((options.content && options.content.tabLabels) ? options.content.tabLabels[1] : "Sign Up")+'</label>' +
      '               <div class="lrSignup content" id = "tab-content2"' + ((options.pagesshown && !options.signup)? ('style="display: none"') : '')+ '>' +
      '                  <div class="lrSignup social-login-b-options">' +
      '                     <div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>' +
      '                     <div id="sociallogin-container"></div>' +
      '                  </div>' +
      '                  <p id="lr-ls-sectiondivider"></p>' +
      '                  <div id="registration-container"></div>' +
      '               </div>' +
      '            </li>' +
      '            <li class= "tab">' +
      '               <input id="tab3" type="radio" name="lr-ls-tabs" ' + ((options.pagesshown && !options.login && !options.signup && options.forgotpassword)? ('checked = "checked"') : '')+ '>' +
      '               <label for= "tab3" id="lr-forgot-label">'+ ((options.content && options.content.tabLabels) ? options.content.tabLabels[2] : "Forgot Password?")+'</label>' +
      '               <div class="lrForgotpw content" id = "tab-content3"' + ((options.pagesshown && !options.forgotpassword)? ('style="display: none"') : '')+ '>' +
      '                  <div class="lrForgotpw greeting">' +
      '                     <p id="emailedtoreset">'+
((options.content && options.content.forgotPWgreet) ? (options.content.forgotPWgreet) : "We\'ll email you an instruction on resetting your password.") + '</p>' +
      '                  </div>' +
      '                  <div id="forgotpassword-container"></div>' +
      '               </div>' +
      '            </li>' +
      '         </ul>' +
      '         <div class="Resetpw-content" id = "Resetpw-content1">' +
      '            <div class="lrResetpw greeting">' +
      '               <p id="reset-password">'+ ((options.content && options.content.resetpage)? options.content.resetpage : 'Reset Password') + '</p>' +
      '            </div>' +
      '            <div id="resetpassword-container"></div>' +
      '         </div>' +
      '      </div>' + 
      '   <script type="text/html" id="loginradiuscustom_tmpl1">'+
      '      <a class="lr-provider-label lr-sl-shaded-brick-button lr-flat-<#=Name.toLowerCase()#>" href="javascript:void(0)" onclick="return <#=ObjectName#>.util.openWindow(\'<#= Endpoint #>\');" title="Sign up with <#= Name #>" alt="Sign in with <#=Name#>"><span class="lr-sl-icon lr-sl-icon-<#= Name.toLowerCase()#>"></span>'+
            ((options.content && options.content.socialblockLabel) ? (options.content.socialblockLabel): "Log in with")+' <#=Name#>'+
      '      </a>'+
      '   </script>'+
      '   <script type="text/html" id="loginradiuscustom_tmpl2">'+
      '      <a class="lr-provider-label lr-sl-shaded-brick-button lr-flat-<#=Name.toLowerCase()#>" href="javascript:void(0)" onclick="return <#=ObjectName#>.util.openWindow(\'<#= Endpoint #>\');" title="Sign up with <#= Name #>" alt="Sign in with <#=Name#>"><span class="lr-sl-icon lr-sl-icon-<#= Name.toLowerCase()#>"></span>'+
      '      </a>'+
      '   </script>';
}
  //
  function renderJS(cb, options, lrCallingObj) {
      function lrlserroraction(errors) {
            window.scrollTo(0, 0);
            document.getElementById("lr-ls-divsuccess").style.display = "none";
            document.getElementById("lr-ls-divisionerror").innerHTML = !errors[0]["Description"] ?
                  errors[0]["description"] : errors[0]["Description"];
            document.getElementById("lr-ls-diverror").style.display = "table-cell";
            document.getElementById("lr-ls-status-area").style.backgroundColor = "#FF1744";
            document.getElementById("lr-ls-status-area").style.display = "table";
            document.getElementById("lr-ls-status-area").style.position = "absolute";
            if(options.singlepagestyle == true){
                  document.getElementById("lr-ls-status-area").style.top = "137px";
            }
            setTimeout(function() {
                  document.getElementById("lr-ls-status-area").style.display = "none";
            }, 8000);
      }

      function lrlssuccessaction(response) {
            window.scrollTo(0, 0);
            document.getElementById("lr-ls-diverror").style.display = "none";
            document.getElementById("lr-ls-divsuccess").style.display = "table-cell";
            document.getElementById("lr-ls-status-area").style.backgroundColor = "#3EA34D";
            document.getElementById("lr-ls-status-area").style.display = "table";
            document.getElementById("lr-ls-status-area").style.position = "absolute";
            if(options.singlepagestyle == true){
                  document.getElementById("lr-ls-status-area").style.top = "137px";
            }
            setTimeout(function() {
                  document.getElementById("lr-ls-status-area").style.display = "none";
            }, 8000);
      }

      function redirect(response) {
            var lrform = document.createElement("form");
            var _token = document.createElement("input");
            lrform.method = "POST";
            lrform.action = ((options.redirecturl && options.redirecturl.afterlogin) ? options.redirecturl.afterlogin :
                  window.location.origin);
            _token.type = "hidden";
            _token.name = "token";
            _token.value = response["access_token"];
            lrform.appendChild(_token);
            document.body.appendChild(lrform);
            lrform.submit();
      }
      var custom_interface_option = {};
      custom_interface_option.templateName = (options.socialsquarestyle ? 'loginradiuscustom_tmpl2' :
            'loginradiuscustom_tmpl1');
      var sl_options = {};
      sl_options.onSuccess = function(response) {
            localStorage.removeItem("LrEmailStatus");
            if(response.access_token){
                  redirect(response);
            }
            cb(response, "socialLogin");
      };
      sl_options.onError = function(errors) {
            localStorage.setItem("LrEmailStatus", 'unverified');
            lrlserroraction(errors);
            cb(errors, "socialLogin");
      };
      sl_options.container = "sociallogin-container";
      var login_options = {};
      login_options.onSuccess = function(response) {
            localStorage.removeItem("LrEmailStatus");
            document.getElementById("lr-ls-status-area").style.display = "none";
            cb(response, "login");
            //safely redirect
            if(response.access_token){
                  redirect(response);
            }
      };
      login_options.onError = function(errors) {
            lrlserroraction(errors);
            cb(errors, "login");
      };
      login_options.container = "login-container";
      var registration_options = {}
      registration_options.onSuccess = function(response) {
            localStorage.removeItem("LrEmailStatus"); 
            lrlssuccessaction(response);
            document.getElementById("lr-ls-divisionsuccess").innerHTML = ((options.content && options.content.signupandForgotPwrequest) ? options.content.signupandForgotPwrequest : "Please check your email!");
            if(response.Data){
                  if(response.Data.AccountSid && response.Data.Sid) {
                        document.getElementById("lr-ls-divisionsuccess").innerHTML = ((options.content && options.content.signupandForgotPwrequestPhone) ? options.content.signupandForgotPwrequestPhone : "Please check your phone!");
                  }
            }
            if(document.getElementsByName("loginradius-registration")[0]) {
                  document.getElementsByName("loginradius-registration")[0].reset();
            }
            cb(response, "registration");
            if(response.access_token){
                  document.getElementById("lr-ls-divisionsuccess").innerHTML = ((options.content && options.content.emailVerifiedMessage) ? options.content.emailVerifiedMessage : "You have successfully registered, you now may log in with this email");
                  redirect(response);
            }
      };
      registration_options.onError = function(errors) {
            lrlserroraction(errors);
            cb(errors, "registration");
      };
      registration_options.container = "registration-container";
      var forgotpassword_options = {};
      forgotpassword_options.container = "forgotpassword-container";
      var forgotPassOTPBool = false;
      forgotpassword_options.onSuccess = function(response) {
            lrlssuccessaction(response);
            document.getElementById("lr-ls-divisionsuccess").innerHTML = ((options.content && options.content.signupandForgotPwrequest) ? options.content.signupandForgotPwrequest : "Please check your email!"); 
            if(response.Data){
                  if(response.Data.AccountSid && response.Data.Sid) {
                        document.getElementById("lr-ls-divisionsuccess").innerHTML = ((options.content && options.content.signupandForgotPwrequestPhone) ? options.content.signupandForgotPwrequestPhone : "Please check your phone!");
                  }
            }
            if(document.getElementsByName("loginradius-forgotpassword")[0]){
                  document.getElementsByName("loginradius-forgotpassword")[0].reset();
            }
            cb(response, "forgotPassword");
            if(forgotPassOTPBool == true){
                  setTimeout(function() {
                        window.location.href = ((options.redirecturl && options.redirecturl.afterreset) ? options.redirecturl.afterreset :
                              window.location.origin);
                  }, 100);
            }
            forgotPassOTPBool = true;
      };
      forgotpassword_options.onError = function(errors) {
            lrlserroraction(errors);
            cb(errors, "forgotPassword");
      }
      var resetpassword_options = {};
      resetpassword_options.container = "resetpassword-container";
      resetpassword_options.onSuccess = function(response) {
            lrlssuccessaction(response);
            if(response.Data == null){
                  setTimeout(function() {
                        window.location.href = ((options.redirecturl && options.redirecturl.afterreset) ? options.redirecturl.afterreset :
                              window.location.origin);
                  }, 2000);
            }
            cb(response, "resetPassword");
      };
      resetpassword_options.onError = function(errors) {
            lrlserroraction(errors);
            cb(errors, "resetPassword");
      };
      if(!(options.singlepagestyle) && screen.width>960 ){
            HideOTPandadjustHeight();
      }
      HideOTP();
      function HideOTP(){
            lrCallingObj.$hooks.register('afterFormRender', function() {
                  if (document.getElementsByClassName("loginradius-otpsignin")[0])
                        {
                        document.getElementsByClassName("loginradius-otpsignin")[0].style.display = "none";
                        document.getElementById("loginradius-otpsignin-send-an-otp-to-sign-in").style.display = "none";
                  }
                  if(document.getElementById('lr-forgotpw-btn')){
                        var passwordNode = document.getElementsByClassName('content-loginradius-password')[0];
                        passwordNode.parentNode.insertBefore(document.getElementById('lr-forgotpw-btn'), passwordNode.nextSibling);   
                  }
            })
            if(options.singlepagestyle) {
                  document.getElementsByClassName("content")[0].style.paddingBottom = "20px";
            }
      }

      function HideOTPandadjustHeight(){
            lrCallingObj.$hooks.register('afterFormRender', function() {                 
                  var RightcontentHeight = document.getElementsByClassName("content")[0].offsetHeight;
                  var rightTabLabel = document.getElementsByClassName("tab-label")[0];
                  var rightTabLabelStyle = window.getComputedStyle(rightTabLabel) || rightTabLabel.currentStyle;
                  var tabHeight = parseInt(rightTabLabelStyle.borderBottomWidth, 10);
                  tabHeight = tabHeight + parseInt(rightTabLabelStyle.lineHeight, 10);
                  var RightPageHeight = document.getElementsByClassName("tab")[0].offsetHeight+RightcontentHeight;
                  if ((options.pagesshown && !options.login)|| RightcontentHeight ==0){
                        if (options.signup){
                              var RightcontentHeight = 580;
                              var RightPageHeight = RightcontentHeight+tabHeight;
                        }
                        else{
                              var RightcontentHeight = 580;
                              var RightPageHeight = RightcontentHeight;
                        }
                  }
                  
                  document.getElementsByClassName("lr-ls-logobase")[0].style.minHeight = RightPageHeight.toString() +"px";
                  document.getElementsByClassName("content")[0].style.height = RightcontentHeight.toString() +"px";
                  document.getElementsByClassName("content")[1].style.height = RightcontentHeight.toString() +"px";
                  document.getElementsByClassName("content")[2].style.height = RightcontentHeight.toString() +"px";
                  document.getElementById("Resetpw-content1").style.height =  RightPageHeight.toString() +"px";
                  
                  document.getElementsByClassName("content")[0].style.overflow = "auto";
                  document.getElementsByClassName("content")[0].style.overflowX = "hidden";
                  document.getElementsByClassName("content")[0].style.width = "50%";
                  document.getElementsByClassName("content")[1].style.overflow = "auto";
                  document.getElementsByClassName("content")[1].style.overflowX = "hidden";
                  document.getElementsByClassName("content")[1].style.width = "50%";
                  document.getElementById("lr-ls-logo-place").style.paddingTop = (RightPageHeight / 2.5).toString() +"px";
            })
      }
      lrCallingObj.util.ready(function() {
            lrCallingObj.customInterface(".interfacecontainerdiv", custom_interface_option);
            lrCallingObj.init('socialLogin', sl_options);
            lrCallingObj.init("login", login_options);
            lrCallingObj.init("registration", registration_options);
            lrCallingObj.init("forgotPassword", forgotpassword_options);
            lrCallingObj.init("resetPassword", resetpassword_options);
      });

      function VerifyEmailInit() {
            var verifyemail_options = {};
            verifyemail_options.onSuccess = function(response) {
                  document.getElementById("lr-ls-divisionsuccess").innerHTML = ((options.content && options.content.emailVerifiedMessage) ? options.content.emailVerifiedMessage : "You have successfully registered, you now may log in with this email");
                  lrlssuccessaction(response);
                  localStorage.setItem("LrEmailStatus", "verified");
                  cb(response, "verifyEmail");
                  if(response.access_token){
                        redirect(response);
                  }
            };
            verifyemail_options.onError = function(errors) {
                  lrlserroraction(errors);
                  cb(errors, "verifyEmail");
            }
            lrCallingObj.util.ready(function() {
                  lrCallingObj.init("verifyEmail", verifyemail_options);
            });
      };

      function VerifyToken() {
            var link = lrCallingObj.util.parseQueryString(window.location.href);
            var values = Object.keys(link).map(function(e) {
                  return link[e];
            })
            if ((Object.keys(link)[0].indexOf("vtype") > -1) && Object.keys(link)[1] == "vtoken" && values.length>1) {
                  if (values[0].indexOf("emailverification") >= 0) {
                        VerifyEmailInit();
                  } else if (values[0] == "reset") {
                        for (i = 0; i < document.getElementsByClassName("tab").length; i++) {
                              document.getElementsByClassName("tab")[i].style.display = "none";
                        }
                        document.getElementById("Resetpw-content1").style.display = "inherit";
                  }
            }
      };
      VerifyToken();
      lrCallingObj.$hooks.register('registrationSchemaFilter', registrationSchema);

      function registrationSchema(regSchema, userProfile) {
            if(userProfile){
                  document.getElementById("registration-container").style.display = "none";
                  document.getElementById("interfacecontainerdiv").style.display = "none";
                  document.getElementById("lr-ls-sectiondivider").style.display = "none";
            }
      }
      lrCallingObj.$hooks.register('startProcess', function() {
            document.getElementById("loader").style.display = "block";
      });
      lrCallingObj.$hooks.register('endProcess', function() {
            document.getElementById("loader").style.display = "none";
      });
      lrCallingObj.$hooks.register('socialLoginFormRender',function(){
            //on social login form render
            document.getElementById("tab2").checked = true;
      });
      if (!options.language){
            lrCallingObj.$hooks.call('setButtonsName', {
                  login: "LOG IN",
                  registration: 'SIGN UP',
                  forgotPassword: "SEND",
                  resetPassword: "RESET"
            });}
  }
})(window);