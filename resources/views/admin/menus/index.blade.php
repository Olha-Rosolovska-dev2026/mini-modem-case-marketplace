{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Menus')
@section('heading', 'Navigation menus')
@section('subheading', 'Header, footer and sidebar link structures')

@section('content')
<form method="POST" action="{{ route('admin.menus.store') }}" class="mb-6 grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 md:grid-cols-4">
    @csrf
    <div><label class="block text-sm font-medium">Menu name</label><input type="text" name="name" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
    <div><label class="block text-sm font-medium">Location</label>
        <select name="location" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
            <option value="header">Header</option><option value="footer">Footer</option><option value="sidebar">Sidebar</option>
        </select></div>
    <div class="flex items-end md:col-span-2"><button class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white">Create menu</button></div>
</form>

<div class="space-y-6">
    @forelse ($menus as $menu)
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-slate-800">{{ $menu->name }} <span class="ml-2 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500">{{ $menu->location }}</span></h2>
            </div>
            <ul class="mt-4 space-y-2 text-sm">
                @foreach ($menu->rootItems as $item)
                    <li class="rounded-lg bg-slate-50 px-4 py-2">
                        <div class="flex items-center justify-between">
                            <span><span class="font-medium text-slate-700">{{ $item->label }}</span> <span class="text-xs text-slate-400">{{ $item->url }}</span></span>
                            <form method="POST" action="{{ route('admin.menus.items.destroy', $item) }}">@csrf @method('DELETE')
                                <button class="text-xs font-semibold text-rose-600">Remove</button>
                            </form>
                        </div>
                        @foreach ($item->children as $child)
                            <div class="mt-2 flex items-center justify-between border-l-2 border-slate-200 pl-4">
                                <span class="text-xs text-slate-600">{{ $child->label }} — {{ $child->url }}</span>
                                <form method="POST" action="{{ route('admin.menus.items.destroy', $child) }}">@csrf @method('DELETE')
                                    <button class="text-xs font-semibold text-rose-600">Remove</button>
                                </form>
                            </div>
                        @endforeach
                    </li>
                @endforeach
            </ul>
            <form method="POST" action="{{ route('admin.menus.items.store', $menu) }}" class="mt-5 grid gap-3 md:grid-cols-5">
                @csrf
                <input type="text" name="label" placeholder="Label" class="rounded-lg border-slate-300 text-sm">
                <input type="text" name="url" placeholder="/shop" class="rounded-lg border-slate-300 text-sm">
                <select name="parent_id" class="rounded-lg border-slate-300 text-sm">
                    <option value="">Top level</option>
                    @foreach ($menu->rootItems as $item)<option value="{{ $item->id }}">Under {{ $item->label }}</option>@endforeach
                </select>
                <select name="target" class="rounded-lg border-slate-300 text-sm">
                    <option value="_self">Same tab</option><option value="_blank">New tab</option>
                </select>
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Add item</button>
            </form>
        </div>
    @empty
        <p class="text-sm text-slate-500">No menus configured yet.</p>
    @endforelse
</div>
@endsection
