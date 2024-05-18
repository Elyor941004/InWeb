<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/categories');
Route::redirect('/home', '/categories');
Auth::routes();

//Route::group(['middleware'=>['isAdmin']], function() {
//
//});
Route::get('/api/documentation', function () {
    $baseUrl = url('/');
    return redirect("$baseUrl/api/documentation");
})->name('api_documentation');
Route::group(['middleware'=>['auth']], function() {
    Route::resource('categories', \App\Http\Controllers\CategoriesController::class);
    Route::resource('pages', \App\Http\Controllers\PagesController::class);
    Route::resource('products', \App\Http\Controllers\ProductsController::class);
});
