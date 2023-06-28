<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Users\ListUsers;
use App\Http\Livewire\Products\ListProducts;
use App\Http\Controllers\RedirectToAdminController;
use App\Http\Controllers\Admin\ImpersonateController;
use App\Http\Controllers\Core\TenantStorageUrlController;
use App\Http\Controllers\Core\DependenceManagerUrlController;

TenantStorageUrlController::routes();
DependenceManagerUrlController::routes();

Route::middleware([
    'auth',
    'can:impersonate-a-tenant',
])->group(function () {
    Route::get('impersonate-tenant/{tenant}', [ImpersonateController::class, 'impersonate'])
        ->name('impersonate-tenant');

    Route::get('end-impersonated-tenant', [ImpersonateController::class, 'end'])->name('end-impersonated-tenant');
});

Route::get('/', RedirectToAdminController::class)->name('home');
Route::get('/login', RedirectToAdminController::class)->name('login');

Route::get('users', ListUsers::class);
Route::get('products', ListProducts::class);
