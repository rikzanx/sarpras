<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kategori';

    protected $table = "kategoris";

    protected $fillable =
    [
        'id_group',
        'id_kategori',
        'nama',
        'deskripsi'
    ];

    protected $guarded = [];

    public function barangs()
    {
        return $this->hasMany(Barang::class,'id_kategori');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }
}