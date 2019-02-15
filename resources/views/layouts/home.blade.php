<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="<?php echo csrf_token() ?>"> 
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />
        <script src="{{asset('js/jquery.min.js')}}"></script> 
        <script src="https://auth.lrcontent.com/v2/js/LoginRadiusV2.js"></script> 
        <script src="{{asset('js/options.js')}}"></script>  
        <script src="{{asset('js/index.js')}}"></script>  
        <script src="{{asset('js/sociallogin.js')}}"></script> 
        <script src="{{asset('js/emailverification.js')}}"></script>
        <script src="{{asset('js/LoginRadiusLoginScreen.1.0.0.js')}}"></script>
        
    </head>
    <body>
    
        <div class="section-menu">
        <div class="menu-header">
                <a href="">
                    <img src="{{asset('images/lr-logo.png')}}"/>
                </a>
                <span style="display:block;margin-left:70px">Laravel Web Demo</span>
                <div class="button-group">
                    <a href="{{ route('minimal') }}">Minimal</a>
                    <a href="{{ route('login') }}" >LoginScreen</a>
                </div>
            </div>


            <div class="vertical-menu">
                <a href="{{ route('minimal') }}" id="menu-login">Login</a>
                <a href="{{ route('signup') }}" id="menu-signup">Register</a>
                <a href="{{ route('forgot')}}" id="menu-forgotpassword">Forgot Password</a>
            </div>
        </div>
        <div class="overlay" id="lr-loading" style="display: none;">
            <div class="lr_loading_screen">
                <div class="lr_loading_screen_center" style="position: fixed;">
                    <div class="lr_loading_screen_spinner"></div> 
                    <div class="lr_loading-phrases-container">
                        <div class="lr_loading-phrases_wrap">
                            <div class="lr_loading_phrase">Please wait...</div>                      
                        </div>              
                    </div>                                   
                </div>     
            </div>
        </div>
        @yield('content')
        

        </body>
    </html>