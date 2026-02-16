<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\Services\Contracts\ProductInterface;
use App\Models\Category;
use App\Models\Type;
use App\Models\Tag;

class PublicProductController extends Controller
{
    protected ProductInterface $productInterface;

    public function __construct(ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;
    }

    /**
     * عرض فورم نشر المنتج مباشرة
     */
    public function create()
    {
        return view('public.products.form', [
            'pageTitle' => 'نشر منتج',
            'data' => [
                'categories' => Category::all(),
                'types' => Type::all(),
                'tags' => Tag::all(),
            ],
        ]);
    }

    /**
     * حفظ المنتج
     */
    public function store(Request $request)
    {
        try {
            $this->productInterface->store($request);

            return redirect()
                ->route('home')
                ->with('success', 'تم نشر الحساب بنجاح');

        } catch (ValidationException $e) {

            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Throwable $e) {

            return redirect()
                ->route('home')
                ->with('error', 'حدث خطأ غير متوقع');
        }
    }
}
