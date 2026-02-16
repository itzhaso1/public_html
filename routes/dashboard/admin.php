<?php
 
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
 
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
 
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        
        Route::resource('admins', Dashboard\AdminController::class);
        Route::get('/link-password', [Dashboard\AdminController::class, 'showForm'])->name('link_password.form');
        Route::post('/link-password', [Dashboard\AdminController::class, 'verify'])->name('link_password.verify');
        
        Route::controller(Dashboard\MainSettingsController::class)->prefix('mainSettings')->as('mainSettings.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('store', 'store')->name('store');
            Route::get('histories', 'history')->name('histories');
        });
 
        Route::resource('categories', Dashboard\CategoryController::class);
        Route::post('categories/import', [Dashboard\CategoryController::class, 'import'])->name('categories.import');
        
        // =======================================================
        // ✅ (هام) تم إضافة رابط إضافة الشحن هنا (قبل products)
        // =======================================================
        Route::get('charge-items/create', [Dashboard\ProductController::class, 'createChargeProduct'])->name('products.create_charge');
        Route::post('charge-items/store', [Dashboard\ProductController::class, 'storeChargeProduct'])->name('products.store_charge');
 
        // الروابط الأصلية للمنتجات
        Route::resource('products', Dashboard\ProductController::class);
        Route::post('products/import', [Dashboard\ProductController::class, 'import'])->name('products.import');
        Route::post('products/test-erp-connection', [Dashboard\ProductController::class, 'exportProductsToERP'])->name('test-erp-connection');
        
        Route::resource('sliders', Dashboard\SliderController::class);
        Route::resource('aboutCounters', Dashboard\AboutCounterController::class);
        Route::resource('sections', Dashboard\SectionController::class);
        Route::resource('brands', Dashboard\BrandController::class);
        Route::resource('types', Dashboard\TypeController::class);
        Route::resource('tags', Dashboard\TagController::class);
        Route::resource('coupons', Dashboard\CouponController::class);
 
        Route::get('about/create', [Dashboard\AboutController::class, 'create'])->name('about.create');
        Route::post('about/store', [Dashboard\AboutController::class, 'store'])->name('about.store');
        Route::get('contact/create', [Dashboard\ContactUsController::class, 'create'])->name('contact.create');
        Route::post('contact/store', [Dashboard\ContactUsController::class, 'store'])->name('contact.store');
 
        Route::resource('privacy', Dashboard\PrivacyController::class);
 
        Route::resource('users', Dashboard\UserController::class)->names('user');
        
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::get('orders', [Dashboard\OrderController::class, 'index'])->name('index');
            Route::get('{id}', [Dashboard\OrderController::class, 'show'])->name('show');
            Route::post('change-status', [Dashboard\OrderController::class, 'changeStatus'])->name('changeStatus');
            Route::post('change-payment-status', [Dashboard\OrderController::class, 'changePaymentStatus'])->name('changePaymentStatus');
            Route::get('{id}/invoice', [Dashboard\OrderController::class, 'generate'])->name('invoice');
            Route::post('{order}/send-to-erp', [Dashboard\OrderController::class, 'sendOrderToERP']);
        });
        
        Route::get('dashboard', Dashboard\DashboardController::class)->name('dashboard');
    });
});