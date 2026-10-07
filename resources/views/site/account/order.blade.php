{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'Order ' . $order->order_number)

@section('content')
<div class="mx-auto max-w-4xl px-4 py-12">
    <h1 class="text-3xl font-bold text-slate-900">Order {{ $order->order_number }}</h1>
    <p class="mt-2 text-sm text-slate-500">Placed {{ optional($order->placed_at)->format('F j, Y') }} · Status: <span class="font-semibold capitalize">{{ $order->status }}</span></p>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-8">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase tracking-wide text-slate-400">
                <tr><th class="pb-3">Product</th><th class="pb-3">Type</th><th class="pb-3">Qty</th><th class="pb-3">Unit</th><th class="pb-3 text-right">Total</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($order->items as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-800">{{ $item->product_name }}<span class="block text-xs text-slate-400">SKU {{ $item->product_sku }}</span></td>
                        <td class="py-3 text-slate-500">{{ case_type_label($item->case_type) }}</td>
                        <td class="py-3 text-slate-500">{{ $item->quantity }}</td>
                        <td class="py-3 text-slate-500">{{ money($item->unit_price) }}</td>
                        <td class="py-3 text-right font-semibold">{{ money($item->total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <dl class="mt-6 space-y-2 border-t border-slate-200 pt-4 text-sm">
            <div class="flex justify-between"><dt class="text-slate-500">Subtotal</dt><dd>{{ money($order->subtotal) }}</dd></div>
            @if ($order->discount > 0)<div class="flex justify-between text-emerald-600"><dt>Discount</dt><dd>-{{ money($order->discount) }}</dd></div>@endif
            <div class="flex justify-between"><dt class="text-slate-500">Shipping</dt><dd>{{ money($order->shipping) }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500">Tax</dt><dd>{{ money($order->tax) }}</dd></div>
            <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold"><dt>Total</dt><dd>{{ money($order->total) }}</dd></div>
        </dl>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-8 text-sm text-slate-600">
        <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Shipping address</h2>
        <p class="mt-3">{{ $order->shipping_name }}</p>
        <p>{{ $order->shipping_address }}</p>
        <p>{{ $order->shipping_city }} {{ $order->shipping_postcode }}</p>
        <p>{{ $order->shipping_country }}</p>
        <p class="mt-2">{{ $order->shipping_email }} · {{ $order->shipping_phone }}</p>
    </div>
</div>
@endsection
