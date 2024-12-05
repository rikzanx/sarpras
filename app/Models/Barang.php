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
        'id_kategori',
        'id_satuan',
        'nama',
        'deskripsi',
    ];

    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id_satuan');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'id_barang', 'id_barang');
    }

    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi_barangs', 'id_barang', 'id_transaksi')
                ->withPivot('quantity', 'deskripsi')
                ->withTimestamps();
    }

    public function transaksi_masuk()
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi_barangs', 'id_barang', 'id_transaksi')
            ->where('tipe', 'in')
            ->withPivot('quantity', 'deskripsi')
            ->withTimestamps();
    }
    public function transaksi_keluar()
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi_barangs', 'id_barang', 'id_transaksi')
            ->where('tipe', 'out')
            ->withPivot('quantity', 'deskripsi')
            ->withTimestamps();
    }

    public function stock_opname()
    {
        return $this->belongsToMany(StockOpname::class, 'stock_opname_items', 'id_barang', 'id_stock_opname')
                ->withPivot('selisih', 'alasan')
                ->withTimestamps();
    }
}