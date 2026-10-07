<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Seller dashboard controller
 */

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\Vendor;

class DashboardController extends Controller
{
    protected function vendor(): Vendor
    {
        return Vendor::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'name' => auth()->user()->name . ' Workshop',
                'email' => auth()->user()->email,
                'status' => 'pending',
            ]
        );
    }

    public function index()
    {
        $vendor = $this->vendor();
        $productIds = $vendor->products()->pluck('id');

        return view('vendor.dashboard', [
            'vendor' => $vendor,
            'stats' => [
                'products' => $productIds->count(),
                'orders' => OrderItem::whereIn('product_id', $productIds)->distinct('order_id')->count('order_id'),
                'revenue' => (float) OrderItem::whereIn('product_id', $productIds)->sum('total'),
                'reviews' => Review::whereIn('product_id', $productIds)->count(),
                'rating' => (float) $vendor->rating,
            ],
            'products' => Product::where('vendor_id', $vendor->id)->latest()->take(6)->get(),
            'recentSales' => OrderItem::with('order')->whereIn('product_id', $productIds)->latest()->take(6)->get(),
        ]);
    }

    public function products()
    {
        $vendor = $this->vendor();

        return view('vendor.products', [
            'vendor' => $vendor,
            'products' => Product::where('vendor_id', $vendor->id)->latest()->paginate(15),
        ]);
    }

    public function orders()
    {
        $vendor = $this->vendor();
        $productIds = $vendor->products()->pluck('id');

        return view('vendor.orders', [
            'vendor' => $vendor,
            'items' => OrderItem::with(['order', 'product'])->whereIn('product_id', $productIds)->latest()->paginate(15),
        ]);
    }

    public function profile()
    {
        return view('vendor.profile', ['vendor' => $this->vendor()]);
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $vendor = $this->vendor();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:2000'],
            'address' => ['nullable', 'string', 'max:200'],
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:80'],
        ]);
        $vendor->update($data);

        return back()->with('status', 'Seller profile saved. Changes are reviewed by the marketplace team.');
    }
}
