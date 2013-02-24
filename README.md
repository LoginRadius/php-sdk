LoginRadius's PHP SDK is used to implement Social Login on your PHP website
==========

Description: LoginRadius's PHP SDK is a development kit that lets you integrate Social Login through providers such as Facebook, Google, Twitter, and over 20 more on a PHP website. The SDK also fetches user profile data and can be customized from your LoginRadius user account. Ex: social icon sets, login interface, provider settings, etc.

Steps to implement LoginRadius PHP SDK for Basic User profile and Social Authentication
===

Step 1: Add SDK file reference to your PHP website

a. Copy the LoginRadius SDK file to your project directory.

b. Include SDK class file on your callback page. 

            <?php include('LoginRadiusSDK.php'); ?>
      
Step 2: Create LoginRadius object in your PHP file

On your callback page, create a LoginRadius object using your unique LoginRadius API Secret.

          <?php 
              $obj = new LoginRadius();
              $userprofile = $obj->construct("Your API Secret key goes here");  
            ?>
          
Step 3: Validate, authenticate and store data from LoginRadius: 

Validate the object using 'IsAuthenticated' variable. After successful validation, access user profile data such as ID, First Name, Last Name, Email using $userprofile->ID, $userprofile->FirstName, $userprofile->LastName, etc.

        <?php  
          $obj = new LoginRadius();  
          $userprofile = $obj->construct("Your API Secret key goes here");  
         if($obj->IsAuthenticated==TRUE)
            {
            echo "ID=".$ID=$userprofile->ID."<br>";
            echo "Provider=".$Provider=$userprofile->Provider."<br>";
            echo "Prefix=".$Prefix=$userprofile->Prefix."<br>";
            echo "FirstName=".$FirstName=$userprofile->FirstName."<br>";
            echo "LastName=".$LastName=$userprofile->LastName."<br>";
            echo "Suffix=".$Suffix=$userprofile->Suffix."<br>";
            echo "FullName=".$FullName=$userprofile->FullName."<br>";
            echo "NickName=".$NickName=$userprofile->NickName."<br>";
            echo "ProfileName=".$ProfileName=$userprofile->ProfileName."<br>";
            echo "BirthDate=".$BirthDate=$userprofile->BirthDate."<br>";
            echo "Gender=".$Gender=$userprofile->Gender."<br>";
            
            
            echo "EmailType=".$EmailType=isset($userprofile->Email[0]->Type)?$userprofile->Email[0]->Type:"";
            echo "<br>";  
            echo "EmailValue=".$EmailValue=isset($userprofile->Email[0]->Value)?$userprofile->Email[0]->Value:$userprofile->Email;
            echo "<br>";
            
            
            echo "Country Name=";
            if(isset($userprofile->Country->Name) && is_string($userprofile->Country->Name)){
            	echo $userprofile->Country->Name."<br>";
            }elseif(isset($userprofile->Country) && is_string($userprofile->Country) ){
            	echo $userprofile->Country."<br>";
            }else{
            	echo '<br>';
            }
            
             echo "Country Code=";  
             if(isset($userprofile->Country->Code) && is_string($userprofile->Country->Code)){  
            		echo $userprofile->Country->Code."<br>";  
             }else{  
            		echo '<br>';  
             }
            
            echo "Provider=".$Provider=$userprofile->Provider."<br>";
            
            }
          ?>

Note: Few providers like Twitter doesn't provide email address with User Profile data, so you need to handle these cases in your callback page.

Compltete SDK documentation: http://support.loginradius.com/customer/portal/articles/983629-php-sdk-documentation-to-access-loginradius-unified-social-api

These are the quick and easy steps to integrate Social Login on your PHP website, if you have any questions or need a further assistance please contact us at hello@loginradius.com.
