<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [\App\Http\Controllers\AuthContorller::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthContorller::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthContorller::class, 'logout']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix'=>'categories'], function(){
        Route::get('/', [\App\Http\Controllers\Api\CategoriesController::class, 'indexCategories']);
        Route::get('/{id}', [\App\Http\Controllers\Api\CategoriesController::class, 'showCategories']);
        Route::post('/store', [\App\Http\Controllers\Api\CategoriesController::class, 'storeCategories']);
        Route::post('/update/{id}', [\App\Http\Controllers\Api\CategoriesController::class, 'updateCategories']);
        Route::post('/destroy/{id}', [\App\Http\Controllers\Api\CategoriesController::class, 'destroyCategories']);
    });
    Route::group(['prefix'=>'pages'], function(){
        Route::get('/', [\App\Http\Controllers\Api\PagesController::class, 'indexPages']);
        Route::get('/{id}', [\App\Http\Controllers\Api\PagesController::class, 'showPages']);
        Route::post('/store', [\App\Http\Controllers\Api\PagesController::class, 'storePages']);
        Route::post('/update/{id}', [\App\Http\Controllers\Api\PagesController::class, 'updatePages']);
        Route::post('/destroy/{id}', [\App\Http\Controllers\Api\PagesController::class, 'destroyPages']);
    });
    Route::group(['prefix'=>'products'], function(){
        Route::get('/', [\App\Http\Controllers\Api\ProductsController::class, 'indexProducts']);
        Route::get('/{id}', [\App\Http\Controllers\Api\ProductsController::class, 'showProducts']);
        Route::post('/store', [\App\Http\Controllers\Api\ProductsController::class, 'storeProducts']);
        Route::post('/update/{id}', [\App\Http\Controllers\Api\ProductsController::class, 'updateProducts']);
        Route::post('/destroy/{id}', [\App\Http\Controllers\Api\ProductsController::class, 'destroyProducts']);
    });

});
