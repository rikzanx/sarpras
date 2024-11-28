<?php

namespace App\Http\Controllers;

use App\Models\LevelUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function list_data_user()
    {
        $user = User::get();
        $level_user = LevelUser::get();
        return view('user.list_data_user',[
            'user' => $user,
            'level_user' => $level_user,
        ]);
    }

    public function profil(Request $request, $id_user)
    {

        $decryptId = Crypt::decryptString($id_user);
        $profile = User::where('id_user',$decryptId)->first();
        $level_user = LevelUser::get();

        return view('user/profile',
        [
            'level_user' => $level_user,
            'profile' => $profile
        ]);
    }

    public function profil_detail(Request $request, $id_user)
    {
        $decryptId = Crypt::decryptString($id_user);
        $profile = User::where('id_user',$decryptId)->first();

        return view('user/profile_detail',
        [
            'profile' => $profile
        ]);
    }

    public function profil_edit(Request $request, $id_user)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "nama" => 'required',
            "email" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_user);
            $user = User::findOrFail($decryptId);
            $user->nama = $request->nama;
            $user->email = $request->email;
            if($request->has('password')){
                if(!empty($request->password)){
                    $user->password = Hash::make($request->password);
                }
            }
            if($request->has('foto')){
                $uploadFolder = "assets/img/foto_profil/";
                $image = $request->file('foto');
                $imageName = time().'-'.str_replace('.','',$request->nik).".".$image->getClientOriginalExtension();;
                $image->move(public_path($uploadFolder), $imageName);
                $user->profile_photo_path = $imageName;
            }
            $user->save();
            DB::commit();

            return redirect()->route('profil',$id_user)->with('success', "Sukses Mengedit Profil");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat mengedit data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function show_user_data($id_user)
    {
        $decryptId = Crypt::decryptString($id_user);
        $profile = User::where('id_user',$decryptId)->firstOrFail();
        return response()->json($profile);
    }

    public function add_user()
    {
        $level_user = LevelUser::get();
        return view('user/add_user',[
            'level_user' => $level_user
        ]);
    }

    public function add_user_action(Request $request)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "level_user" => 'required',
            "nik" => 'required',
            "nama" => 'required',
            "email" => 'required',
            "password" => 'required',
            "foto" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $uploadFolder = "assets/img/foto_profil/";
            $image = $request->file('foto');
            $imageName = time().'-'.str_replace('.','',$request->nik).".".$image->getClientOriginalExtension();;
            $image->move(public_path($uploadFolder), $imageName);

            $user = User::create([
                "id_level_user" => $request->level_user,
                "nik" => $request->nik,
                "nama" => $request->nama,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "profile_photo_path" => $imageName,
            ]);
            DB::commit();

            return redirect()->route('list_data_user')->with('success', "Sukses Menambahkan Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function edit_user(Request $request,$id_user)
    {
        $level_user = LevelUser::get();
        $decryptId = Crypt::decryptString($id_user);
        $user = User::findOrFail($decryptId);

        return view('user.edit_user',[
            'level_user' => $level_user,
            'user' => $user,
        ]);
    }

    public function edit_user_action(Request $request, $id_user)
    {
        $messages = [
            'required'  => 'Harap bagian :attribute di isi.',
        ];
        $validator = Validator::make($request->all(), [
            "level_user" => 'required',
            "nik" => 'required',
            "nama" => 'required',
            "email" => 'required',
        ],$messages);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_user);
            $user = User::findOrFail($decryptId);
            $user->id_level_user = $request->level_user;
            $user->nik = $request->nik;
            $user->nama = $request->nama;
            $user->email = $request->email;
            if($request->has('password')){
                if(!empty($request->password)){
                    $user->password = Hash::make($request->password);
                }
            }
            if($request->has('foto')){
                $uploadFolder = "assets/img/foto_profil/";
                $image = $request->file('foto');
                $imageName = time().'-'.str_replace('.','',$request->nik).".".$image->getClientOriginalExtension();;
                $image->move(public_path($uploadFolder), $imageName);
                $user->profile_photo_path = $imageName;
            }
            $user->save();
            DB::commit();

            return redirect()->route('list_data_user')->with('success', "Sukses Mengedit Data");
        }catch (\Exception $e) {
            report($e);
            DB::rollback();
            $ea = "Terjadi Kesalahan saat menambah data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }

    public function delete_user_action(Request $request,$id_user)
    {
        DB::beginTransaction();
        try{
            $decryptId = Crypt::decryptString($id_user);
            $user = User::withCount('transaksis')->findOrFail($decryptId);
            if($user->transaksis_count > 0){
                DB::rollback();
                return redirect()->route('list_data_user')->with('error', "Gagal Menghapus Data, Data sedang dipakai");
            }
            $user->delete();
            DB::commit();
            return redirect()->route('list_data_user')->with('success', "Sukses Menghapus Data");
        }catch (\Exception $e) {
            DB::rollback();
            report($e);
            $ea = "Terjadi Kesalahan saat menghapus data: " . $e->getMessage();
            return redirect()->back()->with('error', $ea);
        }
    }
}
