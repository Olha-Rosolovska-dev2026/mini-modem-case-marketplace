{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Blog posts')
@section('heading', 'Blog posts')
@section('subheading', 'Guides, installation articles and enclosure comparisons')

@section('content')
<div class="mb-5 flex justify-end">
    <a href="{{ route('admin.posts.create') }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white">New article</a>
</div>

<div class="grid gap-6 lg:grid-cols-[1fr_320px]">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
                <tr><th class="px-6 py-3">Title</th><th class="px-6 py-3">Category</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Views</th><th class="px-6 py-3"></th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($posts as $post)
                    <tr>
                        <td class="px-6 py-3 font-medium text-slate-800">{{ $post->title }}</td>
                        <td class="px-6 py-3 text-slate-500">{{ $post->category?->name ?? '—' }}</td>
                        <td class="px-6 py-3"><span class="rounded-full px-2 py-1 text-xs font-semibold {{ $post->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $post->status }}</span></td>
                        <td class="px-6 py-3 text-slate-500">{{ $post->views }}</td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs font-semibold text-sky-600">Edit</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline">@csrf @method('DELETE')
                                <button class="ml-3 text-xs font-semibold text-rose-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">No articles yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <aside class="space-y-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Add blog category</h2>
            <form method="POST" action="{{ route('admin.posts.categories.store') }}" class="mt-4 space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Category name" class="w-full rounded-lg border-slate-300 text-sm">
                <textarea name="description" rows="2" placeholder="Short description" class="w-full rounded-lg border-slate-300 text-sm"></textarea>
                <button class="w-full rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Create category</button>
            </form>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="font-bold text-slate-800">Existing categories</h2>
            <ul class="mt-4 space-y-2 text-sm">
                @forelse ($categories as $category)
                    <li class="flex items-center justify-between">
                        <span class="text-slate-600">{{ $category->name }} ({{ $category->posts_count }})</span>
                        <form method="POST" action="{{ route('admin.posts.categories.destroy', $category) }}">@csrf @method('DELETE')
                            <button class="text-xs font-semibold text-rose-600">Remove</button>
                        </form>
                    </li>
                @empty
                    <li class="text-slate-500">No categories yet.</li>
                @endforelse
            </ul>
        </div>
    </aside>
</div>
<div class="mt-5">{{ $posts->links() }}</div>
@endsection
