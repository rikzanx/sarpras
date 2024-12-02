<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBarang extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi_barang';

    protected $table = "transaksi_barangs";

    protected $fillable =
    [
        'id_transaksi_barang',
        'id_transaksi',
        'id_barang',
        'quantity',
        'deskripsi',
    ];

    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}