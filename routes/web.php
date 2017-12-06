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
if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::get('/', function () {

    if (Auth::check()) {
        return view('home');
    }
    else {
        return view('welcome');
    }

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

// Route de test
Route::get('/test/{alias}', 'UserController@showTest')->name('test');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user/search', 'SearchController@search')->name('search');
Route::get('/user/search/autocomplete', 'SearchController@autocomplete')->name('search-autocomplete');

Route::get('/user/{alias}', 'UserController@showProfile')->middleware('auth')->name('profile');

Route::get('/user/{alias}/add', 'FriendRequestController@addFriend')->middleware('auth')->name('add-friend');
Route::get('/user/{alias}/remove', 'FriendRequestController@removeFriend')->middleware('auth')->name('remove-friend');

Route::get('/user/{alias}/friendrequests', 'FriendRequestController@showFriendRequest')->middleware('auth')->name('friend-requests');
Route::get('/user/{alias}/friends', 'FriendRequestController@showFriends')->middleware('auth')->name('friends');

Route::get('/user/{alias}/edit', 'UserController@showEdit')->middleware('auth')->name('profile-edit');
Route::post('/user/{alias}/edit', 'UserController@updateFromEdit')->middleware('auth');

Route::post('/chat', 'ChatController@sendMessage')->middleware('auth');
Route::get('/chat', 'ChatController@index')->middleware('auth')->name('chat');
