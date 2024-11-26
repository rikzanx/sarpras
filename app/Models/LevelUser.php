<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_level_user';

    protected $table = "level_users";

    protected $fillable =
    [
        'id_level_user',
        'level_user'
    ];

    protected $guarded = [];
}
