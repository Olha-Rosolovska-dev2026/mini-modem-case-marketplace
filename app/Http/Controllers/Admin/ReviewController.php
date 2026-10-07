<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin review moderation controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.reviews.index', [
            'reviews' => Review::with(['product', 'user'])
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
                ->latest()->paginate(15),
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate(['status' => ['required', 'in:pending,approved,rejected']]);
        $review->update($data);
        $this->recalculate($review->product_id);

        return back()->with('status', 'Review marked as ' . $data['status'] . '.');
    }

    public function destroy(Review $review)
    {
        $productId = $review->product_id;
        $review->delete();
        $this->recalculate($productId);

        return back()->with('status', 'Review deleted.');
    }

    protected function recalculate(?int $productId): void
    {
        if (! $productId) {
            return;
        }

        $average = Review::where('product_id', $productId)->where('status', 'approved')->avg('rating') ?? 0;
        Product::where('id', $productId)->update(['rating' => round((float) $average, 2)]);
    }
}
