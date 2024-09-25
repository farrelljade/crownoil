<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReassignProspectRequest;
use App\Models\LeadSource;
use App\Models\Product;
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
        $data = $this->getCommonData($request);

        return Inertia::render('Prospects/ProspectsPage', $data);
    }

    public function show(Prospect $prospect): Response
    {
        $data = $this->getCommonData(new Request());
        $data['prospect'] = $prospect->load(['user', 'leadSource', 'address', 'orders.product', 'orders.user']);

        return Inertia::render('Prospects/ProspectPage', $data);
    }

    public function create(): Response
    {
        return Inertia::render('Prospects/Create', [
            'users' => User::query()
                ->orderBy('name', 'desc')
                ->get(['id', 'name']),
            'leadSource' => LeadSource::query()
                ->orderBy('name', 'desc')
                ->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'contact_name' => 'required',
            'number' => 'required',
            'email' => 'required',
            'lead_source_id' => 'required',
        ]);

        $prospect = Prospect::create($request->all());

        $prospect->address()->create([
            'line_1' => $request['line_1'],
            'line_2' => $request['line_2'],
            'line_3' => $request['line_3'],
            'city' => $request['city'],
            'county' => $request['county'],
            'postcode' => $request['postcode'],
        ]);

        return redirect()->route('prospects.index');
    }

    private function getCommonData(Request $request): array
    {
        $data['users'] = User::query()
            ->orderBy('name')
            ->get();
        $data['leadSource'] = LeadSource::query()
            ->orderBy('name')
            ->get();
        $data['prospectName'] = Prospect::query()
            ->orderBy('name')
            ->get();
        // Only get specific columns from Prospect and related Models
        $data['prospects'] = Prospect::query()
            ->with(['user:id,name', 'leadSource:id,name'])
            ->orderBy('name')
            ->get(['id', 'name', 'user_id', 'lead_source_id']);
        $data['products'] = Product::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return $data;
    }

    public function reassign(ReassignProspectRequest $request): RedirectResponse
    {
        $request->validated();

        // Update the 'user_id' for the selected prospects
        Prospect::whereIn('id', $request->prospect_ids)
            ->update(['user_id' => $request->new_user_id]);

        return redirect()->route('prospects.index');
    }
}
