<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function list_data_group(){
        $group = Group::get();

        return view('group/list_data_group',[
            'group' => $group
        ]);
    }

    public function show_data_group(Request $request,$id_group)
    {
        $decryptId = Crypt::decryptString($id_group);
        $group = Group::findOrFail($decryptId);

        return response()->json($group);
    }

    public function add_group()
    {
        return view('group/add_group');
    }

    public function add_group_action(Request $request)
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
            Group::create([
                "nama" => $request->nama,
                "deskripsi" => $request->deskripsi,
            ]);
            DB::commit();

            return redirect()->route('list_data_group')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function edit_group(Request $request,$id_group)
    {
        $decryptId = Crypt::decryptString($id_group);
        $group = Group::findOrFail($decryptId);

        return view('group.edit_group',[
            'group' => $group
        ]);
    }

    public function edit_group_action(Request $request, $id_group)
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
            $decryptId = Crypt::decryptString($id_group);
            $group = Group::findOrFail($decryptId);
            $group->nama = $request->nama;
            $group->deskripsi = $request->deskripsi;
            $group->save();
            DB::commit();

            return redirect()->route('list_data_group')->with('success', "Sukses Mengedit Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat mengedit data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function delete_group_action(Request $request,$id_group)
    {
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_group);
            $group = Group::withCount('barangs')->findOrFail($decryptId);
            if($group->barangs_count > 0){
                DB::rollback();
                return redirect()->route('list_data_group')->with('error', "Gagal Menghapus Data, Data sedang dipakai");
            }
            $group->delete();
            DB::commit();
            return redirect()->route('list_data_group')->with('success', "Sukses Menghapus Data");
        }catch (\Exception $e) {
            DB::rollback();
            report($e);
            $ea = "Terjadi Kesalahan saat menghapus data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }
}
