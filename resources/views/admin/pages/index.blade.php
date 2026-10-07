{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Pages')
@section('heading', 'CMS pages')
@section('subheading', 'Static content, legal pages and landing templates')

@section('content')
<div class="mb-5 flex justify-end">
    <a href="{{ route('admin.pages.create') }}" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white">New page</a>
</div>
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400">
            <tr><th class="px-6 py-3">Title</th><th class="px-6 py-3">Slug</th><th class="px-6 py-3">Template</th><th class="px-6 py-3">Status</th><th class="px-6 py-3"></th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($pages as $page)
                <tr>
                    <td class="px-6 py-3 font-medium text-slate-800">{{ $page->title }}</td>
                    <td class="px-6 py-3 text-slate-500">/page/{{ $page->slug }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $page->template }}</td>
                    <td class="px-6 py-3"><span class="rounded-full px-2 py-1 text-xs font-semibold {{ $page->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $page->status }}</span></td>
                    <td class="px-6 py-3 text-right">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="text-xs font-semibold text-sky-600">Edit</a>
                        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="inline">@csrf @method('DELETE')
                            <button class="ml-3 text-xs font-semibold text-rose-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">No pages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $pages->links() }}</div>
@endsection
