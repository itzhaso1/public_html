@extends('website.layouts.common.website')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
    .single-input label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    }
    
    .coupon-row {
    display: flex;
    flex-direction: row-reverse;
    gap: 10px;
    align-items: center;
    }
    
    #coupon_code {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    }
    
    #apply-coupon-btn {
    background-color: #027D9D;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
    white-space: nowrap;
    }
    
    #apply-coupon-btn:hover {
    background-color: #026a86;
    }
</style>
@endsection

@section('pageTitle')
{{ $pageTitle }}
@endsection

@section('content')
<div class="checkout-area rts-section-gap">
    <div class="container">
        <div class="row">
            <div class="order-2 col-lg-8 pr--40 pr_md--5 pr_sm--5 order-xl-1 order-lg-2 order-md-2 order-sm-2 mt_md--30 mt_sm--30">
                <!-- Start Billing -->
                <div class="rts-billing-details-area">
                    <h3 class="title">معلومات الشحن</h3>
                    <form action="{{route('checkout')}}" method="POST">
                        @csrf
                        <div class="single-input">
                            <label for="coupon_code">أدخل كود الخصم</label>
                            <div class="coupon-row">
                                <input id="coupon_code" name="coupon_code" type="text" placeholder="ادخل الكود هنا" />
                                <button type="submit" id="apply-coupon-btn">تطبيق الكوبون</button>
                            </div>
                        </div>
                        <div id="coupon-message" style="margin-top: 10px; color: red;"></div>
                        <div class="single-input">
                            <label for="email">البريد الالكترونى*</label>
                            <input id="email" name="addr[billing][email]" type="text" />
                        </div>
                        <div class="half-input-wrapper">
                            <div class="single-input">
                                <label for="f-name">الاسم الاول*</label>
                                <input id="f-name" name="addr[billing][first_name]" type="text" required />
                            </div>
                            <div class="single-input">
                                <label for="l-name">الاسم الاخير*</label>
                                <input id="l-name" name="addr[billing][last_name]" type="text" />
                            </div>
                        </div>
                        <div class="single-input">
                            <label for="street">عنوان الشحن*</label>
                            <input name="addr[billing][street]" type="text" required />
                        </div>
                        <div class="single-input">
                            <label for="phone">رقم الهاتف*</label>
                            <input id="phone" name="addr[billing][phone]" type="text" />
                        </div>
                        <div class="single-input">
                            <label for="ordernotes">ملاحظات*</label>
                            <textarea name="addr[billing][order_notes]" id="ordernotes"></textarea>
                        </div>
                        <button type="submit" class="rts-btn btn-primary">تاكيد الطلب</button>
                    </form>
                </div>
                <!-- End Billing -->
            </div>
            <!-- Start Your Order -->
            <div class="order-1 col-lg-4 order-xl-2 order-lg-1 order-md-1 order-sm-1">
                <h3 class="title-checkout">الطلب</h3>
                <div class="right-card-sidebar-checkout">
                    <div class="top-wrapper">
                        <div class="product"></div>
                        <div class="price">السعر</div>
                    </div>
                    <div class="single-shop-list">
                        <div class="left-area">
                            <span style="font-weight: 600; color: #2c3c28">السعر الاجمالى:</span>
                        </div>
                        <span class="checkout-total price" id="checkout-total" style="color: #629d23">{{$total}}</span>
                    </div>
                </div>
            </div>
            <!-- End Your Order -->
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('apply-coupon-btn').addEventListener('click', function () {
        const code = document.getElementById('coupon_code').value;
        fetch('{{ route('checkout.apply-coupon') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ coupon_code: code })
        })
        .then(res => res.json())
        .then(data => {
            const messageEl = document.getElementById('coupon-message');
            if (data.success) {
                document.getElementById('checkout-total').textContent = data.discounted_total + ' EGP';
                messageEl.style.color = 'green';
                messageEl.textContent = 'تم تطبيق الكوبون بنجاح 🎉';
            } else {
                messageEl.style.color = 'red';
                messageEl.textContent = data.message;
            }
            setTimeout(() => {
                    messageEl.textContent = '';
                }, 4000);
        });
    });
</script>
@endpush