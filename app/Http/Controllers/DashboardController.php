<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Group;
use App\Models\Satuan;
use App\Models\Barang;
use App\Models\Stock;
use App\Models\TransaksiBarang;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $transaksi = Transaksi::with(['tranksasi_barangs'])
        ->withSum(['transaksi_barangs as total_barang'], 'transaksi_barangs.quantity')
        ->orderBy('tanggal', 'desc')->limit(10)->get();
        return view('dashboard.dashboard',[
            'transaksi' => $transaksi
        ]);
    }

    public function toast()
    {
        return view('toast');
    }
}
