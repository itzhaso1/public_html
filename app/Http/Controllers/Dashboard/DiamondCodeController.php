<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DiamondCode;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DiamondCodeController extends Controller
{
    public function index()
    {
        $codes = DiamondCode::query()
            ->with(['product', 'user'])
            ->latest()
            ->paginate(50);

        return view('dashboard.admin.diamond_codes.index', [
            'pageTitle' => 'أكواد ملابس',
            'codes' => $codes,
        ]);
    }

    public function create()
    {
        $products = Product::query()
            ->where('service_type', 'codes')
            ->with('translations')
            ->orderBy('id', 'desc')
            ->get();

        return view('dashboard.admin.diamond_codes.create', [
            'pageTitle' => 'إضافة كود',
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        // If admin didn't choose a product (or there is only one), auto-select.
        $codesProductIds = Product::query()
            ->where('service_type', 'codes')
            ->pluck('id');

        $productId = $request->input('product_id');
        if (! $productId && $codesProductIds->count() === 1) {
            $productId = $codesProductIds->first();
        }

        $request->merge(['product_id' => $productId]);

        $data = $request->validate([
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(fn ($q) => $q->where('service_type', 'codes')),
            ],
            // One code (single) OR multiple codes (one per line)
            'code' => ['nullable', 'string', 'max:500'],
            'codes' => ['nullable', 'string', 'max:20000'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'images.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        $singleCode = trim((string) ($data['code'] ?? ''));
        $bulkCodesText = trim((string) ($data['codes'] ?? ''));

        if ($singleCode === '' && $bulkCodesText === '') {
            return back()->withErrors(['code' => 'ضع كود واحد أو مجموعة أكواد (كل كود بسطر).'])->withInput();
        }

        Storage::disk('public')->makeDirectory('diamond-codes');

        // Bulk mode
        if ($bulkCodesText !== '') {
            $lines = preg_split("/\\r\\n|\\r|\\n/", $bulkCodesText) ?: [];
            $codes = [];
            foreach ($lines as $line) {
                $c = trim($line);
                if ($c !== '') {
                    $codes[] = $c;
                }
            }

            $codes = array_values(array_unique($codes));
            if (count($codes) === 0) {
                return back()->withErrors(['codes' => 'لا يوجد أكواد صالحة داخل النص.'])->withInput();
            }

            $existing = DiamondCode::query()
                ->whereIn('code', $codes)
                ->pluck('code')
                ->all();

            if (! empty($existing)) {
                return back()->withErrors(['codes' => 'بعض الأكواد موجودة مسبقًا: '.implode(', ', array_slice($existing, 0, 5)).(count($existing) > 5 ? '...' : '')])->withInput();
            }

            $images = $request->file('images', []);

            foreach ($codes as $idx => $codeValue) {
                $imagePath = null;
                if (isset($images[$idx]) && $images[$idx] && $images[$idx]->isValid()) {
                    $imagePath = Storage::disk('public')->putFile('diamond-codes', $images[$idx]);
                }

                DiamondCode::create([
                    'product_id' => $product->id,
                    'code' => $codeValue,
                    'image_path' => $imagePath,
                    'status' => 'available',
                ]);
            }

            return redirect()->route('admin.diamond_codes.index')->with('success', 'تمت إضافة '.count($codes).' كود بنجاح.');
        }

        // Single mode
        if (DiamondCode::query()->where('code', $singleCode)->exists()) {
            return back()->withErrors(['code' => 'هذا الكود موجود مسبقًا.'])->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = Storage::disk('public')->putFile('diamond-codes', $request->file('image'));
        }

        DiamondCode::create([
            'product_id' => $product->id,
            'code' => $singleCode,
            'image_path' => $imagePath,
            'status' => 'available',
        ]);

        return redirect()->route('admin.diamond_codes.index')->with('success', 'تم إضافة الكود بنجاح.');
    }

    public function image(DiamondCode $diamondCode)
    {
        abort_if(! $diamondCode->image_path, 404);
        abort_if(! Storage::disk('public')->exists($diamondCode->image_path), 404);

        return Storage::disk('public')->response($diamondCode->image_path);
    }

    public function destroy(DiamondCode $diamondCode)
    {
        if ($diamondCode->status === 'delivered') {
            return back()->withErrors(['error' => 'لا يمكن حذف كود تم تسليمه.']);
        }

        if ($diamondCode->image_path) {
            Storage::disk('public')->delete($diamondCode->image_path);
        }

        $diamondCode->delete();

        return back()->with('success', 'تم حذف الكود.');
    }
}

