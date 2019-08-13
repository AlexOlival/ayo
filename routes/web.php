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
    Route::get('/expanded-reminders', 'ExpandedReminderListController@index');

    /*
    |--------------------------------------------------------------------------
    | Families Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::prefix('reminders')->name('reminders.')->group(function () {
        Route::get('/', 'RemindersController@index')->name('index');
        Route::post('/', 'RemindersController@store')->name('store');
        Route::patch('/{reminder}', 'RemindersController@update')->name('update');
        Route::middleware('reminder.is.valid')->delete('/{reminder}', 'RemindersController@delete')->name('destroy');
    });

    Route::get('/invites', 'InvitesController@index');

    Route::get('/search-users', 'SearchUsersController');

    Route::get('/profile', 'UsersController@show')->name('profile.show');
    Route::post('/users/{user}/avatars', 'UserAvatarsController@store')->name('avatar.store');
});
