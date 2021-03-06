<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/scan/{block}', [\App\Http\Controllers\API\ApiController::class, 'scanWafer']);

Route::get('/mappings', [\App\Http\Controllers\API\ApiController::class, 'getMappings']);

Route::get('/orders/{order}', [\App\Http\Controllers\API\ApiController::class, 'getOrder']);
Route::get('/orders/{order}/{block}', [\App\Http\Controllers\API\ApiController::class, 'getBlock']);
Route::post('/orders', [\App\Http\Controllers\API\ApiController::class, 'createOrder']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
