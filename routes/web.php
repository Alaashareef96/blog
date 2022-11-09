<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
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

Route::prefix('admin/dashboard')->middleware('auth:admin')->group(function(){

    Route::get('/change-lang/{language}', [DashboardController::class, 'changeLanguage'])->name('dashboard.change-language');
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('edit-profile', [AuthController::class,'editProfile'])->name('auth.edit-profile');
    Route::get('edit-password', [AuthController::class,'editPassword'])->name('auth.edit-password');

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::put('roles/{role}/permission', [RolePermissionController::class, 'update'])->name('role-permission.update');

    Route::resource('admins', AdminController::class);

    Route::resource('posts', PostController::class);

});
