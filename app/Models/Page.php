<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Page model
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'template', 'status', 'featured_image',
        'meta_title', 'meta_description', 'sort_order', 'show_in_menu', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'show_in_menu' => 'boolean',
    ];

    public static function booted(): void
    {
        static::saving(function (Page $page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
            if ($page->status === 'published' && empty($page->published_at)) {
                $page->published_at = now();
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function getUrlAttribute(): string
    {
        return url('/page/' . $this->slug);
    }
}
