<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/{id}', [DashboardController::class, 'show'])->name('user.show');

    // Route::middleware(['can:make users'])->get('/create/user', [DashboardController::class, 'create'])->name('user.create');
    // Route::middleware(['can:make users'])->post('/create/user', [DashboardController::class, 'store'])->name('user.store');
    
    Route::get('/edit/user/{id}', [DashboardController::class, 'edit'])->name('user.edit');
    Route::post('/update/user/{id}', [DashboardController::class, 'update'])->name('user.update');
    Route::post('/delete/user/{id}', [DashboardController::class, 'destroy'])->name('user.destroy');

    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/create/role', [RoleController::class, 'create'])->name('role.create');
    Route::post('/create/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/edit/role/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/update/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::post('/delete/role/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::post('/assign/permission/role/{id}', [RoleController::class, 'give_permission'])->name('role.permission.assign');
    Route::post('/revoke/permission/role/{id}', [RoleController::class, 'revoke_permission'])->name('role.permission.revoke');
    
    // Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    // Route::get('/create/permission', [PermissionController::class, 'create'])->name('permission.create');
    // Route::post('/create/permission', [PermissionController::class, 'store'])->name('permission.store');
    // Route::get('/edit/permission/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    // Route::post('/update/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
    // Route::post('/delete/permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    // Route::post('/assign/permission/{id}',[PermissionController::class,'give_permission'])->name('permission.assign');

    
});


require __DIR__ . '/auth.php';
