{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'Checkout')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12">
    <h1 class="text-3xl font-bold text-slate-900">Checkout</h1>
    <p class="mt-2 text-sm text-slate-500">Complete the delivery details below. Payment is confirmed by our team after the order is placed.</p>

    <form method="POST" action="{{ route('checkout.store') }}" class="mt-8 grid gap-8 lg:grid-cols-[1fr_360px]">
        @csrf
        <div class="rounded-2xl border border-slate-200 bg-white p-8">
            <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Delivery details</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div><label class="block text-sm font-medium text-slate-700">Full name</label>
                    <input type="text" name="shipping_name" value="{{ old('shipping_name', $user?->name) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @error('shipping_name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="shipping_email" value="{{ old('shipping_email', $user?->email) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @error('shipping_email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-slate-700">Phone</label>
                    <input type="text" name="shipping_phone" value="{{ old('shipping_phone', $user?->phone) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
                <div><label class="block text-sm font-medium text-slate-700">Street address</label>
                    <input type="text" name="shipping_address" value="{{ old('shipping_address', $user?->address) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @error('shipping_address')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-slate-700">City</label>
                    <input type="text" name="shipping_city" value="{{ old('shipping_city', $user?->city) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @error('shipping_city')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-medium text-slate-700">Postal code</label>
                    <input type="text" name="shipping_postcode" value="{{ old('shipping_postcode') }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-slate-700">Country</label>
                    <input type="text" name="shipping_country" value="{{ old('shipping_country', $user?->country ?? 'United States') }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            </div>

            <h2 class="mt-8 text-sm font-bold uppercase tracking-wide text-slate-500">Payment method</h2>
            <div class="mt-4 space-y-3 text-sm">
                <label class="flex items-center gap-3 rounded-lg border border-slate-200 p-4"><input type="radio" name="payment_method" value="card" checked class="border-slate-300"> Credit or debit card</label>
                <label class="flex items-center gap-3 rounded-lg border border-slate-200 p-4"><input type="radio" name="payment_method" value="bank_transfer" class="border-slate-300"> Bank transfer</label>
                <label class="flex items-center gap-3 rounded-lg border border-slate-200 p-4"><input type="radio" name="payment_method" value="cod" class="border-slate-300"> Cash on delivery</label>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-slate-700">Order notes (optional)</label>
                <textarea name="notes" rows="3" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="Antenna hole drilling, cable gland size, bulk packaging…">{{ old('notes') }}</textarea>
            </div>
        </div>

        <aside class="h-fit rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Your order</h2>
            <ul class="mt-4 space-y-3 text-sm">
                @foreach ($cart->items as $item)
                    <li class="flex justify-between gap-3">
                        <span class="text-slate-600">{{ $item->quantity }} × {{ $item->product?->name }}</span>
                        <span class="font-medium">{{ money($item->line_total) }}</span>
                    </li>
                @endforeach
            </ul>
            <dl class="mt-6 space-y-2 border-t border-slate-200 pt-4 text-sm">
                <div class="flex justify-between"><dt class="text-slate-500">Subtotal</dt><dd>{{ money($cart->subtotal) }}</dd></div>
                @if ($cart->discount > 0)<div class="flex justify-between text-emerald-600"><dt>Discount</dt><dd>-{{ money($cart->discount) }}</dd></div>@endif
                <div class="flex justify-between"><dt class="text-slate-500">Shipping</dt><dd>{{ $cart->shipping > 0 ? money($cart->shipping) : 'Free' }}</dd></div>
                <div class="flex justify-between"><dt class="text-slate-500">Tax</dt><dd>{{ money($cart->tax) }}</dd></div>
                <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold"><dt>Total</dt><dd>{{ money($cart->total) }}</dd></div>
            </dl>
            <button class="mt-6 w-full rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white hover:bg-sky-700">Place order</button>
        </aside>
    </form>
</div>
@endsection
