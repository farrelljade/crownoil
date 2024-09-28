<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function userTargets(): HasMany
    {
        return $this->hasMany(UserTarget::class);
    }

}
