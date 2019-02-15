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
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthCustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;
class Profile extends Controller
{

    /**
     * handle profile operation
    
     */
    public function profile(Request $request)
    {
        $action=$request->input('action');
        if(method_exists($this,$action))
            $this->$action($request);
        else
            return view('profile');          
    }
    /**
     * function to fetch profile info  by uid
     */
    public function getProfileByUid($request) {
        $uid = $request->input('uid');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($uid)) {
            $response['message'] = 'uid is required field';
        }
        else {
    
            $accountObj = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $accountObj->getProfileByUid($uid);
                if ((isset($result->Uid) && $result->Uid != '')) {
                    $response['data'] = $result;
                    
                    $response['message'] = "fetched profile";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->getMessage();
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }

    /**
     * function to fetch info of profile
     */
    public function getProfile($request) {
         
        $token= $request->input('token');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Token is required';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->getProfile($token);
                if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                    $response['data'] = $result;
                    $response['message'] = "Profile fetched";
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
       echo json_encode($response);
    }
     /**
      * function to change password
      */


    public function changePassword($request) {
        $token =$request->input('token');
        $oldpassword =$request->input('oldpassword');
        $newpassword =$request->input('newpassword');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($oldpassword)) {
            $response['message'] = 'Old password is required';
        }
        elseif (empty($newpassword)) {
            $response['message'] = 'New password is required';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
            try {
                $result = $authenticationObj->changeAccountPassword($token, $oldpassword, $newpassword);
                if (isset($result->IsPosted) && $result->IsPosted) {
                    $response['message'] = "Password has been changed successfully.";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
      echo json_encode($response);
    }
    /**
     * function to set account password
     */
    public function setPassword($request) {
        $uid = $request->input('uid');
        $newpassword =$request->input('newpassword');        
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($newpassword)) {
            $response['message'] = 'New password field is required';
        }
        else {
            $accountObj = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $accountObj->setPassword($uid, $newpassword);
                if (isset($result->PasswordHash) && $result->PasswordHash != '') {
                    $response['message'] = "The password has been set successfully.";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
        echo json_encode($response);
    }

    /**
     * function to handle forgot password 
     */
    public function forgotPassword($request) {
        $email =$request->input('email');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->forgotPassword($email, $request->input('resetPasswordUrl'));
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
      * function to reset password
      */
    public function resetPassword($request){
        $token =  $request->input('resettoken');
        $password = $request->input('password');
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
     /**
      * function to update account
      */
    public function updateAccount($request) {
        $firstname =$request->input('firstname');
        $lastname =$request->input('lastname');
        $about = $request->input('about');
        $response = array('status' => 'error', 'message' => 'an error occoured');
    
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
        try {
            $payload = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);
    
            $result = $authenticationObj->updateProfile($request->input('token'), $payload);
            if (isset($result->IsPosted) && $result->IsPosted) {
                
                $response['message'] = "Profile has been updated successfully.";
                $response['status'] = 'success';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = 'error';
        }
        echo json_encode($response);
    }
    
    /**
     * function to create custom pbject
     */
    public function createCustomObjects($request) {
        $token=$request->input('token');
        $objectName = $request->input('objectName');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required.';
        }
        else {
            $customObj = new AuthCustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
           
            try {
                
                $result = $customObj->createCustomObject($token, $objectName, $request->input('payload'));
                
               
                if (isset($result->Uid) && $result->Uid != '') {
                    
                    $response['message'] = "Custom object created successfully.";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
        echo json_encode($response);
    }
    
    /**
       *function  to get custom object
      
      */
    public function getCustomObjects($request) {
        $token=$request->input('token');
        $objectName = $request->input('objectName');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required.';
        }
        else {
            $customObj = new AuthCustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $customObj->getCustomObjectSetsByToken($token, $objectName);
                if (isset($result->Count) && $result->Count != '0') {
                    $response['result'] = $result;
                    $response['status'] = 'success';
                }
                else {
                    $response['status'] = 'empty';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
        echo json_encode($response);
    }
    /**
       *function to update custom object
      
      */
    
    public function updateCustomObjects($request) {
        $token=$request->input('token');
        $objectName = $request->input('objectName');
        $objectRecordId = $request->input('objectRecordId');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required';
        }
        elseif (empty($objectRecordId)) {
            $response['message'] = 'Object Id is required';
        }
        else {
            $customObj = new AuthCustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $customObj->updateCustomObjectData($token, $objectName, $objectRecordId, 'replace', $request->input('payload'));
                
                if (isset($result->Uid) && $result->Uid != '') {
                    $response['message'] = "Custom object updated successfully.";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
       echo json_encode($response);
    }
    /**
       *function to delete custom object
      
      */
    public function deleteCustomObjects($request) {
        $token=$request->input('token');
        $objectName = $request->input('objectName');
        $objectRecordId =$request->input('objectRecordId');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required';
        }
        elseif (empty($objectRecordId)) {
            $response['message'] = 'Object Id is required';
        }
        else {
            $customObj = new AuthCustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $customObj->deleteCustomObjectSet($token, $objectName, $objectRecordId);
                if (isset($result->IsDeleted) && $result->IsDeleted) {
                    $response['message'] = "Custom object deleted successfully.";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
        echo json_encode($response);
    }
    /**
     * function to reset multi factor authentication
     */
    public function resetMultifactor($request) {
        $accountObj = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $accountObj->mfaResetGoogleAuthenticatorByUid($request->input('uid'), true);
            if (isset($result->IsDeleted) && $result->IsDeleted) {
                $response['message'] = "Reset successfully.";
                $response['status'] = 'success';
            }
             else {
                $response['message'] = "Reset Failed.";
                $response['status'] = 'error';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->error_response->Description;
            $response['status'] = 'error';
        }
        echo json_encode($response);
    }

    /**
       *function  to create Role
      
      */
    public function handleCreateRole($request) {
        $roles = $request->input('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($roles)) {
            $response['message'] = 'Roles field is required';
        }
        else {
            $roleObj = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $roleObj->create($roles);
                if (isset($result->Count) && $result->Count != '') {
                    $response['message'] = "Roles has been created.";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
        echo json_encode($response);
    }
    /**
       *function to delete role
      
      */
    
    function handleDeleteRole($request) {
        $roles = $request->input('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($roles)) {
            $response['message'] = 'Roles field is required';
        }
        else {
            $roleObj = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $roleObj->delete($roles);
                if (isset($result->IsDeleted) && $result->IsDeleted) {
                    $response['message'] = "Role has been deleted.";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
        echo json_encode($response);
    }
    
    /**
       *function to assign user role
      
      */
    public function handleAssignUserRole($request) {
        $uid = $request->input('uid');
        $roles = $request->input('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($roles)) {
            $response['message'] = 'Roles field is required';
        }
        else {
            $roleObj = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $roleObj->assignRolesByUid($uid, $roles);
                if (isset($result->Roles) && $result->Roles != '') {
                    $response['message'] = "Role assigned successfully.";
                    $response['status'] = 'success';
                }
            }
            catch (LoginRadiusException $e) {
                $response['message'] = $e->error_response->Description;
                $response['status'] = 'error';
            }
        }
        echo json_encode($response);
    }
    /**
       *function  to fetch all role
      
      */
    
    public function getAllRoles($request) {
        $roleObj = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $roleObj->get();
            if (isset($result->Count) && $result->Count != '0') {
                $response['result'] = $result;
                $response['status'] = 'success';
            }
            else {
                $response['message'] = 'Roles is empty';
                $response['status'] = 'rolesempty';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->getMessage();
            $response['status'] = 'error';
        }
        echo json_encode($response);
    }
    /**
       *function to fetch user role
      
      */
    
    public function getUserRoles($request) {
        $roleObj = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $roleObj->getAccountRolesByUid($request->input('uid'));
            if (isset($result->Roles) && $result->Roles != '') {
                $response['data'] = $result;
                $response['status'] = 'success';
            }
            else {
                $response['message'] = 'user roles is empty';
                $response['status'] = 'userrolesempty';
            }
        }
        catch (LoginRadiusException $e) {
            $response['message'] = $e->getMessage();
            $response['status'] = 'error';
        }
        echo json_encode($response);
    }
    
    

}
