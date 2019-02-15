<?php

namespace App\Controller;
Use App\Controller\AppController;
use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;

class HomeController extends AppController{
    public function initialize()
        {
            parent::initialize();
            $this->viewBuilder()->setLayout('minimallayout');
        
        }
    public function minimal(){}
    public function loginScreen(){}
    public function registrationView(){}
    public function forgotPasswordView(){}
    /**
     * manage all login action
     */
    public function login() {
        $this->autoRender=false;
        $action=$this->request->data('action');
        if(method_exists($this,$action))
        {
            $this->$action();
            
        }
}
    /**
      * function  for login by email
      */
public function loginByEmail()
{
        $this->autoRender = false;
        $email = $this->request->data('email');
        $password = $this->request->data('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else if (empty($password)) {
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
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
            }
        }
       
        echo json_encode($response);
        exit;
}

     /**
      * function for multifactor authentication
      */

      public function mfaLogin() {

        $email = $this->request->data('email');
        $password = $this->request->data('password');
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
        exit;
    }
    
    /**
     * function for multifactor validation
     */
    public function mfaValidate() {

        $secondFactorAuthenticationToken = $this->request->data('secondFactorAuthenticationToken');
        $googleAuthCode = $this->request->data('googleAuthCode');
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
        exit;
    }
    
    /**
     * function for password less login
     */

    public function pwLessLogin() {

        $email = $this->request->data('email');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->passwordLessLoginByEmail($email, $this->request->data('verificationurl'));
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
        exit;
    }

    /**
     * function for password less link verify
     */
     public function pwLessLinkVerify() {

        $token =$this->request->data('token');
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
        exit;
    }
    function emailVerify() {

        $this->autoRender=false;
        $vtoken = $this->request->data('vtoken');
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
      exit;
    }
    public function registration() {

        $this->autoRender=false;
        $email=$this->request->data('email');
        $password=$this->request->data('password');
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
    
                $result = $authenticationObj->registerByEmail($payload, $this->request->data('verificationurl'));
                if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                    $response['result'] = $result;
                    $response['message'] = "You have successsfully registered.";
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



    public function forgotPassword() {

        $this->autoRender=false;
        $email =$this->request->data('email');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->forgotPassword($email, $this->request->data('resetPasswordUrl'));
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
    public function resetPassword(){

        $this->autoRender=false;
        $token =  $this->request->data('resettoken');
        $password = $this->request->data('password');
       $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Reset token is required';
        }
        elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->resetPassword($token, $password);
                if ((isset($result->IsPosted) && $result->IsPosted)) {
                    $response['message'] = "Password has been reset successfully.";
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

}


?>