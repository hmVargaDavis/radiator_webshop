<?php

namespace App\Services;

use App\Models\Product;
use App\Models\SiteSetting;

class CartService
{
    public const SESSION_KEY = 'cart';

    public function items(): array
    {
        return session(self::SESSION_KEY, []);
    }

    public function count(): int
    {
        return collect($this->items())->sum('quantity');
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $quantity = max(1, min(50, $quantity));
        $product = Product::active()->findOrFail($productId);
        $cart = $this->items();

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = max(1, min(50, $cart[$productId]['quantity'] + $quantity));
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
            ];
        }

        session([self::SESSION_KEY => $cart]);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->items();
        if (!isset($cart[$productId])) {
            return;
        }

        if ($quantity < 1) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['quantity'] = min(50, $quantity);
        }

        session([self::SESSION_KEY => $cart]);
    }

    public function remove(int $productId): void
    {
        $cart = $this->items();
        unset($cart[$productId]);
        session([self::SESSION_KEY => $cart]);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function detailed(): array
    {
        $rows = [];
        $subtotal = 0;

        foreach ($this->items() as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || !$product->is_active) {
                continue;
            }

            $qty = (int) $item['quantity'];
            $line = $product->price * $qty;
            $subtotal += $line;

            $rows[] = [
                'product' => $product,
                'quantity' => $qty,
                'unit_price' => $product->price,
                'line_total' => $line,
            ];
        }

        $shipping = $subtotal > 0 ? $this->shippingFee() : 0;

        return [
            'items' => $rows,
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping,
            'total' => $subtotal + $shipping,
            'count' => collect($rows)->sum('quantity'),
        ];
    }

    public function shippingFee(): int
    {
        return (int) (SiteSetting::getValue('shipping_fee') ?? config('shop.shipping_fee', 2500));
    }
}
