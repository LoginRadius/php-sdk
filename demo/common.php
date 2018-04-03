<script type="text/javascript">
    var commonOptions = {};
    commonOptions.apiKey = "<?php echo API_KEY; ?>"
    commonOptions.hashTemplate = true;
    commonOptions.formValidationMessage = true;
    commonOptions.askEmailForUnverifiedProfileAlways = true;
    commonOptions.sott = "<?php echo lr_raas_get_sott(); ?>";
    var stringVariable = window.location.href;
    domainName = stringVariable.substring(0, stringVariable.lastIndexOf('/'));
    commonOptions.callbackUrl = domainName + "/index.php";
    commonOptions.verificationUrl = domainName + "/index.php";
    commonOptions.forgotPasswordUrl = domainName + "/index.php";
    <?php 
    switch (AUTH_FLOW){
        case "optional":
            echo 'commonOptions.optionalEmailVerification = true;';
            break;
        case "disabled":
            echo 'commonOptions.disabledEmailVerification = true;';
            break;      
    }
    ?>
    var LRObject = new LoginRadiusV2(commonOptions);
</script>  

<?php

function lr_raas_get_sott() {  
    $sott =  new \LoginRadiusSDK\Utility\SOTT(API_KEY, API_SECRET);
    return urlencode($sott->encrypt('10', true));
}