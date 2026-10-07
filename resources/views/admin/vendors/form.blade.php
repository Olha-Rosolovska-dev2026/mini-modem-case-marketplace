{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', $vendor->exists ? 'Edit vendor' : 'New vendor')
@section('heading', $vendor->exists ? 'Edit vendor' : 'Add marketplace vendor')

@section('content')
<form method="POST" action="{{ $vendor->exists ? route('admin.vendors.update', $vendor) : route('admin.vendors.store') }}" class="grid gap-6 lg:grid-cols-2">
    @csrf
    @if ($vendor->exists) @method('PUT') @endif
    <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
        <div><label class="block text-sm font-medium">Vendor name</label><input type="text" name="name" value="{{ old('name', $vendor->name) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div><label class="block text-sm font-medium">Email</label><input type="email" name="email" value="{{ old('email', $vendor->email) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div><label class="block text-sm font-medium">Phone</label><input type="text" name="phone" value="{{ old('phone', $vendor->phone) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        </div>
        <div><label class="block text-sm font-medium">Description</label><textarea name="description" rows="4" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('description', $vendor->description) }}</textarea></div>
        <div><label class="block text-sm font-medium">Address</label><input type="text" name="address" value="{{ old('address', $vendor->address) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div><label class="block text-sm font-medium">City</label><input type="text" name="city" value="{{ old('city', $vendor->city) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div><label class="block text-sm font-medium">Country</label><input type="text" name="country" value="{{ old('country', $vendor->country ?? 'United States') }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        </div>
    </div>
    <div class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6">
        <div><label class="block text-sm font-medium">Status</label>
            <select name="status" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                @foreach (['pending','approved','suspended'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $vendor->status ?? 'pending') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select></div>
        <div><label class="block text-sm font-medium">Commission rate (%)</label><input type="number" step="0.01" name="commission_rate" value="{{ old('commission_rate', $vendor->commission_rate ?? 10) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $vendor->is_featured)) class="rounded border-slate-300"> Feature this seller on the homepage</label>
        <button class="w-full rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white">Save vendor</button>
        <a href="{{ route('admin.vendors.index') }}" class="block text-center text-sm font-medium text-slate-500">Cancel</a>
    </div>
</form>
@endsection
