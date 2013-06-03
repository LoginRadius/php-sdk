LoginRadius library for PHP
=====
PHP SDK for the LoginRadius API. Get social authentication, user profile data and send messages using many social network and email clients such as Facebook, Google, Twitter, Yahoo, LinkedIn, etc.

Installation
----
 1. **Font-end interface:** Add social login interface code from your LoginRadius user account to your webpage.
 2. **Call-back setup:** Set-up the callback URL in your LoginRadius user account, this is the URL where user would be redirected after authentication.
 3. **Library set-up and installation:** Copy SDK file to your project directory and follow the instructions to implement the SDK into your callback page.

    **Note**: If you are implementing callback on the same page where you are showing Social Login interface, then implement callback handling as mentioned below:-

**Example Code**

    if(isset($_REQUEST['token'])){
 	    // callback handling code
    }
Steps to call the library:

     1. Download the LoginRadius SDK and add it to your web project.
     2. On the code behind of callback page, create an object of LoginRadius class and pass secret key.
     3. If success, call loginradius_get_data method to get user's profile data.
       [For Premium paid plans: You can call loginradius_get_data method to get Extended user profile data.]
       visit the link for more information to get list of data: https://www.loginradius.com/product/user-profile-data

**Sample code for authentication and get basic profile data**

**PHP**

    // include main PHP SDK file
 	include('LoginRadiusSDK.php');
	
	 // create LoginRadius class object
     $obj = new LoginRadius("API_SECRET");
	
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
	// Email
	if(isset($userprofile->Email) && is_array($userprofile->Email) && count($userprofile->Email) > 0){
            echo 'Emails:-<br />';
            foreach($userprofile->Email as $email){
                echo isset($email->Type) ? 'Email Type='.$email->Type."<br/>" : '';
                echo isset($email->Value) ? "Email=".$email->Value."<br/>" : '';
                echo '<br/>';
       }
     }
  	 echo "<br>";  
	 // Country
	 echo "Country Name=";  
	 if(isset($userprofile->Country->Name) && is_string($userprofile->Country->Name))
	 {  
		echo $userprofile->Country->Name."<br>";  
	 }elseif(isset($userprofile->Country) && is_string($userprofile->Country) ){  
		echo $userprofile->Country."<br>";  
	 }else{  
		echo '<br>';  
	 }
	 // Country Code 
	 echo "Country Code=";    
	 if(isset($userprofile->Country->Code) && is_string($userprofile->Country->Code))
	 {    
		echo $userprofile->Country->Code."<br>";    
	 }else{    
		echo '<br>';    
	 }
    }



**Sample code to get Extended user profile (Only for Paid plans - Premium)**

