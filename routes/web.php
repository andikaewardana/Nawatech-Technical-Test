<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\LoginController AS LoginPelanggan;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrdersController;

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

// FRONTEND
Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/register', [LoginPelanggan::class, 'show'])->name('register.show');
Route::post('/register', [LoginPelanggan::class, 'register'])->name('register.perform');
Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify'); 


Route::get('/login', [LoginPelanggan::class, 'index'])->name('login.show');
Route::post('/login', [LoginPelanggan::class, 'login'])->name('login.perform');

Route::get('/logout', [LoginPelanggan::class, 'logout'])->name('logout.perform')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrdersController::class, 'update'])->name('orders.update');
Route::post('/cancel-orders', [OrdersController::class, 'cancel'])->name('orders.cancel');
Route::get('/export', [OrdersController::class, 'export'])->name('orders.export');



// BACKEND
Route::get('/admin', [LoginController::class, 'index'])->name('admin.index');
Route::post('/admin', [LoginController::class, 'login'])->name('login.validasiLogin');
Route::get('/admin-logout', [LoginController::class, 'logout'])->name('admin.logout')->middleware('auth');


Route::resource('/product', ProductController::class)->middleware(['auth', 'admin']);
