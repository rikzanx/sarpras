<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionBarang extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaction_barang';

    protected $table = "transaction_barangs";

    protected $fillable =
    [
        'id_transaction_barang',
        'id_transaction',
        'id_barang',
        'quantity',
        'remarks',
    ];

    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}