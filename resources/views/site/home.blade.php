{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', ($shopSettings['name'] ?? 'Mini Modem Case') . ' — Enclosures for mini modems and routers')

@section('content')
<section class="relative overflow-hidden bg-slate-900 text-white">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 30%, #38bdf8 0, transparent 45%), radial-gradient(circle at 80% 70%, #818cf8 0, transparent 45%)"></div>
    <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-20 lg:grid-cols-2 lg:items-center">
        <div>
            <span class="inline-flex rounded-full border border-sky-400/40 bg-sky-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-sky-300">Multi-vendor enclosure marketplace</span>
            <h1 class="mt-5 text-4xl font-black leading-tight sm:text-5xl">Protective cases engineered for mini modems and routers</h1>
            <p class="mt-5 max-w-xl text-lg text-slate-300">
                Browse DIN rail, wall-mount and weatherproof enclosures with verified dimensions, IP ratings and antenna routing.
                Every listing is published by a vetted seller and moderated by our marketplace team.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ url('/shop') }}" class="rounded-xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white hover:bg-sky-400">Browse enclosures</a>
                <a href="{{ url('/page/seller-guide') }}" class="rounded-xl border border-white/30 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10">Sell your cases</a>
            </div>
            <dl class="mt-10 grid grid-cols-3 gap-6 text-sm">
                <div><dt class="text-slate-400">Listings</dt><dd class="text-2xl font-bold">{{ \App\Models\Product::count() }}</dd></div>
                <div><dt class="text-slate-400">Verified sellers</dt><dd class="text-2xl font-bold">{{ \App\Models\Vendor::approved()->count() }}</dd></div>
                <div><dt class="text-slate-400">Case categories</dt><dd class="text-2xl font-bold">{{ \App\Models\Category::count() }}</dd></div>
            </dl>
        </div>
        <div class="rounded-3xl border border-white/15 bg-white/5 p-6 backdrop-blur">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-sky-300">Compatibility first</h2>
            <p class="mt-2 text-sm text-slate-300">Filter cases by the exact modem model you deploy. Each enclosure record stores outer dimensions, inner cavity, material, mounting type and IP rating.</p>
            <ul class="mt-5 space-y-3 text-sm">
                @foreach (\App\Models\ModemModel::orderBy('brand')->take(5)->get() as $model)
                    <li class="flex items-center justify-between rounded-xl bg-slate-950/40 px-4 py-3">
                        <span>{{ $model->full_name }}</span>
                        <span class="text-xs text-slate-400">{{ $model->form_factor }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16">
    <div class="flex items-end justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Shop by enclosure type</h2>
            <p class="mt-1 text-sm text-slate-500">Purpose-built housings for every deployment scenario.</p>
        </div>
        <a href="{{ url('/shop') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-700">View all →</a>
    </div>
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($categories as $category)
            <a href="{{ $category->url }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-sky-300 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">{{ $category->products_count }} listings</p>
                <h3 class="mt-2 text-lg font-semibold text-slate-900">{{ $category->name }}</h3>
                <p class="mt-2 line-clamp-3 text-sm text-slate-500">{{ $category->description }}</p>
            </a>
        @endforeach
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 pb-10">
    <h2 class="text-2xl font-bold text-slate-900">Featured enclosures</h2>
    <p class="mt-1 text-sm text-slate-500">Hand-picked cases with the best ratings from our seller network.</p>
    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($featured as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-10">
    <h2 class="text-2xl font-bold text-slate-900">Newest listings</h2>
    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($latest as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16">
    <h2 class="text-2xl font-bold text-slate-900">Trusted sellers</h2>
    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($vendors as $vendor)
            <a href="{{ $vendor->url }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-sky-300">
                <h3 class="text-lg font-semibold text-slate-900">{{ $vendor->name }}</h3>
                <p class="mt-1 text-xs uppercase tracking-wide text-slate-400">{{ $vendor->city }}, {{ $vendor->country }}</p>
                <p class="mt-3 line-clamp-3 text-sm text-slate-500">{{ $vendor->description }}</p>
                <p class="mt-4 text-sm font-semibold text-sky-600">{{ $vendor->products_count }} enclosures · ★ {{ number_format((float) $vendor->rating, 1) }}</p>
            </a>
        @endforeach
    </div>
</section>

@if ($posts->isNotEmpty())
<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex items-end justify-between">
            <h2 class="text-2xl font-bold text-slate-900">Installation guides</h2>
            <a href="{{ url('/blog') }}" class="text-sm font-semibold text-sky-600">All articles →</a>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ($posts as $post)
                <article class="rounded-2xl border border-slate-200 p-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">{{ $post->category?->name }}</p>
                    <h3 class="mt-2 text-lg font-semibold text-slate-900"><a href="{{ $post->url }}" class="hover:text-sky-600">{{ $post->title }}</a></h3>
                    <p class="mt-2 line-clamp-3 text-sm text-slate-500">{{ $post->excerpt }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
