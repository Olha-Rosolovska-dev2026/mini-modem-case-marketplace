<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin dashboard controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'revenue' => (float) Order::where('status', '!=', 'cancelled')->sum('total'),
                'orders' => Order::count(),
                'products' => Product::count(),
                'vendors' => Vendor::count(),
                'customers' => User::where('role', 'customer')->count(),
                'posts' => Post::count(),
                'pendingReviews' => Review::where('status', 'pending')->count(),
            ],
            'recentOrders' => Order::with('items')->latest()->take(6)->get(),
            'pendingVendors' => Vendor::where('status', 'pending')->latest()->take(5)->get(),
            'topProducts' => Product::withCount('reviews')->orderByDesc('views')->take(5)->get(),
            'statusBreakdown' => Order::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }
}
