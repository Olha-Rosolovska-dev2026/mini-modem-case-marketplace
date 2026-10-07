{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', $vendor->name)

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12">
    <div class="rounded-3xl border border-slate-200 bg-white p-8">
        <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">Verified seller</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $vendor->name }}</h1>
        <p class="mt-2 text-sm text-slate-500">{{ $vendor->city }}, {{ $vendor->country }} · ★ {{ number_format((float) $vendor->rating, 1) }} seller rating</p>
        <p class="mt-4 max-w-3xl text-sm leading-relaxed text-slate-600">{{ $vendor->description }}</p>
    </div>

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @forelse ($products as $product)
            <x-product-card :product="$product" />
        @empty
            <p class="text-sm text-slate-500">This seller has no active listings right now.</p>
        @endforelse
    </div>
    <div class="mt-10">{{ $products->links() }}</div>
</div>
@endsection
