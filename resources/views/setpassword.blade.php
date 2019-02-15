@extends('layouts.profile.home')
  @section('content')
        <div class="section-main section-minimal">
            <center>
                <div class="container-small lr-set-password">
                    Password: <input name="email" type='password' id='user-setpassword-password'/><br/>
                    <button id="btn-user-setpassword">Set Password</button><br/>
                    <span style="color:red" id="user-setpassword-errorMsg"></span>
                    <span style="color:green" id="user-setpassword-successMsg"></span>
                </div>
            </center>                
        </div>      
        
    @endsection
 