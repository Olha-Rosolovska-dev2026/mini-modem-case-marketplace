<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin media library controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::query()
            ->when($request->filled('folder'), fn ($q) => $q->where('folder', $request->string('folder')))
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->string('q') . '%'))
            ->latest()
            ->paginate(24);

        return view('admin.media.index', [
            'media' => $media,
            'folders' => Media::query()->distinct()->pluck('folder')->filter()->values(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:8192', 'mimes:jpg,jpeg,png,webp,gif,svg,pdf'],
            'folder' => ['nullable', 'string', 'max:60'],
            'alt' => ['nullable', 'string', 'max:180'],
        ]);

        $file = $request->file('file');
        $folder = $request->input('folder', 'uploads') ?: 'uploads';
        $path = $file->store($folder, 'public');

        Media::create([
            'user_id' => auth()->id(),
            'name' => $file->getClientOriginalName(),
            'file_name' => basename($path),
            'path' => $path,
            'disk' => 'public',
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'alt' => $request->input('alt'),
            'folder' => $folder,
        ]);

        return back()->with('status', 'File uploaded to the media library.');
    }

    public function destroy(Media $medium)
    {
        $medium->delete();

        return back()->with('status', 'Media entry removed.');
    }
}
