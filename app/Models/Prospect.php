<?php

namespace App\Models;

use App\Enums\LeadSource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lead_source',
        'user_id',
        'contact_name',
        'line_1',
        'line_2',
        'line_3',
        'city',
        'county',
        'postcode',
        'number',
        'email',
    ];

    protected $casts = [
        'lead_source' => LeadSource::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
