<?php
/**
 * @link                : http://www.loginradius.com
 * @category            : CustomerRegistration
 * @package             : UserAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration;

use LoginRadiusSDK\LoginRadius;

/**
 * Class UserAPI
 *
 * This is the main class to communicate with User APIs.
 */
class UserAPI
{
    /**
     *
     * @param type $apikey
     * @param type $apisecret
     * @param type $customize_options
     */
    public function __construct($apikey = '', $apisecret = '', $customize_options = array())
    {
        $options = array_merge(array('authentication'=>true),$customize_options);
        new LoginRadius($apikey, $apisecret, $options);
    }

    /**
     * This API is used to create a new user on your site. This API bypasses the normal email verification process and manually creates the user for your system.
     *
     * $data = array("emailid" => "example@example.com",
     * "password" => "FakePass",
     * "firstname" => "Joe",
     * "lastname" => "Smith",
     * "gender" => "M",
     * "birthdate" => "11-08-1987",
     * "Country" => "USA",
     * "city" => "Chicago",
     * "state" => "Illinois ",
     * "phonenumber" => "1232333232",
     * "address1" => "23/43, II Street",
     * "address2" => "Near Paris garden",
     * "company" => "Orange Inc.",
     * "postalcode" => "43435",
     * "emailsubscription" => "true",
     * "customfields" => array(
     *      "example_field1" => "some data 1",
     *      "example_field2" => "some data 2",
     *      "example_field3" => "some data 3"
     * )
     * );
     *
     * return all user profile
     */
    public function create($data = array())
    {
        return $this->apiClientHandler('', array(), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API used to register user from server side, verification email will be send to provided email address
     *
     * $data = array("emailid" => "example@example.com",
     * "password" => "FakePass",
     * "firstname" => "Joe",
     * "lastname" => "Smith",
     * "gender" => "M",
     * "birthdate" => "11-08-1987",
     * "Country" => "USA",
     * "city" => "Chicago",
     * "state" => "Illinois ",
     * "phonenumber" => "1232333232",
     * "address1" => "23/43, II Street",
     * "address2" => "Near Paris garden",
     * "company" => "Orange Inc.",
     * "postalcode" => "43435",
     * "emailsubscription" => "true",
     * "customfields" => array(
     *      "example_field1" => "some data 1",
     *      "example_field2" => "some data 2",
     *      "example_field3" => "some data 3"
     * ),
     * "EmailVerificationUrl" => "http://yoursite.com/verifyemail"
     * );
     *
     * return "isPosted": "true"
     */
    public function registration($data = array())
    {
        return $this->apiClientHandler("register", array(), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }

    /**
     * This API is used to Modify/Update details of an existing user.
     *
     * $user_id //The LoginRadius user identifier for a particular social platform(like "Facebook", "Twitter") attached with that user account
     * $data = array(
     *  firstname => 'first name',
     *  lastname => 'last name',
     *  gender => 'm',
     *  birthdate => 'MM-DD-YYYY',
     *  ....................
     *  ....................
     * );
     *
     * return {"isPosted": true}
     */
    public function edit($user_id, $data)
    {
        return $this->apiClientHandler('', array('userid' => $user_id), array('method' => 'post', 'post_data' => $data, 'content_type' => 'json'));
    }


    /**
     * This API is used to remove an user's account from LoginRadius system. For security and mis-click concerns, it will send a delete confirmation email to user's email inbox to ask user to confirm the action.
     * $user_id
     * $deleteuserlink Website link where delete user link will handle.
     *
     * return [{"isPosted": "true"}]
     */
    public function deleteUserEmail($user_id, $delete_user_link)
    {
        return $this->apiClientHandler("deleteuseremail", array('userid' => $user_id, 'deleteuserlink' => $delete_user_link));
    }


    /**
     * This API is used to authenticate users and returns the profile data associated with the authenticated user.
     *
     * $user_name = 'username';//email id
     * $password = 'xxxxxxxxxx';
     *
     * return all user profile
     */
    public function signIn($user_name, $password)
    {
        return $this->apiClientHandler('', array('username' => $user_name, 'password' => $password));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the users unique UserID
     *
     * $user_id = 'xxxxxxxxxx';
     *
     * return all user profile
     */
    public function getProfileByID($user_id)
    {
        return $this->apiClientHandler('', array('userid' => $user_id));
    }

    /**
     * This API retrieves the profile data associated with the specific user using the passing in email address.
     *
     * $email = 'example@doamin.com';
     *
     * return all user profile
     */
    public function getProfileByEmail($email)
    {
        return $this->apiClientHandler('', array('emailId' => $email));
    }

    /**
     * This API is used to check the availability of an email from your Customer registration system.
     *
     * $email = 'example@doamin.com'
     *
     * return { "isExist" : true }
     */
    public function checkEmail($email)
    {
        return $this->apiClientHandler("checkemail", array('emailid' => $email));
    }


    /**
     *
     * @param type $path
     * @param type $query_array
     * @param type $options
     * @return type
     */
    private function apiClientHandler($path, $query_array = array(), $options = array())
    {
        return LoginRadius::apiClient("/raas/v1/user/" . $path, $query_array, $options);
    }
}
