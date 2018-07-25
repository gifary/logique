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

Route::get("/", "HomeController@index")->name("home");
Route::post("/check-email", "HomeController@checkEmail")->name("check-email");
Route::get("/get-memberships", "HomeController@getMemberShip")->name("get-memberships");
Route::post("/save-data-user", "HomeController@saveData")->name("save-data-user");
Route::get('login', 'HomeController@showLogin');

// route to process the form
Route::post('login', 'HomeController@doLogin')->name('login');
