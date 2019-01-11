<?php

require_once 'config.php';

use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;

function loginByEmail(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $password = isset($request['password']) ? trim($request['password']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email Id and Password are required fields.';
    } else {
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
    return json_encode($response);
}

function getProfile(array $request) {
    $token = isset($request['token']) ? trim($request['token']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($token)) {
        $response['message'] = 'Access Token is a required field.';
    }
    else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->getProfile($token);
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
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $payload = array('Email' => array(array('Type' => 'Primary', 'Value' => $email)), 'password' => $password);
            $result = $authenticationObj->registerByEmail($payload, $request['verificationurl']);
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
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->passwordLessLoginByEmail($email, $request['verificationurl']);
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
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->forgotPassword($email, $request['resetPasswordUrl']);
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
    return json_encode($response);
}

function pwLessLinkVerify(array $request) {
    $token = isset($request['token']) ? trim($request['token']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($token)) {
        $response['message'] = 'Token is a required field.';
    }
    else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->passwordLessLoginVerification($token);
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
    return json_encode($response);
}

function mfaLogin(array $request) {
    $email = isset($request['email']) ? trim($request['email']) : '';
    $password = isset($request['password']) ? trim($request['password']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($email) || empty($password)) {
        $response['message'] = 'Email Id and Password are required fields.';
    } else {
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $payload = array('email' => $email, 'password' => $password);
            $result = $authenticationObj->mfaEmailLogin($payload);
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
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $authenticationObj->mfaValidateGoogleAuthCode($secondFactorAuthenticationToken, $googleAuthCode);
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
