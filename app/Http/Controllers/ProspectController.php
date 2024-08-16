<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $data['users'] = User::all();
        $data['leadSource'] = LeadSource::all();
        $data['filters'] = $request->all();
        // Only get specific column from Prospect and related Models
        $data['prospects'] = Prospect::with(['user:id,name', 'leadSource:id,name'])
            ->get(['id', 'name', 'user_id', 'lead_source_id']);

        return Inertia::render('Prospects/Index', $data)
            ->with('replace', true);
    }  
}
