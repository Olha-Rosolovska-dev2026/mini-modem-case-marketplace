<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Checkout controller
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::forUser(auth()->id(), session()->getId());
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add an enclosure before checking out.');
        }

        return view('site.checkout.index', [
            'cart' => $cart,
            'user' => auth()->user(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_name' => ['required', 'string', 'max:160'],
            'shipping_email' => ['required', 'email', 'max:160'],
            'shipping_phone' => ['nullable', 'string', 'max:40'],
            'shipping_address' => ['required', 'string', 'max:200'],
            'shipping_city' => ['required', 'string', 'max:120'],
            'shipping_postcode' => ['nullable', 'string', 'max:20'],
            'shipping_country' => ['required', 'string', 'max:80'],
            'payment_method' => ['required', 'in:cod,bank_transfer,card'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = Cart::forUser(auth()->id(), session()->getId());
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = DB::transaction(function () use ($cart, $data) {
            $order = Order::create($data + [
                'order_number' => Order::generateNumber(),
                'user_id' => auth()->id(),
                'status' => 'pending',
                'payment_status' => $data['payment_method'] === 'cod' ? 'unpaid' : 'pending',
                'subtotal' => $cart->subtotal,
                'discount' => $cart->discount,
                'shipping' => $cart->shipping,
                'tax' => $cart->tax,
                'total' => $cart->total,
                'currency' => 'USD',
                'coupon_code' => $cart->coupon_code,
                'placed_at' => now(),
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'vendor_id' => $item->vendor_id,
                    'product_name' => $item->product?->name ?? 'Mini modem case',
                    'product_sku' => $item->product?->sku,
                    'case_type' => $item->product?->case_type,
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'total' => $item->line_total,
                ]);

                $item->product?->decrement('stock', $item->quantity);
            }

            if ($cart->coupon_code) {
                Coupon::where('code', $cart->coupon_code)->increment('used_count');
            }

            $cart->items()->delete();
            $cart->update(['coupon_code' => null]);

            return $order;
        });

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success(string $orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        return view('site.checkout.success', ['order' => $order]);
    }
}
