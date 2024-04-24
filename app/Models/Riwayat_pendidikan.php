<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat_pendidikan extends Model
{
    use HasFactory;
    protected $table = 'riwayat_pendidikans';
    protected $guarded = ['id'];
}
