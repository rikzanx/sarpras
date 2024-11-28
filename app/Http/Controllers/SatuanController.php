<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    public function list_data_satuan(){
        $satuan = Satuan::get();

        return view('satuan/list_data_satuan',[
            'satuan' => $satuan
        ]);
    }

    public function show_data_satuan($id_satuan)
    {
        $decryptId = Crypt::decryptString($id_satuan);
        $satuan = Satuan::where('id_satuan',$decryptId)->firstOrFail();

        return response()->json($satuan);
    }

    public function add_satuan()
    {
        return view('satuan/add_satuan');
    }

    public function add_satuan_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "nama" => 'required',
            "deskripsi" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            Satuan::create([
                "nama" => $request->nama,
                "deskripsi" => $request->deskripsi,
            ]);
            DB::commit();

            return redirect()->route('list_data_satuan')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function edit_satuan(Request $request,$id_satuan)
    {
        $decryptId = Crypt::decryptString($id_satuan);
        $satuan = Satuan::findOrFail($decryptId);

        return view('satuan.edit_satuan',[
            'satuan' => $satuan
        ]);
    }

    public function edit_satuan_action(Request $request, $id_satuan)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "nama" => 'required',
            "deskripsi" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_satuan);
            $satuan = Satuan::findOrFail($decryptId);
            $satuan->nama = $request->nama;
            $satuan->deskripsi = $request->deskripsi;
            $satuan->save();
            DB::commit();

            return redirect()->route('list_data_satuan')->with('success', "Sukses Mengedit Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat mengedit data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function delete_satuan_action(Request $request,$id_satuan)
    {
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_satuan);
            $satuan = Satuan::withCount('barangs')->findOrFail($decryptId);
            if($satuan->barangs_count > 0){
                DB::rollback();
                return redirect()->route('list_data_satuan')->with('error', "Gagal Menghapus Data, Data sedang dipakai");
            }
            $satuan->delete();
            DB::commit();
            return redirect()->route('list_data_satuan')->with('success', "Sukses Menghapus Data");
        }catch (\Exception $e) {
            DB::rollback();
            report($e);
            $ea = "Terjadi Kesalahan saat menghapus data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }
}
