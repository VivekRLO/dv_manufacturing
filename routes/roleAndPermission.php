<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
// Roles and permission starts


Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('roles/edit/{role}', [RoleController::class, 'edit'])->name('roles.edit');
Route::patch('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::get('roles/show/{role}', [RoleController::class, 'show'])->name('roles.show');

Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
Route::get('permissions/edit/{permission}', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::patch('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');


// Roles and permission ends