    <div class="top-tranding-product rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-area-between">
                        <h2 class="title-left mb--10">
                            {{ $section->name }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cover-card-main-over">
                        <div class="row g-4">
                            @forelse ($section->products as $product)
                                <div class="col-xl-3 col-md-6 col-sm-12 col-12">
                                    <div class="single-shopping-card-one tranding-product">
                                        <a href="{{ route('shop.product.show', $product->id) }}" class="thumbnail-preview">
                                            <div class="badge">
                                                @if($product->discount_percent)
                                                    <span>{{ $product->discount_percent }}% <br>Off</span>
                                                @endif
                                                <i class="fa-solid fa-bookmark"></i>
                                            </div>
                                            <img src="{{ $product->getMediaUrl('product', $product, null, 'media', 'product') }}" alt="{{ $product->name }}">
                                        </a>
                                        <div class="body-content">
                                            <a href="#">
                                                <h4 class="title">{{ $product->name }}</h4>
                                            </a>
                                            @if($product->stock)
                                                <span class="availability">{{ $product->stock }}</span>
                                            @endif
                                            <div class="price-area">
                                                <span class="current">${{ $product->price }}</span>
                                                @if($product->price_before_discount)
                                                    <div class="previous">${{ $product->price_before_discount }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted">لا توجد منتجات حالياً.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
