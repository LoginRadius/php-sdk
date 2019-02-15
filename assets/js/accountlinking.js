$(function() {
	var la_options = {};
	la_options.container = "interfacecontainerdiv";
	la_options.templateName = 'loginradiuscustom_tmpl_link';
	la_options.onSuccess = function(response) {          
                if (response.IsPosted == true) {
                    $("#accountlinking-message").attr('style', 'color:green'); 
                    $("#accountlinking-message").text("Account linked successfully");
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }
	};
	la_options.onError = function(errors) {
                 $("#accountlinking-message").attr('style', 'color:red'); 
		 $("#accountlinking-message").text(errors[0].Description);
	};

	var unlink_options = {};
	unlink_options.onSuccess = function(response) {
                if (response.IsDeleted == true) {
                    $("#accountlinking-message").attr('style', 'color:green'); 
                    $("#accountlinking-message").text("Account unlinked successfully");             
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }
	};
	unlink_options.onError = function(errors) {
                $("#accountlinking-message").attr('style', 'color:red'); 
		$("#accountlinking-message").text(errors[0].Description);
	};

	LRObject.util.ready(function() {
		LRObject.init("linkAccount", la_options);
		LRObject.init("unLinkAccount", unlink_options);
	});
});