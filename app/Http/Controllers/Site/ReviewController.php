<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Product review controller
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:140'],
            'comment' => ['required', 'string', 'max:1500'],
        ]);

        $orderItem = OrderItem::where('product_id', $product->id)
            ->whereHas('order', fn ($q) => $q->where('user_id', $request->user()->id))
            ->first();

        Review::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => $request->user()->id],
            $data + [
                'status' => 'pending',
                'is_verified_purchase' => (bool) $orderItem,
                'order_id' => $orderItem?->order_id,
            ]
        );

        return back()->with('status', 'Thank you. Your review was submitted and is awaiting moderation.');
    }
}
