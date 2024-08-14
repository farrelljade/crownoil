<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectController extends Controller
{
    public function index()
    {
        $prospects = Prospect::with('user')->get();

        return Inertia::render('Prospects/Index', [
            'prospects' => $prospects,
        ]);
    }  
}
