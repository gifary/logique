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
Route::post("/save-data-user", "HomeController@saveData")->name("save-data-user");
