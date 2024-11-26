<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function list_data_pengajuan(){

        
        return view('pengajuan/list_data_pengajuan');
    }
}
