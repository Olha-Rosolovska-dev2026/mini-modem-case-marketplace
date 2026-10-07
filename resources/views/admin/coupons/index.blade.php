{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Coupons')
@section('heading', 'Discount coupons')
@section('subheading', 'Promotions for enclosure orders')

@section('content')
<form method="POST" action="{{ route('admin.coupons.store') }}" class="mb-6 grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 md:grid-cols-6">
    @csrf
    <input type="text" name="code" placeholder="CODE" class="rounded-lg border-slate-300 text-sm">
    <select name="type" class="rounded-lg border-slate-300 text-sm">
        <option value="percent">Percent</option><option value="fixed">Fixed amount</option>
    </select>
    <input type="number" step="0.01" name="value" placeholder="Value" class="rounded-lg border-slate-300 text-sm">
    <input type="number" step="0.01" name="min_order" placeholder="Min order" class="rounded-lg border-slate-300 text-sm">
    <input type="date" name="expires_at" class="rounded-lg border-slate-300 text-sm">
    <button class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white">Create coupon</button>
</form>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr><th class="px-6 py-3">Code</th><th class="px-6 py-3">Discount</th><th class="px-6 py-3">Min order</th><th class="px-6 py-3">Used</th><th class="px-6 py-3">Expires</th><th class="px-6 py-3">Active</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($coupons as $coupon)
                <tr>
                    <td class="px-6 py-3 font-semibold text-slate-800">{{ $coupon->code }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $coupon->type === 'percent' ? $coupon->value . '%' : money($coupon->value) }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ money($coupon->min_order) }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $coupon->used_count }}{{ $coupon->max_uses ? ' / ' . $coupon->max_uses : '' }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ optional($coupon->expires_at)->format('M j, Y') ?? '—' }}</td>
                    <td class="px-6 py-3">{{ $coupon->is_active ? 'Yes' : 'No' }}</td>
                    <td class="px-6 py-3 text-right">
                        <form method="POST" action="{{ route('admin.coupons.toggle', $coupon) }}" class="inline">@csrf @method('PATCH')
                            <button class="text-xs font-semibold text-sky-600">Toggle</button>
                        </form>
                        <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" class="inline">@csrf @method('DELETE')
                            <button class="ml-3 text-xs font-semibold text-rose-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-slate-500">No coupons yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $coupons->links() }}</div>
@endsection
