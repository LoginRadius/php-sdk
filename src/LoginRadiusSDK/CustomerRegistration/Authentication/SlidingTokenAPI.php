<?php
 /**
 * @category            : CustomerRegistration
 * @link                : http://www.loginradius.com
 * @package             : SlidingTokenAPI
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\CustomerRegistration\Authentication;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\LoginRadiusException;

class SlidingTokenAPI extends Functions
{

    public function __construct($options = [])
    {
        parent::__construct($options);
    }
       


    /**
     * 
     * @param accessToken 
     * @return Response containing Definition of Complete Token data
     * 1.3
    */

    public function slidingAccessToken($accessToken)
    {
        $resourcePath = "/identity/v2/auth/access_token/sliding_token";
        $queryParam = [];
        if ($accessToken === '' || ctype_space($accessToken)) {
            throw new LoginRadiusException(Functions::paramValidationMsg('accessToken'));
        }
        $queryParam['apiKey'] = Functions::getApiKey();
        $queryParam['access_token'] = $accessToken;
        return Functions::_apiClientHandler('GET', $resourcePath, $queryParam);
    }

}