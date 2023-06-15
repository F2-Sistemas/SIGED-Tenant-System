<?php

use App\Http\Controllers\RedirectToAdminController;
use App\Http\Livewire\Users\ListUsers;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Products\ListProducts;


Route::view('/', 'welcome');
Route::get('/login', RedirectToAdminController::class)->name('login');

Route::get('users', ListUsers::class);
Route::get('products', ListProducts::class);
