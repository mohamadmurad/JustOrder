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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/getSubGroup/{groupID}',[\App\Http\Controllers\SubgroupController::class,'getByGroup']);

Route::post('/AddFabric',[\App\Http\Controllers\FabricController::class,'addFromOrder']);
Route::get('/AddFabric',[\App\Http\Controllers\FabricController::class,'addFromOrder']);
