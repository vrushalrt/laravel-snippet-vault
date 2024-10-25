<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

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

RateLimiter::for('api', function (Request $request){
    return Limit::perMinute(60)->by($request->user()->id ?: $request->id);
});

// 'auth:sanctum' is a middleware that comes with Laravel and is
// defined in the file `vendor/laravel/framework/src/Illuminate/Auth/Middleware/AuthenticateWithBasicAuth.php`
// The middleware is registered in the file `vendor/laravel/framework/src/Illuminate/Auth/AuthServiceProvider.php`
// The middleware uses the `auth:sanctum` guard that is defined in the file `config/auth.php`

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// API Resource
Route::apiResource('events',EventController::class);
Route::apiResource('events.attendees',AttendeeController::class)
//    ->scoped(['attendee' => 'event']);
    ->scoped()->except(['update']);
