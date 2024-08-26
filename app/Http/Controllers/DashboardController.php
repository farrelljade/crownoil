<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use App\Models\Prospect;
use App\Models\User;
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
        $data['users'] = User::query()
            ->orderBy('name', 'desc')
            ->get();
        $data['leadSource'] = LeadSource::query()
            ->orderBy('name', 'desc')
            ->get();

        return Inertia::render('Dashboard/Index', $data);
    }
}
