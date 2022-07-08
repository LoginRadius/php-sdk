<?php

namespace app\controllers;

use yii\web\Controller;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\CustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;



class ProfileController extends Controller
{
    public $enableCsrfValidation = false;
   
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * 
     * load view
     */
    public function actionProfileView()
    {

       
        $this->layout='profilelayout';
        
        return $this->render('profile');
       // die('check');
    }

    public function actionAccount()
    {
        $this->layout='profilelayout';
        return $this->render('account');
    }
    public function actionChangePasswordView()
    {
        $this->layout='profilelayout';
        return $this->render('change_password');
    }
    public function actionSetPasswordView()
    {
        $this->layout='profilelayout';
        return $this->render('set_password');
    }
    
    public function actionCustomObject()
    {
        $this->layout='profilelayout';
        return $this->render('custom_object');
    }
    public function actionRole()
    {
        $this->layout='profilelayout';
        return $this->render('role');
    }
    public function actionAccountLinking()
    {
        $this->layout='profilelayout';
        return $this->render('account_linking');
    }
    public function actionResetMultifactorView()
    {
        $this->layout='profilelayout';
        return $this->render('reset_multifactor');
    }



    /**
     * manage all profile action
     */ 
       
    public function actionProfile(){
        $data=$_POST['action'];
        $action="action".ucfirst($data);
        if(method_exists($this,$action))
        {
            $this->$action();
            exit;
        }
    }


