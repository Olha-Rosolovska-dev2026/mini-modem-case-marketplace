{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'Order confirmed')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-16 text-center">
    <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-emerald-100 text-3xl text-emerald-600">✓</div>
    <h1 class="mt-6 text-3xl font-bold text-slate-900">Thank you for your order</h1>
    <p class="mt-3 text-sm text-slate-500">We emailed a confirmation to {{ $order->shipping_email }}. Your order reference is <span class="font-semibold text-slate-800">{{ $order->order_number }}</span>.</p>

    <div class="mt-10 rounded-2xl border border-slate-200 bg-white p-8 text-left">
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between"><dt class="text-slate-500">Status</dt><dd class="font-medium capitalize">{{ $order->status }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Payment</dt><dd class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method) }} · {{ $order->payment_status }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Ship to</dt><dd class="font-medium">{{ $order->shipping_name }}, {{ $order->shipping_city }}</dd></div>
            <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold"><dt>Total paid</dt><dd>{{ money($order->total) }}</dd></div>
        </dl>

        <h2 class="mt-8 text-sm font-bold uppercase tracking-wide text-slate-500">Items</h2>
        <ul class="mt-3 space-y-2 text-sm text-slate-600">
            @foreach ($order->items as $item)
                <li class="flex justify-between"><span>{{ $item->quantity }} × {{ $item->product_name }}</span><span>{{ money($item->total) }}</span></li>
            @endforeach
        </ul>
    </div>

    <div class="mt-8 flex justify-center gap-3">
        <a href="{{ route('account.orders') }}" class="rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white">View my orders</a>
        <a href="{{ route('shop.index') }}" class="rounded-lg border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700">Keep shopping</a>
    </div>
</div>
@endsection
