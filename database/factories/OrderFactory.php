<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\Prospect;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // select a random prospect
        $prospect = Prospect::inRandomOrder()->first();

        // select the user assigned to the prospect
        $user = $prospect->user;

        // select a random product
        $product = Product::inRandomOrder()->first();

        // random quantity between 500 and 18000
        $quantity = $this->faker->numberBetween(500, 18000);

        // Determine PPL Cost based on quantity thresholds
        $pplCost = $this->calculatePplCost($product, $quantity);

        // Determine PPL Cost based on quantity thresholds
        $pplSell = $this->faker->randomFloat(2, $pplCost, $pplCost + 0.40);

        // Calculate Nett Total (quantity * PPL Sell)
        $nettTotal = $quantity * $pplSell;

        // Calculate VAT (20% of Nett Total)
        $vat = $nettTotal * 0.20;

        // Calculate Total (Nett Total + VAT)
        $total = $nettTotal + $vat;

        // Calculate PPL Profit (PPL Sell - PPL Cost)
        $pplProfit = $pplSell - $pplCost;

        // Calculate Total Profit (PPL Profit * Quantity)
        $totalProfit = $pplProfit * $quantity;

        return [
            'prospect_id' => $prospect->id,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'ppl_cost' => $pplCost,
            'ppl_sell' => $pplSell,
            'nett_total' => round($nettTotal, 2),
            'vat' => round($vat, 2),
            'total' => round($total, 2),
            'ppl_profit' => round($pplProfit, 2),
            'total_profit' => round($totalProfit, 2),
        ];
    }

    /**
     * Calculate the PPL Cost based on product and quantity.
     *
     * @param \App\Models\Product $product
     * @param int $quantity
     * @return float
     */
    private function calculatePplCost($product, $quantity): float
    {
        // Define pricing thresholds for each product
        $pricing = [
            'Derv' => ['threshold' => 10000, 'low' => 1.05, 'high' => 1.10],
            'IHO' => ['threshold' => 10000, 'low' => 0.65, 'high' => 0.70],
            'Kerosene' => ['threshold' => 10000, 'low' => 0.63, 'high' => 0.68],
            'Gas Oil' => ['threshold' => 10000, 'low' => 0.80, 'high' => 0.85],
        ];

        $productName = $product->name;

        if (!isset($pricing[$productName])) {
            return 1.00;
        }

        $productPricing = $pricing[$productName];

        return $quantity < $productPricing['threshold']
            ? $productPricing['high']
            : $productPricing['low'];
    }
}
