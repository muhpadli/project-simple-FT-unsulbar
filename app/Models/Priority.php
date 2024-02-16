<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;
    
    protected $table = 'priorities';
    protected $guarder = ['id'];

    public function tasks(){
        return $this->belongsTo(Task::class);
    }
    
}
