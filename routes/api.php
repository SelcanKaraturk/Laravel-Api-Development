<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use \App\Http\Controllers\Api\CategoryController;
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

Route::get('deneme',function (){
    return 'Api Test';
});

//Route::apiResource('product',ProductController::class);
Route::get('category/custom1',[CategoryController::class,'custom1']);
Route::get('category/custom2',[CategoryController::class,'custom2']);
Route::get('product/report1',[ProductController::class,'report1']);
Route::get('product/custom1',[ProductController::class,'custom1']);
Route::get('user/custom1',[UserController::class,'custom1']);
Route::get('product/listwithcategories',[ProductController::class,'listWithCategories']);

Route::apiResources([
    'product'=>ProductController::class,
    'users'=>UserController::class,
    'category'=>CategoryController::class,
]);

