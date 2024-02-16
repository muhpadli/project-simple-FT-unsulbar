<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    protected $guarded = ['id'];
    
    public function countUser(){
        return self::count();
    }

    public function jabatans()
    {
        return $this->hasMany(jabatan::class, 'organisasi_id');
    }
}


