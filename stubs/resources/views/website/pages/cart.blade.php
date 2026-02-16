@extends('website.layouts.common.website')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
    <!-- rts cart area start -->
    <div class="rts-cart-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row g-5">
                <div class="order-2 col-xl-9 col-lg-12 col-md-12 col-12 order-xl-1 order-lg-2 order-md-2 order-sm-2">
                    <div class="rts-cart-list-area">
                        <div class="single-cart-area-list head">
                            <div class="product-main">
                                <P>{{ __('site/site.products') }}</P>
                            </div>
                            <div class="price">
                                <p>{{ __('site/site.price') }}</p>
                            </div>
                            <div class="quantity">
                                <p>{{ __('site/site.quantity') }}</p>
                            </div>
                            <div class="subtotal">
                                <p>{{ __('site/site.subtotal') }}</p>
                            </div>
                        </div>
                        @forelse($cart as $item)
                            <div class="single-cart-area-list main item-parent">
                                <div class="product-main-cart">
                                    <div class="close section-activation remove-from-cart" data-id="{{ $item['id'] }}">
                                        <i class="fa-regular fa-x"></i>
                                    </div>
                                    <div class="thumbnail">
                                        <img src="{{ $item['product']->getMediaUrl('product', $item['product'], null, 'media', 'product') }}"
                                            alt="{{ $item['product']['name'] }}">
                                    </div>
                                    <div class="information">
                                        <h6 class="title">{{ $item['product']['name'] }}</h6>
                                        <span>SKU: {{ $item['product']['sku'] ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="price">
                                    <p>{{ number_format($item['product']['price'], 2) }} {{ __('site/site.currency') }}
                                    </p>
                                </div>
                                <div class="quantity">
                                    <div class="quantity-edit">
                                        <input type="text" class="input item-quantity" data-id="{{ $item['id'] }}"
                                            data-product-id="{{ $item['product']['id'] }}"
                                            value="{{ $item['quantity'] }}">
                                        <div class="button-wrapper-action">
                                            <button class="button minus"><i class="fa-regular fa-chevron-down"></i></button>
                                            <button class="button plus">+<i class="fa-regular fa-chevron-up"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="subtotal">
                                    <p>{{ number_format($item['product']['price'] * $item['quantity'], 2) }}
                                        {{ __('site/site.currency') }}</p>
                                </div>
                            </div>
                        @empty
                            <br>
                            <p class="text-center text-danger">{{ __('site/site.cart_empty') }}</p>
                        @endforelse
                        <div class="bottom-cupon-code-cart-area">
                            {{--@if(count($cart) > 0)
                            <div class="bottom-cupon-code-cart-area d-flex justify-content-between align-items-center">
                                <a href="#" id="clear-cart" class="rts-btn btn-primary mr--50 clear-all-cart">
                                    {{ __('site/site.clear_all') }}
                                </a>
                                <div id="clear-cart-message" class="mt-3 text-success"></div>
                            </div>
                            @endif--}}
                            {{--<a href="#"  class="rts-btn btn-primary mr--50 clear-all-cart">{{ __('site/site.clear_all') }}</a>--}}
                        </div>
                    </div>
                </div>
                <div class="order-1 col-xl-3 col-lg-12 col-md-12 col-12 order-xl-2 order-lg-1 order-md-1 order-sm-1">
                    <div class="cart-total-area-start-right">
                        <h5 class="title">{{ __('site/site.cart_totals') }}</h5>
                        <div class="subtotal">
                            <span>{{ __('site/site.subtotal') }}</span>
                            <h6 class="price">{{ number_format($total, 2) }} {{ __('site/site.currency') }}</h6>
                        </div>
                        {{--<div class="shipping">
                            <span>{{ __('site/site.shipping') }}</span>
                            <ul>
                                <li>
                                    <input type="radio" id="f-option" name="selector">
                                    <label for="f-option">{{ __('site/site.free_shipping') }}</label>

                                    <div class="check"></div>
                                </li>

                                <li>
                                    <input type="radio" id="s-option" name="selector">
                                    <label for="s-option">{{ __('site/site.flat_rate') }}</label>

                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </li>

                                <li>
                                    <input type="radio" id="t-option" name="selector">
                                    <label for="t-option">{{ __('site/site.local_pickup') }}</label>

                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </li>

                                <li>
                                    <p>{{ __('site/site.shipping_note') }}</p>
                                    <p class="bold">{{ __('site/site.calculate_shipping') }}</p>
                                </li>
                            </ul>
                        </div>--}}
                        <div class="bottom">
                            <div class="wrapper">
                                <span>{{ __('site/site.subtotal') }}</span>
                                <h6 class="price">{{ number_format($total, 2) }} {{ __('site/site.currency') }}</h6>
                            </div>
                            <div class="button-area">
                                <a href="{{route('checkout')}}" class="rts-btn btn-primary">{{ __('site/site.proceed_to_checkout') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts cart area end -->
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.button.plus, .button.minus', function(e) {
                e.preventDefault();
                const updateCartUrlTemplate = @json(route('cart.update', ['cart' => 'ID']));
                const updatedSuccessfully = @json(__('site/site.cart_update_quantity_successfully'));
                const updatedError = @json(__('site/site.something_went_wrong'));
                const isPlus = $(this).hasClass('plus');
                const input = $(this).closest('.quantity-edit').find('.item-quantity');
                let quantity = parseInt(input.val()) || 1;
                quantity = isPlus ? quantity + 1 : Math.max(quantity - 1, 1);
                input.val(quantity);
                const productId = input.data('product-id');
                const cartId = input.data('id');
                $.ajax({
                    url: updateCartUrlTemplate.replace('ID', cartId),
                    method: 'PUT',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('.cart-total-area-start-right').text(response.total);
                        Swal.fire({
                            icon: 'success',
                            title: updatedSuccessfully,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        const price = parseFloat($(input).closest('.item-parent').find(
                            '.price p').text());
                        const newSubtotal = (price * quantity).toFixed(2);
                        $(input).closest('.item-parent').find('.subtotal p').text(
                            `${newSubtotal} {{ __('site/site.currency') }}`);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: updatedError,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });
            $(document).on('click', '.remove-from-cart', function(e) {
                e.preventDefault();

                const cartId = $(this).data('id');
                const deleteCartUrlTemplate = @json(route('cart.destroy', ['cart' => 'ID']));
                const removedSuccessfully = @json(__('site/site.cart_removed_successfully'));
                const removeError = @json(__('site/site.something_went_wrong'));

                Swal.fire({
                    title: @json(__('site/site.confirm_delete')),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: @json(__('site/site.yes_delete')),
                    cancelButtonText: @json(__('site/site.no'))
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteCartUrlTemplate.replace('ID', cartId),
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: removedSuccessfully,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $(`.remove-from-cart[data-id="${cartId}"]`).closest(
                                    '.item-parent').remove();
                                $('.cart-total-area-start-right').text(response.total);
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: removeError,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    } else {
                        return;
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById('clear-cart').addEventListener('click', function (e) {
            e.preventDefault();
    
            fetch('{{ route('cart.clear') }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // حذف كل المنتجات في الصفحة (عدل الكلاس حسب تصميمك)
                    document.querySelectorAll('.item-parent').forEach(el => el.remove());
    
                    // تصفير السعر
                    document.querySelectorAll('.price').forEach(el => el.textContent = '0.00');
    
                    // عرض رسالة
                    const msg = document.getElementById('clear-cart-message');
                    msg.textContent = data.message;
    
                    // إخفاء الرسالة بعد 3 ثواني
                    setTimeout(() => msg.textContent = '', 3000);
                }
            })
            .catch(err => console.error('Error clearing cart:', err));
        });
    </script>
@endpush
