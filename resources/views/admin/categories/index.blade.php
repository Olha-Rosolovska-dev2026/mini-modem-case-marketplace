{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Categories')
@section('heading', 'Enclosure categories')
@section('subheading', 'Case types, mounting families and sub-categories')

@section('content')
<form method="POST" action="{{ route('admin.categories.store') }}" class="mb-6 grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 md:grid-cols-5">
    @csrf
    <input type="text" name="name" placeholder="Category name" class="rounded-lg border-slate-300 text-sm">
    <select name="parent_id" class="rounded-lg border-slate-300 text-sm">
        <option value="">Top level</option>
        @foreach ($categories as $category)<option value="{{ $category->id }}">Under {{ $category->name }}</option>@endforeach
    </select>
    <input type="text" name="description" placeholder="Description" class="rounded-lg border-slate-300 text-sm">
    <input type="number" name="sort_order" placeholder="Sort" class="rounded-lg border-slate-300 text-sm">
    <button class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white">Add category</button>
</form>

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr><th class="px-6 py-3">Name</th><th class="px-6 py-3">Parent</th><th class="px-6 py-3">Products</th><th class="px-6 py-3">Active</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach ($categories as $category)
                <tr>
                    <td class="px-6 py-3">
                        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="flex items-center gap-2">
                            @csrf @method('PUT')
                            <input type="text" name="name" value="{{ $category->name }}" class="w-44 rounded-lg border-slate-300 text-sm">
                            <input type="text" name="description" value="{{ $category->description }}" class="w-64 rounded-lg border-slate-300 text-sm">
                            <input type="number" name="sort_order" value="{{ $category->sort_order }}" class="w-20 rounded-lg border-slate-300 text-sm">
                            <label class="flex items-center gap-1 text-xs text-slate-500"><input type="checkbox" name="is_active" value="1" @checked($category->is_active) class="rounded border-slate-300"> active</label>
                            <button class="rounded-lg border border-slate-300 px-3 py-1 text-xs font-semibold">Save</button>
                        </form>
                    </td>
                    <td class="px-6 py-3 text-slate-500">{{ $category->parent?->name ?? '—' }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $category->products_count }}</td>
                    <td class="px-6 py-3">{{ $category->is_active ? 'Yes' : 'No' }}</td>
                    <td class="px-6 py-3 text-right">
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">@csrf @method('DELETE')
                            <button class="text-xs font-semibold text-rose-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $categories->links() }}</div>
@endsection
