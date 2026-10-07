<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Order model
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'status', 'payment_method', 'payment_status',
        'subtotal', 'discount', 'shipping', 'tax', 'total', 'currency', 'coupon_code',
        'shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address',
        'shipping_city', 'shipping_postcode', 'shipping_country', 'notes', 'placed_at',
    ];

    protected $casts = [
        'placed_at' => 'datetime',
        'subtotal' => 'float',
        'discount' => 'float',
        'shipping' => 'float',
        'tax' => 'float',
        'total' => 'float',
    ];

    public const STATUSES = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateNumber(): string
    {
        return 'MMC-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid((string) mt_rand(), true)), 0, 5));
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'amber',
            'processing' => 'blue',
            'shipped' => 'indigo',
            'delivered' => 'emerald',
            'cancelled', 'refunded' => 'red',
            default => 'slate',
        };
    }

    public function getUrlAttribute(): string
    {
        return url('/account/orders/' . $this->order_number);
    }
}
