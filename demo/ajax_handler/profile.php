<?php

require_once 'config.php';

use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\CustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;

function getProfileByUid(array $request) {
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
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
    return json_encode($response);
}

function updateAccount(array $request) {
    $firstname = isset($request['firstname']) ? trim($request['firstname']) : '';
    $lastname = isset($request['lastname']) ? trim($request['lastname']) : '';
    $about = isset($request['about']) ? trim($request['about']) : '';
    $response = array('status' => 'error', 'message' => 'an error occoured');

    $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
    try {
        $payload = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);
        $result = $authenticationObj->updateProfile($request['token'], $payload);
        if (isset($result->IsPosted) && $result->IsPosted) {
            $response['message'] = "Profile has been updated successfully.";
            $response['status'] = 'success';
        }
    }
    catch (LoginRadiusException $e) {
        $response['message'] = $e->error_response->Description;
        $response['status'] = 'error';
    }
    return json_encode($response);
}

function changePassword(array $request) {
    $token = isset($request['token']) ? trim($request['token']) : '';
    $oldpassword = isset($request['oldpassword']) ? trim($request['oldpassword']) : '';
    $newpassword = isset($request['newpassword']) ? trim($request['newpassword']) : '';
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
    return json_encode($response);
}

function setPassword(array $request) {
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
    $newpassword = isset($request['newpassword']) ? trim($request['newpassword']) : '';
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
    return json_encode($response);
}

function createCustomObjects(array $request) {
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
    $objectName = isset($request['objectName']) ? trim($request['objectName']) : '';
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required.';
    }
    else {
        $customObj = new CustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $customObj->insert($uid, $objectName, $request['payload']);
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
    return json_encode($response);
}

function getCustomObjects(array $request) {
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
    $objectName = isset($request['objectName']) ? trim($request['objectName']) : '';
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required.';
    }
    else {
        $customObj = new CustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $customObj->getObjectByAccountid($uid, $objectName);
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
    return json_encode($response);
}

function updateCustomObjects(array $request) {
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
    $objectName = isset($request['objectName']) ? trim($request['objectName']) : '';
    $objectRecordId = isset($request['objectRecordId']) ? trim($request['objectRecordId']) : '';
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required';
    }
    elseif (empty($objectRecordId)) {
        $response['message'] = 'Object Id is required';
    }
    else {
        $customObj = new CustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $customObj->updateObjectByRecordID($uid, $objectName, $objectRecordId, 'replace', $request['payload']);
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
    return json_encode($response);
}

function deleteCustomObjects(array $request) {
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
    $objectName = isset($request['objectName']) ? trim($request['objectName']) : '';
    $objectRecordId = isset($request['objectRecordId']) ? trim($request['objectRecordId']) : '';
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required';
    }
    elseif (empty($objectRecordId)) {
        $response['message'] = 'Object Id is required';
    }
    else {
        $customObj = new CustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
        try {
            $result = $customObj->delete($uid, $objectName, $objectRecordId);
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
    return json_encode($response);
}

function handleCreateRole(array $request) {
    $roles = isset($request['roles']) ? $request['roles'] : '';
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
    return json_encode($response);
}

function handleDeleteRole(array $request) {
    $roles = isset($request['roles']) ? $request['roles'] : '';
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
    return json_encode($response);
}

function handleAssignUserRole(array $request) {
    $uid = isset($request['uid']) ? trim($request['uid']) : '';
    $roles = isset($request['roles']) ? $request['roles'] : '';
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
    return json_encode($response);
}

function getAllRoles(array $request) {
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
    return json_encode($response);
}

function getUserRoles(array $request) {
    $roleObj = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    try {
        $result = $roleObj->getAccountRolesByUid($request['uid']);
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
    return json_encode($response);
}

function resetMultifactor(array $request) {
    $accountObj = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    try {
        $result = $accountObj->mfaResetGoogleAuthenticatorByUid($request['uid'], true);
        if (isset($result->IsDeleted) && $result->IsDeleted) {
            $response['message'] = "Reset successfully.";
            $response['status'] = 'success';
        }
    }
    catch (LoginRadiusException $e) {
        $response['message'] = $e->error_response->Description;
        $response['status'] = 'error';
    }
    return json_encode($response);
}
