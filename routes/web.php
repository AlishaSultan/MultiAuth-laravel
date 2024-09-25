<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\manager\LoginController as ManagerLoginController;
use App\Http\Controllers\manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['prefix'=>'account'],function() {
    Route::group(['middleware'=>'guest'],function() {
        Route::get('login',[LoginController::class,'loginView'])->name('account.login');
        Route::get('register',[LoginController::class,'registerView'])->name('account.register');
        Route::post('registration',[LoginController::class,'registration'])->name('account.created');
        Route::post('authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');
    });

    Route::group(['middleware'=>'auth'],function() {
        Route::get('logout',[LoginController::class,'logout'])->name('account.logout');
        Route::get('dashboard',[DashboardController::class,'index'])->name('account.dashboard');
    });
});


Route::group(['prefix'=>'admin'],function() {
    Route::group(['middleware'=>'admin.guest'],function() {
        Route::get('login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');

    });

    Route::group(['middleware'=>'admin.auth'],function() {
      Route::get('dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
      Route::get('logout',[AdminLoginController::class,'logout'])->name('admin.logout');
      
    });
});


Route::group(['prefix'=>'manager'],function() {
      Route::group(['middleware'=>'manager.guest'],function() {
        Route::get('login',[ManagerLoginController::class,'index'])->name('manager.login');
        Route::post('authenticate',[ManagerLoginController::class,'authenticate'])->name('manager.authenticate');
      });
      Route::group(['middleware'=>'manager.auth'],function(){
        Route::get('dashboard',[ManagerDashboardController::class,'index'])->name('manager.dashboard');
        Route::get('logout',[ManagerLoginController::class,'logout'])->name('manager.logout');

      });
});



