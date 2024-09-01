<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Prospect;
use App\Models\User;
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
            ->orderBy('created_at')
            ->get();

        return Inertia::render('Orders/OrdersPage', $data);
    }

    public function create(Request $request): Response
    {
        $data = $this->getCommonData();

        return Inertia::render('Orders/Create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'prospect_id' => 'required|exists:prospects,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'ppl' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        Order::create($request->all());

        return redirect()->route('orders.index');
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
