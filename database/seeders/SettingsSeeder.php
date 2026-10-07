<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Default store settings
 */

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Mini Modem Case',
            'site_tagline' => 'Industrial-grade enclosures for mini modems, routers and edge gateways',
            'contact_email' => 'hello@minimodemcase.test',
            'contact_phone' => '+1 (555) 014-7788',
            'contact_address' => '220 Circuit Avenue, Austin, TX 78701, United States',
            'currency_symbol' => '$',
            'shipping_flat_rate' => '7.90',
            'free_shipping_threshold' => '75',
            'tax_rate' => '8.5',
            'items_per_page' => '12',
            'company_registration' => 'US-TX-8841207',
            'vat_number' => 'US884120733',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value, 'general', 'text');
        }
    }
}
