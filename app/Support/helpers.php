<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Global helper functions
 */

if (! function_exists('money')) {
    /**
     * Format a price using the currency symbol stored in settings.
     */
    function money(float|int|string|null $amount, ?string $symbol = null): string
    {
        $symbol = $symbol ?: \App\Models\Setting::get('currency_symbol', '$');

        return $symbol . number_format((float) $amount, 2);
    }
}

if (! function_exists('setting')) {
    /**
     * Read a value from the settings table.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (! function_exists('case_type_label')) {
    /**
     * Human readable label for a mini modem case type.
     */
    function case_type_label(?string $type): string
    {
        return match ($type) {
            'enclosure' => 'Standard Enclosure',
            'din_rail' => 'DIN Rail Case',
            'wall_mount' => 'Wall Mount Case',
            'rack_mount' => 'Rack Mount Case',
            'weatherproof' => 'Weatherproof Case',
            'desktop' => 'Desktop Case',
            'open_frame' => 'Open Frame Case',
            default => ucwords(str_replace('_', ' ', (string) $type)),
        };
    }
}
