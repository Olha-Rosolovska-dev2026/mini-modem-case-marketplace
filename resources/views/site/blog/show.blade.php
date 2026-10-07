{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', $post->title)
@section('meta_description', $post->excerpt)

@section('content')
<article class="mx-auto max-w-3xl px-4 py-12">
    <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">{{ $post->category?->name ?? 'Guide' }}</p>
    <h1 class="mt-3 text-4xl font-black leading-tight text-slate-900">{{ $post->title }}</h1>
    <p class="mt-4 text-sm text-slate-500">{{ optional($post->published_at)->format('F j, Y') }} · {{ $post->author?->name ?? 'Editorial team' }}</p>

    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-8 text-sm leading-relaxed text-slate-700">
        {!! nl2br(e($post->body)) !!}
    </div>

    @if ($post->tags->isNotEmpty())
        <div class="mt-6 flex flex-wrap gap-2">
            @foreach ($post->tags as $tag)
                <a href="{{ url('/blog/tag/' . $tag->slug) }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $tag->name }}</a>
            @endforeach
        </div>
    @endif

    @if ($related->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-lg font-bold text-slate-900">Related guides</h2>
            <ul class="mt-4 space-y-3">
                @foreach ($related as $item)
                    <li><a href="{{ $item->url }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">{{ $item->title }}</a></li>
                @endforeach
            </ul>
        </div>
    @endif
</article>
@endsection
