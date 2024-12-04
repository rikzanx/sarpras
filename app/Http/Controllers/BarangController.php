<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Group;
use App\Models\Stock;
use App\Models\Kategori;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function list_data_barang(){
        $satuan = Satuan::get();
        $group = Group::get();
        $kategori = Kategori::get();
        $barangs = Barang::with(['satuan','group'])->get();

        return view('barang/list_data_barang',[
            'barangs' => $barangs,
            'satuan' => $satuan,
            'group' => $group,
            'kategori' => $kategori
        ]);
    }

    public function show_data_barang(Request $request,$id_barang)
    {
        $decryptId = Crypt::decryptString($id_barang);
        $barang = Barang::findOrFail($decryptId);

        return response()->json($barang);
    }

    public function add_barang()
    {
        return view('barang/add_barang');
    }

    public function add_barang_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "id_group" => 'required',
            "id_kategori" => 'required',
            "id_satuan" => 'required',
            "nama" => 'required',
            "deskripsi" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $barang = Barang::create([
                "id_group" => $request->id_group,
                "id_kategori" => $request->id_kategori,
                "id_satuan" => $request->id_satuan,
                "nama" => $request->nama,
                "deskripsi" => $request->deskripsi,
            ]);
            Stock::create([
                "id_barang" => $barang->id_barang,
                "available_stock" => 0
            ]);
            DB::commit();

            return redirect()->route('list_data_barang')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function edit_barang(Request $request,$id_barang)
    {
        $decryptId = Crypt::decryptString($id_barang);
        $barang = Barang::findOrFail($decryptId);

        return view('barang.edit_barang',[
            'barang' => $barang
        ]);
    }

    public function edit_barang_action(Request $request, $id_barang)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "id_group" => 'required',
            "id_kategori" => 'required',
            "id_satuan" => 'required',
            "nama" => 'required',
            "deskripsi" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_barang);
            $barang = Barang::findOrFail($decryptId);
            $barang->id_group = $request->id_group;
            $barang->id_satuan = $request->id_satuan;
            $barang->id_kategori = $request->id_kategori;
            $barang->nama = $request->nama;
            $barang->deskripsi = $request->deskripsi;
            $barang->save();
            DB::commit();

            return redirect()->route('list_data_barang')->with('success', "Sukses Mengedit Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat mengedit data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function delete_barang_action(Request $request,$id_barang)
    {
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_barang);
            $barang = Barang::withCount('transaksis')->findOrFail($decryptId);
            if($barang->transaksis_count > 0){
                DB::rollback();
                return redirect()->route('list_data_barang')->with('error', "Gagal Menghapus Data, Data sedang dipakai");
            }
            $barang->delete();
            DB::commit();
            return redirect()->route('list_data_barang')->with('success', "Sukses Menghapus Data");
        }catch (\Exception $e) {
            DB::rollback();
            report($e);
            $ea = "Terjadi Kesalahan saat menghapus data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }
}
