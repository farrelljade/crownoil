<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProspectController extends Controller
{
    public function index(Request $request): Response
    {
        $data = [];

        $data['users'] = User::query()
            ->orderBy('name', 'desc')
            ->get();
        $data['leadSource'] = LeadSource::query()
            ->orderBy('name', 'desc')
            ->get();
        $data['filters'] = $request->all();
        // Only get specific columns from Prospect and related Models
        $data['prospects'] = Prospect::with(['user:id,name', 'leadSource:id,name'])
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'user_id', 'lead_source_id']);

        return Inertia::render('Prospects/Index', $data);
    }

    public function show(Prospect $prospect): Response
    {
        return Inertia::render('Prospects/Show', [
            'prospect' => $prospect->load(['user:id,name,email', 'leadSource:id,name'])
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Prospects/Create', [
            'users' => User::all(),
            'leadSource' => LeadSource::all()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required|exists:users,id',
            'lead_source_id' => 'required|exists:lead_sources,id',
        ]);

        Prospect::create($request->all());

        return redirect()->route('prospects.index');
    }
}
