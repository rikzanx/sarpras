<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaction';

    protected $table = "transactions";

    protected $fillable =
    [
        'id_transaction',
        'id_user',
        'transaction_type',
        'penerima',
        'tanggal_transaction',
        'remarks',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }
    public function transaction_barangs()
    {
        return $this->hasMany(TransactionBarang::class, 'id_transaction', 'id_transaction');
    }
}