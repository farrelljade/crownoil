<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerTabsController extends Controller
{
    public function index()
    {
        $data['customer'] = Prospect::query()
            ->with(['user', 'orders'])
            ->get();

        return Inertia::render('Prospects/ProspectPage.vue', $data);
    }
}
