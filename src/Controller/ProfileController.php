<?php

namespace App\Controller;
Use App\Controller\AppController;

use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthCustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;

class ProfileController extends AppController{
    public function initialize()
    {
    
        parent::initialize();
        $this->viewBuilder()->setLayout('profilelayout');

    }

   
    public function profileView(){}
    public function changePasswordView(){}
    public function setPasswordView(){}
    public function accountView(){}
    public function accountLinkingView(){}
    public function customObjectView(){}
    public function resetMultifactorView(){}
    public function roleView(){}
        /**
         * manage all profile action]
         */ 
    public function profile(){
        $this->autoRender=false;    
        $action=$this->request->data('action');
        if(method_exists($this,$action))
        {
            $this->$action();
            
        }
    }
    
    public function getProfileByUid(){
         $this->autoRender=false;
        $uid = $this->request->data('uid');
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
        exit;
    }


    public function getProfile() { 
        $this->autoRender=false;
        $token= $this->request->data('token');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Token is required';
        }
        else {
            $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
            try {
                $result = $authenticationObj->getProfile($token);               
                                
                    $response['data'] = $result;
                    $response['message'] = "Profile fetched";
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
      * function to change password
      */


      public function changePassword() {
        $token =$this->request->data('token');
        $oldpassword =$this->request->data('oldpassword');
        $newpassword =$this->request->data('newpassword');
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
    public function setPassword() {
        $uid = $this->request->data('uid');
        $newpassword =$this->request->data('newpassword');        
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
    public function updateAccount() {
        $firstname =$this->request->data('firstname');
        $lastname =$this->request->data('lastname');
        $about = $this->request->data('about');
        $response = array('status' => 'error', 'message' => 'an error occoured');
    
        $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
        try {
            $payload = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);
    
            $result = $authenticationObj->updateProfile($this->request->data('token'), $payload);
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
    public function createCustomObjects() {
        $token=$this->request->data('token');
        $objectName = $this->request->data('objectName');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required.';
        }
        else {
            $customObj = new AuthCustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
           
            try {
                
                $result = $customObj->createCustomObject($token, $objectName, $this->request->data('payload'));
                
               
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
    public function getCustomObjects() {
        $token=$this->request->data('token');
        $objectName = $this->request->data('objectName');
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
    
    public function updateCustomObjects() {
        $token=$this->request->data('token');
        $objectName = $this->request->data('objectName');
        $objectRecordId = $this->request->data('objectRecordId');
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
                $result = $customObj->updateCustomObjectData($token, $objectName, $objectRecordId, 'replace', $this->request->data('payload'));
                
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
    public function deleteCustomObjects() {
        $token=$this->request->data('token');
        $objectName = $this->request->data('objectName');
        $objectRecordId =$this->request->data('objectRecordId');
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
    public function resetMultifactor() {
        $accountObj = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $accountObj->mfaResetGoogleAuthenticatorByUid($this->request->data('uid'), true);
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
    public function handleCreateRole() {
        $roles = $this->request->data('roles');
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
    
    function handleDeleteRole() {
        $roles = $this->request->data('roles');
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
    public function handleAssignUserRole() {
        $uid = $this->request->data('uid');
        $roles = $this->request->data('roles');
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
    
      public function getAllRoles() {
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


    public function getUserRoles() {
        $roleObj = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $roleObj->getAccountRolesByUid($this->request->data('uid'));
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