<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MyJobApplicationController;
use App\Http\Controllers\MyJobController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// The root route redirects to the jobs.index route.
// The `to_route` helper is a shortcut for generating the URL to a named route.
// So, this redirects to the URL that the `jobs.index` route resolves to.
// This is a common pattern when you want the root of your website to go to a specific route.
Route::get('', fn() => to_route('jobs.index'));

Route::resource('jobs', JobController::class)->only(['index', 'show']);

Route::get('login', fn() => to_route('auth.create'))->name('login');
Route::resource('auth', AuthController::class)->only(['create', 'store']);

Route::delete('logout', fn() => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])->name('auth.destroy');

Route::middleware('auth')->group(function(){
    Route::resource('job.application', JobApplicationController::class)
        ->only(['create','store']); // Only allow the authenticated user to create and store job applications.

    Route::resource('my-jobs-applications', MyJobApplicationController::class)
        ->only(['index', 'destroy']); // Only allow the authenticated user to view and destroy job applications for their jobs.

    Route::resource('employer', EmployerController::class)
        ->only(['create', 'store']); // Only allow the authenticated user to create and store employers.
        
    Route::middleware('employer')
        ->resource('my-jobs', MyJobController::class); 
});