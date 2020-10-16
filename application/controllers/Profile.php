<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

class Profile extends CI_Controller {
 

	
   
function __construct()
{
     parent:: __construct();

	$this->load->helper('url');
	config();


}


public function profile()
{
     $action=$this->input->post('action');
        if(method_exists($this,$action))
        $this->$action();
        else
        $this->load->view('profile.php');
}
  /**
   *fetch profile on social login
  
  */
function getProfileByUid() {

    $uid = $this->input->post('uid');
    $fields=null;
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($uid)) {
        $response['message'] = 'uid is required field';
    }
    else {

        $accountAPI = new AccountAPI(); 
        try {
            $result = $accountAPI->getAccountProfileByUid($uid,$fields);
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
   *Update User Account Information
  
  */
function updateAccount() {
    $firstname =$this->input->post('firstname');
    $lastname =$this->input->post('lastname'); 
    $about = $this->input->post('about'); 
    $response = array('status' => 'error', 'message' => 'an error occoured');
    $authenticationObj = new AuthenticationAPI();
    try {
        $userProfileUpdateModel = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);
        $accessToken =$this->input->post('token');
        $emailTemplate = '';
        $fields = '';
        $nullSupport = '';
        $smsTemplate = '';
        $verificationUrl = '';

        $result = $authenticationObj->updateProfileByAccessToken($accessToken, $userProfileUpdateModel, $emailTemplate, $fields, $nullSupport, $smsTemplate, $verificationUrl);
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
   *fetch profile on traditional Login
  
  */
function getProfile() {

	$token=$this->input->post('token');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($token)) {
        $response['message'] = 'Token is required';
    }
    else {
        $authObj = new AuthenticationAPI();
        $fields = '';
        try {
            $result = $authObj->getProfileByAccessToken($token, $fields);
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
   *change user account password
  
  */
function changePassword() {
    $token = $this->input->post('token');
    $oldpassword = $this->input->post('oldpassword');
    $newpassword =$this->input->post('newpassword');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($oldpassword)) {
        $response['message'] = 'Old password is required';
    }
    elseif (empty($newpassword)) {
        $response['message'] = 'New password is required';
    }
    else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $result = $authenticationObj->changePassword($token,$newpassword, $oldpassword);

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


public function forgotPassword()
{
    $email = $this->input->post('email');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($email)) {
        $response['message'] = 'The Email Id field is required.';
    } else {
        $authenticationObj = new AuthenticationAPI();
        try {
            $result = $authenticationObj->forgotPassword($email, $this->input->post('resetPasswordUrl'), '');
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
   *set user account password
  
  */

function setPassword() {
    $uid = $this->input->post('uid');
    $newpassword =$this->input->post('newpassword');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($newpassword)) {
        $response['message'] = 'New password field is required';
    }
    else {
        $accountObj = new AccountAPI();
        try {
            $result = $accountObj->setAccountPasswordByUid($newpassword, $uid);
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
   *reset user account password
  
  */




function resetPassword(){
    $token =  $this->input->post('resettoken');
    $password = $this->input->post('password');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($token)) {
        $response['message'] = 'Reset token is required';
    }
    elseif (empty($password)) {
        $response['message'] = 'The Password field is required.';
    }
    else {
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
   echo json_encode($response);
}

/**
   *used to create custom object
  
  */
function createCustomObjects() {
    $token=$this->input->post('token');
    $objectName = $this->input->post('objectName');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required.';
    }
    else {
        $authCustomObj = new CustomObjectAPI();
       
        try {
            
            $result = $authCustomObj->createCustomObjectByToken($token, $objectName,$this->input->post('payload'));
      
           
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
   *used  to get custom object
  
  */
function getCustomObjects() {
    $token=$this->input->post('token');
    $objectName = $this->input->post('objectName');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required.';
    }
    else {
        $authCustomObj = new CustomObjectAPI();
        try {
            $result = $authCustomObj->getCustomObjectByToken($token, $objectName);
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
   *used to update custom object
  
  */

function updateCustomObjects() {
    $token=$this->input->post('token');
    $objectName = $this->input->post('objectName');
    $objectRecordId = $this->input->post('objectRecordId');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required';
    }
    elseif (empty($objectRecordId)) {
        $response['message'] = 'Object Id is required';
    }
    else {
        $authCustomObj = new CustomObjectAPI();
        try {
            $result = $authCustomObj->updateCustomObjectByToken($token, $objectName, $objectRecordId,  $this->input->post('payload'));
            
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
   *used to delete custom object
  
  */
function deleteCustomObjects() {
    $token=$this->input->post('token');
    $objectName = $this->input->post('objectName');
    $objectRecordId =$this->input->post('objectRecordId');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required';
    }
    elseif (empty($objectRecordId)) {
        $response['message'] = 'Object Id is required';
    }
    else {
        $authCustomObj = new CustomObjectAPI();
        try {
            $result = $authCustomObj->deleteCustomObjectByToken($token, $objectName, $objectRecordId);
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
   *used to reset multifactor authentication
  
  */
function resetMultifactor() {
    $authObj = new MultiFactorAuthenticationAPI();
    try {
        $result = $authObj->mfaResetGoogleAuthByToken($this->input->post('uid'), true);
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
   *used to create Role
  
  */
function handleCreateRole() {
    $roles = $this->input->post('roles');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($roles)) {
        $response['message'] = 'Roles field is required';
    }
    else {
        $roleObj = new RoleAPI();
        try {
            $result = $roleObj->createRoles($roles);
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
   *Used to delete role
  
  */

function handleDeleteRole() {
    $roles = $this->input->post('roles');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($roles)) {
        $response['message'] = 'Roles field is required';
    }
    else {
        $roleObj = new RoleAPI();
        try {
            $result = $roleObj->deleteRole($roles);
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
   *used to assign user role
  
  */
function handleAssignUserRole() {
    $uid = $this->input->post('uid');
    $roles = $this->input->post('roles');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($roles)) {
        $response['message'] = 'Roles field is required';
    }
    else {
        $roleObj = new RoleAPI();
        try {
            $result = $roleObj->assignRolesByUid($roles, $uid);
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
   *used to fetch all role
  
  */

function getAllRoles() {
    $roleObj = new RoleAPI();
    try {
        $result = $roleObj->getRolesList();
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
   *used to fetch user role
  
  */

function getUserRoles() {
    $roleObj = new RoleAPI();
    try {
        $result = $roleObj->getRolesByUid($this->input->post('uid'));
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
