<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'contact_name',
        'number',
        'email',
        'lead_source_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leadSource(): BelongsTo
    {
        return $this->belongsTo(LeadSource::class, 'lead_source_id');
    }

    /**
     * Helper method to get the lead source name directly.
     */
    public function getLeadSourceNameAttribute(): ?string
    {
        return $this->leadSource?->name;
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
