<?php
defined('BASEPATH') or exit('No direct script access allowed');
use \LoginRadiusSDK\CustomerRegistration\Account\SottAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PasswordLessLoginAPI;

use \LoginRadiusSDK\LoginRadiusException;

class Welcome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
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
        if ($this->input->post('action') == "registration") {
            $this->registration();
        } else {
            $this->load->view('signup.php');
        }

    }

    /**
     *handle Lr default login

     */

    public function login()
    {

        $action = $this->input->post('action');
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            $this->load->view('index.php');
        }

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

        if ($this->input->post('action') == "loginByEmail") {
            $this->loginByEmail();
        } else if ($this->input->post('action') == "pwLessLogin") {
            $this->pwLessLogin();
        } else if ($this->input->post('action') == "mfaLogin") {
            $this->mfaLogin();
        } else if ($this->input->post('action') == "mfaValidate") {
            $this->mfaValidate();
        } else {
            $this->load->view('index.php');
        }

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
    public function loginByEmail()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {
            $authenticationObj = new AuthenticationAPI();

            try {
                $loginByEmailAuthenticationModel = array('email' => $email, 'password' => $password);

                $result = $authenticationObj->loginByEmail($loginByEmailAuthenticationModel);
                if (isset($result->access_token) && $result->access_token != '') {
                    $response['data'] = $result;
                    $response['message'] = "Logged in successfully";
                    $response['status'] = 'success';
                } else {
                    $response['message'] = "something went wrong";
                }

            } catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
            }
        }
        echo json_encode($response);
    }

    public function mfaLogin()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {
            $authenticationObj = new MultiFactorAuthenticationAPI(); 
            try {
                $emailTemplate = ""; //Optional 
                $fields = null; //Optional 
                $loginUrl = ""; //Optional 
                $smsTemplate = ""; //Optional 
                $smsTemplate2FA = ""; //Optional 
                $verificationUrl = ""; //Optional
                
                $result = $authenticationObj->mfaLoginByEmail($email,$password,$emailTemplate,$fields,$loginUrl,$smsTemplate,$smsTemplate2FA,$verificationUrl);
                $response['data'] = $result;
                $response['message'] = "Mfa login successfully";
                $response['status'] = 'success';
            } catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }

    public function mfaValidate()
    {
        $secondFactorAuthenticationToken = $this->input->post('secondFactorAuthenticationToken');
        $googleAuthCode = $this->input->post('googleAuthCode');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($secondFactorAuthenticationToken)) {
            $response['message'] = 'second factor auth token is required';
        } elseif (empty($googleAuthCode)) {
            $response['message'] = 'google auth code is required';
        } else {
            $authenticationObj = new MultiFactorAuthenticationAPI();
            try {
                $fields = '';
                $smsTemplate2FA = '';
                $result = $authenticationObj->mFAValidateGoogleAuthCode($googleAuthCode, $secondFactorAuthenticationToken, $fields, $smsTemplate2FA);
                if ((isset($result->access_token) && $result->access_token != '')) {
                    $response['data'] = $result;
                    $response['message'] = "Mfa validate google auth code.";
                    $response['status'] = 'success';
                }
            } catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }

    public function pwLessLogin()
    {
        $email = $this->input->post('email');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } else {
            $authenticationObj = new PasswordLessLoginAPI();
            try {
                $verificationUrl = $this->input->post('verificationurl');
                $passwordLessLoginTemplate = '';
                $result = $authenticationObj->passwordlessLoginByEmail($email, $passwordLessLoginTemplate, $verificationUrl);
                if ((isset($result->IsPosted) && $result->IsPosted)) {
                    $response['message'] = "One time login link has been sent to your provided email id, check email for further instruction.";
                    $response['status'] = 'success';
                }
            } catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
    public function pwLessLinkVerify()
    {
        $token = $this->input->post('token');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Token is required';
        } else {
            $authenticationObj = new PasswordLessLoginAPI();
            try {
                $fields = '';
                $welcomeEmailTemplate = '';
                $result = $authenticationObj->passwordlessLoginVerification($verificationToken, $fields, $welcomeEmailTemplate);
                if ((isset($result->access_token) && $result->access_token != '')) {
                    $response['data'] = $result;
                    $response['message'] = "Link has been verified.";
                    $response['status'] = 'success';
                }
            } catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
    public function emailVerify()
    {
        $vtoken = $this->input->post('vtoken');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($vtoken)) {
            $response['message'] = 'Verification token is required';
        } else {
            $authenticationObj = new AuthenticationAPI();
            try {
                $result = $authenticationObj->verifyEmail($vtoken);
                if ((isset($result->IsPosted) && $result->IsPosted)) {
                    $response['message'] = "Your email has been verified successfully.";
                    $response['status'] = 'success';
                }
            } catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }

    public function forgotPassword()
    {
        $email = $this->input->post('email');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } else {
            $authenticationObj = new AuthenticationAPI();
            try {
                $result = $authenticationObj->forgotPassword($email, $request['resetPasswordUrl'], '');
                if ((isset($result->IsPosted) && $result->IsPosted)) {
                    $response['message'] = "We'll email you an instruction on how to reset your password";
                    $response['status'] = 'success';
                }
            } catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
/**
 *handle registration process
 */

    public function registration()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');

        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {

            $authenticationObj = new AuthenticationAPI();
            try {
                $userprofileModel = array('Email' => array(array('Type' => 'Primary', 'Value' => $email)), 'password' => $password);
                $sottObj = new SottAPI();
                $sott = $sottObj->generateSott(10);

                if (!is_object($sott)) {
                    $sott = json_decode($sott);
                }
                $emailTemplate = '';
                $fields = "";
                $verificationUrl = $this->input->post('verificationurl');
                $welcomeEmailTemplate = '';

                $result = $authenticationObj->userRegistrationByEmail($userprofileModel, $sott->Sott, $emailTemplate, $fields, $verificationUrl, $welcomeEmailTemplate);
                if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                    $response['result'] = $result;
                    $response['message'] = "You have successfully registered.";
                    $response['status'] = 'success';
                } else {
                    $response['message'] = "You have successfully registered, Please check your email.";

                    $response['status'] = 'registered';
                }
            } catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
}
