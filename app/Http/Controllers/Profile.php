<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

class Profile extends Controller
{

    /**
     * handle profile operation

     */
    public function profile(Request $request)
    {
        $action = $request->input('action');
        if (method_exists($this, $action)) {
            $this->$action($request);
        } else {
            return view('profile');
        }

    }
    /**
     * function to fetch profile info  by uid
     */
    public function getProfileByUid($request)
    {
        $uid = $request->input('uid');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($uid)) {
            $response['message'] = 'uid is required field';
        } else {

            $accountAPI = new AccountAPI();
            $result = $accountAPI->getAccountProfileByUid($uid);
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
    }

    /**
     * function to fetch info of profile
     */
    public function getProfile($request)
    {

        $token = $request->input('token');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Token is required';
        } else {
            $authObj = new AuthenticationAPI();
            $fields = '';
            $result = $authObj->getProfileByAccessToken($token, $fields);
            if ((isset($result->Uid) && $result->Uid != '')) {
                $response['data'] = $result;
                $response['message'] = "Profile successfully retrieved.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }

        }
        echo json_encode($response);
    }
    /**
     * function to change password
     */

    public function changePassword($request)
    {
        $token = $request->input('token');
        $oldpassword = $request->input('oldpassword');
        $newpassword = $request->input('newpassword');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($oldpassword)) {
            $response['message'] = 'Old password is required';
        } elseif (empty($newpassword)) {
            $response['message'] = 'New password is required';
        } else {
            $authenticationObj = new AuthenticationAPI();
            $result = $authenticationObj->changePassword($token, $newpassword, $oldpassword);
            if (isset($result->IsPosted) && $result->IsPosted) {
                $response['message'] = "Password has been changed successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }

        }
        echo json_encode($response);
    }
    /**
     * function to set account password
     */
    public function setPassword($request)
    {
        $uid = $request->input('uid');
        $newpassword = $request->input('newpassword');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($newpassword)) {
            $response['message'] = 'New password field is required';
        } else {
            $accountObj = new AccountAPI();

            $result = $accountObj->setAccountPasswordByUid($newpassword, $uid);
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

    /**
     * function to handle forgot password
     */
    public function forgotPassword($request)
    {
        $email = $request->input('email');
        if (empty($email)) {
            $response['message'] = 'The Email Id field is required.';
        } else {
            $authenticationObj = new AuthenticationAPI();
            $result = $authenticationObj->forgotPassword($email,$request->input('resetPasswordUrl'), '');
            if ((isset($result->IsPosted) && $result->IsPosted)) {
                $response['message'] = "An email has been sent to your address with instructions to reset your password.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        echo json_encode($response);
    }
    /**
     * function to reset password
     */
    public function resetPassword($request)
    {
        $token = $request->input('resettoken');
        $password = $request->input('password');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($token)) {
            $response['message'] = 'Reset token is required';
        } elseif (empty($password)) {
            $response['message'] = 'The Password field is required.';
        } else {
            $authenticationObj = new AuthenticationAPI();
            $formData = ['resettoken' => $token, 'password' => $password, 'welcomeEmailTemplate' => '', 'resetPasswordEmailTemplate' => ''];
            $result = $authenticationObj->resetPasswordByResetToken($formData);
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
    /**
     * function to update account
     */
    public function updateAccount($request)
    {
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $about = $request->input('about');
        $response = array('status' => 'error', 'message' => 'an error occoured');

        $authenticationObj = new AuthenticationAPI();
        $userProfileUpdateModel = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);
        $accessToken = $request->input('token');
        $emailTemplate = '';
        $fields = '';
        $nullSupport = '';
        $smsTemplate = '';
        $verificationUrl = '';

        $result = $authenticationObj->updateProfileByAccessToken($accessToken, $userProfileUpdateModel, $emailTemplate, $fields, $nullSupport, $smsTemplate, $verificationUrl);
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
    public function createCustomObjects($request)
    {
        $token = $request->input('token');
        $objectName = $request->input('objectName');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required.';
        } else {
            $authCustomObj = new CustomObjectAPI();
            $result = $authCustomObj->createCustomObjectByToken($token, $objectName, $request->input('payload'));
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
    public function getCustomObjects($request)
    {
        $token = $request->input('token');
        $objectName = $request->input('objectName');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required.';
        } else {
            $authCustomObj = new CustomObjectAPI();

            $result = $authCustomObj->getCustomObjectByToken($token, $objectName);
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

    public function updateCustomObjects($request)
    {
        $token = $request->input('token');
        $objectName = $request->input('objectName');
        $objectRecordId = $request->input('objectRecordId');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required';
        } elseif (empty($objectRecordId)) {
            $response['message'] = 'Object Id is required';
        } else {
            $authCustomObj = new CustomObjectAPI();
            $result = $authCustomObj->updateCustomObjectByToken($token, $objectName, $objectRecordId, $request->input('payload'));
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
    public function deleteCustomObjects($request)
    {
        $token = $request->input('token');
        $objectName = $request->input('objectName');
        $objectRecordId = $request->input('objectRecordId');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required';
        } elseif (empty($objectRecordId)) {
            $response['message'] = 'Object Id is required';
        } else {
            $authCustomObj = new CustomObjectAPI();

            $result = $authCustomObj->deleteCustomObjectByToken($token, $objectName, $objectRecordId);
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
    public function resetMultifactor($request)
    {
      
        $authObj = new MultiFactorAuthenticationAPI();
        $response = array('status' => 'error', 'message' => 'An error occurred.');
        $result = $authObj->mFAResetGoogleAuthByToken($request->input('token'), true);
        if (isset($result->IsDeleted) && $result->IsDeleted) {
            $response['message'] = "Reset successfully.";
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        }

        echo json_encode($response);
    }

    /**
     *function  to create Role

     */
    public function handleCreateRole($request)
    {
        $roles = $request->input('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($roles)) {
            $response['message'] = 'Roles field is required';
        } else {
            $roleObj = new RoleAPI();
            $result = $roleObj->createRoles($roles);
            if (isset($result->Count) && $result->Count != '') {
                $response['message'] = "Role successfully created.";
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

    public function handleDeleteRole($request)
    {
        $roles = $request->input('roles');
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
    public function handleAssignUserRole($request)
    {
        $uid = $request->input('uid');
        $roles = $request->input('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($roles)) {
            $response['message'] = 'Roles field is required';
        } else {
            $roleObj = new RoleAPI();
            $result = $roleObj->assignRolesByUid($roles, $uid);
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

    public function getAllRoles($request)
    {
        $roleObj = new RoleAPI();
        $response = array('status' => 'error', 'message' => 'An error occurred.');

        $result = $roleObj->getRolesList();
        if (isset($result->Count) && $result->Count != '0') {
            $response['result'] = $result;
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        } else {
            $response['message'] = 'No existing roles found.';
            $response['status'] = 'rolesempty';
        }

        echo json_encode($response);
    }
    /**
     *function to fetch user role

     */

    public function getUserRoles($request)
    {
        $roleObj = new RoleAPI();
        $response = array('status' => 'error', 'message' => 'An error occurred.');

        $result = $roleObj->getRolesByUid($request->input('uid'));
        if (isset($result->Roles) && $result->Roles != '') {
            $response['data'] = $result;
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        } else {
            $response['message'] = 'User has no roles assigned.';
            $response['status'] = 'userrolesempty';
        }

        echo json_encode($response);
    }

}
