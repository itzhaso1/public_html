<!-- rts grocery feature area start -->
<div class="rts-grocery-feature-area rts-section-gapBottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-between">
                    <h2 class="title-left">
                        {{ $section->name }}
                    </h2>
                    <div class="next-prev-swiper-wrapper">
                        <div class="swiper-button-prev swiper-button-prev-{{ $index }}"><i
                                class="fa-regular fa-chevron-left"></i></div>
                        <div class="swiper-button-next swiper-button-next-{{ $index }}"><i
                                class="fa-regular fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($section->products->count())
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="category-area-main-wrapper-one">
                    @php
                    $productCount = $section->products->count();
                    $slidesPerView = $productCount < 6 ? $productCount : 6; $loop=$productCount> $slidesPerView;
                        $swiperOptions = [
                        'spaceBetween' => 16,
                        'slidesPerView' => $slidesPerView,
                        'loop' => $loop,
                        'speed' => 700,
                        'navigation' => [
                        'nextEl' => ".swiper-button-next-{$index}",
                        'prevEl' => ".swiper-button-prev-{$index}",
                        ],
                        'breakpoints' => [
                        '0' => ['slidesPerView' => 1, 'spaceBetween' => 12],
                        '320' => ['slidesPerView' => 1, 'spaceBetween' => 12],
                        '480' => ['slidesPerView' => 2, 'spaceBetween' => 12],
                        '640' => ['slidesPerView' => 2, 'spaceBetween' => 16],
                        '840' => ['slidesPerView' => 3, 'spaceBetween' => 16],
                        '1140' => ['slidesPerView' => 5, 'spaceBetween' => 16],
                        '1540' => ['slidesPerView' => 5, 'spaceBetween' => 16],
                        '1840' => ['slidesPerView' => 6, 'spaceBetween' => 16],
                        ]
                        ];
                        @endphp
                        <div class="swiper mySwiper-category-1 mySwiper-category-{{ $index }} swiper-data"
                            data-swiper='@json($swiperOptions)'>
                            <div class="swiper-wrapper">
                                @foreach($section->products as $product)
                                <div class="swiper-slide">
                                    <div class="single-shopping-card-one">
                                        <div class="image-and-action-area-wrapper">
                                            <a href="{{ route('shop.product.show', $product->id) }}"
                                                class="thumbnail-preview">
                                                <img src="{{ $product->getMediaUrl('product', $product, null, 'media', 'product') }}"
                                                    alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        <div class="body-content">
                                            <a href="{{ route('shop.product.show', $product->id) }}">
                                                <h4 class="title">{{ $product->name }}</h4>
                                            </a>
                                            <span class="availability">{{ $product->stock }}</span>
                                            <div class="price-area">
                                                <span class="current">${{ $product->price }}</span>
                                                @if($product->price_before_discount)
                                                <div class="previous">${{ $product->price_before_discount }}</div>
                                                @endif
                                            </div>
                                            <form action="{{route('cart.store')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="cart-counter-action">
                                                    <div class="quantity-edit">
                                                        <input type="text" name="quantity" class="input" value="1" min="1">
                                                        <div class="button-wrapper-action">
                                                            <button type="button" class="button"><i
                                                                    class="fa-regular fa-chevron-down"></i></button>
                                                            <button type="button" class="button plus">+<i
                                                                    class="fa-regular fa-chevron-up"></i></button>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="rts-btn btn-primary radious-sm with-icon">
                                                        <div class="btn-text">{{trans('site/site.add')}}</div>
                                                        <div class="arrow-icon">
                                                            <i class="fa-regular fa-cart-shopping"></i>
                                                        </div>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- rts grocery feature area end -->
