<?php

use App\Http\Controllers\api\V1\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\V1\MenuController;
use App\Http\Controllers\api\V1\OrderController;
use App\Http\Controllers\api\V1\OrderitemController;
use App\Http\Controllers\api\V1\UserController;
use App\Models\Orderitem;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// this group prefix allows us to add a v1 endpoint to the url
// this is how it will look like
// https://name.com/api/v1/......



Route::group(['prefix' => 'v1'], function() 
{
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    
    Route::apiResource('menu', MenuController::class);
        
    Route::group(['prefix' => 'admin'], function() {
        Route::apiResource('categories', CategoryController::class);
    });

    Route::group(['middleware' => ['auth:sanctum']], function() 
    {   
        Route::post('/logout', [UserController::class, 'logout']);
        /* Route::apiResource('menu', MenuController::class); */
        Route::apiResource('add-to-cart', OrderitemController::class);
        Route::apiResource('checkout', OrderController::class);
    });
});





