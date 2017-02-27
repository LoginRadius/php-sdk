<?php
    include "config.php";
    include_once "functions.php";
    use LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
    use LoginRadiusSDK\CustomerRegistration\Management\AccountAPI;
    use LoginRadiusSDK\LoginRadiusException;
    $authenticationapi = new UserAPI(API_KEY, API_SECRET);
    $emailVerificationUrl  = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    $emailVerificationTemplate = '';
    $smsTemplate = '';
    $flag= '';
    $content ='';
    if(isset($_POST['register_submit'])){
        $v_email = $_POST['Email'];
        if(isset($_POST['Email'])){
            $emailid = $_POST['Email'];
            unset($_POST['Email']);
            $email = array(array('Type'=>'Primary', 'Value'=>$emailid));
            $_POST['Email'] = $email;
        }
        if(isset($_POST['CPassword']) && !empty($_POST['CPassword'])){
            unset($_POST['CPassword']);
        }
        $city = isset($_POST['City']) && !empty($_POST['City']) ? $_POST['City'] : null;
        $state = isset($_POST['State']) && !empty($_POST['State']) ? $_POST['State'] : null;
        $country = isset($_POST['Country']) && !empty($_POST['Country']) ? $_POST['Country'] : null;
        if(isset($_POST['Addresses'])){
            $postalcode = $_POST['Addresses'];
            unset($_POST['Addresses']);
            $postal = array(array(
                'Type'=>null,
                'Address1' => null,
                'Address2' => null,
                'City' => $city,
                'State' => $state,
                'PostalCode' => $postalcode,
                'Region' => null,
                'Country'=> $country
                ));
            $_POST['Addresses'] = $postal;
        }
        if(isset($_POST['Country'])){
            $coun = $_POST['Country'];
             unset($_POST['Country']);
             $count = array(
                'Code'=>"",
                'Name' => $coun
                );
            $_POST['Country'] = $count;
        }
        if(isset($_POST['PhoneNumbers'])){
            $phonenumber = $_POST['PhoneNumbers'];
            unset($_POST['PhoneNumbers']);
            $phone = array(array('PhoneType'=>'Mobile', 'PhoneNumber'=>$phonenumber));
            $_POST['PhoneNumbers'] = $phone;
        }
        foreach($_POST as $key => $postvalue){
            if(preg_match( "/^cf_/", $key)){
                $res = str_replace("cf_", "", $key);
                $custom_value[$res] = $_POST[$key];
                unset($_POST[$key]);
            }
        }
        if(isset($custom_value)){
            $_POST['CustomFields'] = $custom_value;
        }
        $userProfile = json_encode($_POST);
        try{
            $authenticationObjects = new \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
            try{
                $authenticationObjects->register($userProfile, $emailVerificationUrl, $emailVerificationTemplate, $smsTemplate);
                $message = 'A verification email has been sent to '.$v_email;
                $flag = 'success';
            }catch (LoginRadiusSDK\LoginRadiusException $e){
                $message = $e->getErrorResponse()->Description;
                $flag = 'error';
            }
        } catch(LoginRadiusSDK\LoginRadiusException $e){
            $message = $e->getErrorResponse()->Description;
            $flag = 'error';
        }
    }
    else if(isset($_GET['vtype']) && $_GET['vtype'] == 'emailverification' && !empty($_GET['vtoken'])){
        try{
            $result = json_decode($authenticationapi->verifyEmail($_GET['vtoken'], $emailVerificationUrl));
            if(isset($result->IsPosted) && $result->IsPosted) {
                $_SESSION['access_token'] = $result->Data->access_token;
                $_SESSION['userprofile'] = $result->Data->Profile;
                $_SESSION['mainprovider'] = $result->Data->Profile->Provider;
                if(isset($result->Data->access_token) && !empty($result->Data->access_token)){
                    $_SESSION['admin'] = 'login';
                    header("Location: profile.php");
                }
                else{
                    $message = 'Email Verified. Please Login';
                    $flag = 'success';
                }
            }
        }
        catch (LoginRadiusSDK\LoginRadiusException $e) {
            $message = $e->getErrorResponse()->Description;
            $flag = 'error';
        }
    }
    include("header.php");
