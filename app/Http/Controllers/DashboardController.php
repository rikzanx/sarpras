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
        $overview = [];
        $overview['stock_tersedia'] = Stock::sum('stock_available') ?? 0;
        $overview['jumlah_barang_keluar'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'in');
        })->sum('quantity') ?? 0;
        $overview['jumlah_barang_masuk'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'out');
        })->sum('quantity') ?? 0;
        $overview['rata_rata_barang_keluar'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'out');
        })->avg('quantity') ?? 0;
        $transaksi = Transaksi::with(['tranksasi_barangs'])
        ->withSum(['transaksi_barangs as total_barang'], 'transaksi_barangs.quantity')
        ->orderBy('tanggal', 'desc')->limit(10)->get();
        return view('dashboard.dashboard',[
            'overview' => $overview,
            'transaksi' => $transaksi
        ]);
    }

    public function toast()
    {
        return view('toast');
    }
}
