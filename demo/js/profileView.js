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

        // Hide whatever page is currently shown.
        $('.right-elem').removeClass('visible');
        $('.menu-options').removeClass('active');

        let map = {
            // The Homepage.
            '': function () {
                renderProfile();
            },
            // Profile page.
            '#profile': function () {
                renderProfile();
            },
            // Reset Password page.
            '#resetpassword': function () {
                renderResetPassword();
            },
            // Change Password page.
            '#changepassword': function () {
                renderChangePassword();
            },
            // Set Password page.
            '#setpassword': function () {
                renderSetPassword();
            },
            // Update Account page.
            '#account': function () {
                renderUpdateAccount();
            },
            // Account Linking page.
            '#accountlinking': function () {
                renderAccountLinking();
            },
            // Account Linking page.
            '#accountlinking': function () {
                renderAccountLinking();
            },
            // Custom Objects page.
            '#customobjects': function () {
                renderCustomObjects();
            },
            // Multifactor page.
            '#multifactor': function () {
                renderMultifactor();
            },
            // Roles page.
            '#roles': function () {
                renderRoles();
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

    function renderProfile() {
        let page = $('.profile-elem')
        let menuOption = $('#menu-profile')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the profile page.
    }

    function renderResetPassword() {
        let page = $('.resetpassword-elem')
        let menuOption = $('#menu-resetpassword')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderChangePassword() {
        let page = $('.changepassword-elem')
        let menuOption = $('#menu-changepassword')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderSetPassword() {
        let page = $('.setpassword-elem')
        let menuOption = $('#menu-setpassword')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderUpdateAccount() {
        let page = $('.updateaccount-elem')
        let menuOption = $('#menu-account')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderAccountLinking() {
        let page = $('.accountlinking-elem')
        let menuOption = $('#menu-accountlinking')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderCustomObjects() {
        let page = $('.customobj-elem')
        let menuOption = $('#menu-customobjects')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderMultifactor() {
        let page = $('.multifactor-elem')
        let menuOption = $('#menu-multifactor')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderRoles() {
        let page = $('.roles-elem')
        let menuOption = $('#menu-roles')
        page.addClass('visible');
        menuOption.addClass('active');
        // Shows the forgot password page.
    }

    function renderErrorPage() {
        // Shows the error page.
    }

});