**PHP**

     // include main PHP SDK file
     include('LoginRadiusSDK.php');
	
	// create LoginRadius class object
 	$obj = new LoginRadius("API_SECRET");

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
	// Email
	if(isset($userprofile->Email) && is_array($userprofile->Email) &&   count($userprofile->Email) > 0){
            echo 'Emails:-<br />';
            foreach($userprofile->Email as $email){
                echo isset($email->Type) ? 'Email Type='.$email->Type."<br/>" : '';
                echo isset($email->Value) ? "Email=".$email->Value."<br/>" : '';
                echo '<br/>';
            }
     }
  	 echo "<br>";  
	 // Country
	 echo "Country Name=";  
	 if(isset($userprofile->Country->Name) && is_string($userprofile->Country->Name))
	 {  
		echo $userprofile->Country->Name."<br>";  
	 }elseif(isset($userprofile->Country) && is_string($userprofile->Country) ){  
		echo $userprofile->Country."<br>";  
	 }else{  
		echo '<br>';  
	}
	// Country Code 
	echo "Country Code=";    
	if(isset($userprofile->Country->Code) && is_string($userprofile->Country->Code))
	{    
		echo $userprofile->Country->Code."<br>";    
	}else{    
		 echo '<br>';    
	}
	// Image Url
	echo "Image Url =".$ImageUrl=$userprofile->ImageUrl."<br>";
	// Profile Url
	echo "Profile Url=".$ProfileUrl=$userprofile->ProfileUrl."<br>"; 
	// HomeTown
	echo "Home Town=".$Hometown=$userprofile->HomeTown."<br>"; 
	// State
	echo "State=".$State=$userprofile->State."<br>"; 
	// City
	echo "City=".$City=$userprofile->City."<br>"; 
	// About
	echo "About=".$About=$userprofile->About."<br>"; 
	// Time Zone
	echo "TimeZone=".$TimeZone=$userprofile->TimeZone."<br>"; 
	// LocalLanguage
	echo "Local Language=".$LocalLanguage=$userprofile->LocalLanguage."<br>"; 
	// Language
	echo "Language=".$Language=$userprofile->Language."<br>"; 
	// Verified
	echo "Verified=".$Verified=$userprofile->Verified."<br>"; 
	// Updated Time
	echo "Updated Time=".$UpdatedTime=$userprofile->UpdatedTime."<br>"; 
	// Positions
	if(isset($userprofile->Positions) && is_array($userprofile->Positions) && count($userprofile->Positions) > 0){
		  echo 'Positions:-<br />';
		  foreach($userprofile->Positions as $positions){
			echo isset($positions->Position) ? 'Position='.$positions->Position."<br/>" : '';
			echo isset($positions->Summary) ? "Summary=".$positions->Summary."<br/>" : '';
			echo isset($positions->StartDate) ? "Start Date=".$positions->StartDate."<br/>" : '';
			echo isset($positions->EndDate) ? "End Date=".$positions->EndDate."<br/>" : '';
			echo isset($positions->IsCurrent) ? "IsCurrent=".$positions->IsCurrent."<br/>" : '';
			echo isset($positions->comapny->Name) ? "Company Name=".$positions->comapny->Name."<br/>" : '';
			echo isset($positions->comapny->Type) ? "Company Type=".$positions->comapny->Type."<br/>" : '';
			echo isset($positions->comapny->Industry) ? "Company Industry=".$positions->comapny->Industry."<br/>" : '';
			echo isset($positions->Location) ? "Location=".$positions->Location."<br/>" : '';
			echo '<br/>';
		}
	} 
	// Educations
	if(isset($userprofile->Educations) && is_array($userprofile->Educations) && count($userprofile->Educations) > 0){
		echo 'Educations:-<br />';
		foreach($userprofile->Educations as $educations){
			echo isset($educations->School) ? 'School='.$educations->School."<br/>" : '';
			echo isset($educations->year) ? "Year=".$educations->year."<br/>" : '';
			echo isset($educations->type) ? "Type=".$educations->type."<br/>" : '';
			echo isset($educations->notes) ? "Notes=".$educations->notes."<br/>" : '';
			echo isset($educations->activities) ? "Activities=".$educations->activities."<br/>" : '';
			echo isset($educations->degree) ? "Degree=".$educations->degree."<br/>" : '';
			echo isset($educations->fieldofstudy) ? "Field of Study=".$educations->fieldofstudy."<br/>" : '';
			echo isset($educations->StartDate) ? "Start Date=".$educations->StartDate."<br/>" : '';
			echo isset($educations->EndDate) ? "End Date=".$educations->EndDate."<br/>" : '';
			echo '<br/>';
		}
	}
	
	     // im accounts
	     if(isset($userprofile->IMAccounts) && is_array($userprofile->IMAccounts) && count($userprofile->IMAccounts) > 0){
		echo 'IM Accounts:-<br />';
		foreach($userprofile->IMAccounts as $imAccount){
			echo isset($imAccount->AccountType) ? 'Account Type='.$imAccount->AccountType."<br/>" : '';
			echo isset($imAccount->AccountName) ? "Account Name=".$imAccount->AccountName."<br/>" : '';
			echo '<br/>';
		     }
	       }
	
	     // Phone Numbers
	     if(isset($userprofile->PhoneNumbers) && is_array($userprofile->PhoneNumbers) && count($userprofile->PhoneNumbers) > 0){
		echo 'Phone Numbers:-<br />';
		foreach($userprofile->PhoneNumbers as $phoneNumber){
			echo isset($phoneNumber->AccountType) ? 'Phone Number Type='.$phoneNumber->PhoneType."<br/>" : '';
			echo isset($phoneNumber->AccountName) ? "Phone Number=".$phoneNumber->PhoneNumber."<br/>" : '';
			echo '<br/>';
		    }
	      }
	
	     // Addresses
	     if(isset($userprofile->Addresses) && is_array($userprofile->Addresses) && count($userprofile->Addresses) > 0){
		echo 'Addresses:-<br />';
		foreach($userprofile->Addresses as $address){
			echo isset($address->Type) ? 'Type='.$address->Type."<br/>" : '';
			echo isset($address->Address1) ? "Address1=".$address->Address1."<br/>" : '';
			echo isset($address->Address2) ? "Address2=".$address->Address2."<br/>" : '';
			echo isset($address->City) ? "City=".$address->City."<br/>" : '';
			echo isset($address->State) ? "State=".$address->State."<br/>" : '';
			echo isset($address->PostalCode) ? "Postal Code=".$address->PostalCode."<br/>" : '';
			echo isset($address->Region) ? "Region=".$address->Region."<br/>" : '';
			echo '<br/>';
		     }
	       }
	
	     // Main Address
	     echo "Main Address=".$mainAddress=$userprofile->MainAddress."<br>"; 
	     // Created
	     echo "Created=".$created=$userprofile->Created."<br>"; 
	     // Local City
	     echo "Local City=".$localCity=$userprofile->LocalCity."<br>"; 
	     // Profile City
	     echo "Profile City=".$profileCity=$userprofile->ProfileCity."<br>"; 
	     // Local Country
	     echo "Local Country=".$localCountry=$userprofile->LocalCountry."<br>"; 
         // ProfileCountry
	     echo "ProfileCountry=".$ProfileCountry=$userprofile->ProfileCountry."<br>"; 
	     // RelationshipStatus
	     echo "RelationshipStatus=".$RelationshipStatus=$userprofile->RelationshipStatus."<br>"; 
	     // Quotes
	     echo "Quotes=".$Quotes=$userprofile->Quota."<br>"; 
	     // Interested In
	     echo count($userprofile->InterestedIn) > 0 ? "Interested In=".implode(',', $userprofile->InterestedIn) : "Interested In=<br>"; 
	     // Interests
	     echo "Interests=".$Interests=$userprofile->Interests."<br>"; 
	     // Religion
	     echo "Religion=".$Religion=$userprofile->Religion."<br>"; 
	     //  Political Views
	     echo "Political Views=".$Political=$userprofile->Political."<br>"; 
	     // Sports
	     echo "Sports=".$Sports=$userprofile->Sports."<br>";
	     // Inspirational People
	     if(isset($userprofile->InspirationalPeople) && is_array($userprofile->InspirationalPeople) && count($userprofile->InspirationalPeople) > 0){
		 echo 'Inspirational People:-<br />';
		 foreach($userprofile->InspirationalPeople as $people){
			echo isset($people->Id) ? 'ID='.$people->Id."<br/>" : '';
			echo isset($people->Name) ? "Name=".$people->Name."<br/>" : '';
			    echo '<br/>';
		     }
	      }

	     //  Https Image Url
	     echo "Https Image Url=".$HttpsImageUrl=$userprofile->HttpsImageUrl."<br>"; 
	     // Followers Count
	     echo "Followers Count=".$FollowersCount=$userprofile->FollowersCount."<br>"; 
	     //  Friends Count
	     echo "Friends Count=".$FriendsCount=$userprofile->FriendsCount."<br>"; 
	     // Total Status Count
	     echo "Total Status Count=".$TotalStatusesCount=$userprofile->TotalStatusesCount."<br>"; 
	     // Associations
	     echo "Associations=".$Associations=$userprofile->Associations."<br>"; 
	     // Honors
	     echo "Honors=".$Honors=$userprofile->Honors."<br>"; 
	     // Skills
	    if(isset($userprofile->Skills) && is_array($userprofile->Skills) && count($userprofile->Skills) > 0){
            echo 'Skills:-<br />';
            foreach($userprofile->Skills as $skill){
                echo isset($skill->Id) ? 'ID='.$skill->Id."<br/>" : '';
                echo isset($skill->Name) ? "Skill=".$skill->Name."<br/>" : '';
                echo '<br/>';
            }
        } 
	// Current Status
	if(isset($userprofile->CurrentStatus) && is_array($userprofile->CurrentStatus) && count($userprofile->CurrentStatus) > 0){
            echo 'Current Status:-<br />';
            foreach($userprofile->CurrentStatus as $status){
                echo isset($status->Id) ? 'ID='.$status->Id."<br/>" : '';
                echo isset($status->Text) ? "Status=".$status->Text."<br/>" : '';
                echo isset($status->Source) ? "Source=".$status->Source."<br/>" : '';
                echo isset($status->CreatedDate) ? "Created Date=".$status->CreatedDate."<br/>" : '';
                echo '<br/>';
            }
        }
 	    // Certifications
	    echo "Certifications=".$Certifications=$userprofile->Certifications."<br>"; 
	    // Courses
	    echo "Courses=".$Courses=$userprofile->Courses."<br>"; 
	    // Volunteer
	    echo "Volunteer=".$Volunteer=$userprofile->Volunteer."<br>"; 
	    // RecommendationsReceived
	    echo "Recommendations Received=".$RecommendationsReceived=$userprofile->RecommendationsReceived."<br>"; 
	
	    // languages
	    if(isset($userprofile->Languages) && is_array($userprofile->Languages) && count($userprofile->Languages) > 0){
		echo 'Languages:-<br />';
		foreach($userprofile->Languages as $language){
			echo isset($language->Id) ? 'ID='.$language->Id."<br/>" : '';
			echo isset($language->Name) ? "Language=".$language->Name."<br/>" : '';
			echo '<br/>';
		}
	}
	
	    // Public Repository
	    echo "Public Repository=".$PublicRepository=$userprofile->PublicRepository."<br>"; 
	    // Hireable
	    echo "Hireable=".$Hireable=$userprofile->Hireable."<br>"; 
	    // Repository Url
	    echo "Repository Url=".$RepositoryUrl=$userprofile->RepositoryUrl."<br>"; 
	    // Age
	    echo "Age=".$Age=$userprofile->Age."<br>"; 
	    // Patents
	    echo "Patents=".$Patents=$userprofile->Patents."<br>"; 

	   // Favorite Things
	   echo "Favorite Things=".$favorite=$userprofile->FavoriteThings."<br>"; 
	   // Professional Headline
	   echo "Professional Headline=".$ProfessionalHeadline=$userprofile->ProfessionalHeadline."<br>"; 
	   // Patents
	   echo "Patents=".$Patents=$userprofile->Patents."<br>";
	}	


