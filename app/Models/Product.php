<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Product model - mini modem case specifications
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'vendor_id', 'category_id', 'name', 'slug', 'sku', 'short_description', 'description',
        'price', 'compare_price', 'stock', 'case_type', 'material', 'color', 'dimensions',
        'inner_dimensions', 'weight_grams', 'ip_rating', 'antenna_hole', 'ventilation_slots',
        'wall_mount', 'led_indicator_window', 'mounting_type', 'warranty_months', 'status',
        'is_featured', 'rating', 'views', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'price' => 'float',
        'compare_price' => 'float',
        'weight_grams' => 'float',
        'rating' => 'float',
        'antenna_hole' => 'boolean',
        'ventilation_slots' => 'boolean',
        'wall_mount' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'MMC-' . strtoupper(Str::random(6));
            }
        });
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved')->latest();
    }

    public function modemModels(): BelongsToMany
    {
        return $this->belongsToMany(ModemModel::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getUrlAttribute(): string
    {
        return url('/product/' . $this->slug);
    }

    public function getPrimaryImageAttribute(): ?string
    {
        $primary = $this->images->firstWhere('is_primary', true) ?? $this->images->first();

        return $primary ? asset('storage/' . $primary->path) : null;
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return (int) round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }

        return null;
    }

    public function getStockLabelAttribute(): string
    {
        return match (true) {
            $this->stock <= 0 => 'Out of stock',
            $this->stock <= 5 => 'Low stock',
            default => 'In stock',
        };
    }
}
