@extends('layouts.profile.home')
@section('content')
        <div class="section-main section-minimal">
            <center>
                <div class="container-small lr-reset-multifacor">
                    <b>Reset Google Authenticator configurations</b><br/>
                    <button id="btn-user-mfa-resetgoogle">Reset</button><br/>
                    <span style="color:red" id="user-mfa-errorMsg"></span>
                    <span style="color:green" id="user-mfa-successMsg"></span>
                </div>
            </center>                
        </div>       
  @endsection