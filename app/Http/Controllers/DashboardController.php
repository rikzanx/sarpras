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
        // ISMS 
        $overviewisms = [];
        $overviewisms['stock_tersedia'] = Stock::whereHas('barang',function ($query) {
            $query->where('id_group',1);
        })->sum('available_stock') ?? 0;

        $overviewisms['jumlah_barang_keluar'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'out')->where('id_group',1);
        })->sum('quantity') ?? 0;

        $overviewisms['jumlah_barang_masuk'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'in')->where('id_group',1);
        })->sum('quantity') ?? 0;

        $rata_rata_barang_keluar = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'out')->where('id_group',1);
        })->avg('quantity') ?? 0;
        $overviewisms['rata_rata_barang_keluar'] = ROUND($rata_rata_barang_keluar,0);

        $year_now = date('Y');
        $overviewisms['data_barang_keluar'] = DB::table(DB::raw('(SELECT 1 AS bulan UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) as bulan'))
            ->leftJoin(DB::raw(sprintf('(SELECT COALESCE(SUM(transaksi_barangs.quantity), 0) AS jumlah_total_barang, MONTH(transaksis.tanggal) AS bulan_tanggal
                FROM transaksis
                LEFT JOIN transaksi_barangs ON transaksis.id_transaksi = transaksi_barangs.id_transaksi
                WHERE 
                transaksis.tipe = "out"
                AND transaksis.id_group = 1
                AND YEAR(transaksis.tanggal) = %d
                GROUP BY bulan_tanggal) as tr', $year_now)), function ($join) {
                $join->on(DB::raw('tr.bulan_tanggal'), '=', DB::raw('bulan.bulan'));
            })
            ->select(DB::raw('bulan.bulan, COALESCE(SUM(tr.jumlah_total_barang), 0) AS jumlah'))
            ->groupBy('bulan.bulan')
            ->orderBy('bulan.bulan')
            ->get()->pluck('jumlah')->toArray();
        $overviewisms['data_barang_masuk'] = DB::table(DB::raw('(SELECT 1 AS bulan UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) as bulan'))
            ->leftJoin(DB::raw(sprintf('(SELECT COALESCE(SUM(transaksi_barangs.quantity), 0) AS jumlah_total_barang, MONTH(transaksis.tanggal) AS bulan_tanggal
                FROM transaksis
                LEFT JOIN transaksi_barangs ON transaksis.id_transaksi = transaksi_barangs.id_transaksi
                WHERE 
                transaksis.tipe = "in"
                AND transaksis.id_group = 1
                AND YEAR(transaksis.tanggal) = %d
                GROUP BY bulan_tanggal) as tr', $year_now)), function ($join) {
                $join->on(DB::raw('tr.bulan_tanggal'), '=', DB::raw('bulan.bulan'));
            })
            ->select(DB::raw('bulan.bulan, COALESCE(SUM(tr.jumlah_total_barang), 0) AS jumlah'))
            ->groupBy('bulan.bulan')
            ->orderBy('bulan.bulan')
            ->get()->pluck('jumlah')->toArray();

        $transaksiisms = Transaksi::with(['transaksi_barangs'])
            ->withSum(['transaksi_barangs as total_barang'], 'transaksi_barangs.quantity')
            ->where('id_group',1)
            ->orderBy('tanggal', 'desc')->limit(10)->get();
        // END ISMS

        // ATK
        $overviewatk = [];
        $overviewatk['stock_tersedia'] = Stock::whereHas('barang',function ($query) {
            $query->where('id_group',2);
        })->sum('available_stock') ?? 0;

        $overviewatk['jumlah_barang_keluar'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'out')->where('id_group',2);
        })->sum('quantity') ?? 0;

        $overviewatk['jumlah_barang_masuk'] = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'in')->where('id_group',2);
        })->sum('quantity') ?? 0;

        $rata_rata_barang_keluar = TransaksiBarang::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'out')->where('id_group',2);
        })->avg('quantity') ?? 0;
        $overviewatk['rata_rata_barang_keluar'] = ROUND($rata_rata_barang_keluar,0);

        $year_now = date('Y');
        $overviewatk['data_barang_keluar'] = DB::table(DB::raw('(SELECT 1 AS bulan UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) as bulan'))
            ->leftJoin(DB::raw(sprintf('(SELECT COALESCE(SUM(transaksi_barangs.quantity), 0) AS jumlah_total_barang, MONTH(transaksis.tanggal) AS bulan_tanggal
                FROM transaksis
                LEFT JOIN transaksi_barangs ON transaksis.id_transaksi = transaksi_barangs.id_transaksi
                WHERE 
                transaksis.tipe = "out"
                AND transaksis.id_group = 2
                AND YEAR(transaksis.tanggal) = %d
                GROUP BY bulan_tanggal) as tr', $year_now)), function ($join) {
                $join->on(DB::raw('tr.bulan_tanggal'), '=', DB::raw('bulan.bulan'));
            })
            ->select(DB::raw('bulan.bulan, COALESCE(SUM(tr.jumlah_total_barang), 0) AS jumlah'))
            ->groupBy('bulan.bulan')
            ->orderBy('bulan.bulan')
            ->get()->pluck('jumlah')->toArray();
        $overviewatk['data_barang_masuk'] = DB::table(DB::raw('(SELECT 1 AS bulan UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) as bulan'))
            ->leftJoin(DB::raw(sprintf('(SELECT COALESCE(SUM(transaksi_barangs.quantity), 0) AS jumlah_total_barang, MONTH(transaksis.tanggal) AS bulan_tanggal
                FROM transaksis
                LEFT JOIN transaksi_barangs ON transaksis.id_transaksi = transaksi_barangs.id_transaksi
                WHERE 
                transaksis.tipe = "in"
                AND transaksis.id_group = 2
                AND YEAR(transaksis.tanggal) = %d
                GROUP BY bulan_tanggal) as tr', $year_now)), function ($join) {
                $join->on(DB::raw('tr.bulan_tanggal'), '=', DB::raw('bulan.bulan'));
            })
            ->select(DB::raw('bulan.bulan, COALESCE(SUM(tr.jumlah_total_barang), 0) AS jumlah'))
            ->groupBy('bulan.bulan')
            ->orderBy('bulan.bulan')
            ->get()->pluck('jumlah')->toArray();

        $transaksiatk = Transaksi::with(['transaksi_barangs'])
        ->withSum(['transaksi_barangs as total_barang'], 'transaksi_barangs.quantity')
        ->where('id_group',2)
        ->orderBy('tanggal', 'desc')->limit(10)->get();
        // END ATK
        
        return view('dashboard.dashboard',[
            'overviewisms' => $overviewisms,
            'transaksiisms' => $transaksiisms,
            'overviewatk' => $overviewatk,
            'transaksiatk' => $transaksiatk,
        ]);
    }

    public function toast()
    {
        return view('toast');
    }
}
