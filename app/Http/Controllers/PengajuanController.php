<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function list_data_pengajuan(){


        return view('pengajuan/list_data_pengajuan');
    }

    public function add_data_pengajuan(){


        return view('pengajuan/add_data_pengajuan');
    }

    public function detail_form_permintaan_barang(){


        return view('pengajuan/detail_form_permintaan_barang');
    }
}
