<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cart)
    {
        return view('cart.index', [
            'cartData' => $cart->detailed(),
        ]);
    }

    public function summary(CartService $cart)
    {
        return response()->json($this->payload($cart));
    }

    public function drawer(CartService $cart)
    {
        return response()->json(array_merge($this->payload($cart), [
            'html' => view('partials.cart-drawer', ['cartData' => $cart->detailed()])->render(),
        ]));
    }

    public function add(Request $request, CartService $cart)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        $cart->add((int) $data['product_id'], (int) $data['quantity']);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(array_merge($this->payload($cart), [
                'ok' => true,
                'message' => 'A termék a kosárba került.',
                'html' => view('partials.cart-drawer', ['cartData' => $cart->detailed()])->render(),
            ]));
        }

        return redirect()->route('cart.index')->with('success', 'A termék a kosárba került.');
    }

    public function update(Request $request, CartService $cart)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0|max:50',
        ]);

        $cart->update((int) $data['product_id'], (int) $data['quantity']);

        if ($request->wantsJson() || $request->ajax()) {
            $detailed = $cart->detailed();

            return response()->json(array_merge($this->payload($cart), [
                'ok' => true,
                'message' => 'Kosár frissítve.',
                'html' => view('partials.cart-drawer', ['cartData' => $detailed])->render(),
                'page_html' => view('partials.cart-page-body', ['cartData' => $detailed])->render(),
            ]));
        }

        return back()->with('success', 'Kosár frissítve.');
    }

    public function remove(Request $request, CartService $cart)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart->remove((int) $data['product_id']);

        if ($request->wantsJson() || $request->ajax()) {
            $detailed = $cart->detailed();

            return response()->json(array_merge($this->payload($cart), [
                'ok' => true,
                'message' => 'Tétel eltávolítva.',
                'html' => view('partials.cart-drawer', ['cartData' => $detailed])->render(),
                'page_html' => view('partials.cart-page-body', ['cartData' => $detailed])->render(),
            ]));
        }

        return back()->with('success', 'Tétel eltávolítva a kosárból.');
    }

    private function payload(CartService $cart): array
    {
        $detailed = $cart->detailed();

        return [
            'count' => $detailed['count'],
            'subtotal' => $detailed['subtotal'],
            'shipping_fee' => $detailed['shipping_fee'],
            'total' => $detailed['total'],
            'subtotal_formatted' => number_format($detailed['subtotal'], 0, ',', '.').' Ft',
            'shipping_formatted' => number_format($detailed['shipping_fee'], 0, ',', '.').' Ft',
            'total_formatted' => number_format($detailed['total'], 0, ',', '.').' Ft',
            'label' => $detailed['count'].' termék • '.number_format($detailed['total'], 0, ',', '.').' Ft',
            'items' => collect($detailed['items'])->map(fn ($row) => [
                'product_id' => $row['product']->id,
                'name' => $row['product']->name,
                'size' => $row['product']->size_label,
                'slug' => $row['product']->slug,
                'image' => $row['product']->image_url,
                'quantity' => $row['quantity'],
                'unit_price' => $row['unit_price'],
                'line_total' => $row['line_total'],
                'unit_price_formatted' => number_format($row['unit_price'], 0, ',', '.').' Ft',
                'line_total_formatted' => number_format($row['line_total'], 0, ',', '.').' Ft',
                'url' => route('products.show', $row['product']),
            ])->values(),
        ];
    }
}
