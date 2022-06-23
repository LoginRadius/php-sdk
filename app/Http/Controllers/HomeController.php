<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\SottAPI;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PasswordLessLoginAPI;

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
        $action = $request->input('action');
        if (method_exists($this, $action)) {
            $this->$action($request);
        } else {
            return view('signup');
        }

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
    public function minimal(Request $request)
    {

        $action = $request->input('action');
        if (method_exists($this, $action)) {
            $this->$action($request);
        } else {
            return view('index');
        }

    }
    /**
     * function for login by email id
     */
    public function loginByEmail($request)
    {

        $email = $request->input('email');
        $password = $request->input('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } else if (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {
            $authenticationObj = new AuthenticationAPI();
            $loginByEmailAuthenticationModel = array('email' => $email, 'password' => $password);
            $result = $authenticationObj->loginByEmail($loginByEmailAuthenticationModel);
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
    }
    /**
     * function for multifactor authentication
     */

    public function mfaLogin($request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {
            $authenticationObj = new MultiFactorAuthenticationAPI();

            $payload = array('email' => $email, 'password' => $password);
            $emailTemplate = '';//Optional
            $fields = ''; //Optional
            $loginUrl = ''; //Optional
            $smsTemplate = ''; //Optional
            $smsTemplate2FA = ''; //Optional
            $verificationUrl = ''; //Optional
            $emailTemplate2FA = ''; //Optional
            $result = $authenticationObj->mfaLoginByEmail($email, $password, $emailTemplate, $fields, $loginUrl, $smsTemplate, $smsTemplate2FA, $verificationUrl, $emailTemplate2FA);

            if (isset($result->Profile) || isset($result->SecondFactorAuthentication)) {
                $response['data'] = $result;
                $response['message'] = "Successful MFA Login.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode( $response);
    }

    /**
     * function for multifactor validation
     */
    public function mfaValidate($request)
    {
        $secondFactorAuthenticationToken = $request->input('secondFactorAuthenticationToken');
        $googleAuthCode = $request->input('googleAuthCode');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($secondFactorAuthenticationToken)) {
            $response['message'] = 'second factor auth token is required';
        } elseif (empty($googleAuthCode)) {
            $response['message'] = 'google auth code is required';
        } else {
            $authenticationObj = new MultiFactorAuthenticationAPI();
            $fields = '';
            $rbaBrowserEmailTemplate = ''; //Optional 
            $rbaCityEmailTemplate = ''; //Optional 
            $rbaCountryEmailTemplate = ''; //Optional 
            $rbaIpEmailTemplate = ''; //Optional
            $result = $authenticationObj->mFAValidateGoogleAuthCode($googleAuthCode, $secondFactorAuthenticationToken, $fields, $rbaBrowserEmailTemplate, $rbaCityEmailTemplate, $rbaCountryEmailTemplate, $rbaIpEmailTemplate);
            if ((isset($result->access_token) && $result->access_token != '')) {
                $response['data'] = $result;
                $response['message'] = "Google Auth Code successfully validated.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }

    /**
     * function for password less login
     */

    public function pwLessLogin($request)
    {
        $email = $request->input('email');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } else {
            $authenticationObj = new PasswordLessLoginAPI();

            $verificationUrl = $request->input('verificationurl');
            $passwordLessLoginTemplate = '';
            $result = $authenticationObj->passwordlessLoginByEmail($email, $passwordLessLoginTemplate, $verificationUrl);
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "One time login link has been sent to your provided email id, check email for further instruction.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }

        }
        echo json_encode($response);
    }

    /**
     * function for password less link verify
     */
    public function pwLessLinkVerify($request)
    {
        $token = $request->input('token');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Token is required';
        } else {
            $authenticationObj = new PasswordLessLoginAPI();
            $fields = '';
            $welcomeEmailTemplate = '';
            $result = $authenticationObj->passwordlessLoginVerification($token, $fields, $welcomeEmailTemplate);
            if ((isset($result->access_token) && $result->access_token != '')) {
                $response['data'] = $result;
                $response['message'] = "Link successfully verified.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }

        }
        echo json_encode($response);
    }

    public function emailVerify($request)
    {

        $vtoken = $request->input('vtoken');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($vtoken)) {
            $response['message'] = 'Verification token is required';
        } else {
            $authenticationObj = new AuthenticationAPI();
            $result = $authenticationObj->verifyEmail($vtoken);
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "Your email has been verified successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }

        }
        echo json_encode($response);
    }
    /**
     * function for registration
     */

    public function registration($request)
    {

        $email = $request->input('email');
        $password = $request->input('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');

        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {

            $authenticationObj = new AuthenticationAPI();
            $userprofileModel = array('Email' => array(array('Type' => 'Primary', 'Value' => $email)), 'password' => $password);
            $sottObj = new SottAPI();
            $sott = $sottObj->generateSott(10);

            if (!is_object($sott)) {
                $sott = json_decode($sott);
            }
            $emailTemplate = '';
            $fields = "";
            $verificationUrl = $request->input('verificationurl');
            $welcomeEmailTemplate = '';
            $options = null; //Optional 
            $result = $authenticationObj->userRegistrationByEmail($userprofileModel, $sott->Sott, $emailTemplate, $fields, $options,$verificationUrl, $welcomeEmailTemplate);
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

}
