<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_stock_opname';

    protected $table = "stock_opname";

    protected $fillable =
    [
        'id_stock_opname',
        'id_user',
        'id_group',
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
    public function stock_opname_items()
    {
        return $this->hasMany(StockOpnameItem::class, 'id_stock_opname', 'id_stock_opname');
    }
    // Accessor untuk kolom buatan "total_selisih"
    public function getTotalSelisihAttribute()
    {
        return $this->stock_opname->sum('selisih');
    }
}