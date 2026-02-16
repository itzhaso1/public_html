<div class="weekly-best-selling-area rts-section-gap bg_light-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-between">
                    <h2 class="title-left">{{ $section->name }}</h2>
                    <ul class="nav nav-tabs best-selling-grocery" id="myTab-{{ $section->id }}" role="tablist">
                        @foreach($section->categories as $index => $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                    id="tab-{{ $category->id }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#category-{{ $category->id }}"
                                    type="button" role="tab"
                                    aria-controls="category-{{ $category->id }}"
                                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                    {{ $category->name }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{-- المحتوى --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="myTabContent-{{ $section->id }}">
                    @foreach($section->categories as $index => $category)
                        <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                            id="category-{{ $category->id }}"
                            role="tabpanel"
                            aria-labelledby="tab-{{ $category->id }}">

                            <div class="row g-4">
                                @php
                                    $filteredProducts = [];
                                    if ($section->categories->contains('id', $category->id)) {
                                        $filteredProducts = $section->products;
                                    }
                                @endphp

                                @forelse($filteredProducts as $product)
                                    <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                        <div class="single-shopping-card-one">
                                            <!-- image and actions -->
                                            <div class="image-and-action-area-wrapper">
                                                <a href="{{ route('shop.product.show', $product->id) }}" class="thumbnail-preview">
                                                    <div class="badge">
                                                        <span>{{ $product?->discount_percent }}% <br>Off</span>
                                                        <i class="fa-solid fa-bookmark"></i>
                                                    </div>
                                                    <img src="{{ $product->getMediaUrl('product', $product, null, 'media', 'product') }}" alt="{{ $product->name }}">
                                                </a>
                                                <div class="action-share-option">
                                                    <span class="single-action openuptip cta-quickview product-details-popup-btn"
                                                        data-flow="up" title="Quick View">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- body -->
                                            <div class="body-content">
                                                <a href="{{ route('shop.product.show', $product->id) }}">
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
                                                <form action="{{route('cart.store')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <div class="cart-counter-action">
                                                        <div class="quantity-edit">
                                                            <input type="text" name="quantity" class="input" value="1" min="1">
                                                            <div class="button-wrapper-action">
                                                                <button type="button" class="button"><i class="fa-regular fa-chevron-down"></i></button>
                                                                <button type="button" class="button plus">+<i class="fa-regular fa-chevron-up"></i></button>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="rts-btn btn-primary radious-sm with-icon">
                                                            <div class="btn-text">{{trans('site/site.add')}}</div>
                                                            <div class="arrow-icon">
                                                                <i class="fa-regular fa-cart-shopping"></i>
                                                            </div>
                                                        </b>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">لا توجد منتجات في هذا التصنيف حالياً.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
