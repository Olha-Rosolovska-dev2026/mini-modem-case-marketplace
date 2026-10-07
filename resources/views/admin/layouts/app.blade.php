{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') · Mini Modem Case</title>
    @vite(['resources/css/app.css', 'resources/css/shop.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
<div class="flex min-h-screen">
    <aside class="mmc-admin-sidebar hidden w-64 shrink-0 flex-col bg-slate-900 p-5 text-sm text-slate-300 lg:flex">
        <a href="{{ route('admin.dashboard') }}" class="mb-6 flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-sky-500 font-bold text-white">MC</span>
            <span class="font-bold text-white">Mini Modem Case<br><span class="text-xs font-normal text-slate-400">Control panel</span></span>
        </a>
        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Dashboard</a>
            <p class="px-3 pt-4 text-xs font-semibold uppercase tracking-wide text-slate-500">Content</p>
            <a href="{{ route('admin.pages.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.pages*') ? 'is-active' : '' }}">Pages</a>
            <a href="{{ route('admin.posts.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.posts*') ? 'is-active' : '' }}">Blog posts</a>
            <a href="{{ route('admin.media.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.media*') ? 'is-active' : '' }}">Media library</a>
            <a href="{{ route('admin.menus.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.menus*') ? 'is-active' : '' }}">Menus</a>
            <p class="px-3 pt-4 text-xs font-semibold uppercase tracking-wide text-slate-500">Marketplace</p>
            <a href="{{ route('admin.products.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.products*') ? 'is-active' : '' }}">Products</a>
            <a href="{{ route('admin.categories.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.categories*') ? 'is-active' : '' }}">Categories</a>
            <a href="{{ route('admin.vendors.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.vendors*') ? 'is-active' : '' }}">Vendors</a>
            <a href="{{ route('admin.orders.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.orders*') ? 'is-active' : '' }}">Orders</a>
            <a href="{{ route('admin.reviews.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.reviews*') ? 'is-active' : '' }}">Reviews</a>
            <a href="{{ route('admin.coupons.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.coupons*') ? 'is-active' : '' }}">Coupons</a>
            <p class="px-3 pt-4 text-xs font-semibold uppercase tracking-wide text-slate-500">System</p>
            <a href="{{ route('admin.users.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.users*') ? 'is-active' : '' }}">Users</a>
            <a href="{{ route('admin.settings.index') }}" class="block rounded-lg px-3 py-2 hover:bg-slate-800 {{ request()->routeIs('admin.settings*') ? 'is-active' : '' }}">Settings</a>
        </nav>
        <div class="mt-auto pt-6">
            <a href="{{ url('/') }}" class="block rounded-lg border border-slate-700 px-3 py-2 text-center text-xs hover:bg-slate-800">View storefront</a>
        </div>
    </aside>

    <div class="flex-1">
        <header class="flex items-center justify-between border-b border-slate-200 bg-white px-6 py-4">
            <div>
                <h1 class="text-lg font-bold text-slate-900">@yield('heading', 'Dashboard')</h1>
                <p class="text-xs text-slate-500">@yield('subheading', 'Mini Modem Case marketplace administration')</p>
            </div>
            <div class="flex items-center gap-3 text-sm">
                <span class="rounded-full bg-slate-100 px-3 py-1 font-medium">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="text-xs font-semibold text-rose-600">Sign out</button>
                </form>
            </div>
        </header>

        <div class="p-6">
            @if (session('status'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <p class="font-semibold">Please correct the following:</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
