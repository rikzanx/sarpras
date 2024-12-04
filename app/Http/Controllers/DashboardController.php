<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\Group;
use App\Models\Satuan;
use App\Models\Barang;
use App\Models\Stock;
use App\Models\TransaksiBarang;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $overview = [];
        $overview['stock_tersedia'] = Stock::sum('available_stock') ?? 0;
        $overview['jumlah_barang_keluar'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'out');
        })->sum('quantity') ?? 0;
        $overview['jumlah_barang_masuk'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'in');
        })->sum('quantity') ?? 0;
        $rata_rata_barang_keluar = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'out');
        })->avg('quantity') ?? 0;
        $overview['rata_rata_barang_keluar'] = ROUND($rata_rata_barang_keluar,0);
        $transaksi = Transaksi::with(['transaksi_barangs'])
        ->withSum(['transaksi_barangs as total_barang'], 'transaksi_barangs.quantity')
        ->orderBy('tanggal', 'desc')->limit(10)->get();
        $year_now = date('Y');
        $overview['data_barang_keluar'] = DB::table(DB::raw('(SELECT 1 AS bulan UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) as bulan'))
            ->leftJoin(DB::raw(sprintf('(SELECT COALESCE(SUM(transaksi_barangs.quantity), 0) AS jumlah_total_barang, MONTH(transaksis.tanggal) AS bulan_tanggal
                FROM transaksis
                LEFT JOIN transaksi_barangs ON transaksis.id_transaksi = transaksi_barangs.id_transaksi
                WHERE 
                transaksis.tipe = "out"
                AND YEAR(transaksis.tanggal) = %d
                GROUP BY bulan_tanggal) as tr', $year_now)), function ($join) {
                $join->on(DB::raw('tr.bulan_tanggal'), '=', DB::raw('bulan.bulan'));
            })
            ->select(DB::raw('bulan.bulan, COALESCE(SUM(tr.jumlah_total_barang), 0) AS jumlah'))
            ->groupBy('bulan.bulan')
            ->orderBy('bulan.bulan')
            ->get()->pluck('jumlah')->toArray();
        $overview['data_barang_masuk'] = DB::table(DB::raw('(SELECT 1 AS bulan UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) as bulan'))
            ->leftJoin(DB::raw(sprintf('(SELECT COALESCE(SUM(transaksi_barangs.quantity), 0) AS jumlah_total_barang, MONTH(transaksis.tanggal) AS bulan_tanggal
                FROM transaksis
                LEFT JOIN transaksi_barangs ON transaksis.id_transaksi = transaksi_barangs.id_transaksi
                WHERE 
                transaksis.tipe = "in"
                AND YEAR(transaksis.tanggal) = %d
                GROUP BY bulan_tanggal) as tr', $year_now)), function ($join) {
                $join->on(DB::raw('tr.bulan_tanggal'), '=', DB::raw('bulan.bulan'));
            })
            ->select(DB::raw('bulan.bulan, COALESCE(SUM(tr.jumlah_total_barang), 0) AS jumlah'))
            ->groupBy('bulan.bulan')
            ->orderBy('bulan.bulan')
            ->get()->pluck('jumlah')->toArray();

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
