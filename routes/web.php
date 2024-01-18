<?php

use App\Http\Controllers\Clients\ClientController;
use App\Http\Controllers\Configuration\UserController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\Strategy\StrategyController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/login-api/{crm_id}', [UserController::class, 'authApi']);


Route::group(['middleware' => ['auth']], function () {
    // Route::resource('roles', RoleController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/clients', ClientController::class);
    Route::resource('/strategy', StrategyController::class);

    Route::get('/strategy/desing/{id}', [StrategyController::class, 'desing'])->name('strategy.desing');
    route::post('/strategy/test-strategy', [StrategyController::class, 'testStrategy'])->name('strategy.test-strategy');
    Route::post('/strategy/save-strategy', [StrategyController::class, 'saveStrategy'])->name('strategy.save-strategy');
    route::post('/strategy/accepted-strategy', [StrategyController::class, 'acceptedStrategy'])->name('strategy.accepted-strategy');
    route::get('/strategy/history/{client}/{history}', [StrategyController::class, 'history'])->name('strategy.history');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');



//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