Advance features(for Paid customers only)
===

LoginRaidus Contacts API
-----
You can use this API to fetch contacts from users social networks/email clients - Facebook, Twitter, LinkedIn, Google, Yahoo.

> LoginRadius generate a unique session token, when user logs in with
> any of social network. The lifetime of LoginRadius token is 15 mins, get/Save this Token to call this API.

**PHP**
	
	include('LoginRadiusSDK.php');
	include('LoginRadiusContacts.php');    
	$obj = new LoginRadiusContacts("Your API Secret");
	$loginRadiusContacts = $obj->loginradius_get_contacts();


LoginRadius Post API
---
You can use this API to Post data to users social networks - Facebook, Twitter, LinkedIn.

> LoginRadius generate a unique session token, when user logs in with
> any of social network. The lifetime of LoginRadius token is 15 mins, get/Save this Token to call this API.

**PHP**
	
	include('LoginRadiusSDK.php');
	include('LoginRadiusStatusUpdate.php');
	$obj = new LoginRadiusStatusUpdate("Your API Secret");
	$loginRadiusResponse = $obj->loginradius_post_status($to, $title, $url, $imageurl, $status, $caption, $description);
	if($loginRadiusResponse === true){
		echo 'Message posted successfully.'; }
	elseif(isset($loginRadiusResponse->errormessage)){
		echo $loginRadiusResponse->errormessage;
	}else{
		echo 'Error in message post.';
	}


