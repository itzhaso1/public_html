<?php
namespace App\Services\Services\ERP;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
class ERPService {
    protected string $url;
    protected string $connectionString;
    public function __construct() {
        $this->url = config('services.erp.url');
        $this->connectionString = config('services.erp.connection_string');
    }
    public function testConnection(): array {
        $payload = [
            'proName' => 'Api_Website_InsertProducts',
            'par' => new \stdClass(),
            'constr' => $this->connectionString,
        ];
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->url, $payload);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'الاتصال شغال ✅',
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'فشل الاتصال ❌ - كود الخطأ: ' . $response->status(),
                'data' => $response->body()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'فشل الاتصال ❌ - ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function sendProducts(array $products): array {
        $payload = [
            'proName' => 'Api_Website_InsertProducts',
            'par' => [
                'Products' => $products,
            ],
            'constr' => $this->connectionString,
        ];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->url, $payload);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'raw' => $response->body(),
                'json' => json_decode($response->body(), true),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'فشل الإرسال ❌ - ' . $e->getMessage(),
                'data' => []
            ];
        }
    }

    public static function formatProductsForERP($products) {
        $formatted = [];
        foreach ($products as $product) {
            $formatted[] = [
                'SKU' => $product->sku,
                'ItemNameArabic' => $product->translations->where('locale', 'ar')->first()?->name ?? '',
                'ItemNameEnglish' => $product->translations->where('locale', 'en')->first()?->name ?? '',
                'CategoryNameArabic' => $product->category?->translations->where('locale', 'ar')->first()?->name ?? '',
                'UnitName' => $product->type instanceof \App\Models\Type
                    ? $product->type->translations->where('locale', 'ar')->first()?->name
                    : '',
                'Price' => $product->price,
                'Stock' => $product->stock,
                'ItemID' => $product->id,
            ];
        }
        return $formatted;
    }

    /*public function sendOrder(Order $order): array {
        $hdr = [
            [
                'OrderID' => $order->id,
                'CustomerID' => $order->user_id ?? 0,
                'OrderNumber' => $order->number,
                'PaymentStatus' => $order->payment_status,
                'PaymentType' => $order->payment_type,
                'TotalPrice' => (float) $order->total_price,
                'NetPrice' => (float) $order->total_price, // لو فيه خصومات حسب الحاجة
                'CreatedAt' => $order->created_at->format('Y-m-d H:i:s.u'),
                'Note' => $order->addresses()->where('type', 'billing')->first()->order_notes ?? '',
                'CustomerName' => trim(($order->addresses()->where('type', 'billing')->first()->first_name ?? '') . ' ' . ($order->addresses()->where('type', 'billing')->first()->last_name ?? '')),
                'CustomerPhone' => $order->addresses()->where('type', 'billing')->first()->phone ?? '',
                'CustomerAddress' => trim(
                    ($order->addresses()->where('type', 'billing')->first()->city ?? '') . ' - ' .
                        ($order->addresses()->where('type', 'billing')->first()->street ?? '')
                ),
                'CouponType' => $order->coupon?->type ?? '',
                'CouponValue' => $order->coupon?->value ?? 0,
                'CouponCode' => $order->coupon?->code ?? '',
            ]
        ];

        $dtl = $order->order_items->map(function ($item) use ($order) {
            return [
                'OrderID' => $order->id,
                'ItemID' => $item->product_id,
                'Quantity' => $item->quantity,
                'ItemPrice' => (float) $item->product_price,
                'TotalPrice' => (float) ($item->product_price * $item->quantity),
            ];
        })->toArray();

        $payload = [
            'proName' => 'Api_Website_Order_Insert',
            'par' => [
                'hdr' => $hdr,
                'dtl' => $dtl,
            ],
            'constr' => $this->connectionString,
        ];

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->url, $payload);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'raw' => $response->body(),
                'json' => json_decode($response->body(), true),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'فشل الإرسال ❌ - ' . $e->getMessage(),
                'data' => []
            ];
        }
    }*/

    public function sendOrder(Order $order): array {
        $hdr = [
            [
                'OrderID' => $order->id,
                'CustomerID' => $order->user_id ?? 0,
                'OrderNumber' => $order->number,
                'PaymentStatus' => $order->payment_status,
                'PaymentType' => $order->payment_type,
                'TotalPrice' => (float) $order->total_price,
                'NetPrice' => (float) $order->total_price,
                'CreatedAt' => $order->created_at->format('Y-m-d H:i:s.u'),
                'Note' => $order->addresses()->where('type', 'billing')->first()->order_notes ?? '',
                'CustomerName' => trim(($order->addresses()->where('type', 'billing')->first()->first_name ?? '') . ' ' . ($order->addresses()->where('type', 'billing')->first()->last_name ?? '')),
                'CustomerPhone' => $order->addresses()->where('type', 'billing')->first()->phone ?? '',
                'CustomerAddress' => trim(
                    ($order->addresses()->where('type', 'billing')->first()->city ?? '') . ' - ' .
                        ($order->addresses()->where('type', 'billing')->first()->street ?? '')
                ),
                'CouponType' => $order->coupon?->type ?? '',
                'CouponValue' => $order->coupon?->value ?? 0,
                'CouponCode' => $order->coupon?->code ?? '',
            ]
        ];

        $dtl = $order->order_items->map(function ($item) use ($order) {
            return [
                'OrderID' => $order->id,
                'ItemID' => $item->product_id,
                'Quantity' => $item->quantity,
                'ItemPrice' => (float) $item->product_price,
                'TotalPrice' => (float) ($item->product_price * $item->quantity),
            ];
        })->toArray();

        $payload = [
            'proName' => 'Api_Website_Order_Insert',
            'par' => [
                'hdr' => $hdr,
                'dtl' => $dtl,
            ],
            'constr' => $this->connectionString,
        ];

        // هنا اطبع JSON في اللوغ أو في الconsole:
        \Log::info('ERP Payload:', $payload);
        // أو ترجع response في حالة التطوير فقط (لو عندك متغير env)
        // return response()->json($payload);

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->url, $payload);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'raw' => $response->body(),
                'json' => json_decode($response->body(), true),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'فشل الإرسال ❌ - ' . $e->getMessage(),
                'data' => []
            ];
        }
    }
}