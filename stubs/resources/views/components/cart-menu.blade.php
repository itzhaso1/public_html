<div class="btn-border-only cart category-hover-header">
    <i class="fa-sharp fa-regular fa-cart-shopping"></i>
    <span class="text">{{ trans('site/site.my_cart') }}</span>
    <div class="category-sub-menu card-number-show">
        <h5 class="shopping-cart-number">
            {{ trans('site/site.shopping_cart') }} ({{ count($items) }})
        </h5>
        @foreach($items as $item)
        <div class="cart-item-1 border-top">
            <div class="img-name">
                <div class="thumbanil">
                    <img src="{{ $item->product->getMediaUrl('product', $item->product, null, 'media', 'product') }}" alt="{{ $item->product->name }}">
                </div>
                <div class="details">
                    <a href="{{ route('shop.product.show', $item->product->id) }}">
                        <h5 class="title">
                            {{ $item->product->name }}
                        </h5>
                    </a>
                    <div class="number">
                        {{ $item->quantity }} <i class="fa-regular fa-x"></i>
                        <span>{{ number_format($item->product->price, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="close-c1">
                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-0 m-0 bg-transparent border-0 btn">
                        <i class="fa-regular fa-x"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
        <div class="sub-total-cart-balance">
            <div class="bottom-content-deals mt--10">
                <div class="top">
                    <span>{{ __('site/site.subtotal') }}:</span>
                    <span class="number-c">${{ number_format($total, 2) }}</span>
                </div>
                <div class="button-wrapper d-flex align-items-center justify-content-between">
                    <a href="{{ route('cart') }}" class="rts-btn btn-primary">{{trans('site/site.cart')}}</a>
                    <a href="{{ route('checkout') }}" class="rts-btn btn-primary border-only">{{trans('site/site.checkout')}}</a>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('cart') }}" class="over_link"></a>
</div>
