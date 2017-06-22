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

class SOTT {

    private $secret;
    private $key;

    const INITVECTOR = "tu89geji340t89u2";
    const KEYSIZE = 256;
    const DateFormat = 'Y/m/d H:i:s';

    public function __construct($apikey = '', $apisecret = '', $options = array()) {
        if (!empty($apikey) && !empty($apisecret)) {
            $this->secret = $apisecret;
            $this->key = $apikey;
            $options = array_merge(array('authentication' => 'key'), $options);
            new Functions($this->key, $this->secret, $options);
        }else {
            $this->secret = Functions::getApiSecret();
            $this->key = Functions::getApiKey();
        }
    }

    /**
     * Encrpyt data.
     *
     * @param $time
     * @return string
     */
    public function encrypt($time = '10', $getLRserverTime = false) {
        if ($getLRserverTime) {      
            $result = Functions::apiClient("/identity/v2/serverinfo", array("TimeDifference" => $time), array('output_format' => 'json'));
            $startTime = isset($result->Sott) ? $result->Sott->StartTime : '';
            $startTime = str_replace("-", "/", $startTime);
            $endTime = isset($result->Sott) ? $result->Sott->EndTime : '';
            $endTime = str_replace("-", "/", $endTime);
            $plain_text = $startTime . '#' . $this->key . "#" . $endTime;
        }
        if(!$getLRserverTime || empty($startTime) || empty($endTime)) {
            $startTime = 5;
            $di = new \DateInterval('PT' . $startTime . 'M');
            $di->invert = 1;
            $start = new \DateTimeImmutable(gmdate(self::DateFormat));
            $plain_text = $start->add($di)->format(self::DateFormat) . '#' . $this->key . "#" . $start->add(new \DateInterval('PT' . $time . 'M'))->format(self::DateFormat);
        } 

        $plain_text = mb_convert_encoding($plain_text, 'UTF-8');
        $pass_phrase = mb_convert_encoding($this->secret, 'UTF-8');
        $salt = str_pad("", 8, "\0");
        $key = hash_pbkdf2('sha1', $pass_phrase, $salt, 10000, self::KEYSIZE / 8, true);

        $init_vector = mb_convert_encoding(self::INITVECTOR, 'UTF-8');

        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $padding = $block - (strlen($plain_text) % $block);
        $plain_text .= str_repeat(chr($padding), $padding);

        $temp_cipher = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plain_text, MCRYPT_MODE_CBC, $init_vector);

        $token = base64_encode($temp_cipher);

        $ctx = hash_init('md5');

        hash_update($ctx, $token);
        return $token . '*' . hash_final($ctx);
    }

    /**
     * Decrypt data.
     *
     * @param $cipher_text
     * @return string
     */
    public function decrypt($cipher_text) {
        $ciphered_token = base64_decode(str_replace("%2B", "+", strstr($cipher_text, '*', true)));
        $pass_phrase = mb_convert_encoding($this->secret, 'UTF-8');
        $salt = str_pad("", 8, "\0");
        $key = hash_pbkdf2('sha1', $pass_phrase, $salt, 10000, self::KEYSIZE / 8, true);
        $init_vector = mb_convert_encoding(self::INITVECTOR, 'UTF-8');
        $deciphered_text = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphered_token, MCRYPT_MODE_CBC, $init_vector);

        return $deciphered_text;
    }

}
