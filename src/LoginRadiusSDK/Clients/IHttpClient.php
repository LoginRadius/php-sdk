<?php

/**
 * @link : http://www.loginradius.com
 * @category : Clients
 * @package : IHttpClient
 * @author : LoginRadius Team
 * @version : 4.2.0
 * @license : https://opensource.org/licenses/MIT
 */

namespace LoginRadiusSDK\Clients;

/**
 * Interface IHttpClient
 *
 * Used for Custom Client Library.
 *
 * @package LoginRadiusSDK\Clients
 */
interface IHttpClient
{
    public function request($path, $query_array = array(), $options = array());
}