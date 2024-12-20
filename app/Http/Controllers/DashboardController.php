<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use App\Models\Order;
use App\Models\Prospect;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    private function dashboardData(Request $request, $userId): array
    {
        $data = $this->getData($request, $userId);
        $data['getUserOrders'] = $this->dashboardService->getUserOrders($userId);
        $data['getUserCustomers'] = $this->dashboardService->getUserCustomers($userId);
        $data['getUserTotalProfitThisMonth'] = $this->dashboardService->getUserTotalProfitThisMonth($userId);
        $data['getUserTotalProfitLastMonth'] = $this->dashboardService->getUserTotalProfitLastMonth($userId);
        $data['getUserTotalProfitMonthBeforeLast'] = $this->dashboardService->getUserTotalProfitMonthBeforeLast($userId);
        $data['getUserOrdersThisMonth'] = $this->dashboardService->getUserOrdersThisMonth($userId);
        $data['getUserOrdersLastMonth'] = $this->dashboardService->getUserOrdersLastMonth($userId);
        $data['getUserOrdersMonthBeforeLast'] = $this->dashboardService->getUserOrdersMonthBeforeLast($userId);
        $data['getCustomersThisMonthByProfit'] = $this->dashboardService->getCustomersThisMonthByProfit($userId);
        $data['getCustomersLastMonthByProfit'] = $this->dashboardService->getCustomersLastMonthByProfit($userId);
        $data['getCustomersMonthBeforeLast'] = $this->dashboardService->getCustomersMonthBeforeLast($userId);
        $data['getUserTotalOrdersThisMonth'] = $this->dashboardService->getUserTotalOrdersThisMonth($userId);
        $data['getUserTotalOrdersLastMonth'] = $this->dashboardService->getUserTotalOrdersLastMonth($userId);
        $data['getUserTotalOrdersMonthBeforeLast'] = $this->dashboardService->getUserTotalOrdersMonthBeforeLast($userId);
        $data['getUserCustomerList'] = $this->dashboardService->getUserCustomerList($userId);
//        $data['getUserProfitTarget'] = $this->dashboardService->getUserProfitTarget($userId);

        return $data;
    }
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

    private function getData(Request $request, $userId): array
    {
        $data['prospects'] = Prospect::query()
            ->with(['leadSource', 'orders'])
            ->where('user_id', $userId)
            ->whereDoesntHave('orders')
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
