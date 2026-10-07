<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin order management controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.orders.index', [
            'orders' => Order::with('items')
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
                ->when($request->filled('q'), function ($q) use ($request) {
                    $term = '%' . $request->string('q') . '%';
                    $q->where(fn ($w) => $w->where('order_number', 'like', $term)->orWhere('shipping_email', 'like', $term));
                })
                ->latest()->paginate(15),
            'statuses' => Order::STATUSES,
            'totals' => [
                'count' => Order::count(),
                'revenue' => (float) Order::where('status', '!=', 'cancelled')->sum('total'),
                'pending' => Order::where('status', 'pending')->count(),
            ],
        ]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', [
            'order' => $order->load('items.product', 'user'),
            'statuses' => Order::STATUSES,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', Order::STATUSES)],
            'payment_status' => ['required', 'in:unpaid,pending,paid,refunded'],
        ]);

        $order->update($data);

        return back()->with('status', 'Order ' . $order->order_number . ' updated.');
    }
}
