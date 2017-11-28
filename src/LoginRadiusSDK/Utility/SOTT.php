<?php

/**
 * @link                : http://www.loginradius.com
 * @category            : Utility
 * @package             : SOTT
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Utility;

use LoginRadiusSDK\Utility\Functions;

class SOTT {

    private $secret;
    private $key;

    public function __construct($apikey = '', $apisecret = '', $options = array()) {
        if (!empty($apikey) && !empty($apisecret)) {
            $this->secret = $apisecret;
            $this->key = $apikey;
            new Functions($this->key, $this->secret, $options);
        } else {
            $this->secret = Functions::getApiSecret();
            $this->key = Functions::getApiKey();
        }
    }

    /**
     * Encrypt data.
     *
     * @param $time
     * @return string
     */
    public function encrypt($time = '10', $getLRserverTime = false) {
        $options = array('authentication' => 'secret');
        $url = API_DOMAIN . "/identity/v2/manage/account/sott";
        return Functions::apiClient($url, array('timedifference' => $time), $options);        
    }
}