<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Cart model
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'coupon_code'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getSubtotalAttribute(): float
    {
        return round($this->items->sum(fn (CartItem $item) => $item->unit_price * $item->quantity), 2);
    }

    public function getItemCountAttribute(): int
    {
        return (int) $this->items->sum('quantity');
    }

    public function getDiscountAttribute(): float
    {
        if (! $this->coupon_code) {
            return 0.0;
        }
        $coupon = Coupon::where('code', $this->coupon_code)->first();

        return ($coupon && $coupon->isValidFor($this->subtotal)) ? $coupon->discountFor($this->subtotal) : 0.0;
    }

    public function getShippingAttribute(): float
    {
        $freeOver = (float) Setting::get('free_shipping_threshold', 75);
        if ($this->subtotal - $this->discount >= $freeOver) {
            return 0.0;
        }

        return (float) Setting::get('shipping_flat_rate', 7.90);
    }

    public function getTaxAttribute(): float
    {
        $rate = (float) Setting::get('tax_rate', 8.5);

        return round((($this->subtotal - $this->discount) * $rate) / 100, 2);
    }

    public function getTotalAttribute(): float
    {
        return round($this->subtotal - $this->discount + $this->shipping + $this->tax, 2);
    }

    public static function forUser(?int $userId, ?string $sessionId): self
    {
        $query = static::query();
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->whereNull('user_id')->where('session_id', $sessionId);
        }

        return $query->firstOrCreate([
            'user_id' => $userId,
            'session_id' => $userId ? null : $sessionId,
        ]);
    }
}
