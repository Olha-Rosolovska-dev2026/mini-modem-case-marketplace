{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', $category->name)

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12">
    <h1 class="text-3xl font-bold text-slate-900">{{ $category->name }}</h1>
    <p class="mt-2 max-w-3xl text-sm text-slate-500">{{ $category->description }}</p>

    @if ($children->isNotEmpty())
        <div class="mt-6 flex flex-wrap gap-2">
            @foreach ($children as $child)
                <a href="{{ $child->url }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:border-sky-300">{{ $child->name }}</a>
            @endforeach
        </div>
    @endif

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @forelse ($products as $product)
            <x-product-card :product="$product" />
        @empty
            <p class="text-sm text-slate-500">No enclosures in this category yet.</p>
        @endforelse
    </div>
    <div class="mt-10">{{ $products->links() }}</div>
</div>
@endsection
