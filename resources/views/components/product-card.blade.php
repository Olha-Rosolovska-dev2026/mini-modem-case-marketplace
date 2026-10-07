{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@props(['product'])
<div class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
    <a href="{{ $product->url }}" class="relative block aspect-[4/3] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
        @if ($product->primary_image)
            <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105">
        @else
            <span class="grid h-full w-full place-items-center text-4xl font-black text-slate-400">{{ Str::upper(Str::substr($product->name, 0, 2)) }}</span>
        @endif
        @if ($product->discount_percent)
            <span class="absolute left-3 top-3 rounded-full bg-rose-600 px-2 py-1 text-xs font-bold text-white">-{{ $product->discount_percent }}%</span>
        @endif
        @if ($product->is_featured)
            <span class="absolute right-3 top-3 rounded-full bg-sky-600 px-2 py-1 text-xs font-semibold text-white">Featured</span>
        @endif
    </a>
    <div class="flex flex-1 flex-col p-4">
        <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">{{ case_type_label($product->case_type) }}</p>
        <h3 class="mt-1 text-base font-semibold leading-snug text-slate-900">
            <a href="{{ $product->url }}" class="hover:text-sky-600">{{ $product->name }}</a>
        </h3>
        <p class="mt-1 text-xs text-slate-500">
            {{ $product->material ?: 'Material on request' }}
            @if ($product->dimensions) · {{ $product->dimensions }} @endif
            @if ($product->ip_rating) · {{ $product->ip_rating }} @endif
        </p>
        <div class="mt-3 flex items-center gap-2 text-xs text-slate-500">
            <span class="font-semibold text-amber-500">★ {{ number_format((float) $product->rating, 1) }}</span>
            <span>{{ $product->vendor?->name }}</span>
        </div>
        <div class="mt-auto flex items-end justify-between pt-4">
            <div>
                <p class="text-lg font-bold text-slate-900">{{ money($product->price) }}</p>
                @if ($product->compare_price)
                    <p class="text-xs text-slate-400 line-through">{{ money($product->compare_price) }}</p>
                @endif
            </div>
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <button class="rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-700">Add to cart</button>
            </form>
        </div>
    </div>
</div>
