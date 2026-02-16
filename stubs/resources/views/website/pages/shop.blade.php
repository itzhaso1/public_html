@extends('website.layouts.common.website')
@section('css')
<style>
    .subcategory-swiper {
        position: relative;
        padding: 20px 0;
    }

    .subcategory-swiper .swiper-slide {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .subcategory-swiper .swiper-slide a img {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .subcategory-swiper .swiper-slide:hover img {
        transform: scale(1.05);
    }

    .subcategory-swiper .swiper-button-next,
    .subcategory-swiper .swiper-button-prev {
        color: #3c3c3c;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        top: 35%;
        transform: translateY(-50%);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .subcategory-swiper .swiper-button-next {
        right: -20px;
    }

    .subcategory-swiper .swiper-button-prev {
        left: -20px;
    }

    @media (max-width: 768px) {

        .subcategory-swiper .swiper-button-next,
        .subcategory-swiper .swiper-button-prev {
            display: none;
        }
    }
</style>

<style>
    .quantity-ed {
        display: flex;
        align-items: center;
        max-width: 140px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f9f9f9;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .quantity-ed button {
        width: 35px;
        height: 38px;
        border: none;
        background-color: #eee;
        font-size: 18px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .quantity-ed button:hover {
        background-color: #ddd;
    }

    .quantity-ed input[type="number"] {
        width: 60px;
        height: 38px;
        border: none;
        text-align: center;
        font-size: 16px;
        background: transparent;
        outline: none;
        -moz-appearance: textfield;
    }

    .quantity-ed input::-webkit-outer-spin-button,
    .quantity-ed input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
@endsection

@section('pageTitle')
{{$pageTitle}}
@endsection

@section('content')
    <!-- shop[ grid sidebar wrapper -->
    <div class="shop-grid-sidebar-area rts-section-gap">
        <div class="container">
            <div class="row g-0">
                {{-- Sidebar Filters --}}
                <div class="col-xl-3 col-lg-12 pl--70 pl_lg--10 pl_sm--10 pl_md--5 rts-sticky-column-item">
                    <div class="sidebar-filter-main theiaStickySidebar">
                        <form method="GET" action="{{ route('shop.index') }}">

                            {{-- Price Filter --}}
                            <div class="single-filter-box">
                                <h5 class="title">تصفية حسب السعر</h5>
                                <div class="filterbox-body">
                                    <div class="price-input-area">
                                        <div class="half-input-wrapper">
                                            <div class="single">
                                                <label for="min_price">السعر الادنى</label>
                                                <input name="min_price" id="min_price" type="number" value="{{ request('min_price') ?? 0 }}">
                                            </div>
                                            <div class="single">
                                                <label for="max_price">السعر الاقصى</label>
                                                <input name="max_price" id="max_price" type="number" value="{{ request('max_price') ?? 1000 }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Categories Filter --}}
                            <div class="single-filter-box d-none d-lg-block">
                                <h5 class="title">{{trans('site/site.categories')}}</h5>
                                <div class="filterbox-body">
                                    <div class="category-wrapper">
                                        @foreach($categories as $category)
                                            <div class="single-category">
                                                <input
                                                    type="radio"
                                                    name="category_id"
                                                    id="cat{{ $category->id }}"
                                                    value="{{ $category->id }}"
                                                    {{ request('category_id') == $category->id ? 'checked' : '' }}
                                                >
                                                <label for="cat{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Brands Filter --}}
                            <div class="single-filter-box d-none d-lg-block">
                                <h5 class="title">{{trans('site/site.brands')}}</h5>
                                <div class="filterbox-body">
                                    <div class="category-wrapper">
                                        @foreach($brands as $brand)
                                            <div class="single-category">
                                                <input
                                                    type="radio"
                                                    name="brand_id"
                                                    id="brand{{ $brand->id }}"
                                                    value="{{ $brand->id }}"
                                                    {{ request('brand_id') == $brand->id ? 'checked' : '' }}
                                                >
                                                <label for="brand{{ $brand->id }}">
                                                    {{ $brand->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="gap-2 mt-2 single-filter-box d-flex justify-content-between">
                                <button type="submit" class="rts-btn btn-primary w-50">تطبيق</button>
                                <a href="{{ route('shop.index') }}" class="rts-btn btn-secondary w-50">اعاده</a>
                            </div>

                        </form>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="col-xl-9 col-lg-12">
                    <div class="tab-content" id="myTabContent">
                        <!-- Start SubCategory Swiper Filter -->
                        <div class="position-relative">
                            <!-- Swiper Container -->
                            @if($subcategories && $subcategories->isNotEmpty())
                            <div class="swiper subcategory-swiper mb-4">
                                <div class="swiper-wrapper">
                                    @foreach($subcategories as $subcategory)
                                    <div class="swiper-slide text-center">
                                        <a href="{{ route('shop.index', ['category_id' => $subcategory->id]) }}"
                                            class="text-decoration-none text-dark d-block">
                                            <img src="{{ $subcategory->getMediaUrl('category', $subcategory, null, 'media', 'category') }}"
                                                alt="{{ $subcategory->name }}"
                                                style="width: 90px; height: 90px; object-fit: cover; border-radius: 10px; margin: 0 auto;">
                                            <div class="mt-2 small">{{ $subcategory->name }}</div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- الأسهم --}}
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                            @endif
                        </div>
                        <!-- End SubCategory Swiper Filter -->
                        <div class="product-area-wrapper-shopgrid-list mt--20 tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="row g-4">
                                @forelse($products as $product)
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                        <div class="single-shopping-card-one">
                                            <div class="image-and-action-area-wrapper">
                                                <a href="{{ route('shop.product.show', $product->id) }}" class="thumbnail-preview">
                                                    <img src="{{ $product->getMediaUrl('product', $product, null, 'media', 'product') }}" alt="{{ $product->name }}">
                                                </a>
                                            </div>

                                            <div class="body-content">
                                                <a href="{{ route('shop.product.show', $product->id) }}">
                                                    <h4 class="title">{{ $product->name }}</h4>
                                                </a>
                                                <span class="availability">{{ $product->stock ?? '' }}</span>
                                                <div class="price-area">
                                                    <span class="current">${{ $product->price }}</span>
                                                    @if($product->price_before_discount)
                                                        <div class="previous">${{ $product->price_before_discount }}</div>
                                                    @endif
                                                </div>
                                                <div class="cart-counter-action">
                                                    <form action="{{ route('cart.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                                        <div class="flex-wrap gap-2 d-flex justify-content-between align-items-center">
                                                            <div class="gap-2 d-flex align-items-center">
                                                                <button type="button" class="p-2 btn btn-success rounded-circle" onclick="increaseQty(this)">+</button>

                                                                <input name="quantity" id="quantity" type="number" value="1" min="1"
                                                                    class="text-center form-control"
                                                                    style="width: 60px; height: 40px;">

                                                                <button type="button" class="p-2 btn btn-warning rounded-circle" onclick="decreaseQty(this)">−</button>
                                                            </div>
                                                            <button type="submit" class="gap-1 rts-btn btn-primary radious-sm with-icon d-flex align-items-center">
                                                                <span class="btn-text">اضف للسله</span>
                                                                <i class="fa-regular fa-cart-shopping"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p>No products found.</p>
                                    </div>
                                @endforelse
                            </div>

                            {{-- Pagination --}}
                            <div class="mt-4 row">
                                <div class="col-12 d-flex justify-content-center">
                                    {{ $products->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop[ grid sidebar wrapper end -->
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        function increaseQty(button) {
        const input = button.parentElement.querySelector('input[type="number"]');
        let current = parseInt(input.value) || 1;
        input.value = current + 1;
    }

    function decreaseQty(button) {
        const input = button.parentElement.querySelector('input[type="number"]');
        let current = parseInt(input.value) || 1;
        if (current > 1) {
            input.value = current - 1;
        }
    }
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".subcategory-swiper", {
                slidesPerView: 5,
                spaceBetween: 15,
                freeMode: true,
                grabCursor: true,
                breakpoints: {
                    320: { slidesPerView: 2 },
                    576: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    992: { slidesPerView: 5 },
                    1200: { slidesPerView: 6 },
                }
            });
        });
    document.addEventListener('DOMContentLoaded', function () {
        const subcategoryCount = {{ count($subcategories) }};
        const swiper = new Swiper('.subcategory-swiper', {
            slidesPerView: subcategoryCount >= 6 ? 6 : subcategoryCount,
            spaceBetween: 15,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: Math.min(subcategoryCount, 2.5),
                },
                576: {
                    slidesPerView: Math.min(subcategoryCount, 3.5),
                },
                768: {
                    slidesPerView: Math.min(subcategoryCount, 4),
                },
                992: {
                    slidesPerView: Math.min(subcategoryCount, 5),
                },
                1200: {
                    slidesPerView: Math.min(subcategoryCount, 6),
                },
            }
        });
    });
</script>
@endpush
