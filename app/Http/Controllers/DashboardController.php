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

        $data['userOrders'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at')
            ->get();
        $data['userTotalProfit'] = Order::query()
            ->where('user_id', Auth::id())
            ->sum('total_profit');

        return Inertia::render('Dashboard/UserPage', $data);
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
