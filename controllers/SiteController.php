<?php

namespace app\controllers;


use yii\web\Controller;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\SottAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PasswordLessLoginAPI;
class SiteController extends Controller
{

    public $enableCsrfValidation = false;
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays views
     */

     
    public function actionIndex()
    {

        $this->layout='minimallayout';
        return $this->render('minimalview');
    }

    public function actionLoginScreen()
    {

        $this->layout='minimallayout';
        return $this->render('loginscreen');
    }

    public function actionMinimal()
    {

        $this->layout='minimallayout';
        return $this->render('minimalview');
    }
    public function actionSignup()
    {

        $this->layout='minimallayout';
        return $this->render('signup');
    }
    public function actionForgot()
    {

        $this->layout='minimallayout';
        return $this->render('forgot');
    }

 /**
  * login action
  */
   public function actionLogin(){
        $data=$_POST['action'];
        $action="action".ucfirst($data);
        if(method_exists($this,$action))
        {
            $this->$action();
            exit;
        }
    }

    /**
     * js method
     */
     public function actionLoginByEmail(){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else if (empty($password)) {
            $response['message'] = 'The Password field is required.';
        }
        else {
            $authenticationObj = new AuthenticationAPI();
            
                $payload = array('email' => $email, 'password' => $password);
                $result = $authenticationObj->loginByEmail($payload);
                if (isset($result->access_token) && $result->access_token != '') {
                    $response['data'] = $result;
                    $response['message'] = "Logged in successfully";
                    $response['status'] = 'success';
                }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
        }
        
    echo json_encode($response);
    }


 public function actionMfaLogin() {

        $email = $_POST['email'];
        $password = $_POST['password'];
        $emailTemplate = '';//Optional
        $fields = ''; //Optional
        $loginUrl = ''; //Optional
        $smsTemplate = ''; //Optional
        $smsTemplate2FA = ''; //Optional
        $verificationUrl = ''; //Optional
        $emailTemplate2FA = ''; //Optional
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        }
        else {
            $authenticationObj = new MultiFactorAuthenticationAPI();
            
                $result = $authenticationObj->mfaLoginByEmail($email,$password, $emailTemplate, $fields, $loginUrl, $smsTemplate, $smsTemplate2FA, $verificationUrl, $emailTemplate2FA);
                $response['data'] = $result;
                $response['message'] = "Mfa login successfully";
                $response['status'] = 'success';
                if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
        }
        echo json_encode($response);
    }
    
    /**
     * function for multifactor validation
     */
    public function actionMfaValidate() {

        $secondFactorAuthenticationToken = $_POST['secondFactorAuthenticationToken'];
        $googleAuthCode = $_POST['googleAuthCode'];
        $fields = null; //Optional 
        $rbaBrowserEmailTemplate = ''; //Optional 
        $rbaCityEmailTemplate = ''; //Optional 
        $rbaCountryEmailTemplate = ''; //Optional 
        $rbaIpEmailTemplate = ''; //Optional
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($secondFactorAuthenticationToken)) {
            $response['message'] = 'second factor auth token is required';
        }
        elseif (empty($googleAuthCode)) {
            $response['message'] = 'google auth code is required';
        }
        else {
            $authenticationObj = new MultiFactorAuthenticationAPI();
          
                $result = $authenticationObj->mfaValidateGoogleAuthCode($googleAuthCode,$secondFactorAuthenticationToken,$fields,$rbaBrowserEmailTemplate,$rbaCityEmailTemplate,$rbaCountryEmailTemplate,$rbaIpEmailTemplate);
                if ((isset($result->access_token) && $result->access_token != '')) {
                    $response['data'] = $result;
                    $response['message'] = "Mfa validate google auth code.";
                    $response['status'] = 'success';
                }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
        }
        echo json_encode($response);
    }
    
    /**
     * function for password less login
     */

    public function actionPwLessLogin() {

        $email = $_POST['email'];
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else {
            $authenticationObj = new PasswordLessLoginAPI();
            
                $result = $authenticationObj->passwordLessLoginByEmail($email, $_POST['verificationurl']);
                if ((isset($result->IsPosted) && $result->IsPosted)) {
                    $response['message'] = "One time login link has been sent to your provided email id, check email for further instruction.";
                    $response['status'] = 'success';
                }
            
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
        }
        echo json_encode($response);
    }

    /**
     * function for password less link verify
     */
     public function actionPwLessLinkVerify() {

        $token =$_POST['token'];
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Token is required';
        }
        else {
            $authenticationObj = new PasswordLessLoginAPI();
            
                $result = $authenticationObj->passwordLessLoginVerification($token);
                if ((isset($result->access_token) && $result->access_token != '')) {
                    $response['data'] = $result;
                    $response['message'] = "Link has been verified.";
                    $response['status'] = 'success';
                }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
        }
        echo json_encode($response);
    }
    function actionEmailVerify() {

       
        $vtoken = $_POST['vtoken'];
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($vtoken)) {
            $response['message'] = 'Verification token is required';
        }
        else {
            $authenticationObj = new AuthenticationAPI();
            
                $result = $authenticationObj->verifyEmail($vtoken);
                if ((isset($result->IsPosted) && $result->IsPosted)) {
                    $response['message'] = "Your email has been verified successfully.";
                    $response['status'] = 'success';
                }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
        }
      echo json_encode($response);
    }
    public function actionRegistration() {
        $email=$_POST['email'];
        $password=$_POST['password'];
        $response = array('status' => 'error', 'message' => 'an error occoured');
    
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        }
        else {
    
            $authenticationObj = new AuthenticationAPI();
                $payload = array('Email' => array(array('Type' => 'Primary', 'Value' => $email)), 'password' => $password);
                $sottObj = new SottAPI();
                $sott = $sottObj->generateSott();
                
    
                if (!is_object($sott)) {
                    $sott = json_decode($sott);
                }
                $result = $authenticationObj->userRegistrationByEmail($payload, $sott->Sott, $_POST['verificationurl']);
                if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                    $response['result'] = $result;
                    $response['message'] = "You have successsfully registered.";
                    $response['status'] = 'success';
                }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
                else {
                    $response['message'] = "You have successfully registered, Please check your email.";
    
                    $response['status'] = 'registered';
                }
                
        }
        echo json_encode($response);
    }



    public function actionForgotPassword() {

       
        $email =$_POST['email'];
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else {
            $authenticationObj = new AuthenticationAPI();
            
                $result = $authenticationObj->forgotPassword($email, $_POST['resetPasswordUrl']);
                if ((isset($result->IsPosted) && $result->IsPosted)) {
                    $response['message'] = "We'll email you an instruction on how to reset your password";
                    $response['status'] = 'success';
                }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
        }
        echo json_encode($response);
    }
    public function actionResetPassword(){
        $token =  $_POST['resettoken'];
        $password = $_POST['password'];
       $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Reset token is required';
        }
        elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        }
        else {
            $authenticationObj = new AuthenticationAPI();
                $payload = array('password' => $password, 'resetToken' => $token);
                $result = $authenticationObj->resetPasswordByResetToken($payload);
                if ((isset($result->IsPosted) && $result->IsPosted)) {
                    $response['message'] = "Password has been reset successfully.";
                    $response['status'] = 'success';
                }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
        }
       echo json_encode($response);
    }


        
        


}
