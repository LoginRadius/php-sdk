<?php
 /**
 * @category            : CustomerRegistration
 * @link                : http://www.loginradius.com
 * @package             : NativeSocialAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Social;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

class NativeSocialAPI extends Functions
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }
       


    /**
     * The API is used to get LoginRadius access token by sending Facebook's access token. It will be valid for the specific duration of time specified in the response.
     * @param fbAccessToken Facebook Access Token
     * @param socialAppName Name of Social provider APP
     * @return Response containing Definition of Complete Token data
     * 20.3
    */

    public function getAccessTokenByFacebookAccessToken($fbAccessToken, $socialAppName = null)
    {
        $resourcePath = "/api/v2/access_token/facebook";
        $queryParam = [];
        if ($fbAccessToken === '' || ctype_space($fbAccessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('fbAccessToken'));
        }
        $queryParam['key'] = Functions::getApiKey();
        if ($socialAppName != '') {
            $queryParam['socialAppName'] = $socialAppName;
        }
        $queryParam['fb_Access_Token'] = $fbAccessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * The API is used to get LoginRadius access token by sending Twitter's access token. It will be valid for the specific duration of time specified in the response.
     * @param twAccessToken Twitter Access Token
     * @param twTokenSecret Twitter Token Secret
     * @param socialAppName Name of Social provider APP
     * @return Response containing Definition of Complete Token data
     * 20.4
    */

    public function getAccessTokenByTwitterAccessToken($twAccessToken, $twTokenSecret,
        $socialAppName = null)
    {
        $resourcePath = "/api/v2/access_token/twitter";
        $queryParam = [];
        $queryParam['key'] = Functions::getApiKey();
        if ($twAccessToken === '' || ctype_space($twAccessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('twAccessToken'));
        }
        if ($twTokenSecret === '' || ctype_space($twTokenSecret)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('twTokenSecret'));
        }
        if ($socialAppName != '') {
            $queryParam['socialAppName'] = $socialAppName;
        }
        $queryParam['tw_Access_Token'] = $twAccessToken;
        $queryParam['tw_Token_Secret'] = $twTokenSecret;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * The API is used to get LoginRadius access token by sending Google's access token. It will be valid for the specific duration of time specified in the response.
     * @param googleAccessToken Google Access Token
     * @param clientId Google Client ID
     * @param refreshToken LoginRadius refresh token
     * @param socialAppName Name of Social provider APP
     * @return Response containing Definition of Complete Token data
     * 20.5
    */

    public function getAccessTokenByGoogleAccessToken($googleAccessToken, $clientId = null,
        $refreshToken = null, $socialAppName = null)
    {
        $resourcePath = "/api/v2/access_token/google";
        $queryParam = [];
        if ($googleAccessToken === '' || ctype_space($googleAccessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('googleAccessToken'));
        }
        $queryParam['key'] = Functions::getApiKey();
        if ($clientId != '') {
            $queryParam['client_id'] = $clientId;
        }
        if ($refreshToken != '') {
            $queryParam['refresh_token'] = $refreshToken;
        }
        if ($socialAppName != '') {
            $queryParam['socialAppName'] = $socialAppName;
        }
        $queryParam['google_Access_Token'] = $googleAccessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to Get LoginRadius Access Token using google jwt id token for google native mobile login/registration.
     * @param idToken Custom JWT Token
     * @return Response containing Definition of Complete Token data
     * 20.6
    */

    public function getAccessTokenByGoogleJWTAccessToken($idToken)
    {
        $resourcePath = "/api/v2/access_token/googlejwt";
        $queryParam = [];
        if ($idToken === '' || ctype_space($idToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('idToken'));
        }
        $queryParam['key'] = Functions::getApiKey();
        $queryParam['id_Token'] = $idToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * The API is used to get LoginRadius access token by sending Linkedin's access token. It will be valid for the specific duration of time specified in the response.
     * @param lnAccessToken Linkedin Access Token
     * @param socialAppName Name of Social provider APP
     * @return Response containing Definition of Complete Token data
     * 20.7
    */

    public function getAccessTokenByLinkedinAccessToken($lnAccessToken, $socialAppName = null)
    {
        $resourcePath = "/api/v2/access_token/linkedin";
        $queryParam = [];
        $queryParam['key'] = Functions::getApiKey();
        if ($lnAccessToken === '' || ctype_space($lnAccessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('lnAccessToken'));
        }
        if ($socialAppName != '') {
            $queryParam['socialAppName'] = $socialAppName;
        }
        $queryParam['ln_Access_Token'] = $lnAccessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * The API is used to get LoginRadius access token by sending Foursquare's access token. It will be valid for the specific duration of time specified in the response.
     * @param fsAccessToken Foursquare Access Token
     * @return Response containing Definition of Complete Token data
     * 20.8
    */

    public function getAccessTokenByFoursquareAccessToken($fsAccessToken)
    {
        $resourcePath = "/api/v2/access_token/foursquare";
        $queryParam = [];
        if ($fsAccessToken === '' || ctype_space($fsAccessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('fsAccessToken'));
        }
        $queryParam['key'] = Functions::getApiKey();
        $queryParam['fs_Access_Token'] = $fsAccessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * The API is used to get LoginRadius access token by sending a valid Apple ID OAuth Code. It will be valid for the specific duration of time specified in the response.
     * @param code Apple Code
     * @param socialAppName Name of Social provider APP
     * @return Response containing Definition of Complete Token data
     * 20.12
    */

    public function getAccessTokenByAppleIdCode($code, $socialAppName = null)
    {
        $resourcePath = "/api/v2/access_token/apple";
        $queryParam = [];
        if ($code === '' || ctype_space($code)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('code'));
        }
        $queryParam['key'] = Functions::getApiKey();
        if ($socialAppName != '') {
            $queryParam['socialAppName'] = $socialAppName;
        }
        $queryParam['code'] = $code;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to retrieve a LoginRadius access token by passing in a valid WeChat OAuth Code.
     * @param code WeChat Code
     * @return Response containing Definition of Complete Token data
     * 20.13
    */

    public function getAccessTokenByWeChatCode($code)
    {
        $resourcePath = "/api/v2/access_token/wechat";
        $queryParam = [];
        if ($code === '' || ctype_space($code)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('code'));
        }
        $queryParam['key'] = Functions::getApiKey();
        $queryParam['code'] = $code;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * The API is used to get LoginRadius access token by sending Google's AuthCode. It will be valid for the specific duration of time specified in the response.
     * @param googleAuthcode Google AuthCode
     * @param socialAppName Name of Social provider APP
     * @return Response containing Definition of Complete Token data
     * 20.16
    */

    public function getAccessTokenByGoogleAuthCode($googleAuthcode, $socialAppName = null)
    {
        $resourcePath = "/api/v2/access_token/google";
        $queryParam = [];
        $queryParam['apiKey'] = Functions::getApiKey();
        if ($googleAuthcode === '' || ctype_space($googleAuthcode)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('googleAuthcode'));
        }
        if ($socialAppName != '') {
            $queryParam['socialAppName'] = $socialAppName;
        }
        $queryParam['google_authcode'] = $googleAuthcode;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }
       


    /**
     * This API is used to retrieve a LoginRadius access token by passing in a valid custom JWT token.
     * @param idToken Custom JWT Token
     * @param providername JWT Provider Name
     * @return Response containing Definition of Complete Token data
     * 44.3
    */

    public function accessTokenViaCustomJWTToken($idToken, $providername)
    {
        $resourcePath = "/api/v2/access_token/jwt";
        $queryParam = [];
        if ($idToken === '' || ctype_space($idToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('idToken'));
        }
        $queryParam['key'] = Functions::getApiKey();
        if ($providername === '' || ctype_space($providername)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('providername'));
        }
        $queryParam['id_Token'] = $idToken;
        $queryParam['providername'] = $providername;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }

}