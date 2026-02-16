<?php

namespace App\Repositories;

use App\Models\{Product, Category, Type, Brand, Tag};
use App\Services\Contracts\ProductInterface;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\Admin\ProductDataTable;
use App\Models\Concerns\UploadVideoTrait;
use Illuminate\Support\Str;

class ProductRepository implements ProductInterface
{
    use UploadVideoTrait;

    /* =========================
     * Index
     * ========================= */
    public function index(ProductDataTable $productDataTable)
    {
        return $productDataTable->render('dashboard.admin.products.index', [
            'pageTitle' => trans('dashboard/admin.product.products'),
        ]);
    }

    /* =========================
     * Create
     * ========================= */
    public function create()
    {
        return view('dashboard.admin.products.form', [
            'pageTitle' => 'إضافة منتج',
            'data' => [
                'categories' => Category::active()->get(),
                'types'      => Type::all(),
                'brands'     => Brand::all(),
                'tags'       => Tag::all(),
            ],
        ]);
    }

    /* =========================
     * Store
     * ========================= */
    public function store(Request $request)
    {
        $data = $this->extractData($request);
        $product = Product::create($data);

        // الوسوم
        $product->tags()->sync($request->input('tags', []));

        // الصورة الرئيسية
        if ($request->hasFile('product')) {
            $media = $product->uploadSingleMedia(
                'product',
                $request->file('product'),
                $product,
                null,
                'media',
                true
            );

            if ($media) {
                $imagePath = public_path("uploads/product/{$media}");
                $this->addWatermark($imagePath);
            }
        }

        // صور المعرض
        if ($request->hasFile('gallery')) {
            $product->uploadMultipleMedia(
                'product/gallery',
                $request->file('gallery'),
                $product,
                'media',
                false,
                true,
                'gallery'
            );
        }

        // الفيديو
        if ($request->hasFile('video')) {
            $product->uploadVideo($request->file('video'));
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /* =========================
     * Update (الدالة الوحيدة الصحيحة)
     * ========================= */
    public function update(Request $request, Product $product)
{
    $data = $this->extractData($request);
    $product->update($data);

    // الوسوم
    $product->tags()->sync($request->input('tags', []));

    // تحديث الصورة الرئيسية
    if ($request->hasFile('product')) {
        $media = $product->updateSingleMedia(
            'product',
            $request->file('product'),
            $product,
            null,
            'media',
            true
        );

        if ($media) {
            $imagePath = public_path("uploads/product/{$media}");
            $this->addWatermark($imagePath);
        }
    }
$galleryFiles = $request->file('gallery');

if (is_array($galleryFiles)) {

    // نتحقق أن فيه ملفات مرفوعة فعليًا
    $validFiles = array_filter($galleryFiles, function ($file) {
        return $file && $file->isValid();
    });

    if (count($validFiles) > 0) {

        // 🔥 حذف كل الصور القديمة
        $product->deleteExistingMedia(
            'gallery',
            $product,
            null,
            'media',
            true,
            'gallery'
        );

        // 🔥 رفع الصور الجديدة فقط
        $product->uploadMultipleMedia(
            'product/gallery',
            $validFiles,
            $product,
            'media',
            false,
            true,
            'gallery'
        );
    }
}



    // ✅ حل مشكلة الفيديو (حذف القديم + رفع الجديد)
    // ✅ تحديث الفيديو (حذف أي فيديو قديم مهما كان اسمه)
if ($request->hasFile('video')) {

    foreach ($product->media as $media) {
        if (str_starts_with($media->mime_type, 'video')) {
            $media->delete();
        }
    }

    // رفع الفيديو الجديد
    $product->uploadVideo($request->file('video'));
}


    return redirect()->route('admin.products.index')
        ->with('success', 'تم تحديث المنتج بنجاح');
}

    /* =========================
     * Edit
     * ========================= */
    public function edit(Product $product)
    {
        $product->load(['tags', 'media']);

        return view('dashboard.admin.products.form', [
            'pageTitle' => 'تعديل منتج',
            'product'   => $product,
            'data' => [
                'categories' => Category::active()->get(),
                'types'      => Type::all(),
                'brands'     => Brand::all(),
                'tags'       => Tag::all(),
            ],
        ]);
    }

    /* =========================
     * Destroy
     * ========================= */
    public function destroy(Product $product)
    {
        $product->deleteExistingMedia('product', $product, null, 'media', true, 'product');
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم الحذف بنجاح!');
    }

    /* =========================
     * Extract Data
     * ========================= */
    private function extractData(Request $request)
    {
        $data = $request->only([
            'category_id',
            'brand_id',
            'type_id',
            'price_before_discount',
            'price',
            'stock',
            'sku',
            'status',
            'featured',
            'slug',
            'client_number',
        ]);

        $data['featured'] = $request->has('featured');

        foreach (config('translatable.locales') as $locale) {
            $data[$locale] = $request->input($locale);
        }

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($request->input('ar.name', 'product-' . uniqid()));
        } elseif (Product::where('slug', $data['slug'])->exists()) {
            $data['slug'] .= '-' . uniqid();
        }

        return $data;
    }

    /* =========================
     * Watermark
     * ========================= */
    private function addWatermark($imagePath)
    {
        try {
            $logoPath = public_path('watermark/logo.png');

            if (!file_exists($imagePath) || !file_exists($logoPath)) {
                return;
            }

            $info = getimagesize($imagePath);
            $mime = $info['mime'];

            $image = $mime === 'image/png'
                ? imagecreatefrompng($imagePath)
                : imagecreatefromjpeg($imagePath);

            $logo = imagecreatefrompng($logoPath);

            imagesavealpha($image, true);
            imagealphablending($image, true);
            imagesavealpha($logo, true);
            imagealphablending($logo, true);

            $imageWidth  = imagesx($image);
            $imageHeight = imagesy($image);
            $logoWidth   = imagesx($logo);
            $logoHeight  = imagesy($logo);

            $newLogoWidth  = intval($imageWidth * 0.2);
            $scale         = $newLogoWidth / $logoWidth;
            $newLogoHeight = intval($logoHeight * $scale);

            $resizedLogo = imagecreatetruecolor($newLogoWidth, $newLogoHeight);
            imagesavealpha($resizedLogo, true);
            imagefill($resizedLogo, 0, 0, imagecolorallocatealpha($resizedLogo, 0, 0, 0, 127));

            imagecopyresampled(
                $resizedLogo,
                $logo,
                0, 0, 0, 0,
                $newLogoWidth,
                $newLogoHeight,
                $logoWidth,
                $logoHeight
            );

            $y = intval($imageHeight * 0.11);

            $x1 = $imageWidth - $newLogoWidth - 20;
            imagecopy($image, $resizedLogo, $x1, $y, 0, 0, $newLogoWidth, $newLogoHeight);


            $x2 = intval(($imageWidth - $newLogoWidth) / 2) + 40;
imagecopy($image, $resizedLogo, $x2, $y, 0, 0, $newLogoWidth, $newLogoHeight);

            $mime === 'image/png'
                ? imagepng($image, $imagePath, 9)
                : imagejpeg($image, $imagePath, 90);

            imagedestroy($image);
            imagedestroy($logo);
            imagedestroy($resizedLogo);

        } catch (\Exception $e) {
            // تجاهل الخطأ
        }
    }
}
