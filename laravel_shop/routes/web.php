<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AuthController as AdminAuthController;
use App\Http\Controllers\AuthController as WebAuthController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('auth:admin', AdminAuthController::class)->only(['create', 'store','destroy']);
Route::resource('auth:web', WebAuthController::class)->only(['create', 'store','destroy']);

Route::get('login', [WebAuthController::class,'create'])->name('login');
Route::get('admin/login', [AdminAuthController::class,'create'])->name('admin.login');

//Web
Route::middleware('auth')->group( function(){
    Route::resource('user', UserController::class)->only(['index','show','edit','update']);
});

//Admin
Route::middleware('auth.admin')->group( function(){
    
    Route::get('admin',[AdminController::class,'index'])->name('admin.index');
    
});