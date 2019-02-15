<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;


class HomeController extends Controller
{

     
  /*
    *function to load view using routing

  */
    public function index()
    {
           return view('index');
    }
   
    public function loginscreen()
    {
           return view('loginscreen');
    }
    public function forgot()
    {
           return view('forgot');
    }
   
    public function changePassword()
    {
          return view('changepassword');
    }
    public function setPassword()
    {
           return view('setpassword');
    }
    public function account()
    {
           return view('account');
    }
    public function accountlinking()
    {
           return view('accountlinking');
    }
    public function customObjects()
    {
           return view('customobjects');
    }
    public function multifactor()
    {
           return view('multifactor');
    }

    public function roles()
    {
          return view('roles');
    }
    
    public function signup(Request $request)
    {
         $action =$request->input('action');
         if(method_exists($this,$action))
            $this->$action($request);   
         else
           return view('signup');
    }
   /** 
    *handle login operation
    * call to following function for login operation
    *loginByEmail()
    *mfaLogin()
    *mfaValidate()
    *pwLessLogin()
    *pwLessLinkVerify()
   */
    public function minimal(Request $request) {

       $action=$request->input('action');
       if(method_exists($this,$action))
          $this->$action($request);
       else 
       return view('index');
     
    }
     /**
      * function for login by email id
      */
    public function loginByEmail($request) {

        $email = $request->input('email');
        $password = $request->input('password');
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
    }
    /**
      * function for multifactor authentication
      */

    public function mfaLogin($request) {
        $email = $request->input('email');
        $password = $request->input('password');
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
    
    /**
     * function for multifactor validation
     */
    public function mfaValidate($request) {
        $secondFactorAuthenticationToken = $request->input('secondFactorAuthenticationToken');
        $googleAuthCode = $request->input('googleAuthCode');
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
    
    /**
     * function for password less login
     */

    public function pwLessLogin($request) {
        $email = $request->input('email');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->passwordLessLoginByEmail($email, $request->input('verificationurl'));
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

    /**
     * function for password less link verify
     */
    public function pwLessLinkVerify($request) {
        $token =$request->input('token');
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
    
        function emailVerify($request) {

       
        $vtoken = $request->input('vtoken');
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
     /**
      * function for registration
      */

    public function registration($request) {

        $email=$request->input('email');
        $password=$request->input('password');
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
    
                $result = $authenticationObj->registerByEmail($payload, $request->input('verificationurl'));
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
