<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['prospects'] = Prospect::with('leadSource')
            ->where('user_id', Auth::id())
            ->get()
            ->toArray();

        return Inertia::render('Dashboard/Index', $data);
    }
}