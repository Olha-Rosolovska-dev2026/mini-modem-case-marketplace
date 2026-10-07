{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'Shopping cart')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12">
    <h1 class="text-3xl font-bold text-slate-900">Your cart</h1>

    @if ($cart->items->isEmpty())
        <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-white p-16 text-center">
            <p class="text-lg font-semibold text-slate-700">Your cart is empty</p>
            <a href="{{ route('shop.index') }}" class="mt-4 inline-block rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white">Browse enclosures</a>
        </div>
    @else
        <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_360px]">
            <div class="space-y-4">
                @foreach ($cart->items as $item)
                    <div class="flex flex-wrap items-center gap-6 rounded-2xl border border-slate-200 bg-white p-5">
                        <span class="grid h-20 w-20 place-items-center rounded-xl bg-slate-100 text-xl font-bold text-slate-400">{{ Str::upper(Str::substr($item->product?->name ?? 'MM', 0, 2)) }}</span>
                        <div class="flex-1">
                            <a href="{{ $item->product?->url }}" class="text-base font-semibold text-slate-900 hover:text-sky-600">{{ $item->product?->name }}</a>
                            <p class="mt-1 text-xs text-slate-500">{{ case_type_label($item->product?->case_type) }} · SKU {{ $item->product?->sku }}</p>
                            <p class="mt-1 text-sm font-bold text-slate-800">{{ money($item->unit_price) }}</p>
                        </div>
                        <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99" class="w-20 rounded-lg border-slate-300 text-sm">
                            <button class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600">Update</button>
                        </form>
                        <p class="w-24 text-right text-base font-bold text-slate-900">{{ money($item->line_total) }}</p>
                        <form method="POST" action="{{ route('cart.remove', $item) }}">
                            @csrf @method('DELETE')
                            <button class="text-xs font-semibold text-rose-600 hover:text-rose-700">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Order summary</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between"><dt class="text-slate-500">Subtotal</dt><dd class="font-medium">{{ money($cart->subtotal) }}</dd></div>
                    @if ($cart->discount > 0)
                        <div class="flex justify-between text-emerald-600"><dt>Coupon {{ $cart->coupon_code }}</dt><dd>-{{ money($cart->discount) }}</dd></div>
                    @endif
                    <div class="flex justify-between"><dt class="text-slate-500">Shipping</dt><dd class="font-medium">{{ $cart->shipping > 0 ? money($cart->shipping) : 'Free' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Tax</dt><dd class="font-medium">{{ money($cart->tax) }}</dd></div>
                    <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold"><dt>Total</dt><dd>{{ money($cart->total) }}</dd></div>
                </dl>

                <form method="POST" action="{{ route('cart.coupon') }}" class="mt-6 flex gap-2">
                    @csrf
                    <input type="text" name="coupon_code" value="{{ $cart->coupon_code }}" placeholder="Coupon code" class="w-full rounded-lg border-slate-300 text-sm">
                    <button class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-600">Apply</button>
                </form>
                @if ($cart->coupon_code)
                    <form method="POST" action="{{ route('cart.coupon.remove') }}" class="mt-2">
                        @csrf @method('DELETE')
                        <button class="text-xs font-semibold text-rose-600">Remove coupon</button>
                    </form>
                @endif

                <a href="{{ route('checkout.index') }}" class="mt-6 block rounded-lg bg-sky-600 px-6 py-3 text-center text-sm font-semibold text-white hover:bg-sky-700">Proceed to checkout</a>
            </aside>
        </div>
    @endif
</div>
@endsection
