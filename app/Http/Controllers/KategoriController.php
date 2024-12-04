<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function list_data_kategori(){
        $kategori = Kategori::get();
        $group = Group::get();

        return view('kategori/list_data_kategori',[
            'kategori' => $kategori,
            'group' => $group
        ]);
    }

    public function show_data_kategori($id_kategori)
    {
        $decryptId = Crypt::decryptString($id_kategori);
        $kategori = Kategori::where('id_kategori',$decryptId)->firstOrFail();

        return response()->json($kategori);
    }

    public function add_kategori()
    {
        return view('kategori/add_kategori');
    }

    public function add_kategori_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "id_group" => 'required',
            "nama" => 'required',
            "deskripsi" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            Kategori::create([
                "id_group" => $request->id_group,
                "nama" => $request->nama,
                "deskripsi" => $request->deskripsi,
            ]);
            DB::commit();

            return redirect()->route('list_data_kategori')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function edit_kategori(Request $request,$id_kategori)
    {
        $decryptId = Crypt::decryptString($id_kategori);
        $kategori = Kategori::findOrFail($decryptId);

        return view('kategori.edit_kategori',[
            'kategori' => $kategori
        ]);
    }

    public function edit_kategori_action(Request $request, $id_kategori)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "id_group" => 'required',
            "nama" => 'required',
            "deskripsi" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_kategori);
            $kategori = Kategori::findOrFail($decryptId);
            $kategori->id_group = $request->id_group;
            $kategori->nama = $request->nama;
            $kategori->deskripsi = $request->deskripsi;
            $kategori->save();
            DB::commit();

            return redirect()->route('list_data_kategori')->with('success', "Sukses Mengedit Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat mengedit data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function delete_kategori_action(Request $request,$id_kategori)
    {
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_kategori);
            $kategori = Kategori::withCount('barangs')->findOrFail($decryptId);
            if($kategori->barangs_count > 0){
                DB::rollback();
                return redirect()->route('list_data_kategori')->with('error', "Gagal Menghapus Data, Data sedang dipakai");
            }
            $kategori->delete();
            DB::commit();
            return redirect()->route('list_data_kategori')->with('success', "Sukses Menghapus Data");
        }catch (\Exception $e) {
            DB::rollback();
            report($e);
            $ea = "Terjadi Kesalahan saat menghapus data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }
}
