<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Demo CMS pages, blog posts, categories and tags
 */

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['title' => 'About Mini Modem Case', 'excerpt' => 'Why we built a marketplace dedicated to modem enclosures.', 'sort_order' => 1, 'show_in_menu' => true, 'body' => "Mini Modem Case started because engineers kept asking the same question: which enclosure actually fits this modem?\n\nOur marketplace answers it with structured data instead of guesswork. Every listing carries outer dimensions, inner cavity, material, mounting type, IP rating and the modem models it has been checked against. Sellers upload the specification once, and buyers filter on the values that matter: antenna routing, DIN rail compatibility, sealed rating.\n\nThe catalogue is curated. Vendor applications are reviewed by our team before a seller can publish, and every product passes a specification check to ensure the dimensions are stated in a consistent format."],
            ['title' => 'Warranty & Returns Policy', 'excerpt' => 'Thirty-day returns and the manufacturer warranty on every enclosure.', 'sort_order' => 2, 'body' => "Every enclosure sold through the marketplace carries a minimum twelve-month warranty against manufacturing defects. Many listings extend this to twenty-four or thirty-six months; the warranty term is shown on each product page under the technical specification table.\n\nIf a case arrives damaged, does not match its stated dimensions, or fails in normal service, contact the seller through your account page within thirty days of delivery for a replacement or refund.\n\nCustom-cut and made-to-order items are covered for manufacturing defects but cannot be returned for a change of mind, since they are produced specifically for your modem model."],
            ['title' => 'Shipping & Delivery Information', 'excerpt' => 'Dispatch times, carrier options and free shipping thresholds.', 'sort_order' => 3, 'body' => "Orders placed before 14:00 local time on a business day are dispatched the same day when the item is held in stock. Made-to-order enclosures and custom cutouts typically ship within five to eight business days.\n\nStandard tracked delivery is charged at a flat rate, and orders above the free shipping threshold shown in the site header ship at no cost within the continental United States.\n\nInternational orders are shipped with duty unpaid; any import charges are the responsibility of the recipient. Tracking details are emailed when the carrier scans the parcel."],
            ['title' => 'Seller Guide — Open a Storefront', 'excerpt' => 'How to apply as a vendor and publish your first enclosure listing.', 'sort_order' => 4, 'show_in_menu' => true, 'body' => "Selling on Mini Modem Case is open to manufacturers, fabricators and distributors of modem and router enclosures.\n\n1. Create an account and request the seller role from your profile page.\n2. Complete your seller profile with a description, address and contact details.\n3. Submit for review — our team approves vendor applications within two business days.\n4. Publish listings with full specifications: dimensions, inner cavity, material, IP rating, mounting type and compatible modem models.\n\nCommission is charged on completed orders only and is shown in your seller dashboard. Payouts are released after the buyer's return window closes.\n\nListings that omit key dimensions or misstate IP ratings are returned for correction, because accurate compatibility data is what buyers rely on."],
            ['title' => 'Privacy Policy', 'excerpt' => 'What we collect, why we collect it, and how it is protected.', 'sort_order' => 5, 'body' => "We collect the information needed to process your order: name, email, delivery address, phone number and order history. Payment card details are handled by our payment processor and are never stored on our servers.\n\nWe use cookies to keep your cart and login session working. Analytical cookies are only set where you have accepted them.\n\nYou can request a copy of your personal data, or ask us to delete it, by writing to the contact address published on this site. We respond within thirty days."],
            ['title' => 'Terms of Sale', 'excerpt' => 'The commercial terms that apply to every marketplace order.', 'sort_order' => 6, 'body' => "By placing an order you enter into a contract with the individual seller who listed the item, with Mini Modem Case acting as the marketplace operator.\n\nPrices are shown in the store currency and exclude customs duties on international shipments. Orders may be cancelled before dispatch at no cost. Once dispatched, our returns policy applies.\n\nSellers are responsible for the accuracy of their listings. Where a listing materially misstates dimensions or ratings, the buyer is entitled to a full refund including return shipping."],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => Str::slug($page['title'])],
                $page + ['status' => 'published', 'template' => 'default', 'published_at' => now()->subDays(random_int(3, 60)), 'meta_title' => $page['title'], 'meta_description' => $page['excerpt']]
            );
        }

        $categories = [
            ['name' => 'Installation Guides', 'description' => 'Step-by-step mounting and wiring walkthroughs.'],
            ['name' => 'Material Comparisons', 'description' => 'ABS versus polycarbonate versus aluminium.'],
            ['name' => 'Sizing & Compatibility', 'description' => 'How to measure a modem and choose the right cavity.'],
            ['name' => 'Field Notes', 'description' => 'Real deployments, outdoor installs and lessons learned.'],
        ];

        $postCategories = [];
        foreach ($categories as $category) {
            $postCategories[$category['name']] = PostCategory::updateOrCreate(['slug' => Str::slug($category['name'])], $category);
        }

        $author = User::where('email', 'admin@minimodemcase.test')->first();

        $posts = [
            [
                'title' => 'How to measure a mini modem for the correct case cavity',
                'category' => 'Sizing & Compatibility',
                'tags' => ['sizing', 'compatibility', 'measuring'],
                'excerpt' => 'Three measurements decide whether an enclosure will fit: outer length, outer width and the height including any connector shoulders.',
                'body' => "Measure the modem itself, not the marketing datasheet. Manufacturers quote dimensions for the bare unit, without the antenna stub, without a SIM tray flap open and without the rubber feet some models ship with.\n\nStart with length: run a rule along the longest face. For a USB dongle like the Huawei E8372 that is roughly 94 mm, but the hinged USB cap adds several millimetres when it is folded back, so measure with the cap in its working position.\n\nWidth is next. Watch the side buttons and the SIM slot, because they add two to three millimetres depending on the model.\n\nHeight is the measurement that catches people out. Add the thickness of the largest connector plugged into the device, plus a few millimetres for the cable bend radius if the case is sealed.\n\nOnce you have those three numbers, add a working allowance of five millimetres per axis and compare the result with the stated inner cavity on the product page. If the cavity is within two millimetres of your measurement on any axis, check the case's internal rib layout before ordering, because ribs intended to cradle a device can reduce usable width.",
            ],
            [
                'title' => 'ABS or polycarbonate? Choosing an enclosure material',
                'category' => 'Material Comparisons',
                'tags' => ['materials', 'abs', 'polycarbonate'],
                'excerpt' => 'Cost, UV stability and impact resistance trade off against each other. Here is how the three common plastics compare for modem cases.',
                'body' => "ABS is the default for indoor enclosures. It is cheap to mould, holds fine detail and takes a clean finish. Its weakness is UV: leave an ABS case in direct sun for a couple of summers and it chalks, then yellows.\n\nPolycarbonate costs more but shrugs off impact and stays stable under UV. It is the material to choose when the case sits on a pole or a wall that catches afternoon sun. Polycarbonate also machines cleanly, which matters if you are drilling your own antenna holes rather than using the factory-cut gland.\n\nASA sits between the two in price and behaves like ABS to work with, but keeps its colour outdoors. It is the material we recommend for mast-mounted modem housings where the case will be in the elements permanently.\n\nAluminium enters the picture when RF screening matters. Folded aluminium housings attenuate interference from inverters and variable-speed drives far better than plastic, at the cost of weight and a higher price per unit. For a modem next to a solar inverter, the extra screening is often worth it.\n\nThe right answer depends on where the case will live, not on which material is objectively best.",
            ],
            [
                'title' => 'Installing a DIN rail modem case in a control cabinet',
                'category' => 'Installation Guides',
                'tags' => ['din rail', 'installation', 'cabinet'],
                'excerpt' => 'Snap-on enclosures are quick to fit, but airflow and RF placement decide whether the installation is reliable long term.',
                'body' => "A DIN rail case is the fastest way to get a modem permanently mounted inside a cabinet. The clip snaps onto standard 35 mm rail, and the whole assembly can be lifted off for servicing without disturbing the wiring.\n\nBefore clipping in, decide where on the rail the modem should sit. Put it at the cool end of the cabinet, away from transformers and drive controllers, and away from the top where heat collects.\n\nLeave one rail position of clearance on each side if the case has side ventilation slots. Stacked enclosures with no gap between them run measurably hotter, and an LTE modem that throttles on temperature will drop throughput.\n\nRun the antenna tail away from mains wiring. Crossing a mains bundle at right angles is acceptable; running parallel to it for half a metre is not, because that is how noise couples into the receive path.\n\nFinally, check the strain relief. A gland that clamps the cable jacket takes the load off the modem's connector, and that is the difference between a connector that lasts five years and one that fails when someone tugs the coax.",
            ],
            [
                'title' => 'Sealing an outdoor enclosure: IP65 versus IP67 in practice',
                'category' => 'Installation Guides',
                'tags' => ['ip rating', 'weatherproof', 'outdoor'],
                'excerpt' => 'The digits mean different things, and the second one is usually the number that matters for a mast-mounted modem.',
                'body' => "The first digit of an IP rating covers solids, the second covers water. For modem enclosures the water digit is the one that decides whether the install survives a winter, but the solid digit matters for dust in agricultural and construction sites.\n\nIP65 means dust-tight and protected against water projected from a nozzle. On a sheltered wall under an overhang, IP65 is plenty.\n\nIP67 adds immersion for thirty minutes at a metre. That is not the same as being waterproof forever: the test does not include temperature cycling, and heat expansion is what kills most gaskets in the field. An enclosure that seals perfectly on the bench can draw water in through a cable gland when it cools overnight and creates negative pressure.\n\nThat is why a membrane vent matters more than the rating on the box. A vent equalises pressure without admitting liquid, so the gasket is never fighting a pressure differential.\n\nIn practice, an IP65 case with a quality gasket and a pressure vent outperforms an IP67 case with a gland that was over-tightened and a lid screwed down unevenly. Tighten lid fasteners in a cross pattern, to the torque the manufacturer specifies, and inspect the gasket for grit before closing.",
            ],
            [
                'title' => 'Field notes: 40 mini modems in a single rack unit',
                'category' => 'Field Notes',
                'tags' => ['rack', 'deployment', 'field notes'],
                'excerpt' => 'What we learned racking dozens of cellular modems for an event network, including the mistakes worth avoiding.',
                'body' => "The brief was to keep a large batch of USB cellular modems powered, cooled and serviceable inside a flight case for a temporary event network. Loose modems in a bag was the starting point, and it failed immediately: tangled cables, lost SIM trays, and no way to see which device had dropped offline.\n\nRack trays solved most of it. Eight bays per unit, each with a rear cut-out for power and a front cut-out exposing the status LED, meant a technician could walk the rack and spot a dead modem from the aisle without pulling anything out.\n\nTwo things we got wrong the first time. First, we underestimated heat: a fully populated tray in a closed flight case needs forced airflow, not just vent slots, so plan for a fan kit or leave the front door open in service.\n\nSecond, we labelled by bay position instead of by SIM number. When a modem was swapped out, the label stopped matching the device. Label by the thing that never changes, which in a cellular deployment is usually the SIM or the IMEI.\n\nThe final improvement was cosmetic but mattered: tinted front panels rather than clear. In a stage-adjacent environment, blinking LEDs on forty modems are a distraction, and the tint cut the glare while keeping the status readable up close.",
            ],
            [
                'title' => 'Antenna hole placement: getting the RF path right',
                'category' => 'Installation Guides',
                'tags' => ['antenna', 'rf', 'drilling'],
                'excerpt' => 'Where you drill the gland hole affects signal more than which antenna you buy.',
                'body' => "The best antenna in the world performs badly if the case forces the cable into a sharp bend against a metal panel. Placement rules are simple once you accept them.\n\nPut the antenna port on the face that points away from the modem's ground plane. On most mini modems the PCB antenna sits at one end; the connector or pigtail should exit the opposite end so the cable does not run alongside the radio circuitry.\n\nOn metal enclosures, keep the bulkhead fitting at least ten millimetres clear of any internal metal that runs parallel to the pigtail. A coax tail lying flat against an aluminium wall detunes the antenna and raises the standing wave ratio.\n\nRoute cable downwards on outdoor installs. A gland on the underside means water follows gravity away from the seal rather than pooling in the fitting.\n\nIf you are drilling yourself, use a stepped bit and deburr both faces. A rolled burr on the inside edge will chafe the coax jacket every time the cable flexes in wind, and that failure shows up months later as intermittent signal loss.",
            ],
        ];

        foreach ($posts as $index => $data) {
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'body' => $data['body'],
                    'post_category_id' => $postCategories[$data['category']]->id,
                    'user_id' => $author?->id,
                    'status' => 'published',
                    'views' => 120 + ($index * 63),
                    'published_at' => now()->subDays(60 - ($index * 8)),
                    'meta_title' => $data['title'],
                    'meta_description' => $data['excerpt'],
                ]
            );

            $tagIds = collect($data['tags'])->map(function ($name) {
                return Tag::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name])->id;
            });

            $post->tags()->sync($tagIds->all());
        }
    }
}
