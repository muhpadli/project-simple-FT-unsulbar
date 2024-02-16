<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class riwayat_tugas extends Model
{
    use HasFactory;
    protected $table = 'riwayat_tugas';
    protected $guarded = ['id'];
}
