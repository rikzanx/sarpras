<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Group;
use App\Models\Satuan;

class PengajuanController extends Controller
{
    public function list_data_pengajuan(){


        return view('pengajuan/list_data_pengajuan');
    }

    public function add_data_pengajuan(){
        $group = Group::get();
        $satuan = Satuan::get();
        $barang = Barang::where('id_group',2)->get();

        return view('pengajuan/add_data_pengajuan',[
            'group' => $group,
            'satuan' => $satuan,
            'barang' => $barang
        ]);
    }

    public function detail_form_permintaan_barang(){


        return view('pengajuan/detail_form_permintaan_barang');
    }
}
