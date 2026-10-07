<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin page (CMS content) controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index', ['pages' => Page::orderBy('sort_order')->paginate(15)]);
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        Page::create($this->validated($request));

        return redirect()->route('admin.pages.index')->with('status', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', ['page' => $page]);
    }

    public function update(Request $request, Page $page)
    {
        $page->update($this->validated($request, $page));

        return redirect()->route('admin.pages.index')->with('status', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return back()->with('status', 'Page deleted.');
    }

    protected function validated(Request $request, ?Page $page = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'template' => ['required', 'string', 'max:60'],
            'status' => ['required', 'in:draft,published'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'sort_order' => ['nullable', 'integer'],
            'show_in_menu' => ['nullable', 'boolean'],
        ]);

        $data['show_in_menu'] = $request->boolean('show_in_menu');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        if ($data['status'] === 'published' && ! $page?->published_at) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
