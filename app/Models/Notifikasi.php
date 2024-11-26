<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_notifikasi';

    protected $table = "notifikasis";

    protected $fillable =
    [
        'id_notifikasi',
        'id_user_pengirim',
        'id_user_penerima',
        'judul',
        'isi',
        'status'
    ];

    protected $guarded = [];
    public function pengirim()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_pengirim');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user_penerima');
    }
}