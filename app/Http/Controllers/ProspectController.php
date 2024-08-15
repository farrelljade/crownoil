<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectController extends Controller
{
    public function index()
    {
        $data = [];

        $data['prospects'] = Prospect::with(['user', 'leadSource'])->get();

        return Inertia::render('Prospects/Index', $data)
            ->with('replace', true);
    }  
}
