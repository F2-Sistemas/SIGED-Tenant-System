<?php

use App\Http\Controllers\Admin\ImpersonateController;
use App\Http\Controllers\Core\TenantStorageUrlController;
use App\Http\Controllers\RedirectToAdminController;
use App\Http\Livewire\Products\ListProducts;
use App\Http\Livewire\Users\ListUsers;
use Illuminate\Support\Facades\Route;

TenantStorageUrlController::routes();

Route::middleware([
    'auth',
    'can:impersonate-a-tenant',
])->group(function () {
    Route::get('impersonate-tenant/{tenant}', [ImpersonateController::class, 'impersonate'])
        ->name('impersonate-tenant');

    Route::get('end-impersonated-tenant', [ImpersonateController::class, 'end'])->name('end-impersonated-tenant');
});

Route::view('/', 'welcome');
Route::get('/login', RedirectToAdminController::class)->name('login');

Route::get('users', ListUsers::class);
Route::get('products', ListProducts::class);
