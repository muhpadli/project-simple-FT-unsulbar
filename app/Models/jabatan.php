<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatans';
    protected $guarded = ['id'];

    public function organizations(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function level_users()
    {
        return $this->belongsTo(Level_user::class);
    }
}
