<?php

require_once 'config.php';
use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClientInterface;
use \LoginRadiusSDK\Clients\DefaultHttpClient;

use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\SottAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;

use \LoginRadiusSDK\CustomerRegistration\Advanced\ConfigurationAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\CustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\CustomRegistrationDataAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\WebHookAPI;

use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\OneTouchLoginAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PasswordLessLoginAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\PhoneAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\RiskBasedAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\SmartLoginAPI;

use \LoginRadiusSDK\CustomerRegistration\Social\NativeSocialAPI;
use \LoginRadiusSDK\CustomerRegistration\Social\SocialAPI;



function loginByEmail(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $password = isset($request['password']) ? trim($request['password']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email Id and Password are required fields.';
    } else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $loginByEmailAuthenticationModel = array('email' => $email, 'password' => $password);
            $result = $authenticationObj->loginByEmail($loginByEmailAuthenticationModel);
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
    return json_encode($response);
}

function getProfile(array $request) {
    $token = isset($request['token']) ? trim($request['token']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($token)) {
        $response['message'] = 'Access Token is a required field.';
    }
    else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $result = $authenticationObj->getProfileByAccessToken($token);
            if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                $response['data'] = $result;
                $response['message'] = "Profile successfully retrieved.";
                $response['status'] = 'success';
            }
            else {
                $response['message'] = "Email is not verified.";
                $response['status'] = 'error';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}

function registration(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $password = isset($request['password']) ? trim($request['password']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email Id and Password are required fields.';
    } else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $userprofileModel = array('Email' => array(array('Type' => 'Primary', 'Value' => $email)), 'password' => $password);
            $sottObj = new SottAPI();
            $sott = $sottObj->generateSott(10);

            if(!is_object($sott)) {
                $sott = json_decode($sott);
            }
            $emailTemplate = '';
            $fields = "";
            $verificationUrl = $request['verificationurl'];
            $welcomeEmailTemplate = '';

            $result = $authenticationObj->userRegistrationByEmail($userprofileModel, $sott->Sott, $emailTemplate, $fields, $verificationUrl, $welcomeEmailTemplate);
            if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                $response['result'] = $result;
                $response['message'] = "Successfully registered.";
                $response['status'] = 'success';
            } else {
                $response['message'] = "Successfully registered, please check your email to verify your account.";
                $response['status'] = 'registered';
            }
        }
        catch (LoginRadiusException $e) { 
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}

function pwLessLogin(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email)) {
        $response['message'] = 'Email Id is a required field.';
    }
    else {
        $authenticationObj = new PasswordLessLoginAPI();
        try {
            $verificationUrl = $request['verificationurl'];
            $passwordLessLoginTemplate = '';
            $result = $authenticationObj->passwordlessLoginByEmail($email, $passwordLessLoginTemplate, $verificationUrl);
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
    return json_encode($response);
}

function forgotPassword(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email)) {
        $response['message'] = 'Email Id is a required field.';
    }
    else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $result = $authenticationObj->forgotPassword($email, $request['resetPasswordUrl'], '');
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "An email has been sent to your address with instructions to reset your password.";
                $response['status'] = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}

function resetPassword(array $request) {
    $token = isset($request['resettoken']) ? trim($request['resettoken']) : '';
    $password = isset($request['password']) ? trim($request['password']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($token) || empty($password)) {
        $response['message'] = 'Password are required fields.';
    } else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $formData = ['resettoken' => $token, 'password' => $password, 'welcomeEmailTemplate' => '', 'resetPasswordEmailTemplate' => ''];
            $result = $authenticationObj->resetPasswordByResetToken($formData);
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
    return json_encode($response);
}

function pwLessLinkVerify(array $request) {
    $verificationToken = isset($request['token']) ? trim($request['token']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($verificationToken)) {
        $response['message'] = 'Token is a required field.';
    }
    else {
        $authenticationObj = new PasswordLessLoginAPI();
        try {
            $fields = '';
            $welcomeEmailTemplate = '';
            $result = $authenticationObj->passwordlessLoginVerification($verificationToken, $fields, $welcomeEmailTemplate);
            if ((isset($result->access_token) && $result->access_token != '')) {
                $response['data'] = $result;
                $response['message'] = "Link successfully verified.";
                $response['status'] = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}

function emailVerify(array $request) {
    $vtoken = isset($request['vtoken']) ? trim($request['vtoken']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($vtoken)) {
        $response['message'] = 'Verification Token is a required field.';
    }
    else {
        $authenticationObj = new AuthenticationAPI();
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
    return json_encode($response);
}

function mfaLogin(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $password = isset($request['password']) ? trim($request['password']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email Id and Password are required fields.';
    } else {
        $authenticationObj = new MultiFactorAuthenticationAPI();
        try {
            $payload = array('email' => $email, 'password' => $password);
            $emailTemplate = '';
            $fields = '';
            $loginUrl = '';
            $smsTemplate = '';
            $smsTemplate2FA = '';
            $verificationUrl = '';
            $result = $authenticationObj->mfaLoginByEmail($email, $password, $emailTemplate, $fields, $loginUrl, $smsTemplate, $smsTemplate2FA, $verificationUrl);
            $response['data'] = $result;
            $response['message'] = "Successful MFA Login.";
            $response['status'] = 'success';
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}

function mfaValidate(array $request) {
    $secondFactorAuthenticationToken = isset($request['secondFactorAuthenticationToken']) ? trim($request['secondFactorAuthenticationToken']) : '';
    $googleAuthCode = isset($request['googleAuthCode']) ? trim($request['googleAuthCode']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($secondFactorAuthenticationToken)) {
        $response['message'] = 'Second Factor Auth Token is a required field.';
    } else if (empty($googleAuthCode)) {
        $response['message'] = 'Google Auth Code is a required field.';
    } else {
        $authenticationObj = new MultiFactorAuthenticationAPI();
        try {
            $fields = '';
            $smsTemplate2FA = '';
            $result = $authenticationObj->mFAValidateGoogleAuthCode($googleAuthCode, $secondFactorAuthenticationToken, $fields, $smsTemplate2FA);
            if ((isset($result->access_token) && $result->access_token != '')) {
                $response['data'] = $result;
                $response['message'] = "Google Auth Code successfully validated.";
                $response['status'] = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = "error";
        }
    }
    return json_encode($response);
}
