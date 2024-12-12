<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Group;
use App\Models\Satuan;
use App\Models\Barang;
use App\Models\Stock;
use App\Models\TransaksiBarang;
use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockOpnameController extends Controller
{
    //================ ISMS================//
    public function isms_stock_opname()
    {
        $stock_opname = StockOpname::with(['stock_opname_items','group','user'])->where('id_group',1)->get();
        return view('stock_opname/isms_stock_opname',[
            'stock_opname' => $stock_opname
        ]);
    }

    public function isms_stock_opname_tambah()
    {
        $barangs = Barang::with(['stock','satuan'])->where('id_group',1)->get();
        return view('stock_opname/isms_stock_opname_tambah',[
            'barangs' => $barangs
        ]);
    }

    public function isms_stock_opname_tambah_action(Request $request)
    {
        
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.stock_sistem' => 'required|integer|min:1',
            'barang.*.stock_fisik' => 'required|integer|min:1',
            'barang.*.alasan' => 'required|string',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        try{
            DB::beginTransaction();
        
            $stock_opname_isms = StockOpname::create([
                'id_user' => Auth()->user()->id_user,
                'id_group' => 1,
                'tanggal' => now(),
                'deskripsi' => $request->deskripsi
            ]);
            
            foreach ($request->barang as $key => $item) {
                $barang = Barang::with('stock')->where('id_barang',$item['id_barang'])->firstOrFail();
                StockOpnameItem::create([
                    'id_stock_opname' => $stock_opname_isms->id_stock_opname,
                    'id_barang' => $item['id_barang'],
                    'stock_sistem' => $item['stock_sistem'],
                    'stock_fisik' => $item['stock_fisik'],
                    'selisih' => ($item['stock_sistem'] - $item['stock_fisik']) ,
                    'alasan' => $item['alasan']
                ]);
                $barang->stock->available_stock = $barang->stock->available_stock - ($item['stock_sistem'] - $item['stock_fisik']);
                $barang->stock->save();
            }
            DB::commit();

            return redirect()->route('isms_stock_opname')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
        
    }

    public function isms_stock_opname_show(Request $request,$id_stock_opname)
    {
        $decryptId = Crypt::decryptString($id_stock_opname);
        $stock_opname = StockOpname::with('user','group','stock_opname_items','stock_opname_items.barang','stock_opname_items.barang.satuan')->where('id_stock_opname',$decryptId)->firstOrFail();
        return view('stock_opname/isms_stock_opname_show',[
            'stock_opname' => $stock_opname
        ]);
    }

    public function isms_stock_opname_edit(Request $request,$id_stock_opname)
    {
        return 'edit';
    }

    public function isms_stock_opname_edit_action(Request $request,$id_stock_opname)
    {
        return 'edit action';
    }

    public function isms_stock_opname_delete_action(Request $request, $id_stock_opname)
    {
        DB::beginTransaction();

        try {
            $decryptId = Crypt::decryptString($id_stock_opname);
            $stock_opname = StockOpname::with(['stock_opname_items'])->where('id_stock_opname', $decryptId)->firstOrFail();

            // Menghapus setiap transaksi barang yang terkait dan mengembalikan stok yang ditambahkan/dikurangi
            foreach ($stock_opname->stock_opname_items as $transaksiBarang) {
                $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                if ($stock) {
                    $stock->available_stock += $transaksiBarang->quantity; // Kurangi stok yang ditambah
                    $stock->save();
                }
                $transaksiBarang->delete();
                // Hapus transaksi barang
            }

            // Hapus transaksi itu sendiri
            $stock_opname->delete();

            DB::commit();
            return redirect()->route('isms_stock_opname')->with('success', 'Stock Opname berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    } 


    //================ ATK ================//
    public function atk_stock_opname()
    {
        $stock_opname = StockOpname::with(['stock_opname_items','group','user'])->where('id_group',2)->get();
        return view('stock_opname/atk_stock_opname',[
            'stock_opname' => $stock_opname
        ]);
    }

    public function atk_stock_opname_tambah()
    {
        $barangs = Barang::with(['stock','satuan'])->where('id_group',2)->get();
        return view('stock_opname/atk_stock_opname_tambah',[
            'barangs' => $barangs
        ]);
    }

    public function atk_stock_opname_tambah_action(Request $request)
    {
        
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required|string|max:255',
            'barang.*.id_barang' => 'required|exists:barangs,id_barang',
            'barang.*.stock_sistem' => 'required|integer|min:1',
            'barang.*.stock_fisik' => 'required|integer|min:1',
            'barang.*.alasan' => 'required|string',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        try{
            DB::beginTransaction();
        
            $stock_opname_atk = StockOpname::create([
                'id_user' => Auth()->user()->id_user,
                'id_group' => 2,
                'tanggal' => now(),
                'deskripsi' => $request->deskripsi
            ]);
            
            foreach ($request->barang as $key => $item) {
                $barang = Barang::with('stock')->where('id_barang',$item['id_barang'])->firstOrFail();
                StockOpnameItem::create([
                    'id_stock_opname' => $stock_opname_atk->id_stock_opname,
                    'id_barang' => $item['id_barang'],
                    'stock_sistem' => $item['stock_sistem'],
                    'stock_fisik' => $item['stock_fisik'],
                    'selisih' => ($item['stock_sistem'] - $item['stock_fisik']) ,
                    'alasan' => $item['alasan']
                ]);
                $barang->stock->available_stock = $barang->stock->available_stock - ($item['stock_sistem'] - $item['stock_fisik']);
                $barang->stock->save();
            }
            DB::commit();

            return redirect()->route('atk_stock_opname')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
        
    }

    public function atk_stock_opname_show(Request $request,$id_stock_opname)
    {
        $decryptId = Crypt::decryptString($id_stock_opname);
        $stock_opname = StockOpname::with('user','group','stock_opname_items','stock_opname_items.barang','stock_opname_items.barang.satuan')->where('id_stock_opname',$decryptId)->firstOrFail();
        return view('stock_opname/atk_stock_opname_show',[
            'stock_opname' => $stock_opname
        ]);
    }

    public function atk_stock_opname_edit(Request $request,$id_stock_opname)
    {
        return 'edit';
    }

    public function atk_stock_opname_edit_action(Request $request,$id_stock_opname)
    {
        return 'edit action';
    }

    public function atk_stock_opname_delete_action(Request $request, $id_stock_opname)
    {
        DB::beginTransaction();

        try {
            $decryptId = Crypt::decryptString($id_stock_opname);
            $stock_opname = StockOpname::with(['stock_opname_items'])->where('id_stock_opname', $decryptId)->firstOrFail();

            // Menghapus setiap transaksi barang yang terkait dan mengembalikan stok yang ditambahkan/dikurangi
            foreach ($stock_opname->stock_opname_items as $transaksiBarang) {
                $stock = Stock::where('id_barang', $transaksiBarang->id_barang)->first();
                if ($stock) {
                    $stock->available_stock += $transaksiBarang->quantity; // Kurangi stok yang ditambah
                    $stock->save();
                }
                $transaksiBarang->delete();
                // Hapus transaksi barang
            }

            // Hapus transaksi itu sendiri
            $stock_opname->delete();

            DB::commit();
            return redirect()->route('atk_stock_opname')->with('success', 'Stock Opname berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi: ' . $e->getMessage());
        }
    } 



}
