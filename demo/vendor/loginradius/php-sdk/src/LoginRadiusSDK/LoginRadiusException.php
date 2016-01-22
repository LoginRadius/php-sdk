<?php

/**
 * @link : http://www.loginradius.com
 * @category : LoginRadiusSDK
 * @package : LoginRadiusException
 * @author : LoginRadius Team
 * @version : 3.0.0
 * @license : https://opensource.org/licenses/MIT
 */
namespace LoginRadiusSDK;

/**
 * Class For LoginRadius Exception
 * This is the Loginradius Exception class to handle exception when you access LoginRadius APIs.
 *
 * Copyright 2016 LoginRadius Inc. - www.LoginRadius.com
 */
class LoginRadiusException extends \Exception
{

    public $error_response;

    /**
     * Get error message and set error response.
     *
     * @param string $message
     * @param array $error_response
     */
    public function __construct($message, $error_response = array())
    {
        parent::__construct($message);

        $this->error_response = $error_response;
    }

    /**
     * Get error Response from API.
     *
     * @return array
     */
    public function getErrorResponse()
    {
        return $this->error_response;
    }
}