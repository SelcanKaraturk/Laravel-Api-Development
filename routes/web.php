<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});

//Route::resource('product',ProductController::class);

//Route::get('user',[ProductController::class,'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/secured',function (){
    return 'You are authenticate';
})->middleware('auth');

Route::get('uploadForm',[HomeController::class,'upload_form'])->name('uploadForm');
Route::get('download/{filepath}',[HomeController::class,'download'])->name('download');
