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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('customers')->group(function () {
    Route::post('store', 'CustomerController@store');
    Route::get('{customer_id}/transactions/{transaction_id}', 'CustomerController@transaction');
});

Route::prefix('transactions')->group(function () {
    Route::get('/', 'TransactionController@index');
    Route::post('store', 'TransactionController@store');
    Route::put('{id}', 'TransactionController@update');
    Route::delete('{id}', 'TransactionController@destroy');
});
