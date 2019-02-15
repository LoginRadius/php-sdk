<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
class Welcome extends CI_Controller {



    function __construct()
    {
       parent:: __construct();
       $this->load->helper('url');
       config();

    }
    
    /**
    *load main login screen
  
    */

    public function index()
    {

        $this->load->view('index.php');

    }
    public function loginScreen()
    {

        $this->load->view('loginscreen.php');

    }
    /**
     *handle signup
  
    */
    public function signup()

    /**
      *call to function used in profile according to action
      *registration()
    */
    {
        if($this->input->post('action')=="registration")
            $this->registration();
          
        else

          $this->load->view('signup.php');
    }
  
  
    /**
      *handle Lr default login 
      
    */ 

    public function login()
    {  

        $action=$this->input->post('action');
       if(method_exists($this,$action))
         $this->$action();
       else
         $this->load->view('index.php');
        }

    /**
      *handle traditional login process
    */ 

  public function minimal()
  {


    /**
      *call to function used in login according to action
      *loginByEmail()
      *pwLessLogin()
      *mfaLogin()
      *mfaValidate()
    */ 

     if($this->input->post('action')=="loginByEmail")
        $this->loginByEmail();
      else if($this->input->post('action')=="pwLessLogin")
        $this->pwLessLogin();
      else if($this->input->post('action')=="mfaLogin")
        $this->mfaLogin();
      else if($this->input->post('action')=="mfaValidate")
        $this->mfaValidate();
    else
        $this->load->view('index.php');

}


    /**
      *load change password view
    */
public function changePassword()
{
 $this->load->view('changepassword.php');


}
/**
      *load set password view
    */
public function setPassword()
{
 $this->load->view('setpassword.php');


}
/**
      *load account view
    */
public function account()
{
 $this->load->view('account.php');


}
/**
      *load accountlinking view
    */
public function accountLinking()
{
    $this->load->view('accountlinking.php');

}
/**
      *load custom object view
    */
public function customObjects()
{
    $this->load->view('customObjects.php');

}
/**
      *load  resetMultifactor view
    */
public function resetMultifactor()
{
    $this->load->view('multifactor.php');

}
/**
      *load  roles view
    */
public function roles()
{


    $this->load->view('roles.php');

}
/**
      *load  forgot password view
    */
public function forgot()
{
    $this->load->view('forgot.php');

}



/*function to  handle login operation*/
function loginByEmail() {
    $email=$this->input->post('email');
    $password=$this->input->post('password');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($email)) {
        $response['message'] = 'The Email Id field is required.';
    }
    elseif (empty($password)) {
        $response['message'] = 'The Password field is required.';
    }
    else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $payload = array('email' => $email, 'password' => $password);
            $result = $authenticationObj->authLoginByEmail($payload);
            if (isset($result->access_token) && $result->access_token != '') {
                $response['data'] = $result;
                $response['message'] = "Logged in successfully";
                $response['status'] = 'success';
            }else {
                $response['message'] = "something went wrong";
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
        }
    }
    echo json_encode($response);
}


function mfaLogin() {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($email)) {
        $response['message'] = 'The Email Id field is required.';
    }
    elseif (empty($password)) {
        $response['message'] = 'The Password field is required.';
    }
    else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $payload = array('email' => $email, 'password' => $password);
            $result = $authenticationObj->mfaEmailLogin($payload);
            $response['data'] = $result;
            $response['message'] = "Mfa login successfully";
            $response['status'] = 'success';
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    echo json_encode($response);
}


function mfaValidate() {
    $secondFactorAuthenticationToken = $this->input->post('secondFactorAuthenticationToken');
    $googleAuthCode = $this->input->post('googleAuthCode');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($secondFactorAuthenticationToken)) {
        $response['message'] = 'second factor auth token is required';
    }
    elseif (empty($googleAuthCode)) {
        $response['message'] = 'google auth code is required';
    }
    else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->mfaValidateGoogleAuthCode($secondFactorAuthenticationToken, $googleAuthCode);
            if ((isset($result->access_token) && $result->access_token != '')) {
                $response['data'] = $result;
                $response['message'] = "Mfa validate google auth code.";
                $response['status'] = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    echo json_encode($response);
}


function pwLessLogin() {
    $email = $this->input->post('email');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($email)) {
        $response['message'] = 'The Email Id field is required.';
    }
    else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->passwordLessLoginByEmail($email, $this->input->post('verificationurl'));
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "One time login link has been sent to your provided email id, check email for further instruction.";
                $response['status'] = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    echo json_encode($response);
}
function pwLessLinkVerify() {
    $token =$this->input->post('token');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($token)) {
        $response['message'] = 'Token is required';
    }
    else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->passwordLessLoginVerification($token);
            if ((isset($result->access_token) && $result->access_token != '')) {
                $response['data'] = $result;
                $response['message'] = "Link has been verified.";
                $response['status'] = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    echo json_encode($response);
}
function emailVerify() {
    $vtoken = $this->input->post('vtoken');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($vtoken)) {
        $response['message'] = 'Verification token is required';
    }
    else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->verifyEmail($vtoken);
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "Your email has been verified successfully.";
                $response['status'] = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    echo json_encode($response);
}

function forgotPassword() {
  $email = $this->input->post('email');
  $response = array('status' => 'error', 'message' => 'an error occoured');
  if (empty($email)) {
    $response['message'] = 'The Email Id field is required.';
}
else {
    $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    try {
        $result = $authenticationObj->forgotPassword($email, $this->input->post('resetPasswordUrl'));
        if ((isset($result->IsPosted) && $result->IsPosted)) {
            $response['message'] = "We'll email you an instruction on how to reset your password";
            $response['status'] = 'success';
        }
    }
    catch (LoginRadiusException $e) {
        $response['message'] = $e->error_response->Description;
        $response['status'] = "error";
    }
}
echo json_encode($response);
}
/**
      *handle registration process
    */

 function registration() {

    $email=$this->input->post('email');
    $password=$this->input->post('password');
    $response = array('status' => 'error', 'message' => 'an error occoured');

    if (empty($email)) {
        $response['message'] = 'The Email Id field is required.';
    }
    elseif (empty($password)) {
        $response['message'] = 'The Password field is required.';
    }
    else {


        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $payload = array('Email' => array(array('Type' => 'Primary', 'Value' => $email)), 'password' => $password);

            $result = $authenticationObj->registerByEmail($payload, $this->input->post('verificationurl'));
            if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                $response['result'] = $result;
                $response['message'] = "You have successfully registered.";
                $response['status'] = 'success';
            }
            else {
                $response['message'] = "You have successfully registered, Please check your email.";

                $response['status'] = 'registered';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    echo json_encode($response);
}
}
