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
use App\Http\Controllers\TransactionController;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('registration');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('forgot_password', [AuthController::class, 'forgot_password'])->name('forgot_password');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => [AuthMiddleware::class]],function(){

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/list_transaksi_barang_masuk',[TransactionController::class,'list_transaksi_barang_masuk'])->name('list_transaksi_barang_masuk');
    Route::get('/list_transaksi_barang_keluar',[TransactionController::class,'list_transaksi_barang_keluar'])->name('list_transaksi_barang_keluar');

    Route::get('/list_data_user', [UserController::class, 'list_data_user'])->name('list_data_user');
    Route::get('/show_user_data/{id_user}',[UserController::class, 'show_user_data'])->name('show_user_data');
    Route::post('/add_user_action', [UserController::class, 'add_user_action'])->name('add_user_action');
    Route::post('/edit_user_action/{id_user}', [UserController::class, 'edit_user_action'])->name('edit_user_action');
    Route::post('/delete_user_action/{id_user}', [UserController::class, 'delete_user_action'])->name('delete_user_action');

    Route::get('/list_data_group', [GroupController::class, 'list_data_group'])->name('list_data_group');
    Route::get('/show_data_group/{id_group}', [GroupController::class, 'show_data_group'])->name('show_data_group');
    Route::post('/add_group_action',[GroupController::class, 'add_group_action'])->name('add_group_action');
    Route::post('/edit_group_action/{id_group}',[GroupController::class, 'edit_group_action'])->name('edit_group_action');
    Route::post('/delete_group_action/{id_group}',[GroupController::class, 'delete_group_action'])->name('delete_group_action');

    Route::get('/list_data_barang', [BarangController::class, 'list_data_barang'])->name('list_data_barang');
    Route::get('/show_data_barang/{id_barang}', [BarangController::class, 'show_data_barang'])->name('show_data_barang');
    Route::post('/add_barang_action',[BarangController::class, 'add_barang_action'])->name('add_barang_action');
    Route::post('/edit_barang_action/{id_barang}',[BarangController::class, 'edit_barang_action'])->name('edit_barang_action');
    Route::post('/delete_barang_action/{id_barang}',[BarangController::class, 'delete_barang_action'])->name('delete_barang_action');

    Route::get('/list_data_satuan', [SatuanController::class, 'list_data_satuan'])->name('list_data_satuan');
    Route::get('/show_data_satuan/{id_satuan}', [SatuanController::class, 'show_data_satuan'])->name('show_data_satuan');
    Route::post('/add_satuan_action',[SatuanController::class, 'add_satuan_action'])->name('add_satuan_action');
    Route::post('/edit_satuan_action/{id_satuan}',[SatuanController::class, 'edit_satuan_action'])->name('edit_satuan_action');
    Route::post('/delete_satuan_action/{id_satuan}',[SatuanController::class, 'delete_satuan_action'])->name('delete_satuan_action');


    Route::get('/list_data_pengajuan', [PengajuanController::class, 'list_data_pengajuan'])->name('list_data_pengajuan');

});

Route::get('toast', [DashboardController::class, 'toast'])->name('toast');


