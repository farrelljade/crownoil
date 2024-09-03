<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use App\Models\Order;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getCommonData($request);

        // Get each users specific orders
        $data['userOrders'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at')
            ->get();

        return Inertia::render('Dashboard/Index', $data);
    }

    private function getCommonData(Request $request): array
    {
        $data = [];

        $data['prospects'] = Prospect::query()
            ->with('leadSource')
            ->where('user_id', Auth::id())
            ->get()
            ->toArray();
        $data['users'] = User::query()
            ->orderBy('name', 'desc')
            ->get();
        $data['leadSource'] = LeadSource::query()
            ->orderBy('name', 'desc')
            ->get();

        return $data;
    }
}
