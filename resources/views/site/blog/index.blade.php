{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', isset($activeCategory) ? $activeCategory->name : (isset($activeTag) ? 'Tag: ' . $activeTag->name : 'Enclosure guides'))

@section('content')
<div class="mx-auto max-w-7xl px-4 py-12">
    <div class="grid gap-10 lg:grid-cols-[1fr_300px]">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                @if (isset($activeCategory)) {{ $activeCategory->name }} articles
                @elseif (isset($activeTag)) Articles tagged "{{ $activeTag->name }}"
                @else Mini modem case guides @endif
            </h1>
            <p class="mt-2 text-sm text-slate-500">Installation walkthroughs, material comparisons and enclosure sizing advice.</p>

            <div class="mt-10 space-y-8">
                @forelse ($posts as $post)
                    <article class="rounded-2xl border border-slate-200 bg-white p-8">
                        <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">{{ $post->category?->name ?? 'Guide' }}</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900"><a href="{{ $post->url }}" class="hover:text-sky-600">{{ $post->title }}</a></h2>
                        <p class="mt-2 text-xs text-slate-400">{{ optional($post->published_at)->format('F j, Y') }} · {{ $post->author?->name ?? 'Editorial team' }} · {{ $post->views }} views</p>
                        <p class="mt-4 text-sm leading-relaxed text-slate-600">{{ $post->excerpt }}</p>
                        <a href="{{ $post->url }}" class="mt-4 inline-block text-sm font-semibold text-sky-600">Read the guide →</a>
                    </article>
                @empty
                    <p class="text-sm text-slate-500">No articles published yet.</p>
                @endforelse
            </div>
            <div class="mt-10">{{ $posts->links() }}</div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Categories</h2>
                <ul class="mt-4 space-y-2 text-sm">
                    @foreach ($categories as $category)
                        <li><a href="{{ url('/blog/category/' . $category->slug) }}" class="text-slate-600 hover:text-sky-600">{{ $category->name }} ({{ $category->posts_count }})</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500">Tags</h2>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($tags as $tag)
                        <a href="{{ url('/blog/tag/' . $tag->slug) }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600 hover:bg-sky-50">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