?>
<div class="lr-form">
    <h2 class="text-center">LoginRadius Demo</h2>
    <?php
        echo '<div id="messageinfo" class="messageinfo '.$flag .'" >';
        if(isset($message) && !empty($message)){
            echo $message;
        }
        echo '</div>';
    ?>
    <div class="form-header">
        <h4>Register</h4>
    </div>
    <?php
    try {
        
        $validate_url = 'https://cdn.loginradius.com/raas/regSchema/' . API_KEY . '.json';
        //Object for Function API
        $utilityObject = new \LoginRadiusSDK\Utility\Functions(API_KEY, API_SECRET, array('output_format' => 'json'));
        $fieldJSONP = $utilityObject->apiClient($validate_url, FALSE, array('output_format' => 'json')); 
        $fields = json_decode(trim(trim($fieldJSONP, ')'), 'loginRadiusAppRaasSchemaJsonLoaded(')); 
        
        $content .= '<form method="POST" class="form-signin" role="form" action="">';
        if (isset($fields) && !empty($fields)) {
            foreach ($fields as $key => $field) {
                $myvalue = $field->rules;
                $arr = explode('|', trim($myvalue));
                if ($field->name == 'emailid') {
                    $name = 'Email';
                } elseif ($field->name == 'PostalCode') {
                    $name = 'Addresses';
                } elseif ($field->name == 'state') {
                    $name = 'State';
                } elseif ($field->name == 'city') {
                    $name = 'City';
                } elseif ($field->name == 'birthdate') {
                    $name = 'BirthDate';
                } elseif ($field->name == 'firstname') {
                    $name = 'FirstName';
                } elseif ($field->name == 'lastname') {
                    $name = 'LastName';
                } elseif ($field->name == 'country') {
                    $name = 'Country';
                } elseif ($field->name == 'gender') {
                    $name = 'Gender';
                } elseif ($field->name == 'phonenumber') {
                    $name = 'PhoneNumbers';
                } elseif ($field->name == 'prefix') {
                    $name = 'Prefix';
                } elseif ($field->name == 'suffix') {
                    $name = 'Suffix';
                } elseif ($field->name == 'username') {
                    $name = 'UserName';
                } elseif ($field->name == 'password') {
                    $name = 'Password';
                } elseif ($field->name == 'confirmpassword') {
                    $name = 'CPassword';
                } else {
                    if (preg_match("/^cf_/", $field->name)) {
                        $name = $field->name;
                    }
                }
                if ($field->type == 'text' || $field->type == 'string') {
                    $content .='<div class="form-group">';
                    $content .='<input type = "';
                    $content .= 'text" ';
                    $content .= 'name = "' . $name . '" ';
                    $content .= 'id = "' . $name . '" ';
                    foreach ($arr as $value) {
                        if ($value == 'required')
                            $content .= 'required';
                    }
                    $content .=' class="form-control" ';
                    $content .='placeholder="Enter '.$field->display.'" ';
                    $content .=' >';
                    $content .='</div>';
                }
                elseif ($field->type == 'option') {
                    $content .='<div class="form-group">';
                    $content .='<select name="' . $name . '" id= "' . $name . '" class="form-control" >';
                    foreach ($field->options as $key => $optionField) {
                        $content .='<option value ="' . $optionField->value . '" >' . $optionField->text . '</option>';
                    }
                    $content .='</select><br>';
                    $content .='</div>';
                } elseif ($field->type == 'password') {
                    $content .='<div class="form-group">';
                    $content .='<input type = "';
                    $content .= 'password" ';
                    $content .= 'name = "' . $name . '" ';
                    $content .= 'id = "' . $name . '" ';
                    foreach ($arr as $value) {
                        $pass_length = substr($value,0,9);
                        if ($value == 'required'){
                            $content .= 'required';
                        }
                        if($pass_length == 'min_lengt'){
                            $min_length = (null != intval(preg_replace('/[^0-9]+/', '', $value), 10)) ? intval(preg_replace('/[^0-9]+/', '', $value), 10) : 6;
                        }
                        if($pass_length == 'max_lengt'){
                            $max_length = (null != intval(preg_replace('/[^0-9]+/', '', $value), 10)) ? intval(preg_replace('/[^0-9]+/', '', $value), 10) : 32;
                        }
                        if( $name  == 'CPassword' ){
                            $content .= ' "matches[Password]" ';
                        }
                    }
                    $content .= ' minlength ="'.$min_length.'" maxlength="'.$max_length.'" ';
                    $content .=' class="form-control" ';
                    $content .='placeholder=" Enter '.$field->display.'" ';
                    $content .=' >';
                    $content .='</div>';
                }
            }
            $content .='</table>';
            $content .='<input type="submit" name="register_submit" class="btn btn-block bt-login" value ="Register" onClick="return validate_password_fields()">';
            $content .='<div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <i class="fa fa-lock"></i>
                                <a href="forgot_password.php"> Forgot password? </a>

                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <i class="fa fa-check"></i>
                                <a href="index.php"> Sign in </a>
                            </div>
                        </div>';
        }
        $content .='</form>';
        echo $content;
        }
        catch (LoginRadiusSDK\LoginRadiusException $e) {
            $message = $e->getErrorResponse()->Description;
        }
        ?>
    <br/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $( function() {
      $('#BirthDate').datepicker({
            dateFormat: 'dd-mm-yy',
            maxDate: new Date()
        });
    } );
    </script>
</div>
</div>
 <p>&nbsp; </p>
</body>
</html>
