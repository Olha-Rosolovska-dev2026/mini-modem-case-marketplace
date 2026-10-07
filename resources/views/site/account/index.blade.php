{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'My account')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12">
    <h1 class="text-3xl font-bold text-slate-900">Welcome back, {{ $user->name }}</h1>

    <div class="mt-8 grid gap-6 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6"><p class="text-xs uppercase tracking-wide text-slate-400">Orders placed</p><p class="mt-2 text-3xl font-bold">{{ $stats['orders'] }}</p></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6"><p class="text-xs uppercase tracking-wide text-slate-400">Lifetime spend</p><p class="mt-2 text-3xl font-bold">{{ money($stats['spent']) }}</p></div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6"><p class="text-xs uppercase tracking-wide text-slate-400">Reviews written</p><p class="mt-2 text-3xl font-bold">{{ $stats['reviews'] }}</p></div>
    </div>

    <div class="mt-10 rounded-2xl border border-slate-200 bg-white">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Recent orders</h2>
            <a href="{{ route('account.orders') }}" class="text-sm font-semibold text-sky-600">View all →</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($orders as $order)
                <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4 text-sm">
                    <a href="{{ route('account.order', $order->order_number) }}" class="font-semibold text-slate-800 hover:text-sky-600">{{ $order->order_number }}</a>
                    <span class="text-slate-500">{{ optional($order->placed_at)->format('M j, Y') }}</span>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold capitalize text-slate-600">{{ $order->status }}</span>
                    <span class="font-bold">{{ money($order->total) }}</span>
                </div>
            @empty
                <p class="px-6 py-8 text-sm text-slate-500">You have not placed an order yet.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-3">
        <a href="{{ route('account.profile') }}" class="rounded-xl border border-slate-200 bg-white px-6 py-4 text-sm font-semibold text-slate-700 hover:border-sky-300">Edit profile</a>
        <a href="{{ route('account.orders') }}" class="rounded-xl border border-slate-200 bg-white px-6 py-4 text-sm font-semibold text-slate-700 hover:border-sky-300">Order history</a>
        <a href="{{ route('shop.index') }}" class="rounded-xl border border-slate-200 bg-white px-6 py-4 text-sm font-semibold text-slate-700 hover:border-sky-300">Continue shopping</a>
    </div>
</div>
@endsection
