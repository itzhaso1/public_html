<?php

namespace App\Imports;

use Illuminate\Support\{Str,Collection};
use Maatwebsite\Excel\Concerns\{ToCollection,WithHeadingRow};
use App\Models\{Product,Category,Type};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/*class ProductsImport implements ToCollection, WithHeadingRow {
    public function collection(Collection $rows) {
        dd($rows);
        foreach ($rows as $row) {
            // 1. التعامل مع التصنيف
            $category = Category::whereHas('translations', function ($q) use ($row) {
                $q->where('name', $row['اسم_التصنيف'])->where('locale', 'ar');
            })->first();

            if (!$category) {
                $category = Category::create();
                $category->translateOrNew('ar')->name = $row['اسم_التصنيف'];
                $category->translateOrNew('en')->name = $row['اسم_التصنيف']; // ممكن ترجمه لاحقًا
                $category->save();
            }

            // 2. التعامل مع الوحدة (type)
            $type = Type::whereHas('translations', function ($q) use ($row) {
                $q->where('name', $row['اسم_الوحده'])->where('locale', 'ar');
            })->first();

            if (!$type) {
                $type = Type::create();
                $type->translateOrNew('ar')->name = $row['اسم_الوحده'];
                $type->translateOrNew('en')->name = $row['اسم_الوحده']; // ترجمه لاحقًا
                $type->save();
            }

            // 3. إنشاء المنتج
            $product = Product::create([
                'slug' => Str::slug($row['اسم_الصنف_بالانجليزيه']) . '-' . uniqid(),
                'category_id' => $category->id,
                'type_id' => $type->id,
                'price' => $row['السعر'],
                'stock' => $row['الرصيد'],
                'sku' => $row['sku'],
                'status' => 'published',
                'itemID' => $row['رقم_المعرف'],
            ]);

            // 4. الترجمة
            $product->translateOrNew('ar')->name = $row['اسم_الصنف_عربى'];
            $product->translateOrNew('en')->name = $row['اسم_الصنف_بالانجليزيه'];
            $product->save();
        }
    }
}*/

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $row = $row->toArray();

            if (!$row['asm_altsnyf'] || !$row['asm_alohdh'] || !$row['asm_alsnf_aarb'] || !$row['asm_alsnf_balanglyzyh']) {

                continue;
            }
            $category = Category::whereHas('translations', function ($q) use ($row) {
                $q->where('name', $row['asm_altsnyf'])->where('locale', 'ar');
            })->first();

            if (!$category) {
                $category = Category::create();
                $category->translateOrNew('ar')->name = $row['asm_altsnyf'];
                $category->translateOrNew('en')->name = $row['asm_altsnyf'];
                $category->save();
            }
            $type = Type::whereHas('translations', function ($q) use ($row) {
                $q->where('name', $row['asm_alohdh'])->where('locale', 'ar');
            })->first();

            if (!$type) {
                $type = Type::create();
                $type->translateOrNew('ar')->name = $row['asm_alohdh'];
                $type->translateOrNew('en')->name = $row['asm_alohdh'];
                $type->save();
            }
            $product = Product::create([
                'slug' => Str::slug($row['asm_alsnf_balanglyzyh']) . '-' . uniqid(),
                'category_id' => $category->id,
                'type_id' => $type->id,
                'price' => $row['alsaar'] ?? 0,
                'stock' => $row['alrsyd'] ?? 0,
                'sku' => $row['sku'] ?? null,
                'status' => 'published',
                'itemID' => $row['rkm_almaarf'] ?? null,
            ]);
            $product->translateOrNew('ar')->name = $row['asm_alsnf_aarb'];
            $product->translateOrNew('en')->name = $row['asm_alsnf_balanglyzyh'];
            $product->save();
        }
    }
}
