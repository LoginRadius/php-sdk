<?php
// include main PHP SDK file
include('LoginRadiusSDK.php');
// create LoginRadius class object. Replace "API_SECRET" with your API Secret
$obj = new LoginRadius("API_SECRET", $_REQUEST['token']);
// get user profile data
$userprofile = $obj->loginradius_get_data();
// check if user is authenticated/valid 
if($obj->IsAuthenticated == true){
	// print user profile data
	// social ID  
	echo "ID=".$ID=$userprofile->ID."<br>";
	// Social ID Provider
	echo "Provider=".$Provider=$userprofile->Provider."<br>";
	// Prefix
	echo "Prefix=".$Prefix=$userprofile->Prefix."<br>";
	// First Name
	echo "FirstName=".$FirstName=$userprofile->FirstName."<br>";
	// Middle Name
	echo "Middle Name=".$MiddleName=$userprofile->MiddleName."<br>";  
	// Last Name
	echo "LastName=".$LastName=$userprofile->LastName."<br>";  
	// Suffix
	echo "Suffix=".$Suffix=$userprofile->Suffix."<br>";  
	// Full Name
	echo "FullName=".$FullName=$userprofile->FullName."<br>";  
	// Nick Name
	echo "NickName=".$NickName=$userprofile->NickName."<br>";  
	// Profile Name
	echo "ProfileName=".$ProfileName=$userprofile->ProfileName."<br>";  
	// Birthdate
	echo "BirthDate=".$BirthDate=$userprofile->BirthDate."<br>";  
	// Gender
	echo "Gender=".$Gender=$userprofile->Gender."<br>";  
	// Email type
	echo "EmailType=".$EmailType=isset($userprofile->Email[0]->Type)?$userprofile->Email[0]->Type:"";  
	echo "<br>";    
	// Email
	echo "EmailValue=".$EmailValue=isset($userprofile->Email[0]->Value)?$userprofile->Email[0]->Value:$userprofile->Email;  
	echo "<br>";  
	// Country
	echo "Country Name=";  
	if(isset($userprofile->Country->Name) && is_string($userprofile->Country->Name)){  
		echo $userprofile->Country->Name."<br>";  
	}elseif(isset($userprofile->Country) && is_string($userprofile->Country) ){  
		echo $userprofile->Country."<br>";  
	}else{  
		echo '<br>';  
	}
	// Country Code 
	echo "Country Code=";    
	if(isset($userprofile->Country->Code) && is_string($userprofile->Country->Code)){    
		echo $userprofile->Country->Code."<br>";    
	}else{    
		echo '<br>';    
	}  
}
?>