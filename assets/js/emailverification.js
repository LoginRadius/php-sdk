var stringVariable = window.location.href;
domainName = stringVariable.substring(0, stringVariable.lastIndexOf('/'));
$(function() {
	if (getUrlParameter("vtype") == "oneclicksignin") {
                $("#lr-loading").show();
                $("#emailverification-message").text("");
		$.ajax({
			type: "POST",
                        url: 'login',			
                        data: $.param({
				token: getUrlParameter("vtoken"),						
                                action: "pwLessLinkVerify"
			}),
			dataType: "json",
			success: function(res) {
				console.log(res);
                            $("#lr-loading").hide();
                            if (res.status == 'success') {
                                getProfile(res.data.access_token, res.data.Profile.Uid);
				
                            } else if(res.status == 'error'){
                                $("#emailverification-message").attr('style', 'color:red');    
                                $("#emailverification-message").text(res.message);
                            }
			},
			error: function(xhr, status, error) {
			        $("#lr-loading").hide();
                                 console.log(xhr.responseText);
                                $("#emailverification-message").attr('style', 'color:red'); 
				$("#emailverification-message").text("Pwless Login failed");
			}
		});
	} else if (getUrlParameter("vtype") == "emailverification") {
                $("#lr-loading").show();
                $("#emailverification-message").text("");
		$.ajax({
                        url: 'login',
                        type: 'POST',
                        dataType: "json",
                        data: $.param({
                            vtoken: getUrlParameter("vtoken"),
                            action: "emailVerify"
                        }),			
			success: function(res) {    
                                $("#lr-loading").hide();  
                                if (res.status == 'success') {
                                   $("#emailverification-message").attr('style', 'color:green');  
                                   $("#emailverification-message").text(res.message);
                                } else if (res.status == 'error') {
                                    $("#emailverification-message").attr('style', 'color:red');                      
                                    $("#emailverification-message").text(res.message);
                                }                            
			},
			error: function(xhr, status, error) {
				$("#lr-loading").hide();
                                console.log(xhr.responseText);
                                $("#emailverification-message").attr('style', 'color:red');  
				$("#emailverification-message").text("Email verification failed");
			}
		});
	}
});

function getUrlParameter(sParam) {
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : sParameterName[1];
		}
	}
}