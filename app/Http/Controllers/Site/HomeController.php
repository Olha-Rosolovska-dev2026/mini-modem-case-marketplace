<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Storefront home controller
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Vendor;

class HomeController extends Controller
{
    public function index()
    {
        return view('site.home', [
            'featured' => Product::active()->with(['images', 'vendor'])->featured()->latest()->take(8)->get(),
            'latest' => Product::active()->with(['images', 'vendor'])->latest()->take(8)->get(),
            'categories' => Category::where('is_active', true)->withCount('products')->orderBy('sort_order')->take(8)->get(),
            'vendors' => Vendor::approved()->withCount('products')->orderByDesc('is_featured')->take(4)->get(),
            'posts' => Post::published()->with('category')->latest('published_at')->take(3)->get(),
        ]);
    }
}
