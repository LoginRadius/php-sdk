<?php

namespace App\Controller;

use App\Controller\AppController;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\CustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use SebastianBergmann\Environment\Console;

class ProfileController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('profilelayout');
    }
    public function profileView()
    {
    }
    public function changePasswordView()
    {
    }
    public function setPasswordView()
    {
    }
    public function accountView()
    {
    }
    public function accountLinkingView()
    {
    }
    public function customObjectView()
    {
    }
    public function resetMultifactorView()
    {
    }
    public function roleView()
    {
    }
    /**
     * manage all profile action]
     */
    public function profile()
    {
        $this->autoRender = false;
        $action = $this->request->getdata('action');
        if (method_exists($this, $action)) {
            $this->$action();
        }
    }
    public function getProfileByUid()
    {
        $this->autoRender = false;
        $uid = $this->request->getdata('uid');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($uid)) {
            $response['message'] = 'uid is required field';
        } else {

            $accountObject = new AccountAPI();

            $result = $accountObject->getAccountProfileByUid($uid);

            if ((isset($result->Uid) && $result->Uid != '')) {
                $response['data'] = $result;

                $response['message'] = "fetched profile";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
        exit;
    }


    public function getProfile()
    {
        $this->autoRender = false;
        $token = $this->request->getdata('token');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Token is required';
        } else {
            $authenticationAPI = new AuthenticationAPI();

            $result = $authenticationAPI->getProfileByAccessToken($token);

            $response['data'] = $result;
            $response['message'] = "Profile fetched";
            $response['status'] = 'success';
        }

        echo json_encode($response);
        exit;
    }



    /**
     * function to change password
     */


    public function changePassword()
    {
        $token = $this->request->getdata('token');
        $oldpassword = $this->request->getdata('oldpassword');
        $newpassword = $this->request->getdata('newpassword');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($oldpassword)) {
            $response['message'] = 'Old password is required';
        } elseif (empty($newpassword)) {
            $response['message'] = 'New password is required';
        } else {
            $authenticationAPI = new  AuthenticationAPI();

            $result = $authenticationAPI->changePassword($token, $newpassword, $oldpassword);
            if (isset($result->IsPosted) && $result->IsPosted) {
                $response['message'] = "Password has been changed successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }

            echo json_encode($response);
        }
    }



    /*
     * function to set account password
     */
    function setPassword()
    {
        $uid = $this->request->getdata('uid');
        $newpassword = $this->request->getdata('newpassword');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($newpassword)) {
            $response['message'] = 'New password field is required';
        } else {
            $accountObject = new AccountAPI();

            $result = $accountObject->setAccountPasswordByUid($newpassword, $uid);
            if (isset($result->PasswordHash) && $result->PasswordHash != '') {
                $response['message'] = "The password has been set successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
    function updateAccount()
    {
        $firstname = $this->request->getdata('firstname');
        $lastname = $this->request->getdata('lastname');
        $about = $this->request->getdata('about');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        $authenticationObj = new AuthenticationAPI();

        $payload = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);

        $result = $authenticationObj->updateProfileByAccessToken($this->request->getdata('token'), $payload);
        if (isset($result->IsPosted) && $result->IsPosted) {

            $response['message'] = "Profile has been updated successfully.";
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        }
        echo json_encode($response);
    }

    /**
     * function to create custom pbject
     */
    function createCustomObjects()
    {
        $token = $this->request->getdata('token');
        $objectName = $this->request->getdata('objectName');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required.';
        } else {
            $customObj = new CustomObjectAPI();

            $result = $customObj->createCustomObjectByToken($token, $objectName, $this->request->getdata('payload'));


            if (isset($result->Uid) && $result->Uid != '') {

                $response['message'] = "Custom object created successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }

    /**
     *function  to get custom object
      
     */
    function getCustomObjects()
    {
        $token = $this->request->getdata('token');
        $objectName = $this->request->getdata('objectName');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required.';
        } else {
            $customObj = new CustomObjectAPI();

            $result = $customObj->getCustomObjectByToken($token, $objectName);
            if (isset($result->Count) && $result->Count != '0') {
                $response['result'] = $result;
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            } else {
                $response['status'] = 'empty';
            }
        }
        echo json_encode($response);
    }
    /**
     *function to update custom object
      
     */

    function updateCustomObjects()
    {
        $token = $this->request->getdata('token');
        $objectName = $this->request->getdata('objectName');
        $objectRecordId = $this->request->getdata('objectRecordId');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required';
        } elseif (empty($objectRecordId)) {
            $response['message'] = 'Object Id is required';
        } else {
            $customObj = new CustomObjectAPI();

            $result = $customObj->getCustomObjectByRecordIDAndToken($token, $objectName, $objectRecordId, 'replace', $this->request->getdata('payload'));

            if (isset($result->Uid) && $result->Uid != '') {
                $response['message'] = "Custom object updated successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
    /**
     *function to delete custom object
      
     */
    function deleteCustomObjects()
    {
        $token = $this->request->getdata('token');
        $objectName = $this->request->getdata('objectName');
        $objectRecordId = $this->request->getdata('objectRecordId');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required';
        } elseif (empty($objectRecordId)) {
            $response['message'] = 'Object Id is required';
        } else {
            $customObj = new CustomObjectAPI();

            $result = $customObj->deleteCustomObjectByToken($token,$objectName,$objectRecordId);
            if (isset($result->IsDeleted) && $result->IsDeleted) {
                $response['message'] = "Custom object deleted successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
    /**
     * function to reset multi factor authentication
     */
    function resetMultifactor()
    {
        $accountObject = new MultiFactorAuthenticationAPI();
        $googleauthenticator = "true"; //Required 
        $result = $accountObject->mfaResetGoogleAuthenticatorByUid($googleauthenticator, $this->request->getdata('uid'));
        if (isset($result->IsDeleted) && $result->IsDeleted) {
            $response['message'] = "Reset successfully.";
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        } else {
            $response['message'] = "Reset Failed.";
            $response['status'] = 'error';
        }
        echo json_encode($response);
    }

    /**
     *function  to create Role
      
     */
    function handleCreateRole()
    {
        $roles = $this->request->getdata('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($roles)) {
            $response['message'] = 'Roles field is required';
        } else {
            $roleObj = new RoleAPI();

            $result = $roleObj->createRoles($roles);
            if (isset($result->Count) && $result->Count != '') {
                $response['message'] = "Roles has been created.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }


    /**
     *function to delete role
      
     */

    function handleDeleteRole()
    {
        $roles = $this->request->getdata('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($roles)) {
            $response['message'] = 'Roles field is required';
        } else {
            $roleObj = new RoleAPI();

            $result = $roleObj->deleteRole($roles);
            if (isset($result->IsDeleted) && $result->IsDeleted) {
                $response['message'] = "Role has been deleted.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }

    /**
     *function to assign user role
      
     */
    public function handleAssignUserRole()
    {
        $uid = $this->request->getdata('uid');
        $payload = $this->request->getdata('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($payload)) {
            $response['message'] = 'Roles field is required';
        } else {
            $roleObj = new RoleAPI();

            $result = $roleObj->assignRolesByUid($payload, $uid);
            if (isset($result->Roles) && $result->Roles != '') {
                $response['message'] = "Role assigned successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }

    /**
     *function  to fetch all role
      
     */

    public function getAllRoles()
    {
        $roleObj = new RoleAPI();

        $result = $roleObj->getRolesList();
        if (isset($result->Count) && $result->Count != '0') {
            $response['result'] = $result;
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        } else {
            $response['message'] = 'Roles is empty';
            $response['status'] = 'rolesempty';
        }

        echo json_encode($response);
    }


    public function getUserRoles()
    {
        $roleObj = new RoleAPI();

        $result = $roleObj->getRolesByUid($this->request->getdata('uid'));
        if (isset($result->Roles) && $result->Roles != '') {
            $response['data'] = $result;
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        } else {
            $response['message'] = 'user roles is empty';
            $response['status'] = 'userrolesempty';
        }
        echo json_encode($response);
    }
}
