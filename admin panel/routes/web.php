<?php

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


Auth::routes();

Route::get('/clear', function() {
    \Artisan::call('cache:clear');
    \Artisan::call('config:cache');
});
Route::group([
    'middleware' => 'auth',
], function ($router) {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'task'
], function ($router) {
    Route::get('status/{task}/{action}', [App\Http\Controllers\TaskController::class, 'status'])->name('task.status');
});