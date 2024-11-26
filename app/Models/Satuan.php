<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_satuan';

    protected $table = "satuans";

    protected $fillable =
    [
        'id_satuan',
        'nama',
        'deskripsi'
    ];

    protected $guarded = [];

    public function barangs()
    {
        return $this->hasMany(Barang::class,'id_satuan');
    }
}