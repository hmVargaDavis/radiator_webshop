<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Order $order)
    {
        $status = request()->validate([
            'status' => 'required|in:new,processing,shipped,completed,cancelled',
        ])['status'];

        $order->update(['status' => $status]);

        return back()->with('success', 'Rendelés státusza frissítve.');
    }
}
