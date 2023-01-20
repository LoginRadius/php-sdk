<?php
 /**
 * @category            : CustomerRegistration
 * @link                : http://www.loginradius.com
 * @package             : SocialAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Social;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

class SocialAPI extends Functions
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }
       


    /**
     * This API Is used to translate the Request Token returned during authentication into an Access Token that can be used with other API calls.
     * @param token Token generated from a successful oauth from social platform
     * @return Response containing Definition of Complete Token data
     * 20.1
    */

    public function exchangeAccessToken($token)
    {
        $resourcePath = "/api/v2/access_token";
        $queryParam = [];
        $queryParam['secret'] = Functions::getApiSecret();
        if ($token === '' || ctype_space($token)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('token'));
        }
        $queryParam['token'] = $token;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * The Refresh Access Token API is used to refresh the provider access token after authentication. It will be valid for up to 60 days on LoginRadius depending on the provider. In order to use the access token in other APIs, always refresh the token using this API.<br><br><b>Supported Providers :</b> Facebook,Yahoo,Google,Twitter, Linkedin.<br><br> Contact LoginRadius support team to enable this API.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @param expiresIn Allows you to specify a desired expiration time in minutes for the newly issued access token.
     * @param isWeb Is web or not.
     * @return Response containing Definition of Complete Token data
     * 20.2
    */

    public function refreshAccessToken($accessToken, $expiresIn = 0,
        $isWeb = false)
    {
        $resourcePath = "/api/v2/access_token/refresh";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['secret'] = Functions::getApiSecret();
        if ($expiresIn != '') {
            $queryParam['expiresIn'] = $expiresIn;
        }
        if ($isWeb != '') {
            $queryParam['isWeb'] = $isWeb;
        }
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API validates access token, if valid then returns a response with its expiry otherwise error.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @return Response containing Definition of Complete Token data
     * 20.9
    */

    public function validateAccessToken($accessToken)
    {
        $resourcePath = "/api/v2/access_token/validate";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['key'] = Functions::getApiKey();
        $queryParam['secret'] = Functions::getApiSecret();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This api invalidates the active access token or expires an access token validity.
     * @param accessToken Uniquely generated identifier key by LoginRadius that is activated after successful authentication.
     * @return Response containing Definition for Complete Validation data
     * 20.10
    */

    public function inValidateAccessToken($accessToken)
    {
        $resourcePath = "/api/v2/access_token/invalidate";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['key'] = Functions::getApiKey();
        $queryParam['secret'] = Functions::getApiSecret();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This api is use to get all active session by Access Token.
     * @param token Token generated from a successful oauth from social platform
     * @return Response containing Definition for Complete active sessions
     * 20.11.1
    */

    public function getActiveSession($token)
    {
        $resourcePath = "/api/v2/access_token/activesession";
        $queryParam = [];
        $queryParam['key'] = Functions::getApiKey();
        $queryParam['secret'] = Functions::getApiSecret();
        if ($token === '' || ctype_space($token)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('token'));
        }
        $queryParam['token'] = $token;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This api is used to get all active sessions by AccountID(UID).
     * @param accountId UID, the unified identifier for each user account
     * @return Response containing Definition for Complete active sessions
     * 20.11.2
    */

    public function getActiveSessionByAccountID($accountId)
    {
        $resourcePath = "/api/v2/access_token/activesession";
        $queryParam = [];
        if ($accountId === '' || ctype_space($accountId)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accountId'));
        }
        $queryParam['key'] = Functions::getApiKey();
        $queryParam['secret'] = Functions::getApiSecret();
        $queryParam['accountId'] = $accountId;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This api is used to get all active sessions by ProfileId.
     * @param profileId Social Provider Id
     * @return Response containing Definition for Complete active sessions
     * 20.11.3
    */

    public function getActiveSessionByProfileID($profileId)
    {
        $resourcePath = "/api/v2/access_token/activesession";
        $queryParam = [];
        $queryParam['key'] = Functions::getApiKey();
        if ($profileId === '' || ctype_space($profileId)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('profileId'));
        }
        $queryParam['secret'] = Functions::getApiSecret();
        $queryParam['profileId'] = $profileId;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }

}