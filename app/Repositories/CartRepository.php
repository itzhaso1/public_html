<?php

namespace  App\Repositories;

use App\Models\{Cart, Product, User, Coupon};
use App\Services\Contracts\CartInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth, Cookie};
use Illuminate\Support\{Str,Collection};
class CartRepository implements CartInterface {
    protected $items;
    protected $coupon;

    public function __construct() {
        $this->items = collect([]);
        if (session()->has('applied_coupon')) {
            $coupon = Coupon::find(session('applied_coupon'));
            if ($coupon) {
                $this->coupon = $coupon;
            }
        }
    }
    public function get() : Collection {
        if(!$this->items->count())
            $this->items = Cart::with(['product'])->get();
        return $this->items;
    }
    public function add(Product $product, $quantity = 1) {
        $item = Cart::where('product_id', $product->id)->first();
        if(!$item) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product?->id,
                'quantity' => $quantity,
            ]);
            $this->get()->push($cart);
        } else {
            return $item->increment('quantity', $quantity);
        }
    }

    public function update($id, $quantity) {
        Cart::whereId($id)->update([
            'quantity' => $quantity,
        ]);
    }

    public function delete($id) {
        Cart::whereId($id)->delete();
    }

    public function empty() {
        Cart::where('user_id', Auth::id())->delete();
    }

    public function total(): float {
        return $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    public function applyCoupon(Coupon $coupon) {
        $this->coupon = $coupon;
        return $this->calculateDiscountedTotal();
    }

    protected function calculateDiscountedTotal(): float {
        $total = $this->total();
        if (!$this->coupon) {
            return $total;
        }
        if ($this->coupon->status !== 'active') return $total;
        if ($this->coupon->starts_at && now()->lt($this->coupon->starts_at)) return $total;
        if ($this->coupon->expires_at && now()->gt($this->coupon->expires_at)) return $total;
        if ($this->coupon->min_spend && $total < $this->coupon->min_spend) return $total;
        if ($this->coupon->max_spend && $total > $this->coupon->max_spend) return $total;
        $cartItems = $this->get();
        $eligibleItems = $cartItems->filter(function ($item) {
            $product = $item->product;
            if ($this->coupon->products->contains($product)) return true;
            if ($this->coupon->categories->intersect($product->categories)->isNotEmpty()) return true;
            if ($this->coupon->products->count() === 0 && $this->coupon->categories->count() === 0) return true;
            return false;
        });
        $excludedItems = $cartItems->filter(function ($item) {
            $product = $item->product;
            if ($this->coupon->excludedProducts->contains($product)) return true;
            if ($this->coupon->excludedCategories->intersect($product->categories)->isNotEmpty()) return true;
            return false;
        });
        $eligibleTotal = $eligibleItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        $excludedTotal = $excludedItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        $discountableTotal = $eligibleTotal - $excludedTotal;
        if ($this->coupon->type === 'fixed') {
            $discount = $this->coupon->value;
        } elseif ($this->coupon->type === 'percentage') {
            $discount = ($this->coupon->value / 100) * $discountableTotal;
        }
        return max(0, $total - $discount);
    }
}