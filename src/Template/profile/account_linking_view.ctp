<div class="section-main section-minimal">
            <center><span id="accountlinking-message"></span>
                <div class="container">
                    <div class="col-sm-12">
                        <div id="interfacecontainerdiv" class="interfacecontainerdiv"></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="linked-account" align="left">
                            <script type="text/html" id="loginradiuscustom_tmpl_link">
                                <# if(isLinked) { #>
                                <div class="lr-linked">
                                    <a class="lr-provider-label" href="javascript:void(0)" title="<#= Name #>" alt="Connected">
                                        <#=Name#> is connected
                                    </a>
                                    <a onclick='return <#=ObjectName#>.util.unLinkAccount(\"<#= Name.toLowerCase() #>\",\"<#= providerId #>\")' style="cursor: pointer;">Unlink</a>
                                </div>
                                <# }  else {#>
                                <div class="lr-unlinked">
                                    <a class="lr-provider-label" href="javascript:void(0)" onclick="return <#=ObjectName#>.util.openWindow('<#= Endpoint #>');" title="<#= Name #>" alt="Sign in with <#=Name#>">
                                        <#=Name#></a>    </div>
                                <# } #>
                                </script>
                            </div>
                        </div>
                    </div>
                </center>                
            </div>      