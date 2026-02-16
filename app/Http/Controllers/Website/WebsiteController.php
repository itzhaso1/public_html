<?php
 
namespace App\Http\Controllers\Website;
 
use App\Http\Controllers\Controller;
use App\Models\{Category,Slider, Section, Product};
 
class WebsiteController extends Controller {
    public function __invoke() {
        $sliders = Slider::with(['translations', 'media',])->latest()->get();
        $categories = Category::with(['translations', 'media', 'children.translations'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        $featuredCategories = Category::query()
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->with(['translations', 'media'])
            ->get();
        $categoryCount = $categories->count();
        $slidesPerView = $categoryCount < 10 ? $categoryCount : 10;
 
        $sections = Section::with([
            'translations',
            'products.translations',
            'products.media',
            'categories.translations',
        ])
            ->orderBy('order')
            ->get();
        
        $sectionProductIds = $sections->pluck('products')->flatten()->pluck('id')->unique();
        
        // تعديل بسيط: إخفاء منتجات الشحن من الصفحة الرئيسية أيضاً
        $products = Product::with(['translations', 'media'])
            ->where('status', 'published')
            ->whereNotIn('id', $sectionProductIds)
            ->whereNull('service_type') // ✅ إخفاء الجواهر من هنا
            ->latest()
            ->get();
            
        $categoryCount = $categories->count();
        $slidesPerView = $categoryCount < 10 ? $categoryCount : 10;
 
        return view('website.pages.home', ['pageTitle' => trans('site/site.home_page_title'),
            'categories' => $categories,
            'sliders' => $sliders,
            'featuredCategories' => $featuredCategories,
            'categoryCount' => $categoryCount,
            'slidesPerView' => $slidesPerView,
            'sections' => $sections,
            'products' => $products,
        ]);
    }
 
    public function show(Product $product) {
        // ============================================================
        // ✅ التعديل الجديد: توجيه منتجات الشحن لصفحة خاصة
        // ============================================================
        if (!empty($product->service_type)) {
            // إذا كان المنتج شحناً، نستخدم تصميماً مبسطاً
            // سنحتاج لإنشاء هذا الملف في الخطوة التالية
            return view('website.diamonds.show_charge', compact('product'));
        }
        // ============================================================
 
        $product->load(['translations', 'media', 'videos']);
        $mainImage = $product->getMediaUrl('product', $product, null, 'media', 'product');
        $galleryImages = $product->getMultipleMediaUrls('product/gallery', $product, 'media', 'gallery');
        $productVideo = $product->videos->first();
        return view('website.pages.products_show', compact('product', 'mainImage', 'galleryImages', 'productVideo'));
    }
}
