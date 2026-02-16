<?php

namespace App\Http\Controllers\Website\Customer;

use App\Http\Controllers\Controller;
use App\Models\ManualPaymentRequest;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function index(Request $request)
    {
        $requests = ManualPaymentRequest::query()
            ->where('user_id', auth()->id())
            ->with(['product', 'diamondCode'])
            ->latest()
            ->paginate(20);

        return view('website.customer.purchases', [
            'pageTitle' => 'مشترياتي',
            'requests' => $requests,
        ]);
    }
}

