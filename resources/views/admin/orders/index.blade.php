{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Orders')
@section('heading', 'Orders')
@section('subheading', 'Fulfilment queue and payment status')

@section('content')
<div class="mb-5 grid gap-4 sm:grid-cols-3">
    <div class="rounded-2xl border border-slate-200 bg-white p-5"><p class="text-xs uppercase text-slate-400">Total orders</p><p class="mt-1 text-2xl font-bold">{{ $totals['count'] }}</p></div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5"><p class="text-xs uppercase text-slate-400">Revenue</p><p class="mt-1 text-2xl font-bold">{{ money($totals['revenue']) }}</p></div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5"><p class="text-xs uppercase text-slate-400">Awaiting processing</p><p class="mt-1 text-2xl font-bold text-amber-600">{{ $totals['pending'] }}</p></div>
</div>

<form method="GET" class="mb-5 flex flex-wrap gap-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Order number or email" class="rounded-lg border-slate-300 text-sm">
    <select name="status" class="rounded-lg border-slate-300 text-sm">
        <option value="">Any status</option>
        @foreach ($statuses as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach
    </select>
    <button class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold">Search</button>
</form>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr><th class="px-6 py-3">Order</th><th class="px-6 py-3">Customer</th><th class="px-6 py-3">Items</th><th class="px-6 py-3">Payment</th><th class="px-6 py-3">Status</th><th class="px-6 py-3 text-right">Total</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($orders as $order)
                <tr>
                    <td class="px-6 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-sky-600">{{ $order->order_number }}</a><span class="block text-xs text-slate-400">{{ optional($order->placed_at)->format('M j, Y H:i') }}</span></td>
                    <td class="px-6 py-3 text-slate-600">{{ $order->shipping_name }}<span class="block text-xs text-slate-400">{{ $order->shipping_email }}</span></td>
                    <td class="px-6 py-3 text-slate-500">{{ $order->items->count() }}</td>
                    <td class="px-6 py-3"><span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold capitalize">{{ str_replace('_', ' ', $order->payment_method) }} · {{ $order->payment_status }}</span></td>
                    <td class="px-6 py-3"><span class="rounded-full bg-{{ $order->status_color }}-100 px-2 py-1 text-xs font-semibold capitalize text-{{ $order->status_color }}-700">{{ $order->status }}</span></td>
                    <td class="px-6 py-3 text-right font-semibold">{{ money($order->total) }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $orders->links() }}</div>
@endsection
