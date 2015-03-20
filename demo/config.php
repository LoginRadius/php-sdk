<?php

	define('LR_APIKEY', 'LOGINRADIUS_API_KEY');
	define('LR_SECRETKEY', 'LOGINRADIUS_API_SECRET_KEY');
	//Ex :- http://www.example.com/ or http://localhost/
	define('YOUR_DOMAIN', 'YOUR_SITE_DOMAIN');
	
	/**
	 * Redirection function
	**/
	function LoginRadius_Redirect($page){
            echo "<script language=Javascript>
                    document.location.href='".$page.".php';
                </script>";
      	}