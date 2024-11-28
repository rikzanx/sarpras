<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Group;
use App\Models\Satuan;
use App\Models\Barang;
use App\Models\Stock;
use App\Models\TransaksiBarang;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function isms_list_transaksi_barang_masuk()
    {
        $transaksi_barang_masuk = Transaksi::with(['transaksi_barangs','group'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')->where('tipe','in')
        ->where('id_group',1)->get();
        $transaksi_barang_masuk->map(function($item){
            // dd($item);
        });
        $group = Group::get();
        $satuan = Satuan::get();
        return view('transaksi/isms_list_transaksi_barang_masuk',[
            'transaksi_barang_masuk' => $transaksi_barang_masuk,
            'group' => $group,
            'satuan' => $satuan
        ]);
    }

    public function isms_list_transaksi_barang_keluar()
    {
        $transaksi_barang_keluar = Transaksi::with(['transaksi_barangs'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')->where('tipe','in')
        ->where('id_group',1)->get();
        $group = Group::get();
        $satuan = Satuan::get();
        return view('transaksi/isms_list_transaksi_barang_keluar',[
            'transaksi_barang_keluar' => $transaksi_barang_keluar,
            'group' => $group,
            'satuan' => $satuan
        ]);
    }

    public function isms_show_transaksi_barang($group,$id_transaction)
    {
        $decryptId = Crypt::decryptString($id_transaction);
        $transaksi = Transaksi::with(['transaksi_barangs'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')
        ->where('id_group',1)->where('id_transaction',$decryptId)->firstOrFail();

        return response()->json($transaksi);
    }

    public function atk_list_transaksi_barang_masuk()
    {
        $transaksi_barang_masuk = Transaksi::with(['transaksi_barangs','group'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')->where('tipe','in')
        ->where('id_group',2)->get();
        $transaksi_barang_masuk->map(function($item){
            // dd($item);
        });
        $group = Group::get();
        $satuan = Satuan::get();
        $barang = Barang::where('id_group',2)->get();
        return view('transaksi/atk_list_transaksi_barang_masuk',[
            'transaksi_barang_masuk' => $transaksi_barang_masuk,
            'group' => $group,
            'satuan' => $satuan,
            'barang' => $barang   
        ]);
    }

    public function atk_list_transaksi_barang_keluar()
    {
        $transaksi_barang_keluar = Transaksi::with(['transaksi_barangs'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')->where('tipe','in')
        ->where('id_group',2)->get();
        $group = Group::get();
        $satuan = Satuan::with('satuan')->get();
        return view('transaksi/atk_list_transaksi_barang_keluar',[
            'transaksi_barang_keluar' => $transaksi_barang_keluar,
            'group' => $group,
            'satuan' => $satuan
        ]);
    }

    public function atk_show_transaksi_barang($group,$id_transaction)
    {
        $decryptId = Crypt::decryptString($id_transaction);
        $transaksi = Transaksi::with(['transaksi_barangs'])->withCount('transaksi_barangs')->withSum('transaksi_barangs as total_barang', 'quantity')
        ->where('id_group',2)->where('id_transaction',$decryptId)->firstOrFail();

        return response()->json($transaksi);
    }

    public function atk_add_transaksi_barang_masuk_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.quantity' => 'required|integer|min:1',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $transaksi = Transaksi::create([
                "id_user" => Auth()->user()->id_user,
                "id_group" => 2,
                "tanggal" => Carbon::parse($request->tanggal)->format('Y-m-d H:i:s'),
                "deskripsi" => $request->deskripsi,
                "penerima" => $request->penerima,
                "tipe" => "in",
            ]);

            foreach($request->barang as $item){
                TransaksiBarang::create([
                    "id_transaksi" => $transaksi->id_transaksi,
                    "id_barang" => $item['id_barang'],
                    "quantity" => $item['quantity'],
                ]);
                $stock = Stock::where('id_barang',$item['id_barang'])->first();
                if($stock){
                    $stock->available_stock += $item['quantity'];
                    $stock->save();
                }else{
                    Stock::create([
                        "id_barang" => $item['id_barang'],
                        "available_stock" => $item['quantity'],
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('atk_list_transaksi_barang_masuk')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }
}
