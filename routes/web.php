<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangAtkController;
use App\Http\Controllers\BarangIsmsController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StockOpnameController;


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('registration');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('forgot_password', [AuthController::class, 'forgot_password'])->name('forgot_password');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => [AuthMiddleware::class]],function(){

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // ISMS
    Route::get('/isms/stock_opname',[StockOpnameController::class,'isms_stock_opname'])->name('isms_stock_opname');
    Route::get('/isms/stock_opname/tambah',[StockOpnameController::class,'isms_stock_opname_tambah'])->name('isms_stock_opname_tambah');
    Route::post('/isms/stock_opname/tambah/action',[StockOpnameController::class,'isms_stock_opname_tambah_action'])->name('isms_stock_opname_tambah_action');
    Route::get('/isms/stock_opname/show/{id_stock_opname}',[StockOpnameController::class,'isms_stock_opname_show'])->name('isms_stock_opname_show');
    Route::get('/isms/stock_opname/edit/{id_stock_opname}',[StockOpnameController::class,'isms_stock_opname_edit'])->name('isms_stock_opname_edit');
    Route::post('/isms/stock_opname/edit/{id_stock_opname}/action',[StockOpnameController::class,'isms_stock_opname_edit_action'])->name('isms_stock_opname_edit_action');
    Route::post('/isms/stock_opname/delete/{id_stock_opname}/action',[StockOpnameController::class,'isms_stock_opname_delete_action'])->name('isms_stock_opname_delete_action');
    
    Route::get('/isms/stock_barang',[TransaksiController::class,'isms_stock_barang'])->name('isms_stock_barang');
    Route::get('/isms/show_transaksi_barang/{id_transaction}',[TransaksiController::class,'isms_show_transaksi_barang'])->name('isms_show_transaksi_barang');

    Route::get('/isms/list_transaksi_barang_masuk',[TransaksiController::class,'isms_list_transaksi_barang_masuk'])->name('isms_list_transaksi_barang_masuk');
    Route::post('/isms/add_transaksi_barang_masuk_action',[TransaksiController::class,'isms_add_transaksi_barang_masuk_action'])->name('isms_add_transaksi_barang_masuk_action');
    Route::post('/isms/edit_transaksi_barang_masuk_action/{id_transaction}',[TransaksiController::class,'isms_edit_transaksi_barang_masuk_action'])->name('isms_edit_transaksi_barang_masuk_action');
    Route::post('/isms/delete_transaksi_barang_masuk_action/{id_transaction}',[TransaksiController::class,'isms_delete_transaksi_barang_masuk_action'])->name('isms_delete_transaksi_barang_masuk_action');

    Route::get('/isms/list_transaksi_barang_keluar',[TransaksiController::class,'isms_list_transaksi_barang_keluar'])->name('isms_list_transaksi_barang_keluar');
    Route::post('/isms/add_transaksi_barang_keluar_action',[TransaksiController::class,'isms_add_transaksi_barang_keluar_action'])->name('isms_add_transaksi_barang_keluar_action');
    Route::post('/isms/edit_transaksi_barang_keluar_action/{id_transaction}',[TransaksiController::class,'isms_edit_transaksi_barang_keluar_action'])->name('isms_edit_transaksi_barang_keluar_action');
    Route::post('/isms/delete_transaksi_barang_keluar_action/{id_transaction}',[TransaksiController::class,'isms_delete_transaksi_barang_keluar_action'])->name('isms_delete_transaksi_barang_keluar_action');

    Route::get('/isms/list_data_barang', [BarangIsmsController::class, 'isms_list_data_barang'])->name('isms_list_data_barang');
    Route::get('/isms/show_data_barang/{id_barang}', [BarangIsmsController::class, 'isms_show_data_barang'])->name('isms_show_data_barang');
    Route::post('/isms/add_barang_action',[BarangIsmsController::class, 'isms_add_barang_action'])->name('isms_add_barang_action');
    Route::post('/isms/edit_barang_action/{id_barang}',[BarangIsmsController::class, 'isms_edit_barang_action'])->name('isms_edit_barang_action');
    Route::post('/isms/delete_barang_action/{id_barang}',[BarangIsmsController::class, 'isms_delete_barang_action'])->name('isms_delete_barang_action');
    // END ISMS ///

    // ATK
    Route::get('/atk/stock_opname',[StockOpnameController::class,'atk_stock_opname'])->name('atk_stock_opname');
    Route::get('/atk/stock_opname/tambah',[StockOpnameController::class,'atk_stock_opname_tambah'])->name('atk_stock_opname_tambah');
    Route::post('/atk/stock_opname/tambah/action',[StockOpnameController::class,'atk_stock_opname_tambah_action'])->name('atk_stock_opname_tambah_action');
    Route::get('/atk/stock_opname/show/{id_stock_opname}',[StockOpnameController::class,'atk_stock_opname_show'])->name('atk_stock_opname_show');
    Route::get('/atk/stock_opname/edit/{id_stock_opname}',[StockOpnameController::class,'atk_stock_opname_edit'])->name('atk_stock_opname_edit');
    Route::post('/atk/stock_opname/edit/{id_stock_opname}/action',[StockOpnameController::class,'atk_stock_opname_edit_action'])->name('atk_stock_opname_edit_action');
    Route::post('/atk/stock_opname/delete/{id_stock_opname}/action',[StockOpnameController::class,'atk_stock_opname_delete_action'])->name('atk_stock_opname_delete_action');
  
    Route::get('/atk/stock_barang',[TransaksiController::class,'atk_stock_barang'])->name('atk_stock_barang');
    Route::get('/atk/show_transaksi_barang/{id_transaction}',[TransaksiController::class,'atk_show_transaksi_barang'])->name('atk_show_transaksi_barang');

    Route::get('/atk/list_transaksi_barang_masuk',[TransaksiController::class,'atk_list_transaksi_barang_masuk'])->name('atk_list_transaksi_barang_masuk');
    Route::post('/atk/add_transaksi_barang_masuk_action',[TransaksiController::class,'atk_add_transaksi_barang_masuk_action'])->name('atk_add_transaksi_barang_masuk_action');
    Route::post('/atk/edit_transaksi_barang_masuk_action/{id_transaction}',[TransaksiController::class,'atk_edit_transaksi_barang_masuk_action'])->name('atk_edit_transaksi_barang_masuk_action');
    Route::post('/atk/delete_transaksi_barang_masuk_action/{id_transaction}',[TransaksiController::class,'atk_delete_transaksi_barang_masuk_action'])->name('atk_delete_transaksi_barang_masuk_action');

    Route::get('/atk/list_transaksi_barang_keluar',[TransaksiController::class,'atk_list_transaksi_barang_keluar'])->name('atk_list_transaksi_barang_keluar');
    Route::post('/atk/add_transaksi_barang_keluar_action',[TransaksiController::class,'atk_add_transaksi_barang_keluar_action'])->name('atk_add_transaksi_barang_keluar_action');
    Route::post('/atk/edit_transaksi_barang_keluar_action/{id_transaction}',[TransaksiController::class,'atk_edit_transaksi_barang_keluar_action'])->name('atk_edit_transaksi_barang_keluar_action');
    Route::post('/atk/delete_transaksi_barang_keluar_action/{id_transaction}',[TransaksiController::class,'atk_delete_transaksi_barang_keluar_action'])->name('atk_delete_transaksi_barang_keluar_action');

    Route::get('/atk/list_data_barang', [BarangAtkController::class, 'atk_list_data_barang'])->name('atk_list_data_barang');
    Route::get('/atk/show_data_barang/{id_barang}', [BarangAtkController::class, 'atk_show_data_barang'])->name('atk_show_data_barang');
    Route::post('/atk/add_barang_action',[BarangAtkController::class, 'atk_add_barang_action'])->name('atk_add_barang_action');
    Route::post('/atk/edit_barang_action/{id_barang}',[BarangAtkController::class, 'atk_edit_barang_action'])->name('atk_edit_barang_action');
    Route::post('/atk/delete_barang_action/{id_barang}',[BarangAtkController::class, 'atk_delete_barang_action'])->name('atk_delete_barang_action');
    // END ATK ///


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

    Route::get('/list_data_kategori', [KategoriController::class, 'list_data_kategori'])->name('list_data_kategori');
    Route::get('/show_data_kategori/{id_kategori}', [KategoriController::class, 'show_data_kategori'])->name('show_data_kategori');
    Route::post('/add_kategori_action',[KategoriController::class, 'add_kategori_action'])->name('add_kategori_action');
    Route::post('/edit_kategori_action/{id_kategori}',[KategoriController::class, 'edit_kategori_action'])->name('edit_kategori_action');
    Route::post('/delete_kategori_action/{id_kategori}',[KategoriController::class, 'delete_kategori_action'])->name('delete_kategori_action');


    Route::get('/list_data_pengajuan', [PengajuanController::class, 'list_data_pengajuan'])->name('list_data_pengajuan');


    Route::get('/detail_form_permintaan_barang', [PengajuanController::class, 'detail_form_permintaan_barang'])->name('detail_form_permintaan_barang');


});

Route::get('toast', [DashboardController::class, 'toast'])->name('toast');


