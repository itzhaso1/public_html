<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\ManualPaymentRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManualPaymentController extends Controller
{
    public function create(Product $product)
    {
        abort_unless(config('bank.enabled'), 404);

        return view('website.diamonds.manual_payment', [
            'product' => $product,
            'pageTitle' => 'الدفع اليدوي',
        ]);
    }

    public function store(Request $request, Product $product)
    {
        abort_unless(config('bank.enabled'), 404);

        $data = $request->validate([
            'player_id' => ['required', 'string', 'max:64'],
            'contact_phone' => ['nullable', 'string', 'max:64'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'receipt' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = Storage::disk('public')->putFile('manual-payments', $request->file('receipt'));
        }

        $mpr = ManualPaymentRequest::create([
            'reference' => (string) Str::uuid(),
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'player_id' => $data['player_id'],
            'contact_phone' => $data['contact_phone'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'amount' => (float) $product->price,
            'currency' => 'SAR',
            'receipt_path' => $receiptPath,
            'status' => 'pending',
            'ip' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 512, ''),
        ]);

        return redirect()->route('website.diamonds.manual_payment.thanks', ['reference' => $mpr->reference]);
    }

    public function thanks(string $reference)
    {
        $mpr = ManualPaymentRequest::query()
            ->where('reference', $reference)
            ->with(['product'])
            ->firstOrFail();

        return view('website.diamonds.manual_payment_thanks', [
            'mpr' => $mpr,
            'pageTitle' => 'تم استلام طلبك',
        ]);
    }
}

