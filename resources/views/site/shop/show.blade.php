{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', $product->name)
@section('meta_description', $product->meta_description ?: $product->short_description)

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <nav class="text-xs text-slate-500">
        <a href="{{ url('/') }}" class="hover:text-sky-600">Home</a> /
        <a href="{{ route('shop.index') }}" class="hover:text-sky-600">Shop</a> /
        @if ($product->category)<a href="{{ $product->category->url }}" class="hover:text-sky-600">{{ $product->category->name }}</a> /@endif
        <span class="text-slate-700">{{ $product->name }}</span>
    </nav>

    <div class="mt-6 grid gap-10 lg:grid-cols-2">
        <div>
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white">
                @if ($product->primary_image)
                    <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <div class="grid aspect-[4/3] place-items-center bg-gradient-to-br from-slate-100 to-slate-200 text-6xl font-black text-slate-400">
                        {{ Str::upper(Str::substr($product->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            @if ($product->images->count() > 1)
                <div class="mt-4 grid grid-cols-4 gap-3">
                    @foreach ($product->images as $image)
                        <img src="{{ $image->url }}" alt="{{ $image->alt }}" class="aspect-square rounded-xl border border-slate-200 object-cover">
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">{{ case_type_label($product->case_type) }}</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $product->name }}</h1>
            <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-slate-500">
                <span class="font-semibold text-amber-500">★ {{ number_format((float) $product->rating, 1) }}</span>
                <span>{{ $product->approvedReviews->count() }} reviews</span>
                <span>SKU {{ $product->sku }}</span>
                <span class="font-semibold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $product->stock_label }}</span>
            </div>

            <div class="mt-6 flex items-end gap-4">
                <span class="text-4xl font-black text-slate-900">{{ money($product->price) }}</span>
                @if ($product->compare_price)
                    <span class="text-lg text-slate-400 line-through">{{ money($product->compare_price) }}</span>
                    <span class="rounded-full bg-rose-100 px-2 py-1 text-xs font-bold text-rose-700">Save {{ $product->discount_percent }}%</span>
                @endif
            </div>

            <p class="mt-6 text-sm leading-relaxed text-slate-600">{{ $product->short_description }}</p>

            <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-8 flex flex-wrap items-end gap-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Quantity</label>
                    <input type="number" name="quantity" value="1" min="1" max="99" class="mt-2 w-28 rounded-lg border-slate-300 text-sm">
                </div>
                <button class="rounded-xl bg-sky-600 px-8 py-3 text-sm font-semibold text-white hover:bg-sky-700">Add to cart</button>
            </form>

            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Technical specification</h2>
                <dl class="mt-4 grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <div><dt class="text-slate-500">Case type</dt><dd class="font-medium text-slate-800">{{ case_type_label($product->case_type) }}</dd></div>
                    <div><dt class="text-slate-500">Material</dt><dd class="font-medium text-slate-800">{{ $product->material ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Colour</dt><dd class="font-medium text-slate-800">{{ $product->color ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Outer dimensions</dt><dd class="font-medium text-slate-800">{{ $product->dimensions ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Inner cavity</dt><dd class="font-medium text-slate-800">{{ $product->inner_dimensions ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Weight</dt><dd class="font-medium text-slate-800">{{ $product->weight_grams ? $product->weight_grams . ' g' : '—' }}</dd></div>
                    <div><dt class="text-slate-500">IP rating</dt><dd class="font-medium text-slate-800">{{ $product->ip_rating ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Mounting</dt><dd class="font-medium text-slate-800">{{ $product->mounting_type ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Antenna hole</dt><dd class="font-medium text-slate-800">{{ $product->antenna_hole ? 'Yes' : 'No' }}</dd></div>
                    <div><dt class="text-slate-500">Ventilation slots</dt><dd class="font-medium text-slate-800">{{ $product->ventilation_slots ? 'Yes' : 'No' }}</dd></div>
                    <div><dt class="text-slate-500">Wall mount ready</dt><dd class="font-medium text-slate-800">{{ $product->wall_mount ? 'Yes' : 'No' }}</dd></div>
                    <div><dt class="text-slate-500">LED window</dt><dd class="font-medium text-slate-800">{{ $product->led_indicator_window ?: '—' }}</dd></div>
                    <div><dt class="text-slate-500">Warranty</dt><dd class="font-medium text-slate-800">{{ $product->warranty_months }} months</dd></div>
                    <div><dt class="text-slate-500">Seller</dt><dd class="font-medium text-slate-800">{{ $product->vendor?->name ?? 'Marketplace' }}</dd></div>
                </dl>
            </div>

            @if ($product->modemModels->isNotEmpty())
                <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6">
                    <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Compatible modem models</h2>
                    <ul class="mt-4 flex flex-wrap gap-2 text-xs">
                        @foreach ($product->modemModels as $model)
                            <li class="rounded-full bg-slate-100 px-3 py-1 font-medium text-slate-700">{{ $model->full_name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-14 grid gap-10 lg:grid-cols-[1fr_380px]">
        <div>
            <div class="prose max-w-none rounded-2xl border border-slate-200 bg-white p-8">
                <h2 class="text-xl font-bold text-slate-900">Full description</h2>
                <div class="mt-4 text-sm leading-relaxed text-slate-600">{!! nl2br(e($product->description)) !!}</div>
            </div>

            <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-8">
                <h2 class="text-xl font-bold text-slate-900">Customer reviews</h2>
                @forelse ($product->approvedReviews as $review)
                    <div class="mt-6 border-t border-slate-100 pt-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-slate-800">{{ $review->user?->name ?? 'Verified buyer' }}</p>
                            <span class="text-sm font-semibold text-amber-500">{{ str_repeat('★', (int) $review->rating) }}</span>
                        </div>
                        @if ($review->is_verified_purchase)
                            <span class="mt-1 inline-block rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Verified purchase</span>
                        @endif
                        <h3 class="mt-3 text-sm font-bold text-slate-800">{{ $review->title }}</h3>
                        <p class="mt-1 text-sm text-slate-600">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="mt-4 text-sm text-slate-500">No reviews yet. Be the first to review this enclosure.</p>
                @endforelse

                @auth
                    @if ($canReview)
                        <form method="POST" action="{{ route('reviews.store', $product) }}" class="mt-8 rounded-2xl bg-slate-50 p-6">
                            @csrf
                            <h3 class="text-sm font-bold text-slate-800">Write a review</h3>
                            <div class="mt-4 grid gap-4">
                                <select name="rating" class="rounded-lg border-slate-300 text-sm">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                                <input type="text" name="title" placeholder="Review headline" class="rounded-lg border-slate-300 text-sm">
                                <textarea name="comment" rows="4" placeholder="How did the case fit your modem?" class="rounded-lg border-slate-300 text-sm"></textarea>
                                <button class="rounded-lg bg-slate-900 px-6 py-2 text-sm font-semibold text-white">Submit review</button>
                            </div>
                        </form>
                    @endif
                @else
                    <p class="mt-6 text-sm text-slate-500"><a href="{{ route('login') }}" class="font-semibold text-sky-600">Sign in</a> to write a review.</p>
                @endauth
            </div>
        </div>

        <aside>
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Buying guide</h2>
                <ul class="mt-4 space-y-3 text-sm text-slate-600">
                    <li>• Confirm the inner cavity against your modem dimensions.</li>
                    <li>• Choose IP54 or higher for outdoor cabinets and sheds.</li>
                    <li>• Antenna holes are pre-drilled on request.</li>
                    <li>• Bulk pricing available from 25 units.</li>
                </ul>
            </div>
            @if ($related->isNotEmpty())
                <div class="mt-6">
                    <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Similar enclosures</h2>
                    <div class="mt-4 space-y-4">
                        @foreach ($related as $item)
                            <a href="{{ $item->url }}" class="flex gap-4 rounded-xl border border-slate-200 bg-white p-4 hover:border-sky-300">
                                <span class="grid h-16 w-16 shrink-0 place-items-center rounded-lg bg-slate-100 text-lg font-bold text-slate-400">{{ Str::upper(Str::substr($item->name, 0, 2)) }}</span>
                                <span>
                                    <span class="block text-sm font-semibold text-slate-800">{{ $item->name }}</span>
                                    <span class="mt-1 block text-sm font-bold text-sky-600">{{ money($item->price) }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>
</div>
@endsection
