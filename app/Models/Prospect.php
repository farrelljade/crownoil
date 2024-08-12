<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lead_source_id',
        'assigned_user',
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
}
