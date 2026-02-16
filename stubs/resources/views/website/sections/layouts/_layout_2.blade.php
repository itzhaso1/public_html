<div class="rts-grocery-feature-area rts-section-gapBottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-between">
                    <h2 class="title-left">
                        {{ $section->name }}
                    </h2>
                    <div class="countdown">
                        <div class="countDown"></div>
                    </div>
                </div>
            </div>
        </div>
        @if($section->products->count())
        <div class="row">
            <div class="col-lg-12">
                <div class="product-with-discount">
                    <div class="row g-5">
                        {{-- اليسار: أول منتجين --}}
                        <div class="col-xl-4 col-lg-12">
                            @foreach($section->products->take(2) as $product)
                            <a href="#"
                                class="single-discount-with-bg {{ $loop->index == 1 ? 'bg-2' : '' }}">
                                <div class="inner-content">
                                    <h4 class="title">{{ $product->name }}</h4>
                                    <div class="price-area">
                                        <span>Only</span>
                                        <h4 class="title">
                                            {{ number_format($product->price, 2) }} {{ config('app.currency', '$') }}
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>

                        {{-- اليمين: باقي المنتجات --}}
                        <div class="col-xl-8 col-lg-12">
                            <div class="row">
                                @foreach($section->products->skip(2) as $product)
                                <div class="col-lg-6">
                                    <div class="single-shopping-card-one discount-offer">
                                        <a href="{{ route('shop.product.show', $product->id) }}}" class="thumbnail-preview">
                                            <div class="badge">
                                                <span>{{ $product->discount_percent ?? '10%' }} <br>Off</span>
                                                <i class="fa-solid fa-bookmark"></i>
                                            </div>
                                            <img src="{{ $product->getMediaUrl('product', $product, null, 'media', 'product') }}"
                                                alt="{{ $product->name }}">
                                        </a>
                                        <div class="body-content">
                                            <a href="{{ route('shop.product.show', $product->id) }}">
                                                <h4 class="title">{{ $product->name }}</h4>
                                            </a>
                                            <span class="availability">{{ $product->stock ?? '' }}</span>
                                            <div class="price-area">
                                                <span class="current">{{ number_format($product->price, 2) }} {{
                                                    config('app.currency', '$') }}</span>
                                                @if($product->old_price)
                                                <div class="previous">{{ number_format($product->price_before_discount, 2) }} {{
                                                    config('app.currency', '$') }}</div>
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
                                                            <button type="button" class="button plus"><i
                                                                    class="fa-regular fa-chevron-up"></i></button>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="rts-btn btn-primary radious-sm with-icon">
                                                        <div class="btn-text">{{trans('site/site.add')}}</div>
                                                        <div class="arrow-icon"><i class="fa-regular fa-cart-shopping"></i>
                                                        </div>
                                                        <div class="arrow-icon"><i class="fa-regular fa-cart-shopping"></i>
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
</div>
