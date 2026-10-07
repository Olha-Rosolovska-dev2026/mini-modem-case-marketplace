{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Order ' . $order->order_number)
@section('heading', 'Order ' . $order->order_number)
@section('subheading', 'Placed ' . optional($order->placed_at)->format('F j, Y H:i'))

@section('content')
<div class="grid gap-6 lg:grid-cols-[1fr_360px]">
    <div class="space-y-6">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            <h2 class="border-b border-slate-100 px-6 py-4 font-bold text-slate-800">Line items</h2>
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
                    <tr><th class="px-6 py-3">Product</th><th class="px-6 py-3">Case type</th><th class="px-6 py-3">Qty</th><th class="px-6 py-3">Unit</th><th class="px-6 py-3 text-right">Total</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="px-6 py-3"><span class="font-medium text-slate-800">{{ $item->product_name }}</span><span class="block text-xs text-slate-400">SKU {{ $item->product_sku }}</span></td>
                            <td class="px-6 py-3 text-slate-500">{{ case_type_label($item->case_type) }}</td>
                            <td class="px-6 py-3 text-slate-500">{{ $item->quantity }}</td>
                            <td class="px-6 py-3 text-slate-500">{{ money($item->unit_price) }}</td>
                            <td class="px-6 py-3 text-right font-semibold">{{ money($item->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <dl class="border-t border-slate-100 px-6 py-4 text-sm">
                <div class="flex justify-between py-1"><dt class="text-slate-500">Subtotal</dt><dd>{{ money($order->subtotal) }}</dd></div>
                <div class="flex justify-between py-1"><dt class="text-slate-500">Discount</dt><dd>-{{ money($order->discount) }}</dd></div>
                <div class="flex justify-between py-1"><dt class="text-slate-500">Shipping</dt><dd>{{ money($order->shipping) }}</dd></div>
                <div class="flex justify-between py-1"><dt class="text-slate-500">Tax</dt><dd>{{ money($order->tax) }}</dd></div>
                <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold"><dt>Total</dt><dd>{{ money($order->total) }}</dd></div>
            </dl>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-600">
            <h2 class="font-bold text-slate-800">Customer &amp; delivery</h2>
            <p class="mt-3 font-medium text-slate-700">{{ $order->shipping_name }}</p>
            <p>{{ $order->shipping_address }}</p>
            <p>{{ $order->shipping_city }} {{ $order->shipping_postcode }}</p>
            <p>{{ $order->shipping_country }}</p>
            <p class="mt-2">{{ $order->shipping_email }} · {{ $order->shipping_phone }}</p>
            @if ($order->notes)<p class="mt-4 rounded-lg bg-slate-50 p-3"><span class="font-medium">Notes:</span> {{ $order->notes }}</p>@endif
        </div>
    </div>

    <aside class="space-y-5">
        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
            @csrf @method('PATCH')
            <h2 class="font-bold text-slate-800">Update order</h2>
            <div><label class="block text-sm font-medium">Order status</label>
                <select name="status" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @foreach ($statuses as $status)<option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>@endforeach
                </select></div>
            <div><label class="block text-sm font-medium">Payment status</label>
                <select name="payment_status" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @foreach (['unpaid','pending','paid','refunded'] as $status)<option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>@endforeach
                </select></div>
            <button class="w-full rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white">Save changes</button>
        </form>
        <a href="{{ route('admin.orders.index') }}" class="block text-center text-sm font-medium text-slate-500">Back to orders</a>
    </aside>
</div>
@endsection
