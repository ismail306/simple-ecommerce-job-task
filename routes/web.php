<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::resource('admin/categories', CategoryController::class, ['names' => 'categories']);
Route::resource('admin/products', ProductController::class, ['names' => 'products']);
Route::get('/product/{slug}', [HomeController::class, 'getProductBySlug'])->name('getProductBySlug');

