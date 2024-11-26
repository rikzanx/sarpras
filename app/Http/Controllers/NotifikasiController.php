<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class NotifikasiController extends Controller
{
    public function notifikasi($id_user)
    {
        $decryptId = Crypt::decryptString($id_user);
        $notifikasi = Notifikasi::with(['pengirim'])->where('user_id_penerima',$decryptId)->get();

        return view('notifikasi/notifikasi',
        [
            'notifikasi' => $notifikasi
        ]);
    }
}