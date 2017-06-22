<?php include "common.php"; ?>
<script type="text/javascript">
    var custom_interface_option = {};
    custom_interface_option.templateName = "loginradiuscustom_tmpl";

    LRObject.util.ready(function () {
        LRObject.customInterface(".interfacecontainerdiv", custom_interface_option);
        LRObject.$hooks.register('socialLoginFormRender', function () {
            //on social login form render

            setTimeout(function () {
                jQuery("#login-container").hide()
            }, 100);
            jQuery('#registration-container, .OR, .interfacecontainerdiv').hide();
            jQuery('#social-registration-form').show();
            show_birthdate_date_block();
        });
    });

    LRObject.$hooks.register('endProcess', function () {
        var vtype = LRObject.util.getQueryParameterByName("vtype");
        if (vtype == "reset") {
            jQuery('#login-container').hide();
        } else {
            jQuery('#login-container').show();
        }
    }
    );

    function show_birthdate_date_block() {
        var maxYear = new Date().getFullYear();
        var minYear = maxYear - 100;
        if (jQuery('body').on) {
            jQuery('body').on('focus', '.loginradius-birthdate', function () {
                jQuery('.loginradius-birthdate').datepicker({
                    dateFormat: 'mm-dd-yy',
                    maxDate: new Date(),
                    minDate: "-100y",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: (minYear + ":" + maxYear)
                });
            });
        } else {
            jQuery(".loginradius-birthdate").live("focus", function () {
                jQuery('.loginradius-birthdate').datepicker({
                    dateFormat: 'mm-dd-yy',
                    maxDate: new Date(),
                    minDate: "-100y",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: (minYear + ":" + maxYear)
                });
            });
        }
    }
</script>

<div class="interfacecontainerdiv"></div>                
<script type="text/html" id="loginradiuscustom_tmpl">

    <div class="lr-icon-box">	
        <span class="lr-provider-label lr-sl-shaded-brick-button lr-flat-<#=Name.toLowerCase()#>"
              onclick=" return LRObject.util.openWindow('<#= Endpoint #>');" 
              title="<#=Name#>" alt="Sign in with <#=Name#>">  
            <span class="lr-sl-icon lr-sl-icon-<#=Name.toLowerCase()#>"></span>  
            Login with <#=Name#>                 
        </span>
    </div>

</script>

