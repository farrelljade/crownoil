<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getUserTotalProfitThisMonth($userId): float
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->sum('total_profit');
    }

    public function getUserTotalProfitLastMonth($userId): float
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month - 1)
            ->sum('total_profit');
    }

    public function getUserTotalProfitMonthBeforeLast($userId): float
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month -2)
            ->sum('total_profit');
    }

    public function getUserOrdersThisMonth($userId): Collection
    {
        return Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->orderBy('created_at')
            ->get();
    }

    public function getUserOrdersLastMonth($userId): Collection
    {
        return Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->orderBy('created_at')
            ->get();
    }

    public function getUserOrdersMonthBeforeLast($userId): Collection
    {
        return Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonths(2)->month)
            ->orderBy('created_at')
            ->get();
    }

    public function getCustomersThisMonthByProfit($userId): Collection
    {
        return Order::query()
            ->with(['product', 'prospect', 'user'])
            ->selectRaw('prospect_id, sum(total_profit) as total_profit')
            ->selectRaw('prospect_id, count(prospect_id) as total_orders')
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->groupBy('prospect_id')
            ->orderBy('total_profit', 'desc')
            ->get();
    }

    public function getCustomersLastMonthByProfit($userId): Collection
    {
        return Order::query()
            ->with(['product', 'prospect', 'user'])
            ->selectRaw('prospect_id, sum(total_profit) as total_profit')
            ->selectRaw('prospect_id, count(prospect_id) as total_orders')
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->groupBy('prospect_id')
            ->orderBy('total_profit', 'desc')
            ->get();
    }

    public function getUserTotalOrdersMonthBeforeLast($userId): int
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonths(2)->month)
            ->count();
    }

    public function getUserTotalOrdersLastMonth($userId): int
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();
    }

    public function getUserTotalOrdersThisMonth($userId): int
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    public function getUserCustomerList($userId): array
    {
        return Prospect::query()
            ->with(['orders' => function ($query) {
                $query->latest();
            }, 'orders.product'])
            ->where('user_id', $userId)
            ->whereHas('orders')
            ->get()
            ->toArray();
    }

//    public function getUserProfitTarget($userId): float
//    {
//        return User::with('targets')
//            ->where('id', $userId)
//            ->first()
//            ->targets
//            ->pluck('profit_target')
//            ->first();
//    }

    public function getUserOrders($userId): Collection
    {
        return Order::query()
            ->with(['product', 'prospect', 'user'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getUserCustomers($userId): Collection
    {
        return Prospect::query()
            ->where('user_id', $userId)
            ->get();
    }

    public function getUserTotalProfit($userId): float
    {
        return Order::query()
            ->where('user_id', $userId)
            ->sum('total_profit');
    }

    public function getUserProfitThisMonth($userId): float
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->sum('total_profit');
    }

    public function getUserProfitLastMonth($userId): float
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_profit');
    }

    public function getUserProfitMonthBeforeLast($userId): float
    {
        return Order::query()
            ->where('user_id', $userId)
            ->whereMonth('created_at', now()->subMonths(2)->month)
            ->sum('total_profit');
    }
}
