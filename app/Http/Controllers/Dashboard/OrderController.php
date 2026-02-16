<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Services\ERP\ERPService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Dashboard\General\OrderDataTable;
use App\Services\Contracts\OrderInterface;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
class OrderController extends Controller {
    protected $erpService;

    public function __construct(ERPService $erpService)
    {
        $this->erpService = $erpService;
    }
    public function index(OrderDataTable $dataTable) {
        return $dataTable->render('dashboard.general.orders.index', ['pageTitle' => 'الطلبات']);
    }

    public function changeStatus(Request $request) {
        $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'status' => ['required', Rule::in(['pending', 'processing', 'delivering', 'completed', 'canceled', 'refunded'])],
        ]);

        $order = Order::findOrFail($request->order_id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح',
        ]);
    }

    public function changePaymentStatus(Request $request) {
        $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'payment_status' => ['required', 'in:pending,paid,failed'],
        ]);
        $order = Order::findOrFail($request->order_id);
        $order->payment_status = $request->payment_status;
        $order->save();
        return response()->json([
            'message' => 'تم تحديث حالة الدفع بنجاح',
        ]);
    }

    public function show($id) {
        $order = Order::with([
            'user',
            'coupon',
            'addresses',
            'products',
            'products.category',
            'products.brand',
            'products.sections'
        ])->findOrFail($id);

        $statusColors = [
            'pending'     => ['text' => 'قيد الانتظار', 'color' => 'secondary'],
            'processing'  => ['text' => 'جارِ التجهيز', 'color' => 'info'],
            'delivering'  => ['text' => 'جارِ التوصيل', 'color' => 'warning'],
            'completed'   => ['text' => 'مكتمل', 'color' => 'success'],
        ];
        //dd($order->products);
        return view('dashboard.general.orders.show', [
            'order' => $order,
            'statusColors' => $statusColors, 
            'pageTitle' => 'تفاصيل الطلب'
        ]);
    }

    public function generate($id)
    {
        $order = Order::with([
            'user',
            'coupon',
            'addresses',
            'products.category',
            'products.brand',
            'products.sections',
        ])->findOrFail($id);

        $pdf = PDF::loadView('dashboard.general.orders.invoices', [
            'order' => $order,
            'locale' => app()->getLocale(),
            'logo' => public_path('assets/images/logo.png'), // أو مسار شعارك
            'site_name' => config('app.name'),
            'site_url' => config('app.url'),
            'site_phone' => config('settings.phone'), // لو عندك إعدادات
            'site_email' => config('settings.email'), // لو عندك إعدادات
        ]);

        return $pdf->stream("invoice-{$order->number}.pdf");
    }

    public function sendOrderToERP($orderId)
    {
        $order = Order::with(['order_items', 'order_addresses', 'coupon'])->findOrFail($orderId);

        $result = $this->erpService->sendOrder($order);

        if ($result['success']) {
            return response()->json(['message' => 'Order sent to ERP successfully', 'response' => $result['json']]);
        }

        return response()->json(['error' => 'Failed to send order to ERP', 'details' => $result], 500);
    }
}