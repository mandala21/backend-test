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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// survivor urls
Route::get('survivor/', 'SurvivorController@index');
Route::post('survivor/', 'SurvivorController@store');
Route::put('survivor/{id}/', 'SurvivorController@update');
Route::post('survivor/mark_infected/', 'SurvivorController@markInfected');
// inventory urls
Route::post('inventory/trade/','InventoryController@makeTrade');
Route::post('inventory/','InventoryController@store');
Route::get('inventory/{survivor_id}','InventoryController@index');