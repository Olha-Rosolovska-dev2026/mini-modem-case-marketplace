<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Catalogue, search and product detail controller
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ModemModel;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::active()
            ->with(['images', 'vendor', 'category'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . $request->string('q') . '%';
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', $term)
                        ->orWhere('sku', 'like', $term)
                        ->orWhere('short_description', 'like', $term)
                        ->orWhere('material', 'like', $term);
                });
            })
            ->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->string('category'))))
            ->when($request->filled('case_type'), fn ($q) => $q->where('case_type', $request->string('case_type')))
            ->when($request->filled('min'), fn ($q) => $q->where('price', '>=', (float) $request->input('min')))
            ->when($request->filled('max'), fn ($q) => $q->where('price', '<=', (float) $request->input('max')))
            ->when($request->filled('ip_rating'), fn ($q) => $q->where('ip_rating', $request->string('ip_rating')))
            ->when($request->boolean('featured'), fn ($q) => $q->where('is_featured', true));

        match ($request->input('sort')) {
            'price_asc' => $products->orderBy('price'),
            'price_desc' => $products->orderByDesc('price'),
            'rating' => $products->orderByDesc('rating'),
            'name' => $products->orderBy('name'),
            default => $products->latest(),
        };

        return view('site.shop.index', [
            'products' => $products->paginate(12)->withQueryString(),
            'categories' => Category::where('is_active', true)->withCount('products')->orderBy('sort_order')->get(),
            'formFactors' => ModemModel::query()->distinct()->pluck('form_factor')->filter()->values(),
            'ipRatings' => Product::active()->distinct()->pluck('ip_rating')->filter()->values(),
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::active()
            ->with(['images', 'vendor', 'category', 'modemModels', 'approvedReviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $product->increment('views');

        return view('site.shop.show', [
            'product' => $product,
            'related' => Product::active()
                ->with('images')
                ->where('id', '!=', $product->id)
                ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
                ->take(4)->get(),
            'canReview' => auth()->check() && ! Review::where('product_id', $product->id)->where('user_id', auth()->id())->exists(),
        ]);
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('site.shop.category', [
            'category' => $category,
            'products' => Product::active()->with(['images', 'vendor'])
                ->where('category_id', $category->id)
                ->paginate(12),
            'children' => $category->children()->where('is_active', true)->get(),
        ]);
    }

    public function vendor(string $slug)
    {
        $vendor = \App\Models\Vendor::approved()->where('slug', $slug)->firstOrFail();

        return view('site.shop.vendor', [
            'vendor' => $vendor,
            'products' => Product::active()->with('images')
                ->where('vendor_id', $vendor->id)
                ->paginate(12),
        ]);
    }
}
