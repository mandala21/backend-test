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
Route::get('survivor/', 'SurvivorController@index')->name('surivor.list');
Route::post('survivor/', 'SurvivorController@store')->name('survivor.create');
Route::put('survivor/{id}/', 'SurvivorController@update')->name('survivor.edit');
Route::post('survivor/mark_infected/', 'SurvivorController@markInfected')->name('survivor.markInfected');
// inventory urls
Route::post('inventory/trade/','InventoryController@makeTrade')->name('inventory.trade');
Route::post('inventory/','InventoryController@store')->name('inventory.create');
Route::get('inventory/{survivor_id}/','InventoryController@index')->name('inventory.list');
Route::delete('inventory/{survivor_id}/{item_id}/','InventoryController@destroy')->name('inventory.delete');
// reports urls
Route::get('reports/population','ReportController@population')->name('report.population');
Route::get('reports/itens','ReportController@itens')->name('report.itens');
Route::get('reports/lost_itens','ReportController@lostItens')->name('report.lot_itens');