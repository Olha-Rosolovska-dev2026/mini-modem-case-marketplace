<!-- Developer: Olha Rosolovska | Project: Mini Modem Case - CMS & Marketplace -->

# Mini Modem Case - CMS & Marketplace

A complete **Content Management System (CMS)** plus **multi-vendor marketplace** built with **Laravel 12**,
designed for selling **mini modem / router enclosures and cases** (DIN rail, wall mount, weatherproof,
rack mount, desktop and open frame kits).

**Developer: Olha Rosolovska**

---

## Table of contents

1. [Feature overview](#1-feature-overview)
2. [Requirements](#2-requirements)
3. [Quick installation](#3-quick-installation)
4. [Manual installation](#4-manual-installation)
5. [Default demo accounts](#5-default-demo-accounts)
6. [Project structure](#6-project-structure)
7. [Database schema](#7-database-schema)
8. [Application areas and routes](#8-application-areas-and-routes)
9. [Settings, shipping and tax](#9-settings-shipping-and-tax)
10. [Media and product images](#10-media-and-product-images)
11. [Deployment notes](#11-deployment-notes)

---

## 1. Feature overview

### CMS

- **Pages** - full CRUD, templates, draft/published status, sort order, show-in-menu flag, SEO meta title and description.
- **Blog / Posts** - posts with categories, tags, featured image, view counter, author, publish date and SEO meta.
- **Media library** - upload to disk with folders, alt text, mime type and human-readable size, filter by folder or search term.
- **Menus** - multiple menus (header / footer / sidebar) with nested items, sort order, target `_self` / `_blank`.
- **Global settings** - site name, tagline, contact details, currency symbol, shipping, tax and registration numbers.

### Marketplace

- **Vendors** - seller profiles with logo, banner, address, commission rate, rating, approval workflow
  (pending / approved / suspended) and featured flag.
- **Categories** - self-referencing tree with parent / child relations, image, sort order and active flag.
- **Products** - full modem-case specification set:
  case type, material, colour, outer dimensions, inner dimensions, weight, IP rating, mounting type,
  antenna hole, ventilation slots, wall mount, LED indicator window and warranty months,
  plus price, compare price, stock, SKU, gallery images, multi-vendor ownership and SEO meta.
- **Compatible modem models** - a library of real modem / router devices (form factor and device dimensions)
  linked to products through a many-to-many pivot, so buyers can filter cases by the exact device they own.
- **Cart** - session or user bound cart, quantity control, coupon codes, automatic shipping and tax calculation.
- **Checkout** - guest or authenticated checkout, COD / bank transfer / card payment method, stock decrement,
  coupon usage tracking, order number generation and order confirmation page.
- **Orders** - customer order history and detail view, admin order management with status and payment status.
- **Reviews** - star ratings with moderation queue, "verified purchase" detection and automatic product rating recalculation.
- **Coupons** - fixed or percentage discounts with minimum order value, usage cap, start and expiry dates.
- **Roles** - `admin`, `vendor` and `customer` with dedicated dashboards and middleware-protected areas.

---

## 2. Requirements

| Component | Version |
|-----------|---------|
| PHP | 8.2 or newer (tested on 8.3) |
| Composer | 2.x |
| Node.js | 18 or newer (only needed to rebuild assets) |
| Database | SQLite (default), MySQL 8 or PostgreSQL 13+ |

Required PHP extensions: `mbstring`, `xml` / `dom`, `zip`, `curl`, `sqlite3` or `pdo_mysql`, `bcmath`, `intl`.

---

## 3. Quick installation

The archive ships **with `vendor/` and the compiled front-end assets in `public/build/`**, so you can start
without any network access:

```bash
unzip mini-modem-case-marketplace.zip
cd mini-modem-case-marketplace

cp .env.example .env          # if .env is missing
php artisan key:generate      # only if APP_KEY is empty
php artisan migrate --seed    # creates the schema and demo data
php artisan storage:link      # public symlink for uploaded media
php artisan serve
```

Open http://127.0.0.1:8000

A one-shot helper is also registered in `composer.json`:

```bash
composer setup
```

---

## 4. Manual installation

```bash
composer install --no-interaction

npm install
npm run build          # Vite + Tailwind CSS

touch database/database.sqlite
php artisan migrate --seed --force
php artisan storage:link
php artisan serve
```

Environment variables that matter (`/.env`):

```ini
APP_NAME="Mini Modem Case"
APP_URL=http://localhost

DB_CONNECTION=sqlite
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=mini_modem_case
# DB_USERNAME=root
# DB_PASSWORD=

FILESYSTEM_DISK=public
```

Clear the caches after changing `.env`:

```bash
php artisan config:clear && php artisan cache:clear && php artisan view:clear
```

---

## 5. Default demo accounts

All demo accounts use the password **`password`**.

| Role | Email |
|------|-------|
| Administrator | `admin@minimodemcase.test` |
| Vendor / seller | `seller@minimodemcase.test` |
| Vendor / seller | `northline@minimodemcase.test` |
| Vendor / seller | `harbour@minimodemcase.test` |
| Vendor / seller | `field@minimodemcase.test` |
| Customer | `customer@minimodemcase.test` |
| Customer | `priya@minimodemcase.test` |

> Change every password before putting this project on a public server.

---

## 6. Project structure

```
app/
  Http/
    Controllers/
      Admin/      Dashboard, Page, Post, Media, Menu, Vendor, Category, Product,
                  Order, Review, Coupon, Setting, User
      Site/       Home, Shop, Blog, Cart, Checkout, Account, Review
      Vendor/     Dashboard (seller panel)
    Middleware/   IsAdmin, IsVendor
  Models/         Page, Post, PostCategory, Tag, Media, Menu, MenuItem, Setting,
                  Vendor, Category, Product, ProductImage, ModemModel, Review,
                  Coupon, Cart, CartItem, Order, OrderItem, User
  Providers/      AppServiceProvider, ShopServiceProvider
  Support/        helpers.php  (money(), setting(), case_type_label())
database/
  migrations/     CMS tables, marketplace tables, commerce tables, user shop fields
  seeders/        DatabaseSeeder, SettingsSeeder, UserSeeder, StoreSeeder, CmsSeeder
resources/
  views/
    layouts/      shop, admin/app, vendor/app
    partials/     site-header, site-footer
    components/   product-card
    site/         home, shop, blog, page, contact, cart, checkout, account
    admin/        dashboard, pages, posts, media, menus, vendors, categories,
                  products, orders, reviews, coupons, settings, users
  css/            app.css, shop.css
  js/             app.js, shop.js
routes/web.php    storefront, auth, seller and admin route groups
```

---

## 7. Database schema

**CMS**

- `pages` - title, slug, excerpt, body, template, status, featured image, meta, sort order, show in menu, published at
- `post_categories` - name, slug, description
- `posts` - category, author, title, slug, excerpt, body, featured image, status, views, published at
- `tags`, `post_tag` - tag library and pivot
- `media` - name, file name, path, disk, mime type, size, alt, folder
- `menus` - name, slug, location
- `menu_items` - parent (self reference), label, url, target, sort order, active
- `settings` - key, value, group, type

**Marketplace**

- `vendors` - user, name, slug, contacts, logo, banner, address, status, commission rate, rating, featured
- `categories` - parent (self reference), name, slug, description, image, sort order, active
- `products` - vendor, category, name, slug, sku, descriptions, price, compare price, stock,
  case type, material, colour, dimensions, inner dimensions, weight, IP rating, mounting type,
  antenna hole, ventilation slots, wall mount, LED window, warranty months, status, featured, meta
- `product_images` - product, path, alt, sort order, primary flag
- `modem_models` - brand, name, slug, form factor, device dimensions, notes
- `modem_model_product` - pivot between modems and compatible cases
- `reviews` - product, user, order, rating, title, comment, status, verified purchase

**Commerce**

- `carts` - user, session, coupon code
- `cart_items` - cart, product, vendor, quantity, unit price
- `orders` - order number, user, status, payment method, payment status, subtotal, discount,
  shipping, tax, total, currency, coupon, shipping contact and address, notes, placed at
- `order_items` - order, product, vendor, product name, product SKU, case type, unit price, quantity, total
- `coupons` - code, type, value, minimum order, max uses, used count, start, expiry, active

**Users** - the default `users` table is extended with `role`, `phone`, `address`, `city`, `country`,
`avatar` and `is_active`.

---

## 8. Application areas and routes

### Storefront (`/`)

| Method | URI | Name |
|--------|-----|------|
| GET | `/` | `home` |
| GET | `/shop` | `shop.index` |
| GET | `/product/{slug}` | `shop.show` |
| GET | `/category/{slug}` | `shop.category` |
| GET | `/vendor/{slug}` | `shop.vendor` |
| GET | `/blog` | `blog.index` |
| GET | `/blog/{slug}` | `blog.show` |
| GET | `/blog/category/{slug}` | `blog.category` |
| GET | `/blog/tag/{slug}` | `blog.tag` |
| GET | `/page/{slug}` | `page.show` |
| GET, POST | `/contact` | `contact`, `contact.send` |

### Cart and checkout

| Method | URI | Name |
|--------|-----|------|
| GET | `/cart` | `cart.index` |
| POST | `/cart/add/{product}` | `cart.add` |
| PATCH | `/cart/{item}` | `cart.update` |
| DELETE | `/cart/{item}` | `cart.remove` |
| POST | `/cart/coupon` | `cart.coupon.apply` |
| DELETE | `/cart/coupon` | `cart.coupon.remove` |
| GET, POST | `/checkout` | `checkout.index`, `checkout.store` |
| GET | `/checkout/success/{orderNumber}` | `checkout.success` |

### Customer account (auth)

`/account` `account.index` · `/account/orders` `account.orders` · `/account/orders/{orderNumber}` `account.order` ·
`/account/profile` `account.profile.edit`, `account.profile.update` · `POST /product/{product}/review` `reviews.store`

### Seller panel (auth + `vendor` middleware, prefix `/seller`)

`seller.dashboard` · `seller.products` · `seller.orders` · `seller.profile`

### Admin panel (auth + `admin` middleware, prefix `/admin`)

Dashboard, pages, posts and post categories, media library, menus and menu items, products, categories,
vendors (with approve / suspend), orders (status and payment status), reviews (moderation),
coupons (create / toggle / delete), users (role and activation) and settings.

---

## 9. Settings, shipping and tax

Store-wide values live in the `settings` table and are editable in **Admin > Settings**:

| Key | Default | Purpose |
|-----|---------|---------|
| `site_name` | Mini Modem Case | Brand shown in header |
| `site_tagline` | Rugged cases for mobile modems | Hero subtitle |
| `contact_email` | hello@minimodemcase.test | Public e-mail |
| `contact_phone` | +1 (555) 014-7788 | Public phone |
| `contact_address` | 220 Circuit Avenue, Austin, TX 78701 | Business address |
| `currency_symbol` | `$` | Used by `money()` |
| `shipping_flat_rate` | `7.90` | Flat shipping fee |
| `free_shipping_threshold` | `75` | Order subtotal after discount for free shipping |
| `tax_rate` | `8.5` | Percentage applied to the order |
| `items_per_page` | `12` | Storefront pagination |
| `company_registration` | US-TX-8841207 | Footer legal line |
| `vat_number` | US884120733 | Footer legal line |

Cart totals are calculated as:

```
subtotal   = sum(quantity * unit_price)
discount   = coupon (percentage or fixed, capped at subtotal)
shipping   = 0 if (subtotal - discount) >= free_shipping_threshold else shipping_flat_rate
tax        = (subtotal - discount) * tax_rate / 100
total      = subtotal - discount + shipping + tax
```

---

## 10. Media and product images

```bash
php artisan storage:link
```

Uploads are written to `storage/app/public/<folder>` and served from `/storage/...`.
Product galleries are managed from the product form; the first image becomes the primary image.
The CMS media library validates `jpg, jpeg, png, webp, gif, svg, pdf` up to 8 MB per file.

---

## 11. Deployment notes

```bash
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

- Point the web root at `public/`, never at the project root.
- Use `DB_CONNECTION=mysql` for production traffic; the bundled SQLite file is for local use.
- Ship real product photography instead of the placeholder demo paths before launch.
- Rotate all demo passwords and the `APP_KEY` when cloning the project to a new environment.

---

**Developer: Olha Rosolovska - Mini Modem Case - CMS & Marketplace (Laravel 12)**
