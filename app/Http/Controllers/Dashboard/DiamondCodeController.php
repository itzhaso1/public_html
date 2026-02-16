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
            'pageTitle' => 'أكواد الجواهر',
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
            'pageTitle' => 'إضافة كود جواهر',
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
            'code' => ['required', 'string', 'max:500', 'unique:diamond_codes,code'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        $imagePath = null;
        if ($request->hasFile('image')) {
            Storage::disk('public')->makeDirectory('diamond-codes');
            $imagePath = Storage::disk('public')->putFile('diamond-codes', $request->file('image'));
        }

        DiamondCode::create([
            'product_id' => $product->id,
            'code' => trim($data['code']),
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

