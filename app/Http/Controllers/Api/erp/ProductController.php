<?php
namespace App\Http\Controllers\Api\Erp;
use App\Http\Controllers\Controller;
use App\Models\{Product,Category,Type};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Resources\ProductResource;
class ProductController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'slug' => 'nullable|string|unique:products,slug',
            'category_name' => 'required|string',
            'brand_id' => 'nullable|exists:brands,id',
            'type_name' => 'nullable|string',
            'price_before_discount' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'sku' => 'nullable|string',
            'featured' => 'boolean',
            //'status' => ['required', Rule::in(['published', 'draft', 'archived'])],
            'published_at' => 'nullable|date',
            'erp_id' => 'nullable|string',
            'product_name_ar' => 'required|string',
            'product_name_en' => 'required|string',
        ]);
        $category = Category::whereTranslation('name', $request->category_name, 'ar')->first();
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 422);
        }
        $type_id = null;
        if ($request->filled('type_name')) {
            $type = Type::whereTranslation('name', $request->type_name, 'ar')->first();
            if (!$type) {
                return response()->json(['error' => 'Type not found'], 422);
            }
            $type_id = $type->id;
        }
        $slug = $request->slug;
        if (!$slug) {
            $slug = Str::slug($request->product_name_en);
            $count = Product::where('slug', 'LIKE', "$slug%")->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
        }
        $product = Product::create([
            'slug' => $slug,
            'type' => 'simple',
            'category_id' => $category->id,
            'type_id' => $type_id,
            'price_before_discount' => $request->price_before_discount,
            'price' => $request->price,
            'stock' => $request->stock,
            'sku' => $request->sku,
            'featured' => $request->featured ?? false,
            'status' => 'published',
            'published_at' => $request->published_at,
            'erp_id' => $request->erp_id,
        ]);
        $product->translateOrNew('ar')->name = $request->product_name_ar;
        $product->translateOrNew('en')->name = $request->product_name_en;
        $product->save();
        //return response()->json(['message' => 'Product created successfully', 'data' => $product->load('translations')], 201);
        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product->load('translations', 'category', 'type'))
        ], 201);
    }

    public function storeMultiple(Request $request) {
        $request->validate([
            'products' => 'required|array',
            'products.*.slug' => 'nullable|string|unique:products,slug',
            'products.*.category_name' => 'required|string',
            'products.*.brand_id' => 'nullable|exists:brands,id',
            'products.*.type_name' => 'nullable|string',
            'products.*.price_before_discount' => 'nullable|numeric',
            'products.*.price' => 'nullable|numeric',
            'products.*.stock' => 'nullable|integer',
            'products.*.sku' => 'nullable|string',
            'products.*.featured' => 'boolean',
            //'products.*.status' => ['required', Rule::in(['published', 'draft', 'archived'])],
            'products.*.published_at' => 'nullable|date',
            'products.*.erp_id' => 'nullable|string',
            'products.*.product_name_ar' => 'required|string',
            'products.*.product_name_en' => 'required|string',
        ]);

        $createdProducts = [];

        foreach ($request->products as $productData) {
            $category = Category::whereTranslation('name', $productData['category_name'], 'ar')->first();
            if (!$category) {
                return response()->json(['error' => 'Category not found for product with name: ' . $productData['product_name_en']], 422);
            }

            $type_id = null;
            if (!empty($productData['type_name'])) {
                $type = Type::whereTranslation('name', $productData['type_name'], 'ar')->first();
                if (!$type) {
                    return response()->json(['error' => 'Type not found for product with name: ' . $productData['product_name_en']], 422);
                }
                $type_id = $type->id;
            }

            $slug = $productData['slug'] ?? null;
            if (!$slug) {
                $slug = Str::slug($productData['product_name_en']);
                $count = Product::where('slug', 'LIKE', "$slug%")->count();
                if ($count > 0) {
                    $slug .= '-' . ($count + 1);
                }
            }

            $product = Product::create([
                'slug' => $slug,
                'type' => 'simple',
                'category_id' => $category->id,
                'type_id' => $type_id,
                'price_before_discount' => $productData['price_before_discount'] ?? null,
                'price' => $productData['price'] ?? null,
                'stock' => $productData['stock'] ?? null,
                'sku' => $productData['sku'] ?? null,
                'featured' => $productData['featured'] ?? false,
                'status' => 'published',
                'published_at' => $productData['published_at'] ?? null,
                'erp_id' => $productData['erp_id'] ?? null,
            ]);

            $product->translateOrNew('ar')->name = $productData['product_name_ar'];
            $product->translateOrNew('en')->name = $productData['product_name_en'];
            $product->save();

            $createdProducts[] = $product;
        }



//        $productIds = collect($createdProducts)->pluck('id');

//        $productsCollection = Product::whereIn('id', $productIds)->with('category', 'type')->get();

        return response()->json([
            'message' => 'Products created successfully',
        ], 201);
    }

    public function updatePriceStock(Request $request) {
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'price_before_discount' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
        ]);

        $product = Product::find($request->id);
        if (!$product) {
            return response()->json([
                'error' => 'Product with this ID not found'
            ], 404);
        }

        if ($request->has('price_before_discount')) {
            $product->price_before_discount = $request->price_before_discount;
        }
        if ($request->has('price')) {
            $product->price = $request->price;
        }
        if ($request->has('stock')) {
            $product->stock = $request->stock;
        }
        $product->save();
        return response()->json([
            'message' => 'Product updated successfully',
        ]);
    }

    public function updateMultiplePriceStock(Request $request) {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|string',
            'products.*.price_before_discount' => 'nullable|numeric',
            'products.*.price' => 'nullable|numeric',
            'products.*.stock' => 'nullable|integer',
        ]);

        $updatedProducts = [];

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);

            if (!$product) {
                continue;
            }

            if (array_key_exists('price_before_discount', $productData)) {
                $product->price_before_discount = $productData['price_before_discount'];
            }
            if (array_key_exists('price', $productData)) {
                $product->price = $productData['price'];
            }
            if (array_key_exists('stock', $productData)) {
                $product->stock = $productData['stock'];
            }

            $product->save();
            $updatedProducts[] = $product->only([
                'id',
                'price_before_discount',
                'price',
                'stock'
            ]);
        }

        return response()->json([
            'message' => 'Products updated successfully',
            'updated_products' => $updatedProducts
        ]);
    }
}
