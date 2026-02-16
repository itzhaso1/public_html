<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ManualPaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManualPaymentController extends Controller
{
    public function index()
    {
        $requests = ManualPaymentRequest::query()
            ->with(['product', 'user'])
            ->latest()
            ->paginate(30);

        return view('dashboard.admin.manual_payments.index', [
            'pageTitle' => 'طلبات الدفع اليدوي',
            'requests' => $requests,
        ]);
    }

    public function show(ManualPaymentRequest $manualPaymentRequest)
    {
        $manualPaymentRequest->load(['product', 'user']);

        return view('dashboard.admin.manual_payments.show', [
            'pageTitle' => 'تفاصيل طلب الدفع اليدوي',
            'mpr' => $manualPaymentRequest,
            'receiptUrl' => $manualPaymentRequest->receipt_path
                ? Storage::disk('public')->url($manualPaymentRequest->receipt_path)
                : null,
        ]);
    }

    public function approve(Request $request, ManualPaymentRequest $manualPaymentRequest)
    {
        $request->validate([
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $manualPaymentRequest->update([
            'status' => 'approved',
            'approved_at' => now(),
            'admin_note' => $request->input('admin_note'),
        ]);

        return redirect()
            ->route('admin.manual_payments.show', $manualPaymentRequest)
            ->with('success', 'تمت الموافقة على الطلب.');
    }

    public function reject(Request $request, ManualPaymentRequest $manualPaymentRequest)
    {
        $request->validate([
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $manualPaymentRequest->update([
            'status' => 'rejected',
            'admin_note' => $request->input('admin_note'),
        ]);

        return redirect()
            ->route('admin.manual_payments.show', $manualPaymentRequest)
            ->with('success', 'تم رفض الطلب.');
    }
}

