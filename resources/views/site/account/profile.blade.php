{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', 'Profile settings')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-12">
    <h1 class="text-3xl font-bold text-slate-900">Profile settings</h1>
    <form method="POST" action="{{ route('account.profile.update') }}" class="mt-8 rounded-2xl border border-slate-200 bg-white p-8">
        @csrf @method('PATCH')
        <div class="grid gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2"><label class="block text-sm font-medium text-slate-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div><label class="block text-sm font-medium text-slate-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div><label class="block text-sm font-medium text-slate-700">City</label>
                <input type="text" name="city" value="{{ old('city', $user->city) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div class="sm:col-span-2"><label class="block text-sm font-medium text-slate-700">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div class="sm:col-span-2"><label class="block text-sm font-medium text-slate-700">Country</label>
                <input type="text" name="country" value="{{ old('country', $user->country) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        </div>
        <button class="mt-6 rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white hover:bg-sky-700">Save changes</button>
    </form>
</div>
@endsection
