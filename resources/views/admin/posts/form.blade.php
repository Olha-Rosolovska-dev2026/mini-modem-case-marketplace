{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', $post->exists ? 'Edit article' : 'New article')
@section('heading', $post->exists ? 'Edit article' : 'Write article')

@section('content')
<form method="POST" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" class="grid gap-6 lg:grid-cols-[1fr_320px]">
    @csrf
    @if ($post->exists) @method('PUT') @endif
    <div class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6">
        <div><label class="block text-sm font-medium">Title</label><input type="text" name="title" value="{{ old('title', $post->title) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        <div><label class="block text-sm font-medium">Slug</label><input type="text" name="slug" value="{{ old('slug', $post->slug) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        <div><label class="block text-sm font-medium">Excerpt</label><textarea name="excerpt" rows="3" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('excerpt', $post->excerpt) }}</textarea></div>
        <div><label class="block text-sm font-medium">Body</label><textarea name="body" rows="16" class="mt-1 w-full rounded-lg border-slate-300 text-sm">{{ old('body', $post->body) }}</textarea></div>
    </div>
    <aside class="space-y-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <div><label class="block text-sm font-medium">Status</label>
                <select name="status" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
                </select></div>
            <div class="mt-4"><label class="block text-sm font-medium">Blog category</label>
                <select name="post_category_id" class="mt-1 w-full rounded-lg border-slate-300 text-sm">
                    <option value="">Uncategorised</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('post_category_id', $post->post_category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select></div>
            <div class="mt-4"><label class="block text-sm font-medium">Tags (comma separated)</label>
                <input type="text" name="tags" value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm" placeholder="din rail, ip54, sizing"></div>
            <div class="mt-4"><label class="block text-sm font-medium">Featured image path</label>
                <input type="text" name="featured_image" value="{{ old('featured_image', $post->featured_image) }}" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
        </div>
        <button class="w-full rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white">Save article</button>
        <a href="{{ route('admin.posts.index') }}" class="block text-center text-sm font-medium text-slate-500">Cancel</a>
    </aside>
</form>
@endsection
