<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPermissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'permission_id',
        'user_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function permission(): HasOne
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }
}
