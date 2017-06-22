<?php
/**
 * @link                : http://www.loginradius.com
 * @category            : SOTT
 * @package             : SOTT
 * @author              : LoginRadius Team
 * @license             : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\Utility\SOTTTest;

use LoginRadiusSDK\Utility\Functions;
use LoginRadiusSDK\Utility\SOTT;

date_default_timezone_set('UTC');

class SOTTTest extends \PHPUnit_Framework_TestCase
{
    protected $sott;
    public function __construct()
    {
        $this->sott = new SOTT(API_KEY, API_SECRET);
    }

    public function testEncrypt()
    {

        $this->cipher_text = $this->sott->encrypt();
        define('cipher_text', $this->cipher_text);
        $this->assertTrue(is_string($this->cipher_text));

    }
    public function testDecrypt()
    {
        $result = $this->sott->decrypt(cipher_text);
        $this->assertTrue(is_string($result));
    }

}