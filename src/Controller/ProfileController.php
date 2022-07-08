<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \LoginRadiusSDK\CustomerRegistration\Account\AccountAPI;
use \LoginRadiusSDK\CustomerRegistration\Account\RoleAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\CustomObjectAPI;
use \LoginRadiusSDK\CustomerRegistration\Advanced\MultiFactorAuthenticationAPI;
use \LoginRadiusSDK\CustomerRegistration\Authentication\AuthenticationAPI;
use Symfony\Component\HttpFoundation\Response;



$request = Request::createFromGlobals();

// the URI being requested (e.g. /about) minus any query parameters
$request->getPathInfo();
class ProfileController extends ApiController
{




    public function profileView()
    {
        return $this->render('profile/profile.html.twig');
    }
    public function updateAccountView()
    {
        return $this->render('profile/account.html.twig');
    }
    public function setPasswordView()
    {
        return $this->render('profile/setpassword.html.twig');
    }
    public function changePasswordView()
    {
        return $this->render('profile/changepassword.html.twig');
    }
    public function customObjectView()
    {
        return $this->render('profile/customobject.html.twig');
    }
    public function roleView()
    {
        return $this->render('profile/role.html.twig');
    }

    public function accountLinkingView()
    {
        return $this->render('profile/accountlinking.html.twig');
    }

    public function resetMultifactorView()
    {
        return $this->render('profile/resetmultifactor.html.twig');
    }


    /**
     * handle profile action
     */
    public function profile(Request $request)
    {
        $action = $request->request->get('action');

        if (method_exists($this, $action))
            return $this->$action($request);
        else
            return $this->render('site/minimal.html.twig');
    }



    /**
     *fetch profile on traditional Login
  
     */
    function getProfile($request)
    {
        $this->autoRender = false;

    $token=$request->request->get('token');
    $fields = null; //Optional 
    $emailTemplate = ''; //Optional 
    $verificationUrl = ''; //Optional 
    $welcomeEmailTemplate = ''; //Optional
    $response = array('status' => 'error', 'message' => 'an error occoured');
    if (empty($token)) {
        $response['message'] = 'Token is required';
    }
    else {
        $authenticationAPI = new AuthenticationAPI();

        $result = $authenticationAPI->getProfileByAccessToken($token,$fields,$emailTemplate,$verificationUrl,$welcomeEmailTemplate);
        if ((isset($result->EmailVerified) && $result->EmailVerified) || AUTH_FLOW == 'optional' || AUTH_FLOW == 'disabled') {
                $response['data'] = $result;
                $response['message'] = "Profile fetched";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        return new Response(json_encode($response));
    }
    }
    public function getProfileByUid($request)
    {
        $this->autoRender = false;
        $uid = $request->request->get('uid');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($uid)) {
            $response['message'] = 'uid is required field';
        } else {

            $accountObject = new AccountAPI();

            $result = $accountObject->getAccountPasswordHashByUid($uid);

            if ((isset($result->Uid) && $result->Uid != '')) {
                $response['data'] = $result;

                $response['message'] = "fetched profile";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = "error";
            }
        }
        return new Response(json_encode($response));
    }



    public function getAllRoles($request)
    {
        $roleObj = new RoleAPI();

        $result = $roleObj->getRolesList();
        if (isset($result->Count) && $result->Count != '0') {
            $response['result'] = $result;
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = 'error';
        } else {
            $response['message'] = 'Roles is empty';
            $response['status'] = 'rolesempty';
        }
        return new Response(json_encode($response));
    }


    public function getUserRoles($request)
    {
        $roleObj = new RoleAPI();

        $result = $roleObj->getRolesByUid($request->request->get('uid'));
        if (isset($result->Roles) && $result->Roles != '') {
            $response['data'] = $result;
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = 'error';
        }
        return new Response(json_encode($response));
    }


