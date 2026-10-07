<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Vendor model
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Vendor extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'email', 'phone', 'logo', 'banner', 'description',
        'address', 'city', 'country', 'status', 'commission_rate', 'rating', 'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'rating' => 'float',
        'commission_rate' => 'float',
    ];

    protected static function booted(): void
    {
        static::saving(function (Vendor $vendor) {
            if (empty($vendor->slug)) {
                $vendor->slug = Str::slug($vendor->name);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function getUrlAttribute(): string
    {
        return url('/vendor/' . $this->slug);
    }
}
