{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'My orders')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-12">
    <h1 class="text-3xl font-bold text-slate-900">Order history</h1>
    <div class="mt-8 space-y-4">
        @forelse ($orders as $order)
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <a href="{{ route('account.order', $order->order_number) }}" class="text-base font-bold text-slate-900 hover:text-sky-600">{{ $order->order_number }}</a>
                        <p class="mt-1 text-xs text-slate-500">Placed {{ optional($order->placed_at)->format('M j, Y') }} · {{ $order->items->count() }} item(s)</p>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold capitalize text-slate-600">{{ $order->status }}</span>
                    <span class="text-base font-bold">{{ money($order->total) }}</span>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500">No orders yet.</p>
        @endforelse
    </div>
    <div class="mt-8">{{ $orders->links() }}</div>
</div>
@endsection
