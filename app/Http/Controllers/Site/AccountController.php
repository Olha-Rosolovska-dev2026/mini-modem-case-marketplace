<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Customer account controller
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('site.account.index', [
            'user' => $user,
            'orders' => Order::where('user_id', $user->id)->latest()->take(5)->get(),
            'stats' => [
                'orders' => Order::where('user_id', $user->id)->count(),
                'spent' => (float) Order::where('user_id', $user->id)->where('payment_status', '!=', 'refunded')->sum('total'),
                'reviews' => $user->reviews()->count(),
            ],
        ]);
    }

    public function orders()
    {
        return view('site.account.orders', [
            'orders' => Order::with('items')->where('user_id', auth()->id())->latest()->paginate(10),
        ]);
    }

    public function order(string $orderNumber)
    {
        $order = Order::with('items.product')->where('order_number', $orderNumber)->firstOrFail();
        abort_unless($order->user_id === auth()->id(), 403);

        return view('site.account.order', ['order' => $order]);
    }

    public function profile()
    {
        return view('site.account.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:200'],
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:80'],
        ]);

        $user->update($data);

        return back()->with('status', 'Your profile details were saved.');
    }
}
