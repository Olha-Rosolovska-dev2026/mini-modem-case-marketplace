{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Marketplace performance at a glance')

@section('content')
<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
    @php
        $cards = [
            ['Revenue', money($stats['revenue'])],
            ['Orders', number_format($stats['orders'])],
            ['Products', number_format($stats['products'])],
            ['Vendors', number_format($stats['vendors'])],
        ];
    @endphp
    @foreach ($cards as [$label, $value])
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $value }}</p>
        </div>
    @endforeach
</div>

<div class="mt-5 grid gap-5 sm:grid-cols-3">
    <div class="rounded-2xl border border-slate-200 bg-white p-6"><p class="text-xs uppercase text-slate-400">Customers</p><p class="mt-1 text-2xl font-bold">{{ $stats['customers'] }}</p></div>
    <div class="rounded-2xl border border-slate-200 bg-white p-6"><p class="text-xs uppercase text-slate-400">Blog posts</p><p class="mt-1 text-2xl font-bold">{{ $stats['posts'] }}</p></div>
    <div class="rounded-2xl border border-slate-200 bg-white p-6"><p class="text-xs uppercase text-slate-400">Reviews awaiting moderation</p><p class="mt-1 text-2xl font-bold text-amber-600">{{ $stats['pendingReviews'] }}</p></div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="rounded-2xl border border-slate-200 bg-white lg:col-span-2">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h2 class="font-bold text-slate-800">Recent orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-sky-600">All orders →</a>
        </div>
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
                <tr><th class="px-6 py-3">Order</th><th class="px-6 py-3">Customer</th><th class="px-6 py-3">Status</th><th class="px-6 py-3 text-right">Total</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-sky-600">{{ $order->order_number }}</a><span class="block text-xs text-slate-400">{{ optional($order->placed_at)->format('M j, Y') }}</span></td>
                        <td class="px-6 py-3 text-slate-600">{{ $order->shipping_name }}</td>
                        <td class="px-6 py-3"><span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold capitalize">{{ $order->status }}</span></td>
                        <td class="px-6 py-3 text-right font-semibold">{{ money($order->total) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Vendors awaiting approval</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @forelse ($pendingVendors as $vendor)
                    <li class="flex items-center justify-between">
                        <span class="text-slate-600">{{ $vendor->name }}</span>
                        <form method="POST" action="{{ route('admin.vendors.approve', $vendor) }}">@csrf
                            <button class="rounded-lg bg-emerald-600 px-3 py-1 text-xs font-semibold text-white">Approve</button>
                        </form>
                    </li>
                @empty
                    <li class="text-slate-500">All sellers are reviewed.</li>
                @endforelse
            </ul>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Most viewed enclosures</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @foreach ($topProducts as $product)
                    <li class="flex items-center justify-between">
                        <span class="truncate text-slate-600">{{ $product->name }}</span>
                        <span class="text-xs text-slate-400">{{ $product->views }} views</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Orders by status</h2>
            <ul class="mt-4 space-y-2 text-sm">
                @foreach ($statusBreakdown as $status => $total)
                    <li class="flex justify-between"><span class="capitalize text-slate-600">{{ $status }}</span><span class="font-semibold">{{ $total }}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
