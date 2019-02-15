<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('index');
});
*/

/*
route for view
*/


Route::get('/index','HomeController@index');
Route::get('/minimal', ['as' => 'minimal', 'uses' => 'HomeController@index']);

Route::get('/login', ['as' => 'login', 'uses' => 'HomeController@loginscreen']);
Route::get('/profile', ['as' => 'profileview', 'uses' => 'HomeController@profile']);
Route::get('/register', ['as' => 'signup', 'uses' => 'HomeController@signup']);

Route::get('/forgotpassword', ['as' => 'forgot', 'uses' => 'HomeController@forgot']);
Route::get('/changepassword', ['as' => 'changepassword', 'uses' => 'HomeController@changePassword']);
Route::get('/setpassword', ['as' => 'setpassword', 'uses' => 'HomeController@setPassword']);
Route::get('/account', ['as' => 'account', 'uses' => 'HomeController@account']);

Route::get('/customobjects', ['as' => 'customobjects', 'uses' => 'HomeController@customObjects']);
Route::get('/roles', ['as' => 'roles', 'uses' => 'HomeController@roles']);
Route::get('/multifactor', ['as' => 'multifactor', 'uses' => 'HomeController@multifactor']);
Route::get('/accountlinking', ['as' => 'accountlinking', 'uses' => 'HomeController@accountlinking']);
/** 
 * route for controller
 */
Route::post('/loginByEmail', 'HomeController@loginByEmail');
Route::any('/profile', 'Profile@Profile');
Route::any('/forgot', 'HomeController@forgot');
Route::any('/minimal', 'HomeController@minimal');
Route::any('/signup', 'HomeController@signup');

/** 
 * default route
 */
Route::any('/{default?}', 'HomeController@index');





