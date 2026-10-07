{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
<footer class="mt-20 border-t border-slate-200 bg-slate-900 text-slate-300">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 md:grid-cols-4">
        <div>
            <h3 class="text-lg font-bold text-white">{{ $shopSettings['name'] ?? 'Mini Modem Case' }}</h3>
            <p class="mt-3 text-sm leading-relaxed">{{ $shopSettings['tagline'] ?? '' }}</p>
            <p class="mt-3 text-sm">{{ $shopSettings['address'] ?? '' }}</p>
        </div>
        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Case categories</h4>
            <ul class="mt-3 space-y-2 text-sm">
                @foreach (($footerCategories ?? collect()) as $category)
                    <li><a href="{{ $category->url }}" class="hover:text-sky-300">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Marketplace</h4>
            <ul class="mt-3 space-y-2 text-sm">
                <li><a href="{{ url('/shop') }}" class="hover:text-sky-300">All enclosures</a></li>
                <li><a href="{{ url('/shop?featured=1') }}" class="hover:text-sky-300">Featured cases</a></li>
                <li><a href="{{ url('/page/warranty') }}" class="hover:text-sky-300">Warranty</a></li>
                <li><a href="{{ url('/page/shipping') }}" class="hover:text-sky-300">Shipping &amp; returns</a></li>
                <li><a href="{{ url('/page/seller-guide') }}" class="hover:text-sky-300">Become a seller</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wide text-white">Contact</h4>
            <ul class="mt-3 space-y-2 text-sm">
                <li>{{ $shopSettings['email'] ?? '' }}</li>
                <li>{{ $shopSettings['phone'] ?? '' }}</li>
                <li><a href="{{ url('/contact') }}" class="hover:text-sky-300">Send a message</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-slate-800 px-4 py-6 text-center text-xs text-slate-400">
        © {{ date('Y') }} {{ $shopSettings['name'] ?? 'Mini Modem Case' }}. All rights reserved. Built with Laravel.
    </div>
</footer>
