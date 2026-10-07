<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Categories, modem models, vendors, products, coupons and menu
 */

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Menu;
use App\Models\ModemModel;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        /* ---------------------------------------------------------------
         | Enclosure categories
         | --------------------------------------------------------------- */
        $categories = [
            ['name' => 'DIN Rail Cases', 'description' => 'Snap-on housings for 35 mm DIN rail mounting inside control cabinets.'],
            ['name' => 'Wall Mount Cases', 'description' => 'Enclosures with moulded mounting lugs for walls, poles and cabinets.'],
            ['name' => 'Weatherproof Cases', 'description' => 'Sealed IP65 and IP67 housings for outdoor mini modem deployments.'],
            ['name' => 'Desktop Cases', 'description' => 'Ventilated bench housings with LED windows and non-slip feet.'],
            ['name' => 'Rack Mount Cases', 'description' => '1U and 2U trays that hold up to eight mini modems side by side.'],
            ['name' => 'Open Frame Kits', 'description' => 'Mounting plates and brackets for OEM integration projects.'],
        ];

        $categoryModels = [];
        foreach ($categories as $index => $category) {
            $categoryModels[$category['name']] = Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category['name'])],
                $category + ['sort_order' => $index, 'is_active' => true]
            );
        }

        /* ---------------------------------------------------------------
         | Compatible modem and router models
         | --------------------------------------------------------------- */
        $modems = [
            ['brand' => 'Huawei', 'name' => 'E8372h-153', 'form_factor' => 'USB dongle', 'device_dimensions' => '94 x 30 x 14 mm'],
            ['brand' => 'Huawei', 'name' => 'B535-232', 'form_factor' => 'Desktop router', 'device_dimensions' => '198 x 120 x 60 mm'],
            ['brand' => 'Teltonika', 'name' => 'RUT240', 'form_factor' => 'Industrial LTE router', 'device_dimensions' => '83 x 74 x 25 mm'],
            ['brand' => 'Teltonika', 'name' => 'RUT956', 'form_factor' => 'Dual-SIM router', 'device_dimensions' => '110 x 100 x 27 mm'],
            ['brand' => 'ZTE', 'name' => 'MF920', 'form_factor' => 'Portable hotspot', 'device_dimensions' => '106 x 66 x 16 mm'],
            ['brand' => 'Netgear', 'name' => 'LB2120', 'form_factor' => 'LTE bridge', 'device_dimensions' => '150 x 100 x 30 mm'],
            ['brand' => 'Cradlepoint', 'name' => 'IBR600C', 'form_factor' => 'Branch router', 'device_dimensions' => '152 x 127 x 32 mm'],
            ['brand' => 'Peplink', 'name' => 'MAX BR1 Mini', 'form_factor' => 'Compact LTE router', 'device_dimensions' => '112 x 76 x 28 mm'],
            ['brand' => 'MikroTik', 'name' => 'LtAP mini', 'form_factor' => 'Outdoor LTE router', 'device_dimensions' => '115 x 78 x 32 mm'],
            ['brand' => 'Sierra Wireless', 'name' => 'RV50X', 'form_factor' => 'Industrial gateway', 'device_dimensions' => '150 x 110 x 45 mm'],
        ];

        $modemModels = collect($modems)->map(function ($modem) {
            return ModemModel::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($modem['brand'] . ' ' . $modem['name'])],
                $modem + ['notes' => 'Verified against the manufacturer datasheet.']
            );
        });

        /* ---------------------------------------------------------------
         | Marketplace vendors
         | --------------------------------------------------------------- */
        $vendors = [
            ['name' => 'Cascade Enclosure Works', 'city' => 'Portland', 'country' => 'United States', 'email' => 'seller@minimodemcase.test', 'description' => 'Injection-moulded ABS and polycarbonate enclosures for compact LTE modems. Family-run tool shop since 2009.', 'commission_rate' => 12, 'rating' => 4.8, 'is_featured' => true, 'status' => 'approved'],
            ['name' => 'Northline Fabrication', 'city' => 'Minneapolis', 'country' => 'United States', 'email' => 'northline@minimodemcase.test', 'description' => 'Sheet-metal and aluminium housings laser-cut to order for industrial gateways and DIN rail routers.', 'commission_rate' => 10, 'rating' => 4.6, 'is_featured' => true, 'status' => 'approved'],
            ['name' => 'Harbour Signal Cases', 'city' => 'Halifax', 'country' => 'Canada', 'email' => 'harbour@minimodemcase.test', 'description' => 'IP-rated weatherproof enclosures with gasket sealing and pre-drilled antenna ports for outdoor deployments.', 'commission_rate' => 11, 'rating' => 4.7, 'is_featured' => true, 'status' => 'approved'],
            ['name' => 'Field Deployment Supply', 'city' => 'Bristol', 'country' => 'United Kingdom', 'email' => 'field@minimodemcase.test', 'description' => 'Rack trays, pole brackets and field-ready kits for temporary connectivity and event networks.', 'commission_rate' => 9, 'rating' => 4.4, 'is_featured' => false, 'status' => 'approved'],
            ['name' => 'Ridgeway Plastics', 'city' => 'Leeds', 'country' => 'United Kingdom', 'email' => 'ridgeway@minimodemcase.test', 'description' => 'New seller application - compact desktop housings with smoked LED windows.', 'commission_rate' => 10, 'rating' => 0, 'is_featured' => false, 'status' => 'pending'],
        ];

        $vendorModels = [];
        foreach ($vendors as $vendor) {
            $user = User::where('email', $vendor['email'])->first();
            $vendorModels[$vendor['name']] = Vendor::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($vendor['name'])],
                $vendor + ['user_id' => $user?->id, 'phone' => '+1 (555) 010-220' . count($vendorModels)]
            );
        }

        /* ---------------------------------------------------------------
         | Products - mini modem cases
         | --------------------------------------------------------------- */
        $products = [
            [
                'name' => 'DIN Rail Mini Modem Case 35 mm — ABS Slate Grey',
                'vendor' => 'Cascade Enclosure Works', 'category' => 'DIN Rail Cases',
                'price' => 18.90, 'compare_price' => 24.00, 'stock' => 140,
                'case_type' => 'din_rail', 'material' => 'ABS UL94-V0', 'color' => 'Slate grey',
                'dimensions' => '120 x 65 x 28 mm', 'inner_dimensions' => '110 x 55 x 22 mm', 'weight_grams' => 96.5,
                'ip_rating' => 'IP20', 'mounting_type' => '35 mm DIN rail clip', 'led_indicator_window' => 'Smoked acrylic 3 mm',
                'antenna_hole' => true, 'ventilation_slots' => true, 'wall_mount' => false, 'is_featured' => true, 'warranty_months' => 24,
                'short_description' => 'Snap-on DIN rail enclosure sized for Teltonika RUT240 and similar compact LTE routers.',
                'description' => "A tooled ABS enclosure that clips directly onto standard 35 mm DIN rail. The interior cavity accepts mini modems up to 110 x 55 x 22 mm, and the side wall carries a pre-scored 8 mm antenna gland position.\n\nVentilation slots on both flanks keep the radio module within operating temperature, while the smoked acrylic window lets you read the signal LEDs without opening the lid. Supplied with two M3 stainless screws and a self-adhesive DIN clip.",
                'modems' => ['Teltonika RUT240', 'Teltonika RUT956', 'Peplink MAX BR1 Mini'],
            ],
            [
                'name' => 'Wall Mount Router Enclosure with Antenna Ports',
                'vendor' => 'Cascade Enclosure Works', 'category' => 'Wall Mount Cases',
                'price' => 27.50, 'compare_price' => 33.00, 'stock' => 86,
                'case_type' => 'wall_mount', 'material' => 'Polycarbonate', 'color' => 'Graphite',
                'dimensions' => '160 x 100 x 35 mm', 'inner_dimensions' => '148 x 90 x 30 mm', 'weight_grams' => 178.0,
                'ip_rating' => 'IP54', 'mounting_type' => 'Four-point wall lugs', 'led_indicator_window' => 'Clear polycarbonate strip',
                'antenna_hole' => true, 'ventilation_slots' => true, 'wall_mount' => true, 'is_featured' => true, 'warranty_months' => 24,
                'short_description' => 'Impact-resistant polycarbonate housing with twin SMA bulkhead cut-outs for Huawei B535 class routers.',
                'description' => "Designed for wall and cabinet-side mounting where the router needs airflow but not direct weather exposure. Two 6.5 mm bulkhead positions accept standard SMA or RP-SMA pigtails.\n\nA clear polycarbonate strip across the front keeps the LED status readable from across a room. The base plate is removable for bench wiring before final installation.",
                'modems' => ['Huawei B535-232', 'Netgear LB2120', 'Cradlepoint IBR600C'],
            ],
            [
                'name' => 'IP67 Weatherproof Mini Modem Housing — Sealed Gasket',
                'vendor' => 'Harbour Signal Cases', 'category' => 'Weatherproof Cases',
                'price' => 42.00, 'compare_price' => 49.50, 'stock' => 54,
                'case_type' => 'weatherproof', 'material' => 'Glass-filled nylon', 'color' => 'Light grey',
                'dimensions' => '145 x 95 x 45 mm', 'inner_dimensions' => '130 x 82 x 38 mm', 'weight_grams' => 265.0,
                'ip_rating' => 'IP67', 'mounting_type' => 'Wall or pole bracket', 'led_indicator_window' => 'Not included',
                'antenna_hole' => true, 'ventilation_slots' => false, 'wall_mount' => true, 'is_featured' => true, 'warranty_months' => 36,
                'short_description' => 'Fully sealed outdoor housing with silicone gasket, membrane vent and dual N-type antenna ports.',
                'description' => "Built for outdoor LTE gateways on masts, lamp posts and remote cabinets. The lid compresses a replaceable silicone gasket onto a machined lip, and a Gore-style membrane vent equalises pressure without admitting water.\n\nTwo N-type bulkhead fittings are pre-drilled at the bottom face so cable and antenna runs stay downward and drip-free. Stainless fasteners are supplied.",
                'modems' => ['MikroTik LtAP mini', 'Sierra Wireless RV50X', 'Teltonika RUT956'],
            ],
            [
                'name' => 'Desktop Modem Case with Smoked LED Window',
                'vendor' => 'Cascade Enclosure Works', 'category' => 'Desktop Cases',
                'price' => 15.40, 'compare_price' => null, 'stock' => 210,
                'case_type' => 'desktop', 'material' => 'ABS', 'color' => 'Matte black',
                'dimensions' => '130 x 80 x 30 mm', 'inner_dimensions' => '120 x 70 x 24 mm', 'weight_grams' => 112.0,
                'ip_rating' => 'IP20', 'mounting_type' => 'Rubber feet', 'led_indicator_window' => 'Smoked 2 mm acrylic',
                'antenna_hole' => false, 'ventilation_slots' => true, 'wall_mount' => false, 'is_featured' => false, 'warranty_months' => 12,
                'short_description' => 'Bench-friendly housing with a wide smoked window so LED status stays visible.',
                'description' => "A simple, tidy housing for desk-side USB modems and portable hotspots. The bottom is moulded with recessed rubber feet to stop the enclosure sliding across a shelf, and the rear face has a single cable notch.\n\nFour self-tapping screws hold the lid; the smoked window can be polished or replaced if you need a clear line of sight for infrared remotes.",
                'modems' => ['Huawei E8372h-153', 'ZTE MF920'],
            ],
            [
                'name' => '1U Rack Tray for Eight Mini Modems',
                'vendor' => 'Field Deployment Supply', 'category' => 'Rack Mount Cases',
                'price' => 118.00, 'compare_price' => 139.00, 'stock' => 18,
                'case_type' => 'rack_mount', 'material' => 'Powder-coated steel', 'color' => 'Black RAL 9005',
                'dimensions' => '483 x 250 x 44 mm', 'inner_dimensions' => 'Eight bays 120 x 55 x 24 mm', 'weight_grams' => 2450.0,
                'ip_rating' => null, 'mounting_type' => '19-inch rack ears', 'led_indicator_window' => 'Per-bay cut-out',
                'antenna_hole' => true, 'ventilation_slots' => true, 'wall_mount' => false, 'is_featured' => true, 'warranty_months' => 36,
                'short_description' => 'Rack-mounted tray that keeps eight mini modems powered and organised in one unit of space.',
                'description' => "For deployments where a dozen modems end up loose in a cabinet. Eight individual bays each accept a mini modem up to 120 x 55 x 24 mm, with a cut-out at the rear for USB power and a passthrough for antenna tails.\n\nCold-rolled steel with a powder-coated finish, supplied with cage nuts and a rear cable-management bar. Front panel cut-outs expose each device LED.",
                'modems' => ['Huawei E8372h-153', 'Teltonika RUT240', 'ZTE MF920', 'Peplink MAX BR1 Mini'],
            ],
            [
                'name' => 'Open Frame Mounting Plate Kit — OEM Integration',
                'vendor' => 'Northline Fabrication', 'category' => 'Open Frame Kits',
                'price' => 34.00, 'compare_price' => null, 'stock' => 62,
                'case_type' => 'open_frame', 'material' => 'Anodised aluminium 2 mm', 'color' => 'Natural anodised',
                'dimensions' => '180 x 120 x 3 mm plate', 'inner_dimensions' => 'Six M4 standoff positions', 'weight_grams' => 320.0,
                'ip_rating' => null, 'mounting_type' => 'M4 standoffs', 'led_indicator_window' => null,
                'antenna_hole' => true, 'ventilation_slots' => true, 'wall_mount' => true, 'is_featured' => false, 'warranty_months' => 12,
                'short_description' => 'Aluminium base plate with a standoff pattern for integrating routers into your own enclosure.',
                'description' => "For product teams who already have a final housing and just need a stable internal mount. The 2 mm anodised plate carries a grid of M4 threaded standoffs and a slotted antenna pass-through.\n\nLaser-cut to order, so custom hole patterns are available from 25 units. Supplied with countersunk screws and nylon washers to isolate the PCB from the chassis.",
                'modems' => ['Cradlepoint IBR600C', 'Sierra Wireless RV50X', 'Netgear LB2120'],
            ],
            [
                'name' => 'Pole Mount Case with UV-Stable Shell',
                'vendor' => 'Harbour Signal Cases', 'category' => 'Weatherproof Cases',
                'price' => 58.00, 'compare_price' => 64.00, 'stock' => 31,
                'case_type' => 'wall_mount', 'material' => 'UV-stabilised ASA', 'color' => 'Off white',
                'dimensions' => '170 x 110 x 40 mm', 'inner_dimensions' => '158 x 98 x 33 mm', 'weight_grams' => 340.0,
                'ip_rating' => 'IP65', 'mounting_type' => 'Stainless pole strap 30–60 mm', 'led_indicator_window' => 'Tinted insert',
                'antenna_hole' => true, 'ventilation_slots' => false, 'wall_mount' => true, 'is_featured' => false, 'warranty_months' => 24,
                'short_description' => 'ASA shell that resists UV yellowing on masts and poles, with a stainless strap clamp.',
                'description' => "ASA keeps its colour after years of sun exposure, unlike cheaper ABS. The enclosure mounts to poles from 30 mm to 60 mm with a supplied stainless band, and the base can be reversed for flat wall fixing.\n\nA tinted front insert hides the device while still showing power and signal LEDs. Foam gasket and cable glands included.",
                'modems' => ['MikroTik LtAP mini', 'Teltonika RUT956'],
            ],
            [
                'name' => 'DIN Rail Case with Pre-Cut Antenna Gland — 2 Pack',
                'vendor' => 'Northline Fabrication', 'category' => 'DIN Rail Cases',
                'price' => 39.90, 'compare_price' => 45.00, 'stock' => 74,
                'case_type' => 'din_rail', 'material' => 'Aluminium 1.5 mm', 'color' => 'Anthracite',
                'dimensions' => '135 x 72 x 32 mm', 'inner_dimensions' => '125 x 62 x 26 mm', 'weight_grams' => 210.0,
                'ip_rating' => 'IP40', 'mounting_type' => '35 mm DIN rail', 'led_indicator_window' => 'Polycarbonate lens',
                'antenna_hole' => true, 'ventilation_slots' => true, 'wall_mount' => false, 'is_featured' => false, 'warranty_months' => 24,
                'short_description' => 'Two-pack of folded aluminium DIN rail housings with a factory-cut gland hole.',
                'description' => "Folded and riveted aluminium gives better RF screening than plastic, which helps when the modem sits next to inverters and drive controllers. The antenna gland hole is cut at the factory to 8 mm, and a polycarbonate lens covers the LED cluster.\n\nSold as a two-pack for dual-modem failover installations.",
                'modems' => ['Teltonika RUT240', 'Peplink MAX BR1 Mini'],
            ],
            [
                'name' => 'Compact USB Modem Cradle Case — Clear Lid',
                'vendor' => 'Cascade Enclosure Works', 'category' => 'Desktop Cases',
                'price' => 12.60, 'compare_price' => 16.00, 'stock' => 165,
                'case_type' => 'enclosure', 'material' => 'Polypropylene', 'color' => 'Transparent smoke',
                'dimensions' => '100 x 45 x 22 mm', 'inner_dimensions' => '92 x 38 x 18 mm', 'weight_grams' => 58.0,
                'ip_rating' => null, 'mounting_type' => 'Clip-on belt loop', 'led_indicator_window' => 'Full clear lid',
                'antenna_hole' => false, 'ventilation_slots' => true, 'wall_mount' => false, 'is_featured' => false, 'warranty_months' => 12,
                'short_description' => 'Pocket-sized cradle that protects USB dongle modems and shows the status LEDs through a clear lid.',
                'description' => "A low-cost protective shell for USB stick modems that travel between sites. The clear lid exposes the whole device, and the internal ribs hold USB dongles up to 92 mm long.\n\nA moulded loop lets you clip the case to a belt or bag strap. Ventilation slots on both ends prevent heat build-up during long transfers.",
                'modems' => ['Huawei E8372h-153', 'ZTE MF920'],
            ],
            [
                'name' => '2U Twin-Bay Modem Enclosure for Branch Cabinets',
                'vendor' => 'Field Deployment Supply', 'category' => 'Rack Mount Cases',
                'price' => 164.00, 'compare_price' => null, 'stock' => 12,
                'case_type' => 'rack_mount', 'material' => 'Steel with ABS fascia', 'color' => 'Black',
                'dimensions' => '483 x 300 x 88 mm', 'inner_dimensions' => 'Two bays 200 x 140 x 60 mm', 'weight_grams' => 3200.0,
                'ip_rating' => null, 'mounting_type' => '19-inch rack ears', 'led_indicator_window' => 'Two tinted panels',
                'antenna_hole' => true, 'ventilation_slots' => true, 'wall_mount' => false, 'is_featured' => false, 'warranty_months' => 36,
                'short_description' => 'Two large bays for branch routers with room for a power injector alongside each modem.',
                'description' => "The larger sibling of our 1U tray, for sites running two full-size branch routers with their power injectors and serial adapters inside the same enclosure.\n\nEach bay has a tinted front panel, a rear cable entry grommet and a removable inner shelf. Includes a 1U fan kit and a locking front door.",
                'modems' => ['Cradlepoint IBR600C', 'Huawei B535-232', 'Sierra Wireless RV50X'],
            ],
        ];

        foreach ($products as $index => $data) {
            $modemsForProduct = $data['modems'];
            $vendor = $vendorModels[$data['vendor']];
            $category = $categoryModels[$data['category']];
            unset($data['vendor'], $data['category'], $data['modems']);

            $product = Product::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['name'])],
                $data + [
                    'vendor_id' => $vendor->id,
                    'category_id' => $category->id,
                    'sku' => 'MMC-' . strtoupper(substr(md5($data['name']), 0, 6)),
                    'status' => 'active',
                    'rating' => 0,
                    'views' => 40 + ($index * 17),
                    'meta_title' => $data['name'],
                    'meta_description' => $data['short_description'],
                ]
            );

            $product->images()->delete();
            foreach (['front', 'side', 'installed'] as $sort => $view) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => 'products/' . $product->slug . '-' . $view . '.jpg',
                    'alt' => $product->name . ' — ' . $view . ' view',
                    'sort_order' => $sort,
                    'is_primary' => $sort === 0,
                ]);
            }

            $ids = $modemModels->filter(fn ($model) => in_array($model->full_name, $modemsForProduct))->pluck('id');
            $product->modemModels()->sync($ids->all());
        }

        /* ---------------------------------------------------------------
         | Reviews
         | --------------------------------------------------------------- */
        $customer = User::where('email', 'customer@minimodemcase.test')->first();
        $secondCustomer = User::where('email', 'priya@minimodemcase.test')->first();
        $firstProduct = Product::orderBy('id')->first();
        $secondProduct = Product::orderBy('id')->skip(2)->first();

        $reviews = [
            ['product' => $firstProduct, 'user' => $customer, 'rating' => 5, 'title' => 'Perfect fit for a RUT240', 'comment' => 'The DIN clip snapped onto the rail first try and the modem slid in with about 2 mm to spare. Ventilation is clearly doing its job — the case is barely warm after a full day.', 'status' => 'approved', 'verified' => true],
            ['product' => $firstProduct, 'user' => $secondCustomer, 'rating' => 4, 'title' => 'Good, gland hole a touch tight', 'comment' => 'Solid moulding and clean edges. The antenna gland position is slightly tight for a chunky RP-SMA pigtail but it worked with a thin cable.', 'status' => 'approved', 'verified' => true],
            ['product' => $secondProduct, 'user' => $customer, 'rating' => 5, 'title' => 'Survived a winter on the mast', 'comment' => 'Gasket is still soft after four months outdoors. No condensation inside the sealed section, and the membrane vent is doing its job.', 'status' => 'approved', 'verified' => true],
            ['product' => $secondProduct, 'user' => $secondCustomer, 'rating' => 4, 'title' => 'Wanted a clear window', 'comment' => 'Excellent weather sealing. I would like an option with a clear front instead of the tinted insert so I can read the LEDs without opening it.', 'status' => 'pending', 'verified' => false],
        ];

        foreach ($reviews as $review) {
            if (! $review['product'] || ! $review['user']) {
                continue;
            }

            Review::updateOrCreate(
                ['product_id' => $review['product']->id, 'user_id' => $review['user']->id],
                [
                    'rating' => $review['rating'],
                    'title' => $review['title'],
                    'comment' => $review['comment'],
                    'status' => $review['status'],
                    'is_verified_purchase' => $review['verified'],
                ]
            );
        }

        foreach (Product::with('reviews')->get() as $product) {
            $average = $product->reviews->where('status', 'approved')->avg('rating') ?? 0;
            $product->update(['rating' => round((float) $average, 2)]);
        }

        /* ---------------------------------------------------------------
         | Coupons
         | --------------------------------------------------------------- */
        Coupon::updateOrCreate(['code' => 'CASE10'], ['type' => 'percent', 'value' => 10, 'min_order' => 50, 'max_uses' => 500, 'is_active' => true, 'expires_at' => now()->addYear()]);
        Coupon::updateOrCreate(['code' => 'FREESHIP'], ['type' => 'fixed', 'value' => 7.90, 'min_order' => 40, 'max_uses' => 250, 'is_active' => true, 'expires_at' => now()->addMonths(6)]);
        Coupon::updateOrCreate(['code' => 'BULK25'], ['type' => 'percent', 'value' => 25, 'min_order' => 250, 'max_uses' => null, 'is_active' => true, 'expires_at' => now()->addMonths(3)]);

        /* ---------------------------------------------------------------
         | Header navigation menu
         | --------------------------------------------------------------- */
        $menu = Menu::updateOrCreate(['slug' => 'main-navigation'], ['name' => 'Main navigation', 'location' => 'header']);

        if ($menu->items()->count() === 0) {
            $shop = $menu->items()->create(['label' => 'Shop cases', 'url' => '/shop', 'sort_order' => 1, 'target' => '_self']);
            $menu->items()->create(['label' => 'DIN rail cases', 'url' => '/category/din-rail-cases', 'parent_id' => $shop->id, 'sort_order' => 1, 'target' => '_self']);
            $menu->items()->create(['label' => 'Weatherproof cases', 'url' => '/category/weatherproof-cases', 'parent_id' => $shop->id, 'sort_order' => 2, 'target' => '_self']);
            $menu->items()->create(['label' => 'Rack trays', 'url' => '/category/rack-mount-cases', 'parent_id' => $shop->id, 'sort_order' => 3, 'target' => '_self']);
            $menu->items()->create(['label' => 'Guides', 'url' => '/blog', 'sort_order' => 2, 'target' => '_self']);
            $menu->items()->create(['label' => 'Sellers', 'url' => '/page/seller-guide', 'sort_order' => 3, 'target' => '_self']);
            $menu->items()->create(['label' => 'Contact', 'url' => '/contact', 'sort_order' => 4, 'target' => '_self']);
        }
    }
}
