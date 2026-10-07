{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'Enclosure catalogue')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10">
    <h1 class="text-3xl font-bold text-slate-900">Mini modem case catalogue</h1>
    <p class="mt-2 text-sm text-slate-500">{{ $products->total() }} enclosures from verified marketplace sellers.</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-[280px_1fr]">
        <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6">
            <form method="GET" action="{{ route('shop.index') }}" class="space-y-5">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Search</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Case name, SKU or material" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Category</label>
                    <select name="category" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }} ({{ $category->products_count }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Case type</label>
                    <select name="case_type" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                        <option value="">Any type</option>
                        @foreach (['enclosure','din_rail','wall_mount','rack_mount','weatherproof','desktop','open_frame'] as $type)
                            <option value="{{ $type }}" @selected(request('case_type') === $type)>{{ case_type_label($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">IP rating</label>
                    <select name="ip_rating" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                        <option value="">Any rating</option>
                        @foreach ($ipRatings as $rating)
                            <option value="{{ $rating }}" @selected(request('ip_rating') === $rating)>{{ $rating }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Min price</label>
                        <input type="number" step="0.01" name="min" value="{{ request('min') }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Max price</label>
                        <input type="number" step="0.01" name="max" value="{{ request('max') }}" class="mt-2 w-full rounded-lg border-slate-300 text-sm">
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="featured" value="1" @checked(request('featured')) class="rounded border-slate-300"> Featured only
                </label>
                <div class="flex gap-2">
                    <button class="flex-1 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Apply filters</button>
                    <a href="{{ route('shop.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600">Reset</a>
                </div>
            </form>
        </aside>

        <div>
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3">
                <p class="text-sm text-slate-500">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}</p>
                <form method="GET" action="{{ route('shop.index') }}">
                    @foreach (request()->except('sort','page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="sort" onchange="this.form.submit()" class="rounded-lg border-slate-300 text-sm">
                        <option value="">Newest first</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: low to high</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: high to low</option>
                        <option value="rating" @selected(request('sort') === 'rating')>Highest rated</option>
                        <option value="name" @selected(request('sort') === 'name')>Name A–Z</option>
                    </select>
                </form>
            </div>

            @if ($products->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-16 text-center">
                    <p class="text-lg font-semibold text-slate-700">No enclosures matched your filters</p>
                    <p class="mt-2 text-sm text-slate-500">Try widening the price range or clearing the case type filter.</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                <div class="mt-10">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
