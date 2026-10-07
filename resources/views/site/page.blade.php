{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('layouts.shop')
@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: $page->excerpt)

@section('content')
<div class="mx-auto max-w-3xl px-4 py-14">
    <h1 class="text-4xl font-black text-slate-900">{{ $page->title }}</h1>
    @if ($page->excerpt)<p class="mt-4 text-lg text-slate-500">{{ $page->excerpt }}</p>@endif
    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-8 text-sm leading-relaxed text-slate-700">
        {!! nl2br(e($page->body)) !!}
    </div>
</div>
@endsection
