<div class="order-details-page container py-5">
    <h2 class="mb-4">{{ $pageTitle }}</h2>
    {{-- معلومات الطلب --}}
    <div class="card mb-4">
        <div class="card-header">
            رقم الطلب: {{ $order->number }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>الحالة:</strong>
                        <span class="badge bg-{{ $statusColors[$order->status]['color'] ?? 'secondary' }}">
                            {{ $statusColors[$order->status]['text'] ?? $order->status }}
                        </span>
                    </p>
                </div>
                <div class="col-md-4">
                    <p><strong>العميل:</strong> {{ $order->user?->name }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>رقم الهاتف:</strong>
                         @foreach($order->addresses as $address)
                            {{ $address->phone }}
                        @endforeach
                    </p>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>الكوبون:</strong> {{ $order->coupon?->code ?? 'لا يوجد' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>الاجمالى:</strong> {{ $order->total_price ?? 'لا يوجد' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">عنوان التوصيل</div>
        <div class="card-body">
            @foreach($order->addresses as $address)
            <p>{{ $address->street }}</p>
            @endforeach
        </div>
    </div>

    {{-- المنتجات --}}
    <div class="card">
        <div class="card-header">المنتجات</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الصورة</th>
                        <th>اسم المنتج</th>
                        <th>القسم</th>
                        <th>العلامة التجارية</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->products as $product)
                    <tr>
                        <td><img src="{{ $product->getMediaUrl('product', $product, null, 'media', 'product') }}" width="50" alt=""></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category?->name }}</td>
                        <td>{{ $product->brand?->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->price }} {{ config('app.currency') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>