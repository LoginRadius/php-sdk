<html lang="en">
    <head>
        <title>profile</title>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="<?php echo csrf_token() ?>"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />
        <script src="{{asset('js/jquery.min.js')}}"></script> 
        <script src="{{asset('js/logout.js')}}"></script> 
        <script type="text/javascript" src="https://auth.lrcontent.com/v2/js/LoginRadiusV2.js"></script>
        <script src="{{asset('js/profile.js')}}"></script>
        <script src="{{asset('js/account.js')}}"></script>
        <script src="{{asset('js/options.js')}}"></script>
        <script src="{{asset('js/accountlinking.js')}}"></script>

    </head>
    <body>
        <div class="section-menu">
            <div class="menu-header">
                <a href="">
                    <img src="{{asset('images/lr-logo.png')}}"/>
                </a>
                <span style="display:block;margin-left:70px">Laravel Web Demo</span>
     
            </div>
            <div class="vertical-menu">
                <a href="{{ route('profileview') }}" id="menu-profile">Profile</a>
                <a href="{{ route('changepassword') }}" id="menu-changepassword">Change Password</a>
                <a href="{{ route('setpassword') }}" id="menu-setpassword">Set Password</a>
                <a href="{{ route('account') }}" id="menu-account">Update Account</a>
                <a href="{{ route('accountlinking')}}" id="menu-accountlinking">Account Linking</a>
                <a href="{{ route('customobjects')}}" id="menu-customobjects">Custom Object Management</a>
                <a href="{{ route('multifactor')}}" id="menu-multifactor">Reset MultiFactor</a>
                <a href="{{ route('roles') }}" id="menu-roles">Roles Management</a>
                <a href="" id="menu-user-logout">Logout</a>
            </div>
        </div>
           @yield('content')
    </body>
</html>