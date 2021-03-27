<?php

use Illuminate\Support\Facades\Route;

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
    if (Auth::user()) {
        return redirect("/home");
    }
    return view('welcome');
});
Route::get('/log/{code}', 'Controller@log');
Route::get('/renew/{user_id}', 'Controller@renew');
Route::get('/cron', 'Controller@cron');

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
	Route::resource('computer', 'ComputerController');
});
Route::get('/home', 'HomeController@index')->name('home');
