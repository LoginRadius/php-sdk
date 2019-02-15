@extends('layouts.home')


@section('content')

        <div class="section-main section-minimal">       
            <center><span id="emailverification-message"></span>
                <div class="container">
                    <center><table>
                            <tr><th colspan="2">Traditional Login</th></tr>
                            <tr><td>Email Address: </td><td><input name="email" type='text' id='minimal-login-email'/></td></tr>
                            <tr><td>Password: </td><td><input name="password" type='password' id='minimal-login-password'/></td></tr>
                        </table></center>
                    <button id="btn-minimal-login">Login</button><br/>
                    <span style="color:red" id="minimal-login-errorMsg"></span>
                    <br></br>

                    <center><table>
                            <tr><th colspan="2">Multi-Factor Login</th></tr>
                            <tr><td>Email Address: </td><td><input name="email" type='text' id='minimal-mfalogin-email'/></td></tr>
                            <tr><td>Password: </td><td><input name="password" type='password' id='minimal-mfalogin-password'/></td></tr>
                        </table>
                    </center>
                    <button id="btn-minimal-mfalogin-next">Next</button><br/>
                    <div id="minimal-mfalogin-login"></div>
                    <span style="color:red" id="minimal-mfalogin-errorMsg"></span>
                    <br></br>
                    <center>
                        <table>
                            <tr><th colspan="2">Passwordless Login</th></tr>
                            <tr><td>Email Address: </td><td><input name="email" type='text' id='minimal-pwless-email'/></td></tr>
                        </table>
                    </center>
                    <button id="btn-minimal-pwless">Email me a link to sign in</button><br/>
                    <span style="color:red" id="minimal-pwless-errorMsg"></span>
                    <span style="color:green" id="minimal-pwless-successMsg"></span>
                    <br></br>

                    <b>Social Login</b><br/>                            
                    <script type="text/html" id="loginradiuscustom_tmpl">
                        <a class="lr-provider-label" href="javascript:void(0)" onclick="return LRObject.util.openWindow('<#= Endpoint #>');" title="<#= Name #>" alt="Sign in with <#=Name#>">
                            <span class="lr-ls-icon lr-ls-icon-<#= Name #>"></span>
                        </a>&nbsp;&nbsp;&nbsp;
                        </script>

                        <div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
                        <div id="sociallogin-container"></div>

                    </div><br></br><br></br><br></br>
                </center>
            </div>
     
@endsection

