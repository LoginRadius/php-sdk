<?php 
class LoginRadius {
public $IsAuthenticated,$JsonResponse,$UserProfile; 
public function construct($ApiSecrete) {
$IsAuthenticated = false;
if(isset($_REQUEST['token'])) {
$ValidateUrl = "http://hub.loginradius.com/userprofile.ashx?token=".$_REQUEST['token']."&apisecrete=".$ApiSecrete."";
if(in_array('curl', get_loaded_extensions())) {
$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL, $ValidateUrl);
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 3);
curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, true);
if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
$JsonResponse = curl_exec($curl_handle);
}
else {
curl_setopt($curl_handle,CURLOPT_HEADER, 1);
$url = curl_getinfo($curl_handle,CURLINFO_EFFECTIVE_URL);
curl_close($curl_handle);
$ch=curl_init();
$url = str_replace('?','/?',$url);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$JsonResponse = curl_exec($ch);
curl_close($ch);
}
$UserProfile = json_decode($JsonResponse);
}
else if(ini_get('allow_url_fopen')== 1) {
$JsonResponse = file_get_contents($ValidateUrl);
$UserProfile = json_decode($JsonResponse);
}
else {
echo "Please check php.ini settings<br><b>cURL support = enabled <br>or<br>allow_url_fopen = On</b>";
}
if(isset($UserProfile->ID) && $UserProfile->ID!=''){ 
$this->IsAuthenticated = true;
return $UserProfile;
}}}}?>