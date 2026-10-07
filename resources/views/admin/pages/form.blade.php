{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', $page->exists ? 'Edit page' : 'New page')
@section('heading', $page->exists ? 'Edit page' : 'Create page')

@section('content')
<form method="POST" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" class="grid gap-6 lg:grid-cols-[1fr_320px]">
    @csrf
    @if ($page->exists) @method('PUT') @endif
    <div class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6">
        <div><label class="block text-sm font-medium">Title</label><input type="text" name="title" value="{{ old('title', $page->title) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        <div><label class="block text-sm font-medium">Slug (leave blank to auto-generate)</label><input type="text" name="slug" value="{{ old('slug', $page->slug) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        <div><label class="block text-sm font-medium">Excerpt</label><textarea name="excerpt" rows="2" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('excerpt', $page->excerpt) }}</textarea></div>
        <div><label class="block text-sm font-medium">Body</label><textarea name="body" rows="14" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('body', $page->body) }}</textarea></div>
    </div>
    <aside class="space-y-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div><label class="block text-sm font-medium">Status</label>
                <select name="status" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    <option value="draft" @selected(old('status', $page->status) === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $page->status) === 'published')>Published</option>
                </select></div>
            <div class="mt-4"><label class="block text-sm font-medium">Template</label>
                <select name="template" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    @foreach (['default','legal','landing','faq'] as $template)
                        <option value="{{ $template }}" @selected(old('template', $page->template) === $template)>{{ ucfirst($template) }}</option>
                    @endforeach
                </select></div>
            <div class="mt-4"><label class="block text-sm font-medium">Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <label class="mt-4 flex items-center gap-2 text-sm"><input type="checkbox" name="show_in_menu" value="1" @checked(old('show_in_menu', $page->show_in_menu)) class="rounded border-slate-300"> Show in header menu</label>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">SEO</h2>
            <div class="mt-4"><label class="block text-sm font-medium">Meta title</label><input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
            <div class="mt-4"><label class="block text-sm font-medium">Meta description</label><textarea name="meta_description" rows="3" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('meta_description', $page->meta_description) }}</textarea></div>
            <div class="mt-4"><label class="block text-sm font-medium">Featured image path</label><input type="text" name="featured_image" value="{{ old('featured_image', $page->featured_image) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="pages/hero.jpg"></div>
        </div>
        <button class="w-full rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white">Save page</button>
        <a href="{{ route('admin.pages.index') }}" class="block text-center text-sm font-medium text-slate-500">Cancel</a>
    </aside>
</form>
@endsection
