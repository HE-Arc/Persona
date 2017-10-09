<?php

use App\User;

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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');


//TODO : Passer les middleware('auth') dans les controllers
Route::get('/home', 'HomeController@index')->name('home');

//Search
Route::get('/user/search', 'SearchController@search')->name('search');

Route::get('/user/{alias}', 'UserController@show')->middleware('auth')->name('profile');

Route::get('/user/{alias}/add', 'UserController@addFriend')->middleware('auth')->name('add-friend');
Route::get('/user/{alias}/remove', 'UserController@removeFriend')->middleware('auth')->name('remove-friend');

Route::get('/user/{alias}/edit', 'UserController@showEdit')->middleware('auth')->name('profile-edit');
Route::post('/user/{alias}/edit', 'UserController@updateFromEdit')->middleware('auth');
