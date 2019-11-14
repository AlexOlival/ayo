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

Route::view('/', 'welcome')->name('welcome');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/reminders', 'RemindersController@index');
    Route::get('/expanded-reminders', 'ExpandedReminderListController@index');
    Route::post('/reminders', 'RemindersController@store');
    Route::patch('/reminders/{reminder}', 'RemindersController@update');
    Route::delete('/reminders/{reminder}', 'RemindersController@destroy');

    Route::get('/invites', 'InvitesController@index');
    Route::get('/expanded-invites', 'ExpandedInviteListController@index');
    Route::patch('/accept-invite/{reminder}', 'AcceptInviteController');
    Route::patch('/refuse-invite/{reminder}', 'RefuseInviteController');

    Route::get('/search-users', 'SearchUsersController');

    Route::get('/profile', 'UsersController@show')->name('profile.show');
    Route::post('/users/{user}/avatars', 'UserAvatarsController@store')->name('avatar.store');
    Route::delete('/users/{user}', 'UsersController@destroy')->name('user.destroy');
});
