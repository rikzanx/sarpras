<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\PengajuanController;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('registration');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('forgot_password', [AuthController::class, 'forgot_password'])->name('forgot_password');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => [AuthMiddleware::class]],function(){
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/list_data_user', [UserController::class, 'list_data_user'])->name('list_data_user');
    Route::post('/add_user_action', [UserController::class, 'add_user_action'])->name('add_user_action');
    Route::get('/show_user_data/{id_user}',[UserController::class, 'show_user_data'])->name('show_user_data');
    Route::post('/edit_user_action/{id_user}', [UserController::class, 'edit_user_action'])->name('edit_user_action');
    Route::post('/delete_user_action/{id_user}', [UserController::class, 'delete_user_action'])->name('delete_user_action');



    Route::get('/list_data_inventory_group', [GroupController::class, 'list_data_inventory_group'])->name('list_data_inventory_group');

    Route::get('/list_data_barang', [BarangController::class, 'list_data_barang'])->name('list_data_barang');

    Route::get('/list_data_satuan', [SatuanController::class, 'list_data_satuan'])->name('list_data_satuan');



    Route::get('/list_data_pengajuan', [PengajuanController::class, 'list_data_pengajuan'])->name('list_data_pengajuan');



});

Route::get('toast', [DashboardController::class, 'toast'])->name('toast');


