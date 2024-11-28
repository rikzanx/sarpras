<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi';

    protected $table = "transaksis";

    protected $fillable =
    [
        'id_transaksi',
        'id_user',
        'id_group',
        'tipe',
        'penerima',
        'tanggal',
        'deskripsi',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }
    public function group()
    {
        return $this->hasOne(Group::class, 'id_group', 'id_group');
    }
    public function transaksi_barangs()
    {
        return $this->hasMany(TransaksiBarang::class, 'id_transaksi', 'id_transaksi');
    }
}