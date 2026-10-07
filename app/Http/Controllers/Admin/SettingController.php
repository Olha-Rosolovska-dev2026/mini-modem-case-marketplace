<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Admin settings controller
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public const FIELDS = [
        'site_name' => 'Store name',
        'site_tagline' => 'Tagline',
        'contact_email' => 'Contact email',
        'contact_phone' => 'Contact phone',
        'contact_address' => 'Business address',
        'currency_symbol' => 'Currency symbol',
        'shipping_flat_rate' => 'Flat shipping rate',
        'free_shipping_threshold' => 'Free shipping threshold',
        'tax_rate' => 'Tax rate (%)',
        'items_per_page' => 'Products per page',
        'company_registration' => 'Company registration number',
        'vat_number' => 'VAT number',
    ];

    public function index()
    {
        $values = [];
        foreach (self::FIELDS as $key => $label) {
            $values[$key] = Setting::get($key);
        }

        return view('admin.settings.index', ['values' => $values, 'fields' => self::FIELDS]);
    }

    public function update(Request $request)
    {
        foreach (array_keys(self::FIELDS) as $key) {
            Setting::set($key, $request->input($key, ''), 'general', 'text');
        }

        return back()->with('status', 'Store settings saved.');
    }
}
