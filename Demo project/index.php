<html>
<head>
<style type="text/css">
th, td{
	text-align:left;
	width:150px
}
table{
	border:1px solid black
}
</style>
</head>
<body>
<?php
if(!isset($_REQUEST['token'])){
	?>
	<div style="border:1px solid #000; width:200px; padding: 10px; margin-top:10px">
	// Change to your LoginRadius API key and Callback URL
	<script src="http://hub.loginradius.com/include/js/LoginRadius.js" ></script> <script type="text/javascript"> var options={}; options.login=true; LoginRadius_SocialLogin.util.ready(function () { $ui = LoginRadius_SocialLogin.lr_login_settings;$ui.interfacesize = "";$ui.apikey = "Your-LoginRadius-API-Key";$ui.callback=""; $ui.lrinterfacecontainer ="interfacecontainerdiv"; LoginRadius_SocialLogin.init(options); }); </script>
	<div class="interfacecontainerdiv"></div>
	</div>
	<?php
}else{
	include('LoginRadiusSDK.php');
	include('LoginRadiusStatusUpdate.php');
	include('LoginRadiusContacts.php');
	include('LoginRadiusCompany.php');
	include('LoginRadiusGroups.php');
	include('LoginRadiusMentions.php');
	include('LoginRadiusMessage.php');
	include('LoginRadiusPosts.php');
	include('LoginRadiusGetEvents.php');
	include('LoginRadiusGetStatus.php');
	// LoginRadius API secret
	$api_secret = 'Your-LoginRadius-API-Secret';
	$loginRadiusObject = new LoginRadiusContacts($api_secret);
	$userProfile = $loginRadiusObject->loginradius_get_data();
	if($loginRadiusObject->IsAuthenticated == TRUE){
	if($userProfile->Provider == "facebook" || $userProfile->Provider == "twitter" || $userProfile->Provider == "linkedin"){
		//update status
		$makepost = new LoginRadiusStatusUpdate($api_secret); 
		$updateStatus = $makepost->loginradius_post_status($to='', $title='LoginRadius PHP SDK', $url='http://loginradius.com/', $imageurl='http://loginradius.com/', $status='LoginRadius PHP SDK Test', $caption='LoginRadius PHP SDK', $description='LoginRadius PHP SDK Test');
	}
	if($userProfile->Provider == "linkedin"){
		//get company
		$getCompany = new LoginRadiusCompany($api_secret);
		$getCompany = $getCompany->loginradius_get_company();
	}
	//get contacts
	$getcontacts = new LoginRadiusContacts($api_secret);
    $getcontacts = $getcontacts->loginradius_get_contacts();
	if($userProfile->Provider == "facebook"){
		// get groups
		$getGroups = new LoginRadiusGroups($api_secret);
		$getGroups = $getGroups->loginradius_get_groups();
	}
	if($userProfile->Provider == "twitter" || $userProfile->Provider == "linkedin"){
		// send messages
		$sendMessage = new LoginRadiusMessage($api_secret);
		// Message to Sent - Please change ID, subject and message
		if(is_array($getcontacts) && count($getcontacts) > 0){
    		$sendMessage = $sendMessage->loginradius_send_message($getcontacts[0]->ID, 'LoginRadius PHP SDK Test', 'This message is sent using LoginRadius PHP SDK');
		}
	}
	if($userProfile->Provider == "facebook"){
		// get posts
		$getPosts = new LoginRadiusPosts($api_secret);
		$getPosts = $getPosts->loginradius_get_posts();
	}
	if($userProfile->Provider == "twitter"){
		// get Mentions
		$getMentions = new LoginRadiusMentions($api_secret);
		$getMentions = $getMentions->loginradius_get_mentions();
	}
	// get status
	$getStatus = new LoginRadiusGetStatus($api_secret);
    $getStatus = $getStatus->loginradius_get_status();
	if($userProfile->Provider == "facebook"){
		// get events
		$getEvents = new LoginRadiusGetEvents($api_secret);
		$getEvents = $getEvents->loginradius_get_events();
	}
		echo '<h2>User Profile Data</h2>';
		?>
		<table border='1'>
			<tr>
				<th valign="top">Social Avatar  </th>
				<th><img height="60" width="60" src="<?php echo $avatar = $userProfile->ThumbnailImageUrl; ?>" /></th>
			</tr>
			<tr>
				<th>Social ID  </th>
				<td><?php echo $id = $userProfile->ID ?></td>
			</tr>
			<tr>
				<th>Provider  </th>
				<td><?php echo $provider = ucfirst($userProfile->Provider) ?></td>
			</tr>
			<tr>
				<th>Prefix  </th>
				<td><?php echo $prefix = ucfirst($userProfile->Prefix) ?></td>
			</tr>
			<tr>
				<th>First Name  </th>
				<td><?php echo $fname = ucfirst($userProfile->FirstName) ?></td>
			</tr>
			<tr>
				<th>Last Name  </th>
				<td><?php echo $lname = ucfirst($userProfile->LastName) ?></td>
			</tr>
			<tr>
				<th>Suffix  </th>
				<td><?php echo $suffix = ucfirst($userProfile->Suffix) ?></td>
			</tr>
			<tr>
				<th>Full Name  </th>
				<td><?php echo $fullName = ucfirst($userProfile->FullName) ?></td>
			</tr>
			<tr>
				<th>Nickname  </th>
				<td><?php echo $nickName = ucfirst($userProfile->NickName) ?></td>
			</tr>
			<tr>
				<th>Profile Name  </th>
				<td><?php echo $profileName = $userProfile->ProfileName ?></td>
			</tr>
			<tr>
				<th>Birthdate  </th>
				<td><?php echo $birthDate = $userProfile->BirthDate ?></td>
			</tr>
			<tr>
				<th>Gender  </th>
				<td><?php 
					if($userProfile->Gender == 'F'){
						echo 'Female';	  
					}elseif($userProfile->Gender == 'M'){
						echo 'Male';
					}
					?>
				</td>
			</tr>
			<tr>
				<th>Email Type  </th>
				<td><?php echo $EmailType=isset($userProfile->Email[0]->Type)?$userProfile->Email[0]->Type:"" ?></td>
			</tr>
			<tr>
				<th>Email Value  </th>
				<td><?php echo $EmailValue=isset($userProfile->Email[0]->Value)?$userProfile->Email[0]->Value:$userProfile->Email ?></td>
			</tr>
			<tr>
				<th>Country Code  </th>
				<td><?php
					if(isset($userProfile->Country->Code) && is_string($userProfile->Country->Code)){  
						echo $userProfile->Country->Code."<br>";  
					}else{  
						echo '<br>';  
					}
					?>
				</th>
			</tr>
			<tr>
				<th>Country Name  </th>
				<th>
				<?php
				if(isset($userProfile->Country->Name) && is_string($userProfile->Country->Name)){  
					echo ucfirst($userProfile->Country->Name)."<br>";  
				}elseif(isset($userProfile->Country) && is_string($userProfile->Country) ){  
					echo $userProfile->Country."<br>";  
				}else{  
					echo '<br>';  
				}
				?>
				</th>
			</tr>
			<tr>
			// Enter the URL for your login page
				<td colspan="2"><a href="URL-for-login-page"><input type="button" value="Back to Social Login"  /></a></td>
			</tr>
		</table>
			<?php 
		if(isset($updateStatus)){
			if(!isset($updateStatus->errorcode)){
			echo '<h2>Status Post</h2>';?>
			<table>
			<tr>
				<th>Successful</th>
			</tr>
			<tr>
			<td><?php 
				if($updateStatus == 1){
					echo "Status successfully posted on your Facebook wall!";
				}
				?></td>
			</tr>
			</table>
			<?php
			}
		}
		if(isset($sendMessage) && is_array($getcontacts) && count($getcontacts) > 0){
			if(!isset($sendMessage->errorcode)){
			echo '<h2>Message Sending</h2>';?>
			<table>
			<tr>
				<th>Successful</th>
			</tr>
			<tr>
			<td><?php 
				if($sendMessage == true){
					echo "Message sent successfully to ".$getcontacts[0]->Name;
				}
				?></td>
			</tr>
			</table>
			<?php
			}
		}
		
		if(isset($getGroups)){
		if(!isset($getGroups->errorcode)){
		 echo '<h2>Groups</h2>';?>
		<table  border='1'>
		<tr>
			<th>S.No.</th>
		<th>ID</th>
		<th>Name</th>
		</tr>
		<?php 
		for($i=0;$i<sizeof($getGroups);$i++){
		?>
			<tr>
			<td><?php echo $i+1; ?></td>
				<td><?php echo $id = $getGroups[$i]->ID ?></td>
				<td><?php echo $provider = ucfirst($getGroups[$i]->Name) ?></td>
			</tr>
			<?php }?>
		</table>
		<?php 
		}
		}
		if(isset($getStatus)){
		if(!isset($getStatus->errorcode)){
		echo '<h2>Status</h2>';?>
		<table  border='1'>
		<tr>
		<th>ID</th>
		<th>Text</th>
		<th>DateTime</th>
		<th>Likes</th>
		<th>Place</th>
		<th>Source</th>
		<th>ImageUrl</th>
		<th>LinkUrl</th>
		</tr>
		<?php 
		for($i=0;$i<sizeof($getStatus);$i++){
		?>
			<tr>
				<td><?php echo $id = $getStatus[$i]->ID ?></td>
				<td><?php echo $provider = ucfirst($getStatus[$i]->Text) ?></td>
				<td><?php echo $Title = $getStatus[$i]->DateTime ?></td>
				<td><?php echo $StartTime = ucfirst($getStatus[$i]->Likes) ?></td>
				<td><?php echo $provider = ucfirst($getStatus[$i]->Place) ?></td>
				<td><?php echo $Message = ucfirst($getStatus[$i]->Source) ?></td>
				<td><?php echo $Place = ucfirst($getStatus[$i]->ImageUrl) ?></td>
				<td><?php echo $Share = ucfirst($getStatus[$i]->LinkUrl) ?></td>
			</tr>
			<?php }?>
		</table>
			<?php
			}
			}
		if(isset($getPosts)){
		if(!isset($getPosts->errorcode)){
	 echo '<h2>Posts</h2>';?>
		<table  border='1'>
		<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Title</th>
		<th>StartTime</th>
		<th>UpdateTime</th>
		<th>Message</th>
		<th>Place</th>
		<th>Picture</th>
		<th>Share</th>
		<th>Likes</th>
		</tr>
		<?php 
		for($i=0;$i<sizeof($getPosts);$i++){
		?>
			<tr>
				<td><?php echo $id = $getPosts[$i]->ID ?></td>
				<td><?php echo $provider = ucfirst($getPosts[$i]->Name) ?></td>
				<td><?php echo $Title = $getPosts[$i]->Title ?></td>
				<td><?php echo $StartTime = ucfirst($getPosts[$i]->StartTime) ?></td>
				<td><?php echo $provider = ucfirst($getPosts[$i]->UpdateTime) ?></td>
				<td><?php echo $Message = ucfirst($getPosts[$i]->Message) ?></td>
				<td><?php echo $Place = ucfirst($getPosts[$i]->Place) ?></td>
				<td><?php echo $Picture = ucfirst($getPosts[$i]->Picture) ?></td>
				<td><?php echo $Share = ucfirst($getPosts[$i]->Share) ?></td>
				<td><?php echo $Likes = ucfirst($getPosts[$i]->Likes) ?></td>
			</tr>
			<?php }?>
		</table>
				<?php
				}
				}
		if(isset($getEvents)){
		if(!isset($getEvents->errorcode)){
		 echo '<h2>Events</h2>';?>
		<table  border='1'>
		<tr>
		<th>ID</th>
		<th>Name</th>
		<th>StartTime</th>
		<th>RsvpStatus</th>
		<th>Location</th>
		</tr>
		<?php 
		for($i=0;$i<sizeof($getEvents);$i++){
		?>
			<tr>
				<td><?php echo $id = $getEvents[$i]->ID ?></td>
				<td><?php echo $provider = ucfirst($getEvents[$i]->Name) ?></td>
				<td><?php echo $StartTime = ucfirst($getEvents[$i]->StartTime) ?></td>
				<td><?php echo $provider = ucfirst($getEvents[$i]->RsvpStatus) ?></td>
				<td><?php echo $Message = ucfirst($getEvents[$i]->Location) ?></td>
			</tr>
			<?php }?>
		</table>
		<?php
		}
		}
		if(isset($getcontacts)){
	    if(!isset($getcontacts->errorcode)){
		 echo '<h2>Contacts</h2>';?>
		<table  border='1'>
		<tr>
		<th>Name</th>
		<th>EmailID</th>
		<th>PhoneNumber</th>
		<th>ID</th>
		<th>ProfileUrl</th>
		<th>ImageUrl</th>
		<th>Status</th>
		<th>Industry</th>
		<th>Country</th>
		<th>Gender</th>
		</tr>
		<?php
			for($i=0;$i<sizeof($getcontacts);$i++){
		?>
			<tr>
				<td><?php echo $provider = ucfirst($getcontacts[$i]->Name) ?></td>
				<td><?php echo $StartTime = ucfirst($getcontacts[$i]->EmailID) ?></td>
				<td><?php echo $provider = ucfirst($getcontacts[$i]->PhoneNumber) ?></td>
				<td><?php echo $Message = ucfirst($getcontacts[$i]->ID) ?></td>
					<td><?php echo $provider = ucfirst($getcontacts[$i]->ProfileUrl) ?></td>
				<td><?php echo $StartTime = ucfirst($getcontacts[$i]->ImageUrl) ?></td>
				<td><?php echo $provider = ucfirst($getcontacts[$i]->Status) ?></td>
				<td><?php echo $Message = ucfirst($getcontacts[$i]->Industry) ?></td>
					<td><?php echo $provider = ucfirst($getcontacts[$i]->Country) ?></td>
				<td><?php echo $Message = ucfirst($getcontacts[$i]->Gender) ?></td>
			</tr>
			<?php }?>
	</table>
	<?php
	}
	}
	if(isset($getMentions)){
	    if(!isset($getMentions->errorcode)){
		 echo '<h2>'.$userProfile->Provider.' Mentions</h2>';?>
		<table border='1'>
		<tr>
		<th>ID</th>
		<th>Message</th>
		<th>Date-Time</th>
		<th>Likes</th>
		<th>Place</th>
		<th>Source</th>
		<th>ImageUrl</th>
		<th>LinkUrl</th>
		<th>Person who mentioned</th>
		</tr>
		<?php
			for($i=0;$i<sizeof($getMentions);$i++){
		?>
			 <tr>
				<td><?php echo $ID = ucfirst($getMentions[$i]->ID) ?></td>
				<td><?php echo $text = ucfirst($getMentions[$i]->Text) ?></td>
				<td><?php echo $provider = ucfirst($getMentions[$i]->DateTime) ?></td>
				<td><?php echo $likes = ucfirst($getMentions[$i]->Likes) ?></td>
				<td><?php echo $place = ucfirst($getMentions[$i]->Place) ?></td>
				<td><?php echo $source = ucfirst($getMentions[$i]->Source) ?></td>
				<td><?php echo $imageUrl = ucfirst($getMentions[$i]->ImageUrl) ?></td>
				<td><?php echo $linkUrl = ucfirst($getMentions[$i]->LinkUrl) ?></td>
				<td><?php echo $name = ucfirst($getMentions[$i]->Name) ?></td>
			</tr>
			<?php }?>
	</table>
	<?php
	}
	}
	if(isset($getCompany)){
		if(!isset($getCompany->errorcode)){
				 echo '<h2>Company of '.$userProfile->Provider.'</h2>';?>
		<table  border='1'>
		<tr>
		<th>ID</th>
		<th>Name</th>
		</tr>
		<?php 
		for($i=0;$i<sizeof($getCompany);$i++){
		?>
			<tr>
				<td><?php echo $id = $getCompany[$i]->ID ?></td>
				<td><?php echo $provider = ucfirst($getCompany[$i]->Name) ?></td>
			</tr>
			<?php }?>
		</table>
	<?php
	}
	}
	}
}
?>
</body>
</html>