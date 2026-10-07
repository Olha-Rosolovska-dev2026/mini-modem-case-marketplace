{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="bg-slate-900 px-4 py-2 text-center text-xs font-medium text-slate-200">
        Free shipping on enclosure orders over {{ money($shopSettings['free_shipping_threshold'] ?? 75) }} · Industrial-grade mini modem cases
    </div>
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-4">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 text-lg font-bold text-white">MC</span>
            <span class="leading-tight">
                <span class="block text-lg font-bold text-slate-900">{{ $shopSettings['name'] ?? 'Mini Modem Case' }}</span>
                <span class="block text-xs text-slate-500">Marketplace for modem enclosures</span>
            </span>
        </a>

        <nav class="hidden items-center gap-6 text-sm font-medium text-slate-700 lg:flex">
            @if (! empty($headerMenu))
                @foreach ($headerMenu->rootItems as $item)
                    <div class="relative group">
                        <a href="{{ $item->url }}" target="{{ $item->target }}" class="hover:text-sky-600">{{ $item->label }}</a>
                        @if ($item->children->isNotEmpty())
                            <div class="invisible absolute left-0 top-full w-52 rounded-xl border border-slate-200 bg-white p-2 shadow-lg group-hover:visible">
                                @foreach ($item->children as $child)
                                    <a href="{{ $child->url }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-sky-600">{{ $child->label }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <a href="{{ url('/shop') }}" class="hover:text-sky-600">Shop</a>
                <a href="{{ url('/blog') }}" class="hover:text-sky-600">Guides</a>
                <a href="{{ url('/page/about') }}" class="hover:text-sky-600">About</a>
                <a href="{{ url('/contact') }}" class="hover:text-sky-600">Contact</a>
            @endif
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('cart.index') }}" class="relative rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:border-sky-300 hover:text-sky-600">
                Cart
                @php $cartCount = \App\Models\Cart::forUser(auth()->id(), session()->getId())->item_count; @endphp
                @if ($cartCount > 0)
                    <span class="absolute -right-2 -top-2 grid h-5 min-w-5 place-items-center rounded-full bg-sky-600 px-1 text-xs font-bold text-white">{{ $cartCount }}</span>
                @endif
            </a>
            @auth
                <div class="relative">
                    <button type="button" onclick="document.getElementById('userMenu').classList.toggle('hidden')" class="rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white">{{ auth()->user()->name }}</button>
                    <div id="userMenu" class="absolute right-0 mt-2 hidden w-56 rounded-xl border border-slate-200 bg-white p-2 shadow-lg">
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-50">Admin panel</a>
                        @endif
                        @if (auth()->user()->isVendor() || auth()->user()->isAdmin())
                            <a href="{{ route('vendor.dashboard') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-50">Seller dashboard</a>
                        @endif
                        <a href="{{ route('account.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-50">My account</a>
                        <a href="{{ route('account.orders') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-50">My orders</a>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button class="block w-full rounded-lg px-3 py-2 text-left text-sm text-rose-600 hover:bg-rose-50">Sign out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Sign in</a>
            @endauth
        </div>
    </div>
</header>
