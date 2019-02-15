<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \LoginRadiusSDK\Utility\Functions;
use \LoginRadiusSDK\LoginRadiusException;
use \LoginRadiusSDK\Clients\IHttpClient;
use \LoginRadiusSDK\Clients\DefaultHttpClient;
use \LoginRadiusSDK\CustomerRegistration\Authentication\UserAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthCustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;

use Symfony\Component\HttpFoundation\Response;



$request = Request::createFromGlobals();

// the URI being requested (e.g. /about) minus any query parameters
$request->getPathInfo();
class ProfileController extends ApiController 
{




    public function profileView(){
        return $this->render('profile/profile.html.twig') ;

    }
    public function updateAccountView(){
        return $this->render('profile/account.html.twig') ;

    }
    public function setPasswordView(){
        return $this->render('profile/setpassword.html.twig') ;

    }
    public function changePasswordView(){
        return $this->render('profile/changepassword.html.twig') ;

    }
    public function customObjectView(){
        return $this->render('profile/customobject.html.twig') ;

    }
    public function roleView(){
        return $this->render('profile/role.html.twig') ;

    }
    
    public function accountLinkingView(){
        return $this->render('profile/accountlinking.html.twig') ;

    }
    
    public function resetMultifactorView(){
        return $this->render('profile/resetmultifactor.html.twig') ;

    }
    

    /**
     * handle profile action
     */
    public function profile(Request $request)
    {
       $action=$request->request->get('action');
     
        if(method_exists($this,$action))
           return $this->$action($request);
        else
        return $this->render('site/minimal.html.twig') ;
    }



/**
   *fetch profile on traditional Login
  
  */
  function getProfile($request) {

    $token=$request->request->get('token');
    
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
    return new Response(json_encode($response));

}

public function getProfileByUid($request){
    $this->autoRender=false;
   $uid = $request->request->get('uid');
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
   return new Response(json_encode($response));
}



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
  return new Response(json_encode($response));
}


public function getUserRoles($request) {
    $roleObj = new RoleAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    try {
        $result = $roleObj->getAccountRolesByUid($request->request->get('uid'));
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
   return new Response(json_encode($response));
}


public function changePassword($request) {
    $token =$request->request->get('token');
    $oldpassword =$request->request->get('oldpassword');
    $newpassword =$request->request->get('newpassword');
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
  return new Response(json_encode($response));
}
/**
 * function to set account password
 */
public function setPassword($request) {
    $uid = $request->request->get('uid');
    $newpassword =$request->request->get('newpassword');        
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
    return new Response(json_encode($response));
}


public function updateAccount($request) {
    $firstname =$request->request->get('firstname');
    $lastname =$request->request->get('lastname');
    $about = $request->request->get('about');
    $response = array('status' => 'error', 'message' => 'an error occoured');

    $authenticationObj = new UserAPI(API_KEY, API_SECRET, array('output_format' => 'json'));
    try {
        $payload = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);

        $result = $authenticationObj->updateProfile($request->request->get('token'), $payload);
        if (isset($result->IsPosted) && $result->IsPosted) {
            
            $response['message'] = "Profile has been updated successfully.";
            $response['status'] = 'success';
        }
    }
    catch (LoginRadiusException $e) {
        $response['message'] = $e->error_response->Description;
        $response['status'] = 'error';
    }
    return new Response( json_encode($response));
}

/**
 * function to create custom pbject
 */
public function createCustomObjects($request) {
    $token=$request->request->get('token');
    $objectName = $request->request->get('objectName');
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($objectName)) {
        $response['message'] = 'Object name is required.';
    }
    else {
        $customObj = new AuthCustomObjectAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
       
        try {
            
            $result = $customObj->createCustomObject($token, $objectName, $request->request->get('payload'));
            
           
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
    return new Response( json_encode($response));
}

/**
   *function  to get custom object
  
  */
public function getCustomObjects($request) {
    $token=$request->request->get('token');
    $objectName = $request->request->get('objectName');
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
    return new Response( json_encode($response));
}
/**
   *function to update custom object
  
  */

public function updateCustomObjects($request) {
    $token=$request->request->get('token');
    $objectName = $request->request->get('objectName');
    $objectRecordId = $request->request->get('objectRecordId');
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
            $result = $customObj->updateCustomObjectData($token, $objectName, $objectRecordId, 'replace', $request->request->get('payload'));
            
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
   return new Response( json_encode($response));
}
/**
   *function to delete custom object
  
  */
public function deleteCustomObjects($request) {
    $token=$request->request->get('token');
    $objectName = $request->request->get('objectName');
    $objectRecordId =$request->request->get('objectRecordId');
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
    return new Response( json_encode($response));
}
/**
 * function to reset multi factor authentication
 */
public function resetMultifactor($request) {
    $accountObj = new AccountAPI(API_KEY, API_SECRET, array('output_format' => 'json', 'api_request_signing' => API_REQUEST_SIGNING));
    try {
        $result = $accountObj->mfaResetGoogleAuthenticatorByUid($request->request->get('uid'), true);
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
    return new Response( json_encode($response));
}

/**
   *function  to create Role
  
  */
public function handleCreateRole($request) {
    $roles = $request->request->get('roles');
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
    return new Response( json_encode($response));
}
/**
   *function to delete role
  
  */

function handleDeleteRole($request) {
    $roles = $request->request->get('roles');
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
    return new Response( json_encode($response));
}

/**
   *function to assign user role
  
  */
public function handleAssignUserRole($request) {
    $uid = $request->request->get('uid');
    $roles = $request->request->get('roles');
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
    return new Response( json_encode($response));
}

 

      
    }


