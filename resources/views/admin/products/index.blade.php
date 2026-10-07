{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Products')
@section('heading', 'Mini modem case catalogue')
@section('subheading', 'Enclosures, specifications and compatibility data')

@section('content')
<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <form method="GET" class="flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products" class="rounded-lg border-slate-300 text-sm">
        <select name="status" class="rounded-lg border-slate-300 text-sm">
            <option value="">Any status</option>
            @foreach (['active','draft','archived'] as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold">Filter</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white">New product</a>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr><th class="px-6 py-3">Product</th><th class="px-6 py-3">Case type</th><th class="px-6 py-3">Vendor</th><th class="px-6 py-3">Price</th><th class="px-6 py-3">Stock</th><th class="px-6 py-3">Status</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($products as $product)
                <tr>
                    <td class="px-6 py-3"><span class="font-medium text-slate-800">{{ $product->name }}</span><span class="block text-xs text-slate-400">{{ $product->sku }}</span></td>
                    <td class="px-6 py-3 text-slate-500">{{ case_type_label($product->case_type) }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $product->vendor?->name ?? '—' }}</td>
                    <td class="px-6 py-3 font-semibold">{{ money($product->price) }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $product->stock }}</td>
                    <td class="px-6 py-3"><span class="rounded-full px-2 py-1 text-xs font-semibold {{ $product->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $product->status }}</span></td>
                    <td class="px-6 py-3 text-right">
                        <a href="{{ $product->url }}" target="_blank" class="text-xs font-semibold text-slate-500">View</a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="ml-3 text-xs font-semibold text-sky-600">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">@csrf @method('DELETE')
                            <button class="ml-3 text-xs font-semibold text-rose-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-slate-500">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $products->links() }}</div>
@endsection
