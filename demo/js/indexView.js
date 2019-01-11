$(function () {

    $(window).on('hashchange', function () {
        // On every hash change the render function is called with the new hash.
        // This is how the navigation of our app happens.
        render(decodeURI(window.location.hash));
    }).trigger('hashchange');

    function render(url) {
        // This function decides what type of page to show 
        // depending on the current url hash value.

        // Get the keyword from the url.
        let temp = url.split('/')[0];
        temp = temp.split('?')[0];
        // Hide whatever page is currently shown.
        $('.right-elem').removeClass('visible');
        $('.menu-options').removeClass('active');

        let map = {
            // The Homepage.
            '': function () {
                renderLogin();
            },
            // Login page.
            '#login': function () {
                renderLogin();
            },
            // Register page.
            '#signup': function () {
                renderSignup();
            },
            // Forgot Password page.
            '#forgotpassword': function () {
                renderForgotPassword();
            },
            // Reset Password page.
            '#resetpassword': function () {
                renderResetPassword();
            }
        };

        // Execute the needed function depending on the url keyword (stored in temp).
        if (map[temp]) {
            map[temp]();
        }
        // If the keyword isn't listed in the above - render the error page.
        else {
            renderErrorPage();
        }
    }

    function renderLogin() {
        let page = $('.login-elem')
        let menuOption = $('#menu-login')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the login page.
    }

    function renderSignup() {
        let page = $('.signup-elem')
        let menuOption = $('#menu-signup')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the signup page.
    }

    function renderForgotPassword() {
        let page = $('.forgotpassword-elem')
        let menuOption = $('#menu-forgotpassword')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderResetPassword() {
        let page = $('.resetpassword-elem')
        page.addClass('visible');
        // Shows the reset password page.
    }
});