        public function actionGetProfile() { 
   
            $token= $_POST['token'];
            $fields = null; //Optional 
            $emailTemplate = ''; //Optional 
            $verificationUrl = ''; //Optional 
            $welcomeEmailTemplate = ''; //Optional
        
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($token)) {
                $response['message'] = 'Token is required';
            }
            else {
                $authenticationObj = new AuthenticationAPI();
                
                $result = $authenticationObj->getProfileByAccessToken($token,$fields,$emailTemplate,$verificationUrl,$welcomeEmailTemplate);               
                if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {                
                        $response['data'] = $result;
                        $response['message'] = "Profile fetched";
                        $response['status'] = 'success';
                }else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
            }
          echo json_encode($response);
           
        }

        public function actionGetProfileByUid(){
            
            $uid = $_POST['uid'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($uid)) {
                $response['message'] = 'uid is required field';
            }
            else {
        
                $accountObj = new AccountAPI();
                    $result = $accountObj->getAccountProfileByUid($uid);
                    if ((isset($result->Uid) && $result->Uid != '')) {
                        $response['data'] = $result;
                        
                        $response['message'] = "fetched profile";
                        $response['status'] = 'success';
                    }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;

                    $response['status'] = "error";
                }
            }
            echo json_encode($response);
        }


        public function actionUpdateAccount() {
            
            $firstname =$_POST['firstname'];
            $lastname = $_POST['lastname'];
            $about = $_POST['about'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
        
            $authenticationObj = new AuthenticationAPI();
            
                $payload = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);
        
                $result = $authenticationObj->updateProfileByAccessToken($_POST['token'], $payload);
                if (isset($result->IsPosted) && $result->IsPosted) {
                    
                    $response['message'] = "Profile has been updated successfully.";
                    $response['status'] = 'success';
                }
        
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
            echo json_encode($response);
        }
         
        public function actionChangePassword() {

            
            $token =$_POST['token'];
            $oldpassword =$_POST['oldpassword'];
            $newpassword =$_POST['newpassword'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($oldpassword)) {
                $response['message'] = 'Old password is required';
            }
            elseif (empty($newpassword)) {
                $response['message'] = 'New password is required';
            }
            else {
                $authenticationObj = new AuthenticationAPI();
                
                    $result = $authenticationObj->changePassword($token,$newpassword, $oldpassword);
                    if (isset($result->IsPosted) && $result->IsPosted) {
                        $response['message'] = "Password has been changed successfully.";
                        $response['status'] = 'success';
                    }   
                    else if (isset($result->error_response)) {
                        $response['message'] = $result->error_response->Description;
                        $response['status'] = "error";
                    }
            }
          echo json_encode($response);
        }
    
    
    
        /**
         * function to set account password
         */
        public function actionSetPassword() {
            $uid = $_POST['uid'];
            $newpassword =$_POST['newpassword'];        
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($newpassword)) {
                $response['message'] = 'New password field is required';
            }
            else {
                $accountObj = new AccountAPI();
               
                    $result = $accountObj->setAccountPasswordByUid($newpassword,$uid);
                    if (isset($result->PasswordHash) && $result->PasswordHash != '') {
                        $response['message'] = "The password has been set successfully.";
                        $response['status'] = 'success';
                    }
          
                    else if (isset($result->error_response)) {
                        $response['message'] = $result->error_response->Description;
    
                        $response['status'] = "error";
                    }
            }
            echo json_encode($response);
        }
    
        /**
         * function to create custom pbject
         */
        public function ActionCreateCustomObjects() {
            $token=$_POST['token'];
            $objectName = $_POST['objectName'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($objectName)) {
                $response['message'] = 'Object name is required.';
            }
            else {
                $customObj = new CustomObjectAPI();
                    
                    $result = $customObj->createCustomObjectByToken($token, $objectName, $_POST['payload']);
                    
                   
                    if (isset($result->Uid) && $result->Uid != '') {
                        
                        $response['message'] = "Custom object created successfully.";
                        $response['status'] = 'success';
                    }
                    else if (isset($result->error_response)) {
                        $response['message'] = $result->error_response->Description;
    
                        $response['status'] = "error";
                    }
            }
            echo json_encode($response);
        }
        
        /**
           *function  to get custom object
          
          */
        public function actionGetCustomObjects() {
            $token=$_POST['token'];
            $objectName = $_POST['objectName'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($objectName)) {
                $response['message'] = 'Object name is required.';
            }
            else {
                $customObj = new CustomObjectAPI();
                    $result = $customObj->getCustomObjectByToken($token, $objectName);
                    if (isset($result->Count) && $result->Count != '0') {
                        $response['result'] = $result;
                        $response['status'] = 'success';
                    }
                    else if (isset($result->error_response)) {
                        $response['message'] = $result->error_response->Description;
                        $response['status'] = 'error';
                    }
                    else {
                        $response['status'] = 'empty';
                    }
                    
            }
          echo json_encode($response);

        }
        /**
           *function to update custom object
          
          */
        
        public function actionUpdateCustomObjects() {
            $token=$_POST['token'];
            $objectName = $_POST['objectName'];
            $objectRecordId = $_POST['objectRecordId'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($objectName)) {
                $response['message'] = 'Object name is required';
            }
            elseif (empty($objectRecordId)) {
                $response['message'] = 'Object Id is required';
            }
            else {
                $customObj = new CustomObjectAPI();
                
                    $result = $customObj->updateCustomObjectByToken($token, $objectName, $objectRecordId, $_POST['payload']);
                    
                    if (isset($result->Uid) && $result->Uid != '') {
                        $response['message'] = "Custom object updated successfully.";
                        $response['status'] = 'success';
                    }
                
                    else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = 'error';
                }
            }
           echo json_encode($response);
        }
        /**
           *function to delete custom object
          
          */
        public function actionDeleteCustomObjects() {
            $token=$_POST['token'];
            $objectName = $_POST['objectName'];
            $objectRecordId =$_POST['objectRecordId'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($objectName)) {
                $response['message'] = 'Object name is required';
            }
            elseif (empty($objectRecordId)) {
                $response['message'] = 'Object Id is required';
            }
            else {
                $customObj = new CustomObjectAPI();
               
                    $result = $customObj->deleteCustomObjectByToken($token, $objectName, $objectRecordId);
                    if (isset($result->IsDeleted) && $result->IsDeleted) {
                        $response['message'] = "Custom object deleted successfully.";
                        $response['status'] = 'success';
                    }
                    else if (isset($result->error_response)){
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = 'error';
                }
            }
            echo json_encode($response);
        }
        /**
         * function to reset multi factor authentication
         */
        public function actionResetMultifactor() {
            $accountObj = new MultiFactorAuthenticationAPI;
            
                $result = $accountObj->mfaResetGoogleAuthenticatorByUid(true,$_POST['uid']);
                if (isset($result->IsDeleted) && $result->IsDeleted) {
                    $response['message'] = "Reset successfully.";
                    $response['status'] = 'success';
                }
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = 'error';
                }
                 else {
                    $response['message'] = "Reset Failed.";
                    $response['status'] = 'error';
                }
            
            echo json_encode($response);
        }
    
        /**
           *function  to create Role
          
          */
        public function actionHandleCreateRole() {
            $roles = $_POST['roles'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($roles)) {
                $response['message'] = 'Roles field is required';
            }
            else {
                $roleObj = new RoleAPI();
               
                    $result = $roleObj->createRoles($roles);
                    if (isset($result->Count) && $result->Count != '') {
                        $response['message'] = "Roles has been created.";
                        $response['status'] = 'success';
                    }
                
                else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
            }
            echo json_encode($response);
        }
        /**
           *function to delete role
          
          */
        
        public function actionHandleDeleteRole() {
            $roles = $_POST['roles'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($roles)) {
                $response['message'] = 'Roles field is required';
            }
            else {
                $roleObj = new RoleAPI();
                
                    $result = $roleObj->deleteRole($roles);
                    if (isset($result->IsDeleted) && $result->IsDeleted) {
                        $response['message'] = "Role has been deleted.";
                        $response['status'] = 'success';
                    }else if (isset($result->error_response)) {
                        $response['message'] = $result->error_response->Description;
                        $response['status'] = 'error';
                    }
            }
            echo json_encode($response);
        }
        
        /**
           *function to assign user role
          
          */
        public function actionHandleAssignUserRole() {
            $uid = $_POST['uid'];
            $roles = $_POST['roles'];
            $response = array('status' => 'error', 'message' => 'an error occoured');
            if (empty($roles)) {
                $response['message'] = 'Roles field is required';
            }
            else {
                $roleObj = new RoleAPI();
               
                    $result = $roleObj->assignRolesByUid($roles,$uid);
                    if (isset($result->Roles) && $result->Roles != '') {
                        $response['message'] = "Role assigned successfully.";
                        $response['status'] = 'success';
                    }
                    else if (isset($result->error_response)){
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = 'error';
                }
            }
            echo json_encode($response);
        }
      
         /**
           *function  to fetch all role
          
          */
        






         public function actionGetAllRoles() {
             $roleObj = new RoleAPI();
             
                 $result = $roleObj->getRolesList();
                 if (isset($result->Count) && $result->Count != '0') {
                     $response['result'] = $result;
                     $response['status'] = 'success';
                 }
                 else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
                 else {
                     $response['message'] = 'Roles is empty';
                     $response['status'] = 'rolesempty';
                 }
           
             echo json_encode($response);
         }
     
     
         public function actionGetUserRoles() {
             $roleObj = new RoleAPI();
           
                 $result = $roleObj->getRolesByUid($_POST['uid']);
                 if (isset($result->Roles) && $result->Roles != '') {
                     $response['data'] = $result;
                     $response['status'] = 'success';
                 }
                 else if (isset($result->error_response)) {
                    $response['message'] = $result->error_response->Description;
                    $response['status'] = "error";
                }
                 else {
                     $response['message'] = 'user roles is empty';
                     $response['status'] = 'userrolesempty';
                 }
            
             echo json_encode($response);
         }




        


}
