<?php

use Illuminate\Support\Facades\Route;
use Modules\Superadmin\Http\Controllers\PermissionController;
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

Route::prefix('superadmin')->group(function () {
    Route::get('/', 'SuperadminController@index');
});

Route::middleware('auth')->group(function () {
    Route::middleware(['can:see permission list'])->get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::middleware(['can:create permission'])->get('/create/permission', [PermissionController::class, 'create'])->name('permission.create');
    Route::middleware(['can:create permission'])->post('/create/permission', [PermissionController::class, 'store'])->name('permission.store');
    Route::middleware(['can:edit permission'])->get('/edit/permission/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::middleware(['can:edit permission'])->post('/update/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::middleware(['can:delete permission'])->post('/delete/permission/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
    // Route::middleware(['can:assign permission'])->post('/assign/permission/{id}', [PermissionController::class, 'give_permission'])->name('permission.assign');
    Route::post('/assign/permission/{id}', [PermissionController::class, 'give_permission'])->name('permission.assign');
    Route::post('/revoke/permission/{id}', [PermissionController::class, 'revoke_permission'])->name('permission.revoke');
    // Route::middleware(['can:revoke permission'])->post('/revoke/permission/{id}', [PermissionController::class, 'revoke_permission'])->name('permission.revoke');
});


