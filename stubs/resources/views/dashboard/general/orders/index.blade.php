@extends('dashboard.layouts.master')

@section('css')

@endsection

@section('pageTitle')
{{$pageTitle}}
@endsection

@section('content')
@include('dashboard.layouts.common._partial.messages')
<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{$pageTitle}}</span>
            </h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="py-3 card-body">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-striped table-row-bordered gy-5 gs-7">
                    {!! $dataTable->table() !!}
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    @endsection

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {!! $dataTable->scripts() !!}
    <script>
        $(document).on('change', '.order-status-change', function () {
            let orderId = $(this).data('id');
            let newStatus = $(this).val();
    
            $.ajax({
                url: "{{ route('admin.orders.changeStatus') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: orderId,
                    status: newStatus
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحديث',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#orders_datatable').DataTable().ajax.reload(null, false);
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: xhr.responseJSON?.message || 'حدث خطأ أثناء التحديث',
                    });
                }
            });
        });
        $(document).on('change', '.payment-status-change', function () {
            let orderId = $(this).data('id');
            let newStatus = $(this).val();
            $.ajax({
                url: "{{ route('admin.orders.changePaymentStatus') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_id: orderId,
                    payment_status: newStatus
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحديث',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#orders_datatable').DataTable().ajax.reload(null, false);
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: xhr.responseJSON?.message || 'حدث خطأ أثناء التحديث',
                    });
                }
            });
        });
    </script>
    <script>
        document.getElementById('sendToErpBtn').addEventListener('click', function() {
            // خذ الـ order ID لو موجود في الصفحة، مثلاً من data attribute
            const orderId = '{{ $order->id ?? '' }}';  // تأكد إن عندك متغير order في البليد
    
            if (!orderId) {
                alert('Order ID not found!');
                return;
            }
    
            fetch(`/dashboard/orders/${orderId}/send-to-erp`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم الإرسال للـ ERP بنجاح');
                } else {
                    alert('فشل الإرسال: ' + (data.message || 'خطأ غير معروف'));
                }
            })
            .catch(error => {
                alert('حدث خطأ أثناء الإرسال');
                console.error(error);
            });
        });
    </script>
    @endpush
