<?php

/**
 * @link : http://www.loginradius.com
 * @category : LoginRadiusSDK
 * @package : LoginRadius
 * @author : LoginRadius Team
 * @version : 3.5.0
 * @license : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Tests\Clients;


interface IHttpClientTest
{
    public function testRequest($path, $query_array = array(), $options = array());
}