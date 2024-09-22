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
        $data = $this->dashboardData($request, Auth::id());

        return Inertia::render('Dashboard/UserPage', $data);
    }

    public function show($id)
    {
        $data = $this->dashboardData(request(), $id);

        return Inertia::render('Dashboard/UserPage', $data);
    }

    private function dashboardData(Request $request, $userId): array
    {
        $data = [];

        $data['userOrders'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', $userId)
            ->orderBy('created_at')
            ->get();
        $data['userCustomers'] = Prospect::query()
            ->where('user_id', $userId)
            ->get();
        $data['userTotalProfit'] = Order::query()
            ->where('user_id', $userId)
            ->sum('total_profit');
        $data['userTotalProfitThisMonth'] = Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->sum('total_profit');
        $data['userOrdersThisMonth'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->orderBy('created_at')
            ->get();
        $data['userOrdersLastMonth'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->orderBy('created_at')
            ->get();
        $data['userOrdersMonthBeforeLast'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonths(2)->month)
            ->orderBy('created_at')
            ->get();
        $data['userTotalOrdersThisMonth'] = Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->count();
        $data['userTotalOrdersLastMonth'] = Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();
        $data['userTotalOrdersMonthBeforeLast'] = Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonths(2)->month)
            ->count();
        $data['customersThisMonthByProfit'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->selectRaw('prospect_id, sum(total_profit) as total_profit')
            ->selectRaw('prospect_id, count(prospect_id) as total_orders')
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->groupBy('prospect_id')
            ->orderBy('total_profit', 'desc')
            ->get();
        $data['prospects'] = Prospect::query()
            ->with('leadSource')
            ->where('user_id', $userId)
            ->get()
            ->toArray();
        $data['users'] = User::query()
            ->orderBy('name', 'desc')
            ->get();
        $data['leadSource'] = LeadSource::query()
            ->orderBy('name', 'desc')
            ->get();
        $data['userProfitTarget'] = User::with('targets')
            ->where('id', $userId)
            ->first()
            ->targets
            ->pluck('profit_target')
            ->first();


        return $data;
    }
}