Get Posts
--
You can use this API to get posts from users social networks - Facebook, Twitter, LinkedIn

> LoginRadius generate a unique session token, when user logs in with
> any of social network. The lifetime of LoginRadius token is 15 mins, get/Save this Token to call this API.

**PHP**
	
	include('LoginRadiusSDK.php');
	include('LoginRadiusPosts.php');
	$obj = new LoginRadiusPosts("Your API Secret");
	$loginRadiusPosts = $obj->loginradius_get_posts();


Get Twitter Mentions
--

You can use this API to get mentions from users social network - Twitter.

> LoginRadius generate a unique session token, when user logs in with
> any of social network. The lifetime of LoginRadius token is 15 mins, get/Save this Token to call this API.

**PHP**
	
	include('LoginRadiusSDK.php');
	include('LoginRadiusMentions.php');
	$obj = new LoginRadiusMentions("Your API Secret");
	$loginRadiusMentions = $obj->loginradius_get_mentions();

Facebook Groups
--
You can use this API to get groups from users social network - Facebook.

> LoginRadius generate a unique session token, when user logs in with
> any of social network. The lifetime of LoginRadius token is 15 mins, get/Save this Token to call this API.

**PHP**

	include('LoginRadiusSDK.php');
	include('LoginRadiusGroups.php');
	$obj = new LoginRadiusGroups("Your API Secret");
	$loginRadiusGroups = $obj->loginradius_get_groups();


Get LinkedIn follow companies
--
You can use this API to get followed companies list from users social network - LinkedIn.

> LoginRadius generate a unique session token, when user logs in with
> any of social network. The lifetime of LoginRadius token is 15 mins, get/Save this Token to call this API.

**PHP**

	include('LoginRadiusSDK.php');
   	include('LoginRadiusCompany.php');
	$obj = new LoginRadiusCompany("Your API Secret");
	$loginRadiusCompanies = $obj->loginradius_get_company();

LoginRadius direct message API
--
You can use this API to send direct message.

> LoginRadius generate a unique session token, when user logs in with
> any of social network. The lifetime of LoginRadius token is 15 mins, get/Save this Token to call this API.

**PHP**
	
	include('LoginRadiusSDK.php');
	include('LoginRadiusMessage.php');
	$obj = new LoginRadiusMessage("Your API Secret");
	$loginRadiusResponse = $obj->loginradius_send_message($to,$subject,$message);
	if($loginRadiusResponse === true){
    	echo 'Message sent successfully.';
	}elseif(isset($loginRadiusResponse->errormessage)){
    	echo $loginRadiusResponse->errormessage;
	}else{
    	echo 'Error in sending message.';
	}

**Request:** Please let us know your feedback and comments. If you have any questions or need a further assistance please contact us at hello@loginradius.com.
