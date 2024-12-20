<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pengajuan';

    protected $table = "pengajuans";

    protected $fillable =
    [
        'id_pengajuan',
        'id_user',
        'id_transaksi',
        'tanggal',
        'deskripsi',
        'validasi',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }
    public function transaksi_barangs()
    {
        return $this->hasMany(TransaksiBarang::class, 'id_transaksi', 'id_transaksi');
    }
}