<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_user extends Model
{
    use HasFactory;

    protected $table = 'level_users';
    protected $guarded = ['id'];
}
