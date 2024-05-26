<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level_user extends Model
{
    use HasFactory;

    protected $table = 'level_users';
    protected $guarded = ['id'];

    public function jabatans()
    {
        return $this->hasMany(jabatan::class);
    }
}

