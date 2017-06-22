<script type="text/javascript">
    function raasRedirect(token) {
        var form = document.createElement('form');
        var stringVariable = window.location.href;
        domainName = stringVariable.substring(0, stringVariable.lastIndexOf('/')); 
        form.action = domainName+"/index.php";
        form.method = 'POST';

        var hiddenToken = document.createElement('input');
        hiddenToken.type = 'hidden';
        hiddenToken.value = token;
        hiddenToken.name = 'token';
        form.appendChild(hiddenToken);

        document.body.appendChild(form);
        form.submit();
    }

    function handleResponse(message, status) {
        status = status ? status : "success";
        if (message != null && message != "") {
            jQuery('.messageinfo').show();
            jQuery('.messageinfo').addClass(status);
            jQuery('.messages').text(message);
        } else {
            jQuery('.messageinfo').hide();
            jQuery('.messages').text("");
        }
    }
</script>  
