{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $shopSettings['name'] ?? 'Mini Modem Case')</title>
    <meta name="description" content="@yield('meta_description', $shopSettings['tagline'] ?? '')">
    @vite(['resources/css/app.css', 'resources/css/shop.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
    @include('partials.site-header')

    @if (session('status'))
        <div class="mx-auto max-w-7xl px-4 pt-6">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="mx-auto max-w-7xl px-4 pt-6">
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">{{ session('error') }}</div>
        </div>
    @endif

    <main>@yield('content')</main>

    @include('partials.site-footer')
</body>
</html>
