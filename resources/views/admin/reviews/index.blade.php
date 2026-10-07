{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Reviews')
@section('heading', 'Review moderation')
@section('subheading', 'Approve or reject customer feedback')

@section('content')
<div class="mb-5 flex gap-2 text-sm">
    <a href="{{ route('admin.reviews.index') }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 font-medium">All</a>
    <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 font-medium">Pending</a>
    <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 font-medium">Approved</a>
    <a href="{{ route('admin.reviews.index', ['status' => 'rejected']) }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 font-medium">Rejected</a>
</div>

<div class="space-y-4">
    @forelse ($reviews as $review)
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="font-semibold text-slate-800">{{ $review->product?->name }}</p>
                    <p class="text-xs text-slate-400">{{ $review->user?->name ?? 'Guest' }} · {{ optional($review->created_at)->format('M j, Y') }}</p>
                    <p class="mt-2 text-amber-500">{{ str_repeat('★', (int) $review->rating) }}</p>
                    <p class="mt-2 text-sm font-medium text-slate-700">{{ $review->title }}</p>
                    <p class="mt-1 text-sm text-slate-600">{{ $review->comment }}</p>
                    @if ($review->is_verified_purchase)<span class="mt-2 inline-block rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Verified purchase</span>@endif
                </div>
                <div class="flex flex-col gap-2">
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-center text-xs font-semibold capitalize">{{ $review->status }}</span>
                    <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="flex gap-2">@csrf @method('PATCH')
                        <select name="status" class="rounded-lg border-slate-300 text-xs">
                            @foreach (['pending','approved','rejected'] as $status)<option value="{{ $status }}" @selected($review->status === $status)>{{ ucfirst($status) }}</option>@endforeach
                        </select>
                        <button class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white">Save</button>
                    </form>
                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}">@csrf @method('DELETE')
                        <button class="w-full text-xs font-semibold text-rose-600">Delete review</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-sm text-slate-500">No reviews to moderate.</p>
    @endforelse
</div>
<div class="mt-5">{{ $reviews->links() }}</div>
@endsection
