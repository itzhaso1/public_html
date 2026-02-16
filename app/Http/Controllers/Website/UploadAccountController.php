<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Type;

class UploadAccountController extends Controller
{
    public function create()
    {
        // نرسل أنواع المنتجات للواجهة ليختار منها المستخدم
        return view('website.upload-account', [
            'types' => Type::all()
        ]);
    }

    public function store(Request $request)
    {
        // التحقق من المدخلات
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:50',
            'description' => 'required|string',
            'client_number' => 'required|string',
            'type_id' => 'required|integer',
            'price' => 'required|numeric',
            'product' => 'required|image',
            'gallery.*' => 'image',
            'video' => 'nullable|mimes:mp4,mov,avi'
        ]);

        // إنشاء المنتج
        $product = new Product();

        // الترجمات (لغة عربية)
        $product->translateOrNew('ar')->name = $request->name;
        $product->translateOrNew('ar')->short_description = $request->short_description;
        $product->translateOrNew('ar')->description = $request->description;

        $product->client_number = $request->client_number;
        $product->type_id = $request->type_id;
        $product->price = $request->price;

        $product->slug = 'product-' . time();  // slug تلقائي
        $product->status = 'published';        // نشر المنتج مباشرة

        $product->save();

        // رفع الصورة الرئيسية
        if ($request->hasFile('product')) {
            $product->addMedia($request->file('product'))->toMediaCollection('product');
        }

        // رفع الصور الفرعية
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $product->addMedia($image)->toMediaCollection('gallery');
            }
        }

        // رفع الفيديو (إذا موجود)
        if ($request->hasFile('video')) {
            $product->addMedia($request->video)->toMediaCollection('videos');
        }

        return back()->with('success', '✔️ تم رفع الحساب بنجاح!');
    }
}
