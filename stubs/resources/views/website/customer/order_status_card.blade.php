{{-- كارت الحالة --}}
<div class="card text-white {{ $color }} mb-3" style="opacity: 0.6;">
    <div class="card-body text-center">
        <h3 class="card-title text-white">{{ $statusText }}</h3>
        <p class="card-text text-white">رقم الطلب: {{ $order->number }}</p>
    </div>
</div>

{{-- تفاصيل الطلب --}}
@include('website.customer.orders_details', [
    'order' => $order,
    'statusColors' => [
        'pending' => ['text' => 'قيد الانتظار', 'color' => 'secondary'],
        'processing' => ['text' => 'جارِ التجهيز', 'color' => 'info'],
        'delivering' => ['text' => 'جارِ التوصيل', 'color' => 'warning'],
        'completed' => ['text' => 'مكتمل', 'color' => 'success'],
    ],
    'pageTitle' => 'تفاصيل الطلب',
])
