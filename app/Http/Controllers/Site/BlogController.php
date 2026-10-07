<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Blog and CMS page controller
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;

class BlogController extends Controller
{
    public function index()
    {
        return view('site.blog.index', [
            'posts' => Post::published()->with(['category', 'author'])->latest('published_at')->paginate(9),
            'categories' => PostCategory::withCount('posts')->get(),
            'tags' => Tag::withCount('posts')->take(12)->get(),
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::published()->with(['category', 'author', 'tags'])->where('slug', $slug)->firstOrFail();
        $post->increment('views');

        return view('site.blog.show', [
            'post' => $post,
            'related' => Post::published()->with('category')
                ->where('id', '!=', $post->id)
                ->when($post->post_category_id, fn ($q) => $q->where('post_category_id', $post->post_category_id))
                ->take(3)->get(),
        ]);
    }

    public function category(string $slug)
    {
        $category = PostCategory::where('slug', $slug)->firstOrFail();

        return view('site.blog.index', [
            'posts' => Post::published()->with(['category', 'author'])
                ->where('post_category_id', $category->id)
                ->latest('published_at')->paginate(9),
            'categories' => PostCategory::withCount('posts')->get(),
            'tags' => Tag::withCount('posts')->take(12)->get(),
            'activeCategory' => $category,
        ]);
    }

    public function tag(string $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        return view('site.blog.index', [
            'posts' => $tag->posts()->published()->with(['category', 'author'])->latest('published_at')->paginate(9),
            'categories' => PostCategory::withCount('posts')->get(),
            'tags' => Tag::withCount('posts')->take(12)->get(),
            'activeTag' => $tag,
        ]);
    }

    public function page(string $slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('site.page', ['page' => $page]);
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function contactSend(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        \App\Models\Setting::set('last_contact_message', json_encode($data + ['at' => now()->toDateTimeString()]), 'contact', 'json');

        return back()->with('status', 'Thank you, ' . $data['name'] . '. Our enclosure specialists will reply within one business day.');
    }
}
