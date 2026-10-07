{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Vendors')
@section('heading', 'Marketplace vendors')
@section('subheading', 'Seller applications, commissions and storefront profiles')

@section('content')
<div class="mb-5 flex flex-wrap items-center justify-between gap-3">
    <div class="flex gap-2 text-sm">
        <a href="{{ route('admin.vendors.index') }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 font-medium">All</a>
        <a href="{{ route('admin.vendors.index', ['status' => 'pending']) }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 font-medium">Pending ({{ $pendingCount }})</a>
        <a href="{{ route('admin.vendors.index', ['status' => 'approved']) }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 font-medium">Approved</a>
        <a href="{{ route('admin.vendors.index', ['status' => 'suspended']) }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 font-medium">Suspended</a>
    </div>
    <a href="{{ route('admin.vendors.create') }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white">Add vendor</a>
</div>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr><th class="px-6 py-3">Vendor</th><th class="px-6 py-3">Location</th><th class="px-6 py-3">Products</th><th class="px-6 py-3">Commission</th><th class="px-6 py-3">Status</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($vendors as $vendor)
                <tr>
                    <td class="px-6 py-3"><span class="font-medium text-slate-800">{{ $vendor->name }}</span><span class="block text-xs text-slate-400">{{ $vendor->email }}</span></td>
                    <td class="px-6 py-3 text-slate-500">{{ $vendor->city }}, {{ $vendor->country }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $vendor->products_count }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ number_format((float) $vendor->commission_rate, 2) }}%</td>
                    <td class="px-6 py-3">
                        <span class="rounded-full px-2 py-1 text-xs font-semibold
                            @if ($vendor->status === 'approved') bg-emerald-100 text-emerald-700
                            @elseif ($vendor->status === 'pending') bg-amber-100 text-amber-700
                            @else bg-rose-100 text-rose-700 @endif">{{ $vendor->status }}</span>
                    </td>
                    <td class="px-6 py-3 text-right">
                        @if ($vendor->status !== 'approved')
                            <form method="POST" action="{{ route('admin.vendors.approve', $vendor) }}" class="inline">@csrf
                                <button class="text-xs font-semibold text-emerald-600">Approve</button>
                            </form>
                        @endif
                        @if ($vendor->status !== 'suspended')
                            <form method="POST" action="{{ route('admin.vendors.suspend', $vendor) }}" class="inline">@csrf
                                <button class="ml-3 text-xs font-semibold text-amber-600">Suspend</button>
                            </form>
                        @endif
                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="ml-3 text-xs font-semibold text-sky-600">Edit</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-500">No vendors registered yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $vendors->links() }}</div>
@endsection
