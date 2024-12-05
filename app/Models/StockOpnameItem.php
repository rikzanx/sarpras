<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_stock_opname_item';

    protected $table = "stock_opname_items";

    protected $fillable =
    [
        'id_stock_opname_item',
        'id_stock_opname',
        'id_barang',
        'stock_sistem',
        'stock_fisik',
        'selisih',
        'alasan',
    ];

    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function stock_opname()
    {
        return $this->hasOne(StockOpname::class, 'id_stock_opname', 'id_stock_opname');
    }
}