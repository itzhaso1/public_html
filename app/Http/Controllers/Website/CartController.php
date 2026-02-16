<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product, Category, Coupon};
use App\Services\Contracts\CartInterface;
use Cart;
class CartController extends Controller {
    public function __construct(protected CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;
    }
    public function index() {
        $items = $this->cartInterface->get();
        $total = $this->cartInterface->total();
        $couponId = session('coupon_id');
        $discountedTotal = null;
        if ($couponId) {
            $coupon = Coupon::find($couponId);
            if ($coupon) {
                $discountedTotal = $this->cartInterface->applyCoupon($coupon);
            }
        }
        $categories = Category::with(['translations', 'media', 'children.translations'])
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        return view('website.pages.cart')->with([
            'total' => $total,
            'categories' => $categories,
            'cart' => $items,
            'pageTitle' => trans('site/site.cart'),
            'breadcrumbs' => [
                ['title' => trans('site/site.cart')],
            ]
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1']
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        $this->cartInterface->add($product, $request->post('quantity'));
        return redirect()->back()->with([
            'success' => trans('site/site.product_add_successfully')
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1']
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        return $this->cartInterface->update($product, $request->post('quantity'));
    }

    public function destroy($id) {
        return $this->cartInterface->delete($id);
    }

    public function applyCoupon(Request $request) {
        $coupon = Coupon::where('code', $request->coupon_code)->first();
        if (!$coupon) {
            return response()->json(['error' => 'الكوبون غير صالح'], 400);
        }
        session()->put('coupon_id', $coupon->id);
        $discountedTotal = $this->cartInterface->applyCoupon($coupon);
        return response()->json([
            'message' => 'تم تطبيق الكوبون بنجاح',
            'discounted_total' => $discountedTotal,
            'total' => $this->cartInterface->total(),
        ]);
    }

    public function clearCart(Request $request) {
        $this->cartInterface->empty();
        //session()->forget('applied_coupon');
        return response()->json([
            'success' => true,
            'message' => 'تم تفريغ السلة بنجاح.'
        ]);
    }

}