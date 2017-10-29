<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::post('register', 'APIControllers\MainController@register');
Route::post('register',['as'=>'register','uses'=>'APIControllers\MainController@register']);
Route::post('login', ['as'=>'login', 'uses'=>'APIControllers\MainController@login']);

Route::group(['middleware' => 'jwt-auth'], function () {
  Route::post('add-city', ['as'=>'add-city','uses'=>'APIControllers\ManageCities@addCity']);
  Route::post('get-city', ['as'=>'get-city','uses'=>'APIControllers\WeatherData@getWeatherForUser']);
  Route::post('get-info', ['as'=>'get-info','uses'=>'APIControllers\MainController@getUserInfo']);
});
