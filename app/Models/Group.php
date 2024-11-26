<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_group';

    protected $table = "groups";

    protected $fillable =
    [
        'id_group',
        'nama',
        'deskripsi'
    ];

    protected $guarded = [];

    public function barangs()
    {
        return $this->hasMany(Barang::class,'id_group');
    }
}