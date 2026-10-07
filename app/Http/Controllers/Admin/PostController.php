<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin post and category controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::with('category')->latest()->paginate(15),
            'categories' => PostCategory::withCount('posts')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.posts.form', [
            'post' => new Post(),
            'categories' => PostCategory::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $post = Post::create($this->validated($request));
        $this->syncTags($post, $request->input('tags'));

        return redirect()->route('admin.posts.index')->with('status', 'Article created successfully.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', [
            'post' => $post,
            'categories' => PostCategory::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($this->validated($request, $post));
        $this->syncTags($post, $request->input('tags'));

        return redirect()->route('admin.posts.index')->with('status', 'Article updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('status', 'Article deleted.');
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:400'],
        ]);

        PostCategory::create($data);

        return back()->with('status', 'Blog category created.');
    }

    public function destroyCategory(PostCategory $category)
    {
        $category->delete();

        return back()->with('status', 'Blog category deleted.');
    }

    protected function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'post_category_id' => ['nullable', 'exists:post_categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $data['user_id'] = auth()->id();
        if ($data['status'] === 'published' && ! $post?->published_at) {
            $data['published_at'] = now();
        }

        return $data;
    }

    protected function syncTags(Post $post, ?string $raw): void
    {
        if (! $raw) {
            return;
        }

        $ids = collect(explode(',', $raw))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->map(fn ($name) => Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name])->id);

        $post->tags()->sync($ids->all());
    }
}
