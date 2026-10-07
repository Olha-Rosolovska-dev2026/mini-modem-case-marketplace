{{-- Developer: Olha Rosolovska | Mini Modem Case - CMS & Marketplace --}}
@extends('admin.layouts.app')
@section('title', 'Media library')
@section('heading', 'Media library')
@section('subheading', 'Product photography, diagrams and datasheets')

@section('content')
<form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="mb-6 grid gap-4 rounded-2xl border border-slate-200 bg-white p-6 md:grid-cols-4">
    @csrf
    <div><label class="block text-sm font-medium">File</label><input type="file" name="file" class="mt-1 w-full text-sm"></div>
    <div><label class="block text-sm font-medium">Folder</label><input type="text" name="folder" value="products" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
    <div><label class="block text-sm font-medium">Alt text</label><input type="text" name="alt" class="mt-1 w-full rounded-lg border-slate-300 text-sm"></div>
    <div class="flex items-end"><button class="w-full rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white">Upload</button></div>
</form>

<div class="grid gap-5 sm:grid-cols-3 xl:grid-cols-5">
    @forelse ($media as $item)
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
            @if (str_starts_with((string) $item->mime_type, 'image/'))
                <img src="{{ $item->url }}" alt="{{ $item->alt }}" class="h-40 w-full object-cover">
            @else
                <div class="grid h-40 place-items-center bg-slate-100 text-sm font-semibold text-slate-500">{{ strtoupper(pathinfo($item->file_name, PATHINFO_EXTENSION)) }}</div>
            @endif
            <div class="p-4">
                <p class="truncate text-xs font-semibold text-slate-700">{{ $item->name }}</p>
                <p class="mt-1 text-xs text-slate-400">{{ $item->folder }} · {{ $item->human_size }}</p>
                <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="mt-3">@csrf @method('DELETE')
                    <button class="text-xs font-semibold text-rose-600">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-sm text-slate-500">The media library is empty. Upload product images above.</p>
    @endforelse
</div>
<div class="mt-6">{{ $media->links() }}</div>
@endsection
