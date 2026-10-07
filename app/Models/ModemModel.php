<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: ModemModel model - modem/router models a case is compatible with
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class ModemModel extends Model
{
    protected $fillable = ['brand', 'name', 'slug', 'form_factor', 'device_dimensions', 'notes'];

    protected static function booted(): void
    {
        static::saving(function (ModemModel $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->brand . ' ' . $model->name);
            }
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->brand . ' ' . $this->name);
    }
}
