/**
 * title: Using LoginRadius PHP SDK with Composer
 * website: https://www.loginradius.com
 * author: lucius@loginradius.com
 * date: Dec 02, 2014
 */


1. Open your composer.json file in your project's root directory.

2. Add the following line under "require" dependencies
   =>"loginradius/php-sdk-2.0": "dev-master"

3. After doing composer install/update, you should be able to see folder "loginradius" in your vendor folder

4. To use the class
	a. require your autoload.php file (you may have done that)
	=> require_once __DIR__ . '/../vendor/autoload.php';

	b. use
	=> use LoginRadiusSDK\LoginRadius;

	c. call class object LoginRadius like this
	=> LoginRadius::loginradius_is_callback()

5. Test

	To run a simple test with the composer class, you can copy the file test.php to your root directory, and run
	=> $ php test.php
	in your command line. If you see a sentence like "Call back failed, but loginradius class is found.", then it means loginradius class is successfully imported.
