<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_barang';

    protected $table = "barangs";

    protected $fillable =
    [
        'id_barang',
        'id_group',
        'id_satuan',
        'nama',
        'deskripsi',
    ];

    protected $guarded = [];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }

    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi_barangs', 'id_barang', 'id_transaksi')
                ->withPivot('quantity', 'deskripsi')
                ->withTimestamps();
    }
}