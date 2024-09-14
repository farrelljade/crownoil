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
        $data['userTotalProfitThisMonth'] = Order::query()
            ->where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->sum('total_profit');
        $data['userOrdersThisMonth'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->orderBy('created_at')
            ->get();
        $data['userOrdersLastMonth'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', Auth::id())
            ->whereMonth('created_at', now()->subMonth()->month)
            ->orderBy('created_at')
            ->get();
        $data['userOrdersMonthBeforeLast'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', Auth::id())
            ->whereMonth('created_at', now()->subMonths(2)->month)
            ->orderBy('created_at')
            ->get();
        $data['customersThisMonthByProfit'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->selectRaw('prospect_id, sum(total_profit) as total_profit')
            ->selectRaw('prospect_id, count(prospect_id) as total_orders')
            ->where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->groupBy('prospect_id')
            ->orderBy('total_profit', 'desc')
            ->get();

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
