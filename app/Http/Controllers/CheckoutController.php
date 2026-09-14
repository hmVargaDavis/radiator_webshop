<?php

namespace App\Http\Controllers;

use App\Mail\OrderAdminNotification;
use App\Mail\OrderCustomerConfirmation;
use App\Models\AdminActivity;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SiteSetting;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(CartService $cart)
    {
        $cartData = $cart->detailed();

        if ($cartData['count'] < 1) {
            return redirect()->route('cart.index')->with('error', 'A kosár üres. Adjon hozzá radiátort a rendeléshez.');
        }

        return view('checkout.show', [
            'cartData' => $cartData,
            'pickupAddress' => SiteSetting::getValue('pickup_address') ?? config('shop.pickup_address'),
        ]);
    }

    public function store(Request $request, CartService $cart)
    {
        $cartData = $cart->detailed();

        if ($cartData['count'] < 1) {
            return redirect()->route('cart.index')->with('error', 'A kosár üres.');
        }

        $data = $request->validate([
            'customer_name' => 'required|string|max:120',
            'customer_phone' => 'required|string|max:40',
            'customer_email' => 'required|email|max:160',
            'shipping_address' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'privacy' => 'accepted',
        ], [
            'customer_name.required' => 'Adja meg a nevét.',
            'customer_phone.required' => 'Adja meg a telefonszámát.',
            'customer_email.required' => 'Adja meg az e-mail címét.',
            'customer_email.email' => 'Érvényes e-mail címet adjon meg.',
            'shipping_address.required' => 'Adja meg a budapesti szállítási címet.',
            'privacy.accepted' => 'A rendeléshez el kell fogadnia az adatkezelési tájékoztatót.',
        ]);

        $order = DB::transaction(function () use ($data, $cartData) {
            $order = Order::create([
                'order_number' => 'ROB-'.now()->format('ymd').'-'.Str::upper(Str::random(5)),
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'],
                'shipping_address' => $data['shipping_address'],
                'note' => $data['note'] ?? null,
                'subtotal' => $cartData['subtotal'],
                'shipping_fee' => $cartData['shipping_fee'],
                'total' => $cartData['total'],
                'status' => 'new',
            ]);

            foreach ($cartData['items'] as $row) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $row['product']->id,
                    'product_name' => $row['product']->name,
                    'size_label' => $row['product']->size_label,
                    'unit_price' => $row['unit_price'],
                    'quantity' => $row['quantity'],
                    'line_total' => $row['line_total'],
                ]);
            }

            return $order;
        });

        $ownerEmail = SiteSetting::getValue('owner_email') ?? config('shop.owner_email');

        try {
            Mail::to($ownerEmail)->send(new OrderAdminNotification($order));
            Mail::to($order->customer_email)->send(new OrderCustomerConfirmation($order));
        } catch (\Throwable $e) {
            report($e);
        }

        $cart->clear();

        AdminActivity::log(
            'order',
            'Új rendelés: '.$order->order_number,
            $order->customer_name.' · '.number_format($order->total, 0, ',', '.').' Ft',
            route('admin.orders.show', $order),
            ['order_id' => $order->id, 'total' => $order->total]
        );

        return redirect()->route('checkout.thanks', $order->order_number);
    }

    public function thanks(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        return view('checkout.thanks', compact('order'));
    }
}
