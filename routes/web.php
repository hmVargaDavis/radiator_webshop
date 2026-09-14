<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\AdminAuth;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/radiatorok', [ProductController::class, 'index'])->name('products.index');
Route::get('/radiatorok/{product:slug}.json', [ProductController::class, 'json'])->name('products.json');
Route::get('/radiatorok/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/api/katalogus.json', [ProductController::class, 'catalogJson'])->name('api.catalog');
Route::get('/api/products.json', [ProductController::class, 'catalogJson']);

Route::get('/llms.txt', function (\App\Services\SeoService $seo) {
    $products = \App\Models\Product::active()->get();
    $lines = [
        '# Radiátor Outlet Budapest',
        '',
        '> Új 22K acéllemez panelradiátorok Budapesten, raktárról. Kiszállítás csak Budapesten.',
        '',
        '## Üzlet',
        '- Név: Radiátor Outlet Budapest',
        '- Telefon: '.$seo->phoneE164(),
        '- Átvétel: '.$seo->pickupAddress(),
        '- Szolgáltatási terület: Budapest (összes kerület)',
        '- Szállítási díj: '.$seo->shippingFee().' HUF / rendelés',
        '- Vidéki kiszállítás: nincs',
        '- Web: '.url('/'),
        '',
        '## Gépi olvasható adatok',
        '- Katalógus JSON: '.url('/api/katalogus.json'),
        '- Sitemap: '.url('/sitemap.xml'),
        '',
        '## Termékek',
    ];
    foreach ($products as $p) {
        $lines[] = '- '.$p->name.' | '.$p->formatted_price.'/db | HTML: '.route('products.show', $p).' | JSON: '.route('products.json', $p);
    }
    $lines[] = '';
    $lines[] = '## Kulcsszavak';
    $lines[] = '22K radiátor Budapest, panelradiátor Budapest, lapradiátor raktárról, radiátor kiszállítás Budapest, radiátor Soroksár';

    return response(implode("\n", $lines), 200)
        ->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('llms');

Route::get('/kosar', [CartController::class, 'index'])->name('cart.index');
Route::get('/api/kosar', [CartController::class, 'summary'])->name('api.cart');
Route::get('/api/kosar/drawer', [CartController::class, 'drawer'])->name('api.cart.drawer');
Route::post('/kosar/hozzaadas', [CartController::class, 'add'])->name('cart.add');
Route::post('/kosar/frissites', [CartController::class, 'update'])->name('cart.update');
Route::post('/kosar/torles', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/megrendeles', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/megrendeles', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/megrendeles/koszonjuk/{orderNumber}', [CheckoutController::class, 'thanks'])->name('checkout.thanks');

Route::get('/velemenyek', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/velemenyek', [ReviewController::class, 'store'])->name('reviews.store');

Route::get('/szallitas', [PageController::class, 'shipping'])->name('shipping');
Route::get('/kapcsolat', [PageController::class, 'contact'])->name('contact');
Route::get('/csomag-tartalma', [PageController::class, 'package'])->name('package');
Route::get('/adatkezeles', [PageController::class, 'privacy'])->name('privacy');

Route::get('/sitemap.xml', function () {
    $products = Product::active()->get();
    $content = view('sitemap', compact('products'))->render();

    return response($content, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware(AdminAuth::class)->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::get('/seo', [SeoController::class, 'index'])->name('seo');
        Route::get('/search', SearchController::class)->name('search');

        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('reviews', AdminReviewController::class)->except(['show']);
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
