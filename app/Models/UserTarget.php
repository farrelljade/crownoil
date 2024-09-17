<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calls_target',
        'prospect_target',
        'profit_target',
        'rejuve_target',
        'iho_target',
        'lubricant_target',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
