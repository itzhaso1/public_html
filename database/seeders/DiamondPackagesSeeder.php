<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DiamondPackagesSeeder extends Seeder
{
    public function run(): void
    {
        // Use any existing category/type to satisfy FK constraints.
        $categoryId = DB::table('categories')->value('id');
        $typeId = DB::table('types')->value('id');

        if (! $categoryId) {
            // No categories yet, nothing to seed safely.
            return;
        }

        $typeId = $typeId ?: null;

        $packages = [
            100,
            320,
            572,
            1188,
            2400,
        ];

        foreach ($packages as $amount) {
            $nameAr = "شحن {$amount} جوهرة";
            $slugBase = Str::slug("diamonds-{$amount}");

            $product = Product::query()
                ->where('service_type', 'gems')
                ->where('slug', $slugBase)
                ->first();

            if (! $product) {
                $product = Product::create([
                    'slug' => $slugBase,
                    'type' => 'simple',
                    'category_id' => $categoryId,
                    'type_id' => $typeId,
                    'service_type' => 'gems',
                    'price' => 0, // set later from dashboard
                    'price_before_discount' => null,
                    'stock' => 9999,
                    'sku' => "GEMS-{$amount}",
                    'featured' => false,
                    'status' => 'published',
                    'published_at' => now(),
                ]);
            } else {
                $product->update([
                    'status' => 'published',
                    'stock' => $product->stock ?? 9999,
                ]);
            }

            // Insert / update translations.
            DB::table('product_translations')->updateOrInsert(
                ['product_id' => $product->id, 'locale' => 'ar'],
                [
                    'name' => $nameAr,
                    'description' => 'شحن فوري بعد التأكيد.',
                    'short_description' => (string) $amount,
                ]
            );

            DB::table('product_translations')->updateOrInsert(
                ['product_id' => $product->id, 'locale' => 'en'],
                [
                    'name' => "Top up {$amount} diamonds",
                    'description' => 'Fast top up after confirmation.',
                    'short_description' => (string) $amount,
                ]
            );
        }
    }
}

