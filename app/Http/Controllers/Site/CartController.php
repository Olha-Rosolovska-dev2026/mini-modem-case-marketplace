<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Shopping cart controller
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function cart(): Cart
    {
        return Cart::forUser(auth()->id(), session()->getId());
    }

    public function index()
    {
        $cart = $this->cart();
        $cart->load('items.product.images');

        return view('site.cart.index', ['cart' => $cart]);
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate(['quantity' => ['nullable', 'integer', 'min:1', 'max:99']]);
        $cart = $this->cart();
        $quantity = (int) ($data['quantity'] ?? 1);

        $item = $cart->items()->where('product_id', $product->id)->first();
        if ($item) {
            $item->update(['quantity' => $item->quantity + $quantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'vendor_id' => $product->vendor_id,
                'quantity' => $quantity,
                'unit_price' => $product->price,
            ]);
        }

        return back()->with('status', '"' . $product->name . '" was added to your cart.');
    }

    public function update(Request $request, CartItem $item)
    {
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:99']]);
        $item->update(['quantity' => $data['quantity']]);

        return back()->with('status', 'Cart updated.');
    }

    public function remove(CartItem $item)
    {
        $item->delete();

        return back()->with('status', 'Item removed from your cart.');
    }

    public function coupon(Request $request)
    {
        $data = $request->validate(['coupon_code' => ['required', 'string', 'max:32']]);
        $coupon = Coupon::where('code', strtoupper($data['coupon_code']))->first();
        $cart = $this->cart();

        if (! $coupon || ! $coupon->isValidFor($cart->subtotal)) {
            return back()->with('error', 'This coupon code is not valid for your current cart.');
        }

        $cart->update(['coupon_code' => $coupon->code]);

        return back()->with('status', 'Coupon "' . $coupon->code . '" applied.');
    }

    public function removeCoupon()
    {
        $this->cart()->update(['coupon_code' => null]);

        return back()->with('status', 'Coupon removed.');
    }
}
