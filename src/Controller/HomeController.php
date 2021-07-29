<?php

namespace App\Controller;

use App\Controller\AppController;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\CustomerRegistration\Account\SottAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PasswordLessLoginAPI;


class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('minimallayout');
    }
    public function minimal()
    {
    }
    public function loginScreen()
    {
    }
    public function registrationView()
    {
    }
    public function forgotPasswordView()
    {
    }
    /**
     * manage all login action
     */
    public function login()
    {
        $this->autoRender = false;
        $action = $this->request->getdata('action');
        if (method_exists($this, $action)) {
            $this->$action();
        }
    }
    /**
     * function  for login by email
     */
    public function loginByEmail()
    {
        $this->autoRender = false;
        $email = $this->request->getdata('email');
        $password = $this->request->getdata('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } else if (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {
            $authenticationAPI  = new AuthenticationAPI();
            $payload = array('email' => $email, 'password' => $password);
            $result = $authenticationAPI->loginByEmail($payload);
            if (isset($result->access_token) && $result->access_token != '') {
                $response['data'] = $result;
                $response['message'] = "Logged in successfully";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
        exit;
    }

    /**
     * function for multifactor authentication
     */

    public function mfaLogin()
    {

        $email = $this->request->getdata('email');
        $password = $this->request->getdata('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {
            $authenticationAPI  = new MultiFactorAuthenticationAPI();

            //$payload = array('email' => $email, 'password' => $password); No need of payload in this API
            $result = $authenticationAPI->mfaLoginByEmail($email, $password);
            $response['data'] = $result;
            $response['message'] = "Mfa login successfully";
            $response['status'] = 'success';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * function for multifactor validation
     */
    public function mfaValidate()
    {

        $secondFactorAuthenticationToken = $this->request->getdata('secondFactorAuthenticationToken');
        $googleAuthCode = $this->request->getdata('googleAuthCode');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($secondFactorAuthenticationToken)) {
            $response['message'] = 'second factor auth token is required';
        } elseif (empty($googleAuthCode)) {
            $response['message'] = 'google auth code is required';
        } else {
            $authenticationAPI  = new MultiFactorAuthenticationAPI();

            $result = $authenticationAPI->mfaValidateGoogleAuthCode($googleAuthCode,$secondFactorAuthenticationToken);
            if ((isset($result->access_token) && $result->access_token != '')) {
                $response['data'] = $result;
                $response['message'] = "Mfa validate google auth code.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
        exit;
    }

    /**
     * function for password less login
     */

    public function pwLessLogin()
    {

        $email = $this->request->getdata('email');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } else {
            $authenticationAPI  = new PasswordLessLoginAPI();

            $result = $authenticationAPI->passwordLessLoginByEmail($email, $this->request->getdata('verificationurl'));
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "One time login link has been sent to your provided email id, check email for further instruction.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
        exit;
    }

    /**
     * function for password less link verify
     */
    public function pwLessLinkVerify()
    {

        $token = $this->request->getdata('token');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Token is required';
        } else {
            $passwordLessLoginAPI  = new PasswordLessLoginAPI();

            $result = $passwordLessLoginAPI->passwordLessLoginVerification($token);
            if ((isset($result->access_token) && $result->access_token != '')) {
                $response['data'] = $result;
                $response['message'] = "Link has been verified.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
        exit;
    }
    function emailVerify()
    {

        $this->autoRender = false;
        $vtoken = $this->request->getdata('vtoken');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($vtoken)) {
            $response['message'] = 'Verification token is required';
        } else {
            $authenticationAPI  = new AuthenticationAPI();

            $result = $authenticationAPI->verifyEmail($vtoken);
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "Your email has been verified successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
        exit;
    }
    public function registration()
    {

        $this->autoRender = false;
        $email = $this->request->getdata('email');
        $password = $this->request->getdata('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');

        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {

            $authenticationAPI  = new AuthenticationAPI();

            $payload = array('Email' => array(array('Type' => 'Primary', 'Value' => $email)), 'password' => $password);
            $sottObj = new SottAPI();
            $sott = $sottObj->generateSott();
            

            if (!is_object($sott)) {
                $sott = json_decode($sott);
            }
            $verificationUrl=$this->request->getdata('verificationUrl');

            $result = $authenticationAPI->userRegistrationByEmail($payload, $sott->Sott,$verificationUrl );
            
            if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                $response['result'] = $result;
                $response['message'] = "Successfully registered.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            } else {
                $response['message'] = "Successfully registered, please check your email to verify your account.";
                $response['status'] = 'registered';
            }
        }
        echo json_encode($response);
    }



    public function forgotPassword()
    {

        $this->autoRender = false;
        $email = $this->request->getdata('email');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } else {
            $authenticationAPI  = new AuthenticationAPI();

            $result = $authenticationAPI->forgotPassword($email, $this->request->getdata('resetPasswordUrl'));
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "We'll email you an instruction on how to reset your password";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
    public function resetPassword()
    {
        $this->autoRender = false;
        $token =  $this->request->getdata('resettoken');
        $password = $this->request->getdata('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Reset token is required';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {
            $authenticationAPI  = new AuthenticationAPI();

            $payload = array('password' => $password, 'resetToken' => $token);
            $result = $authenticationAPI->resetPasswordByResetToken($payload);
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "Password has been reset successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
}