    public function changePassword($request)
    {
        $token = $request->request->get('token');
        $oldpassword = $request->request->get('oldpassword');
        $newpassword = $request->request->get('newpassword');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($oldpassword)) {
            $response['message'] = 'Old password is required';
        } elseif (empty($newpassword)) {
            $response['message'] = 'New password is required';
        } else {
            $authenticationAPI = new  AuthenticationAPI();

            $result = $authenticationAPI->changePassword($token,$newpassword, $oldpassword);
            if (isset($result->IsPosted) && $result->IsPosted) {
                $response['message'] = "Password has been changed successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }
    /**
     * function to set account password
     */
    public function setPassword($request)
    {
        $uid = $request->request->get('uid');
        $newpassword = $request->request->get('newpassword');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($newpassword)) {
            $response['message'] = 'New password field is required';
        } else {
            $accountObject = new AccountAPI();

            $result = $accountObject->setAccountPasswordByUid($newpassword,$uid);
            if (isset($result->PasswordHash) && $result->PasswordHash != '') {
                $response['message'] = "The password has been set successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }


    public function updateAccount($request)
    {
        $firstname = $request->request->get('firstname');
        $lastname = $request->request->get('lastname');
        $about = $request->request->get('about');
        $response = array('status' => 'error', 'message' => 'an error occoured');

        $authenticationObj = new AuthenticationAPI();

        $payload = array('FirstName' => $firstname, 'LastName' => $lastname, 'About' => $about);

        $result = $authenticationObj->updateProfileByAccessToken($request->request->get('token'), $payload);
        if (isset($result->IsPosted) && $result->IsPosted) {

            $response['message'] = "Profile has been updated successfully.";
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = 'error';
        }
        return new Response(json_encode($response));
    }

    /**
     * function to create custom pbject
     */
    public function createCustomObjects($request)
    {
        $token = $request->request->get('token');
        $objectName = $request->request->get('objectName');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required.';
        } else {
            $customObj = new CustomObjectAPI();



            $result = $customObj->createCustomObjectByToken($token, $objectName, $request->request->get('payload'));


            if (isset($result->Uid) && $result->Uid != '') {

                $response['message'] = "Custom object created successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }

    /**
     *function  to get custom object
  
     */
    public function getCustomObjects($request)
    {
        $token = $request->request->get('token');
        $objectName = $request->request->get('objectName');
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
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }
    /**
     *function to update custom object
  
     */

    public function updateCustomObjects($request)
    {
        $token = $request->request->get('token');
        $objectName = $request->request->get('objectName');
        $objectRecordId = $request->request->get('objectRecordId');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required';
        } elseif (empty($objectRecordId)) {
            $response['message'] = 'Object Id is required';
        } else {
            $customObj = new CustomObjectAPI();

            $result = $customObj->updateCustomObjectByToken($token, $objectName, $objectRecordId, $request->request->get('payload'));

            if (isset($result->Uid) && $result->Uid != '') {
                $response['message'] = "Custom object updated successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response;
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }
    /**
     *function to delete custom object
  
     */
    public function deleteCustomObjects($request)
    {
        $token = $request->request->get('token');
        $objectName = $request->request->get('objectName');
        $objectRecordId = $request->request->get('objectRecordId');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty($objectName)) {
            $response['message'] = 'Object name is required';
        } elseif (empty($objectRecordId)) {
            $response['message'] = 'Object Id is required';
        } else {
            $customObj = new CustomObjectAPI();

            $result = $customObj->deleteCustomObjectByToken($token, $objectName, $objectRecordId);
            if (isset($result->IsDeleted) && $result->IsDeleted) {
                $response['message'] = "Custom object deleted successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }
    /**
     * function to reset multi factor authentication
     */
    public function resetMultifactor($request)
    {
        $accountObject = new MultiFactorAuthenticationAPI();
        $googleauthenticator = "true"; //Required 
        $result = $accountObject->mfaResetGoogleAuthenticatorByUid($googleauthenticator,$request->request->get('uid'));
        if (isset($result->IsDeleted) && $result->IsDeleted) {
            $response['message'] = "Reset successfully.";
            $response['status'] = 'success';
        } else if (isset($result->error_response)) {
            $response['message'] = $result->error_response->Description;
            $response['status'] = 'error';
        } else {
            $response['message'] = "Reset Failed.";
            $response['status'] = 'error';
        }
        return new Response(json_encode($response));
    }

    /**
     *function  to create Role
  
     */
    public function handleCreateRole($request)
    {
        $roles = $request->request->get('roles');
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
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }
    /**
     *function to delete role
  
     */

    function handleDeleteRole($request)
    {
        $roles = $request->request->get('roles');
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
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }

    /**
     *function to assign user role
  
     */
    public function handleAssignUserRole($request)
    {
        $uid = $request->request->get('uid');
        $payload  = $request->request->get('roles');
        $response = array('status' => 'error', 'message' => 'an error occoured');
        if (empty( $payload )) {
            $response['message'] = 'Roles field is required';
        } else {
            $roleObj = new RoleAPI();

            $result = $roleObj->assignRolesByUid($payload ,$uid  );
            if (isset($result->Roles) && $result->Roles != '') {
                $response['message'] = "Role assigned successfully.";
                $response['status'] = 'success';
            } else if (isset($result->error_response)) {
                $response['message'] = $result->error_response->Description;
                $response['status'] = 'error';
            }
        }
        return new Response(json_encode($response));
    }
}
