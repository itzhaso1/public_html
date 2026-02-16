<?php
 
namespace App\Http\Controllers\Dashboard;
 
use App\DataTables\Dashboard\Admin\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Services\Contracts\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Services\Services\ERP\ERPService;
use Illuminate\Support\Str; // مكتبة للنصوص
 
class ProductController extends Controller
{
    protected ERPService $erpService;
 
    public function __construct(ERPService $erpService, protected ProductDataTable $productDataTable, protected ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;
        $this->productDataTable = $productDataTable;
        $this->erpService = $erpService;
    }
 
    // --- الدوال الأساسية ---
    public function index(ProductDataTable $productDataTable) { return $this->productInterface->index($this->productDataTable); }
    public function create() { return $this->productInterface->create(); }
    public function store(Request $request) { return $this->productInterface->store($request); }
    public function edit(Product $product) { return $this->productInterface->edit($product); }
    public function update(Request $request, Product $product) { return $this->productInterface->update($request, $product); }
    public function destroy(Product $product) { return $this->productInterface->destroy($product); }
    
    public function import(Request $request) {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        Excel::import(new ProductsImport, $request->file('file'));
        return response()->json(['message' => 'تم حفظ المنتج بنجاح ✅']);
    }
 
    public function testConnection() {
        $result = $this->erpService->testConnection();
        return $result['success'] ? back()->with('success', $result['message']) : back()->with('error', $result['message']);
    }
 
    public function exportProductsToERP() {
        $products = Product::with(['translations', 'category.translations', 'type.translations'])->get();
        $formattedProducts = $this->erpService::formatProductsForERP($products);
        $result = $this->erpService->sendProducts($formattedProducts);
        return $result['success'] ? back()->with('success', 'تم الإرسال بنجاح') : back()->with('error', 'فشل الإرسال');
    }
 
    public function show($id) {
        return redirect()->route('admin.products.index');
    }
 
    // ==========================================
    // ✅ (الجديد) قسم إضافة منتجات الشحن
    // ==========================================
    public function createChargeProduct()
    {
        return view('dashboard.admin.products.create_charge');
    }
 
    public function storeChargeProduct(Request $request)
    {
        // التحقق: نطلب أن تكون القيمة إما gems أو codes
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'type_id' => 'required|in:gems,codes', 
        ]);
 
        try {
            \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
 
            // نأخذ أول قسم ونوع موجودين لتجنب الأخطاء
            $cat = \DB::table('categories')->first();
            $type = \DB::table('types')->first(); 
 
            $slug = \Illuminate\Support\Str::slug($request->name) . '-' . time();
 
            $id = \DB::table('products')->insertGetId([
                'slug'         => $slug,
                'type'         => 'simple',
                'category_id'  => $cat ? $cat->id : 5, 
                'type_id'      => $type ? $type->id : 2, 
                'service_type' => $request->type_id, // ✅ هنا نحفظ القيمة الجديدة (gems/codes)
                'price'        => $request->price,
                'stock'        => 9999,
                'sku'          => 'CHG-' . time(),
                'status'       => 'published',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
 
            \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
 
            // حفظ الاسم في الترجمة
            try {
                \DB::table('product_translations')->insert([
                    ['product_id' => $id, 'locale' => 'ar', 'name' => $request->name, 'description' => $request->name],
                    ['product_id' => $id, 'locale' => 'en', 'name' => $request->name, 'description' => $request->name],
                ]);
            } catch (\Exception $e) {}
 
            return redirect()->back()->with('success', 'تم إضافة الباقة بنجاح وتصنيفها بشكل صحيح! 🎉');
 
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
}