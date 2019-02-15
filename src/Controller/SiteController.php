<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();

// the URI being requested (e.g. /about) minus any query parameters
$request->getPathInfo();
class SiteController extends ApiController {
  
    /**
     * function to handle login view
     */
    public function index()
    {
    return $this->render('site/minimal.html.twig') ;
     
    }
    public function registrationview()
    {
    return $this->render('site/signup.html.twig') ;
     
    }
    public function loginScreenView()
    {
    return $this->render('site/loginscreen.html.twig') ;
     
    }
    public function forgotPasswordView()
    {
    return $this->render('site/forgotpassword.html.twig') ;
     
    }

    /**
     * handle login action
     */
    public function login(Request $request)
    {
       $action=$request->request->get('action');
        if(method_exists($this,$action))
           return $this->$action($request);
        else
        return $this->render('site/minimal.html.twig') ;
    }
    /**
     * login by email function
     */
    public function loginByEmail($request) {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
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
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
            }
        }
        return new Response(json_encode($response));  
      }
  /**
     * function to handle forgot password 
     */
    public function forgotPassword($request) {
        $email =$request->request->get('email');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->forgotPassword($email, $request->request->get('resetPasswordUrl'));
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
        return new Response(json_encode($response));
    }

     /**
      * function to verify email after registration
      */
    public function emailVerify($request) {
        $vtoken = $request->request->get('vtoken');
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
        return new Response(json_encode($response));
    }

    
    public function resetPassword($request){
        $token =  $request->request->get('resettoken');
        $password = $request->request->get('password');
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
       return new Response(json_encode($response));
    }

    public function mfaLogin($request) {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
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
       return new Response( json_encode($response));
    }
    
    /**
     * function for multifactor validation
     */
    public function mfaValidate($request) {
        $secondFactorAuthenticationToken = $request->request->get('secondFactorAuthenticationToken');
        $googleAuthCode = $request->request->get('googleAuthCode');
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
       return new Response( json_encode($response));
    }
    
    /**
     * function for password less login
     */

    public function pwLessLogin($request) {
        $email = $request->request->get('email');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->passwordLessLoginByEmail($email, $request->request->get('verificationurl'));
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
       return new Response( json_encode($response));
    }

    /**
     * function for password less link verify
     */
    public function pwLessLinkVerify($request) {
        $token =$request->request->get('token');
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
       return new Response( json_encode($response));
    }
     /**
      * function for registration
      */

    public function registration($request) {
        $email=$request->request->get('email');
        $password=$request->request->get('password');
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
    
                $result = $authenticationObj->registerByEmail($payload, $request->request->get('verificationurl'));
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
       return new Response( json_encode($response));
    }
}