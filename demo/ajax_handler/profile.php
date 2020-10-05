<?php

require_once 'config.php';

use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\CustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;

function getProfileByToken(array $request)
{
    $token = isset($request['token']) ? trim($request['token']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($token)) {
        $response['message'] = 'Access Token is a required field.';
    } else {
        $authObj = new AuthenticationAPI();
        $fields = '';

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
    return json_encode($response);
}

function updateAccount(array $request)
{
    $firstname = isset($request['firstname']) ? trim($request['firstname']) : '';
    $lastname = isset($request['lastname']) ? trim($request['lastname']) : '';
    $about = isset($request['about']) ? trim($request['about']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');

    $authenticationObj = new AuthenticationAPI();
    $userProfileUpdateModel = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);
    $accessToken = $request['token'];
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

    return json_encode($response);
}

function changePassword(array $request)
{
    $accessToken = isset($request['token']) ? trim($request['token']) : '';
    $oldPassword = isset($request['oldpassword']) ? trim($request['oldpassword']) : '';
    $newPassword = isset($request['newpassword']) ? trim($request['newpassword']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($oldPassword)) {
        $response['message'] = 'Old password is a required field.';
    } elseif (empty($newPassword)) {
        $response['message'] = 'New password is a required field.';
    } else {
        $authenticationObj = new AuthenticationAPI();

        $result = $authenticationObj->changePassword($accessToken, $newPassword, $oldPassword);
        if (isset($result->IsPosted) && $result->IsPosted) {
            $response['message'] = "Password has been changed successfully.";
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        }

    }
    return json_encode($response);
}

function setPassword(array $request)
{
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
    $newpassword = isset($request['newpassword']) ? trim($request['newpassword']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($newpassword)) {
        $response['message'] = 'New password is a required field.';
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
    return json_encode($response);
}

function createCustomObjects(array $request)
{
    $token = isset($request['token']) ? trim($request['token']) : '';
    $objectName = isset($request['objectName']) ? trim($request['objectName']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($objectName)) {
        $response['message'] = 'Object name is a required field.';
    } else {
        $authCustomObj = new CustomObjectAPI();

        $result = $authCustomObj->createCustomObjectByToken($token, $objectName, $request['payload']);
        if (isset($result->Uid) && $result->Uid != '') {
            $response['message'] = "Custom object created successfully.";
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        }

    }
    return json_encode($response);
}

function getCustomObjects(array $request)
{
    $token = isset($request['token']) ? trim($request['token']) : '';
    $objectName = isset($request['objectName']) ? trim($request['objectName']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($objectName)) {
        $response['message'] = 'Object name is a required field.';
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
    return json_encode($response);
}

function updateCustomObjects(array $request)
{
    $token = isset($request['token']) ? trim($request['token']) : '';
    $objectName = isset($request['objectName']) ? trim($request['objectName']) : '';
    $objectRecordId = isset($request['objectRecordId']) ? trim($request['objectRecordId']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($objectName)) {
        $response['message'] = 'Object name is a required field.';
    } elseif (empty($objectRecordId)) {
        $response['message'] = 'Object Id is a required field.';
    } else {
        $authCustomObj = new CustomObjectAPI();

        $result = $authCustomObj->updateCustomObjectByToken($token, $objectName, $objectRecordId, $request['payload']);
        if (isset($result->Uid) && $result->Uid != '') {
            $response['message'] = "Custom object updated successfully.";
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = "error";
        }

    }
    return json_encode($response);
}

function deleteCustomObjects(array $request)
{
    $token = isset($request['token']) ? trim($request['token']) : '';
    $objectName = isset($request['objectName']) ? trim($request['objectName']) : '';
    $objectRecordId = isset($request['objectRecordId']) ? trim($request['objectRecordId']) : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($objectName)) {
        $response['message'] = 'Object name is a required field.';
    } elseif (empty($objectRecordId)) {
        $response['message'] = 'Object Id is a required field.';
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
    return json_encode($response);
}

function handleCreateRole(array $request)
{
    $roles = isset($request['roles']) ? $request['roles'] : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($roles)) {
        $response['message'] = 'Role is a required field.';
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
    return json_encode($response);
}

function handleDeleteRole(array $request)
{
    $roles = isset($request['roles']) ? $request['roles'] : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($roles)) {
        $response['message'] = 'Role is a required field.';
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
    return json_encode($response);
}

function handleAssignUserRole(array $request)
{
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
    $roles = isset($request['roles']) ? $request['roles'] : '';
    $response = array('status' => 'error', 'message' => 'An error occurred.');
    if (empty($roles)) {
        $response['message'] = 'Role is a required field.';
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
    return json_encode($response);
}

function getAllRoles(array $request)
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

    return json_encode($response);
}

function getUserRoles(array $request)
{
    $roleObj = new RoleAPI();
    $response = array('status' => 'error', 'message' => 'An error occurred.');

    $result = $roleObj->getRolesByUid($request['uid']);
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

    return json_encode($response);
}

function resetMultifactor(array $request)
{
    $authObj = new MultiFactorAuthenticationAPI();
    $response = array('status' => 'error', 'message' => 'An error occurred.');

    $result = $authObj->mFAResetGoogleAuthByToken($request['token'], true);
    if (isset($result->IsDeleted) && $result->IsDeleted) {
        $response['message'] = "Reset successfully.";
        $response['status'] = 'success';
    } else if (isset($result->error_response)) {
        $response['message'] = $result->error_response->Description;
        $response['status'] = "error";
    }

    return json_encode($response);
}
