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

date_default_timezone_set('UTC');

class SOTT  extends Functions
{
    const INITVECTOR = "tu89geji340t89u2";
    const KEYSIZE = 256;
    const DateFormat = 'Y/m/d H:i:s';

     public function __construct($options = [])
    {
        parent::__construct($options);
    }

    /**
     * Generate SOTT Manually.
     * You can pass the start and end time interval and the SOTT will be valid for this time duration. 
     * @param $startTime (optional) Valid Start Date with Date and time.
     * @param $endTime (optional) Valid End Date with Date and time.
     * @param $getLRserverTime (optional)  If true it will call LoginRadius Get Server Time Api and fetch basic server information and server time information which is useful when generating an SOTT token.
     * @param $timeDifference (optional) The time difference you would like to pass, If you not pass difference then the default value is 10 minutes.
     * @param $apiKey (optional) LoginRadius Api Key.
     * @param $apiSecret (optional) LoginRadius Api Secret.
     * @return string
     */

    public function getSott($startTime="",$endTime="", $getLRserverTime = false,$timeDifference = '', $apiKey = "",$apiSecret = "")
    {
        $time=!empty($timeDifference)?$timeDifference:'10';
   
        $apiKey=!empty($apiKey)?$apiKey:Functions::getApiKey();
        $apiSecret=!empty($apiSecret)?$apiSecret:Functions::getApiSecret();
      
        $plain_text = !empty($startTime) && !empty($endTime) ?$startTime . '#' . $apiKey . "#" . $endTime:"";
        if ($getLRserverTime) {
            $queryParam = [];
            $queryParam['apiKey'] = $apiKey;
            $queryParam['TimeDifference']=$time;
            $result =  Functions::_apiClientHandler('GET', "/identity/v2/serverinfo" ,$queryParam); 
            $startTime = isset($result->Sott) ? $result->Sott->StartTime : '';
            $startTime = str_replace("-", "/", $startTime);
            $endTime = isset($result->Sott) ? $result->Sott->EndTime : '';
            $endTime = str_replace("-", "/", $endTime);
            $plain_text = $startTime . '#' . $apiKey . "#" . $endTime;
        }else if(empty($plain_text)){
            $startTime = 0;
            $di = new \DateInterval('PT' . $startTime . 'M');
            $di->invert = 1;
            $start = new \DateTimeImmutable(gmdate(self::DateFormat));
            $plain_text = $start->add($di)->format(self::DateFormat) . '#' . $apiKey . "#" . $start->add(new \DateInterval('PT' . $time . 'M'))->format(self::DateFormat);
        }

        $plain_text = mb_convert_encoding($plain_text, 'UTF-8');
        $pass_phrase = mb_convert_encoding($apiSecret, 'UTF-8');
        $salt = str_pad("", 8, "\0");
        $key = hash_pbkdf2('sha1', $pass_phrase, $salt, 10000, self::KEYSIZE / 8, true);

        $init_vector = mb_convert_encoding(self::INITVECTOR, 'UTF-8');

        $temp_cipher = openssl_encrypt($plain_text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $init_vector);

        $token = base64_encode($temp_cipher);

        $ctx = hash_init('md5');

        hash_update($ctx, $token);
        return $token . '*' . hash_final($ctx);
    }


     /**
     * @deprecated
     * Generate SOTT Manually.
     * @param $timeDifference (optional) The time difference you would like to pass, If you not pass difference then the default value is 10 minutes.
     * @param $getLRserverTime (optional) If true it will call LoginRadius Get Server Time Api and fetch basic server information and server time information which is useful when generating an SOTT token.
     * @param $apiKey (optional) LoginRadius Api Key.
     * @param $apiSecret (optional) LoginRadius Api Secret.
     * @return string
     */

    public function encrypt($timeDifference = '', $getLRserverTime = false, $apiKey = "",$apiSecret = "")
    {
        $time=!empty($timeDifference)?$timeDifference:'10';
       
        $apiKey=!empty($apiKey)?$apiKey:Functions::getApiKey();
        
        $apiSecret=!empty($apiSecret)?$apiSecret:Functions::getApiSecret();

        if ($getLRserverTime) {
            $result = Functions::apiClient("/identity/v2/serverinfo", array("TimeDifference" => $time), array('output_format' => 'json'));
            $startTime = isset($result->Sott) ? $result->Sott->StartTime : '';
            $startTime = str_replace("-", "/", $startTime);
            $endTime = isset($result->Sott) ? $result->Sott->EndTime : '';
            $endTime = str_replace("-", "/", $endTime);
            $plain_text = $startTime . '#' . $apiKey . "#" . $endTime;
        }

        if (!$getLRserverTime || empty($startTime) || empty($endTime)) {
            $startTime = 0;
            $di = new \DateInterval('PT' . $startTime . 'M');
            $di->invert = 1;
            $start = new \DateTimeImmutable(gmdate(self::DateFormat));
            $plain_text = $start->add($di)->format(self::DateFormat) . '#' . $apiKey . "#" . $start->add(new \DateInterval('PT' . $time . 'M'))->format(self::DateFormat);
        }
        
        $plain_text = mb_convert_encoding($plain_text, 'UTF-8');
        $pass_phrase = mb_convert_encoding($apiSecret, 'UTF-8');
        $salt = str_pad("", 8, "\0");
        $key = hash_pbkdf2('sha1', $pass_phrase, $salt, 10000, self::KEYSIZE / 8, true);

        $init_vector = mb_convert_encoding(self::INITVECTOR, 'UTF-8');

        $temp_cipher = openssl_encrypt($plain_text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $init_vector);

        $token = base64_encode($temp_cipher);

        $ctx = hash_init('md5');

        hash_update($ctx, $token);
        return $token . '*' . hash_final($ctx);
    }
}
