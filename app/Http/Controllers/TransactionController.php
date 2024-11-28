<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function list_transaksi_barang_masuk()
    {
        return view('transaksi/list_transaksi_barang_masuk');
    }

    public function list_transaksi_barang_keluar()
    {
        return view('transaksi/list_transaksi_barang_keluar');
    }
}
