<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        $data = $this->getCommonData();

        $data['orders'] = Order::query()
            ->with(['product', 'prospect', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Orders/OrdersPage', $data);
    }

    public function create(Request $request): Response
    {
        $data = $this->getCommonData();

        return Inertia::render('Orders/Create', $data);
    }

    public function store(OrderRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $order = Order::create($validatedData);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    private function getCommonData(): array
    {
        $data = [];

        $data['products'] = Product::query()
            ->orderBy('name')
            ->get(['id', 'name']);
        $data['users'] = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);
        $data['prospects'] = Prospect::query()
            ->with('user:id,name')
            ->orderBy('name')
            ->get(['id', 'user_id', 'name']);

        return $data;
    }
}
