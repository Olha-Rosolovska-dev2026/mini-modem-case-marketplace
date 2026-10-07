{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'Contact the enclosure team')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-14">
    <h1 class="text-3xl font-bold text-slate-900">Talk to our enclosure specialists</h1>
    <p class="mt-2 text-sm text-slate-500">Need a custom cutout, a bulk quotation or advice on IP ratings? Send us the details below.</p>

    <div class="mt-10 grid gap-8 md:grid-cols-2">
        <form method="POST" action="{{ route('contact.send') }}" class="rounded-2xl border border-slate-200 bg-white p-8">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Your name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">How can we help?</label>
                    <textarea name="message" rows="5" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <button class="w-full rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white hover:bg-sky-700">Send message</button>
            </div>
        </form>

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-8 text-sm text-slate-600">
                <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Customer service</h2>
                <p class="mt-3">{{ $shopSettings['email'] ?? '' }}</p>
                <p>{{ $shopSettings['phone'] ?? '' }}</p>
                <p class="mt-3">{{ $shopSettings['address'] ?? '' }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-8 text-sm text-slate-600">
                <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Business hours</h2>
                <p class="mt-3">Monday to Friday, 09:00 – 18:00 (CST)</p>
                <p>Technical support replies within one business day.</p>
            </div>
        </div>
    </div>
</div>
@endsection
