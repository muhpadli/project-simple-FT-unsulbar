<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function priority(){
        return $this->hasOne(Priority::class);
    }
}
