@extends('dashboard.layouts.master')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('pageTitle')
    عرض تفاصيل الطلب
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle .' (' . $order?->number .')'}}</span>
                    <span class="mt-1 text-muted fw-bold fs-7"> عرض تفاصيل الطلب</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="py-3 card-body">
                <!-- Start Accordion -->
                <div class="accordion" id="orderAccordion">
                
                    {{-- بيانات العميل والحالة --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCustomer">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustomer"
                                aria-expanded="true">
                                بيانات العميل والحالة
                            </button>
                        </h2>
                        <div id="collapseCustomer" class="accordion-collapse collapse show" data-bs-parent="#orderAccordion">
                            <div class="accordion-body">
                                <p><strong>العميل:</strong> {{ $order->user->name }}</p>
                                <p><strong>الحالة:</strong>
                                    <span class="badge bg-{{ $statusColors[$order->status]['color'] ?? 'secondary' }}">
                                        {{ $statusColors[$order->status]['text'] ?? $order->status }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                
                    {{-- تفاصيل الطلب --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDetails">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDetails">
                                تفاصيل الطلب
                            </button>
                        </h2>
                        <div id="collapseDetails" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                            <div class="accordion-body">
                                <p><strong>الإجمالي:</strong> {{ number_format($order->total_price, 2) }} ر.س</p>
                                <p><strong>الكوبون:</strong> {{ $order->coupon?->code ?? 'لا يوجد' }}</p>
                            </div>
                        </div>
                    </div>
                
                    {{-- المنتجات --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingProducts">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseProducts">
                                المنتجات
                            </button>
                        </h2>
                        <div id="collapseProducts" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>الصورة</th>
                                            <th>المنتج</th>
                                            <th>السعر</th>
                                            <th>الكمية</th>
                                            <th>التصنيف</th>
                                            <th>القسم</th>
                                            <th>العلامة التجارية</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->products as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ $product->getMediaUrl('product', $product, null, 'media', 'product') }}" alt="Product Image"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            </td>
                                            <td>{{ $product->pivot->product_name ?? $product->name }}</td>
                                            <td>{{ number_format($product->pivot->product_price, 2) }} ر.س</td>
                                            <td>{{ $product->pivot->quantity }}</td>
                                            <td>{{ $product->category?->name ?? '—' }}</td>
                                            <td>
                                                @foreach($product->sections as $section)
                                                <span class="badge bg-info">{{ $section->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $product->brand?->name ?? '—' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                    {{-- العناوين --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingAddresses">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseAddresses">
                                العناوين
                            </button>
                        </h2>
                        <div id="collapseAddresses" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                            <div class="accordion-body">
                                @foreach($order->addresses as $address)
                                <p><strong>{{ $address->type }}:</strong> {{ $address->first_name }} {{ $address->last_name }} - {{
                                    $address->city }}, {{ $address->country }} - {{ $address->phone }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Accordion -->
            </div>
            <!--end::Body-->
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endpush
