<?php

/*
 * Developer: Olha Rosolovska
 * Project: Mini Modem Case - CMS & Marketplace
 * File: Application routes (storefront, customer account, seller, admin)
 */

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Site\AccountController;
use App\Http\Controllers\Site\BlogController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\ShopController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use Illuminate\Support\Facades\Route;

/* ---------------------------------------------------------------------------
 | Storefront
 | ------------------------------------------------------------------------- */
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/vendor/{slug}', [ShopController::class, 'vendor'])->name('shop.vendor');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/page/{slug}', [BlogController::class, 'page'])->name('page.show');
Route::get('/contact', [BlogController::class, 'contact'])->name('contact');
Route::post('/contact', [BlogController::class, 'contactSend'])->name('contact.send');

/* ---------------------------------------------------------------------------
 | Cart and checkout (guest carts are supported through the session id)
 | ------------------------------------------------------------------------- */
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'coupon'])->name('cart.coupon');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{orderNumber}', [AccountController::class, 'order'])->name('account.order');
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::patch('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
});

Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

/* ---------------------------------------------------------------------------
 | Seller dashboard
 | ------------------------------------------------------------------------- */
Route::middleware(['auth', 'vendor'])->prefix('seller')->name('vendor.')->group(function () {
    Route::get('/', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [VendorDashboardController::class, 'products'])->name('products');
    Route::get('/orders', [VendorDashboardController::class, 'orders'])->name('orders');
    Route::get('/profile', [VendorDashboardController::class, 'profile'])->name('profile');
    Route::patch('/profile', [VendorDashboardController::class, 'updateProfile'])->name('profile.update');
});

/* ---------------------------------------------------------------------------
 | Administration panel
 | ------------------------------------------------------------------------- */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('pages', AdminPageController::class)->except(['show']);
    Route::resource('posts', AdminPostController::class)->except(['show']);
    Route::post('posts/categories', [AdminPostController::class, 'storeCategory'])->name('posts.categories.store');
    Route::delete('posts/categories/{category}', [AdminPostController::class, 'destroyCategory'])->name('posts.categories.destroy');

    Route::get('media', [AdminMediaController::class, 'index'])->name('media.index');
    Route::post('media', [AdminMediaController::class, 'store'])->name('media.store');
    Route::delete('media/{medium}', [AdminMediaController::class, 'destroy'])->name('media.destroy');

    Route::get('menus', [AdminMenuController::class, 'index'])->name('menus.index');
    Route::post('menus', [AdminMenuController::class, 'store'])->name('menus.store');
    Route::post('menus/{menu}/items', [AdminMenuController::class, 'storeItem'])->name('menus.items.store');
    Route::delete('menus/items/{item}', [AdminMenuController::class, 'destroyItem'])->name('menus.items.destroy');

    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
    Route::get('vendors/create', [AdminVendorController::class, 'create'])->name('vendors.create');
    Route::post('vendors', [AdminVendorController::class, 'store'])->name('vendors.store');
    Route::get('vendors/{vendor}/edit', [AdminVendorController::class, 'edit'])->name('vendors.edit');
    Route::put('vendors/{vendor}', [AdminVendorController::class, 'update'])->name('vendors.update');
    Route::post('vendors/{vendor}/approve', [AdminVendorController::class, 'approve'])->name('vendors.approve');
    Route::post('vendors/{vendor}/suspend', [AdminVendorController::class, 'suspend'])->name('vendors.suspend');
    Route::delete('vendors/{vendor}', [AdminVendorController::class, 'destroy'])->name('vendors.destroy');

    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');

    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}', [AdminReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
    Route::post('coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
    Route::patch('coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
    Route::delete('coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

require __DIR__ . '/auth.php';
