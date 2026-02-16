<div class="search-header-area-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="logo-search-category-wrapper">
                    <a href="{{route('home')}}" class="logo-area">
                        <img src="{{$logo}}" alt="logo-main" class="logo" style="max-width: 100px; height: auto;">
                    </a>
                    <div class="category-search-wrapper">
                        {{--<div class="category-btn category-hover-header">
                            <img class="parent" src="{{asset('assets/images/icons/bar-1.svg')}}" alt="icons">
                            <span>{{ trans('site/site.categories') }}</span>
                            <ul class="category-sub-menu" id="category-active-four">
                                @foreach($categories as $category)
                                <li>
                                    <a href="#" class="menu-item">
                                        <img src="{{ $category->getMediaUrl('category', $category, null, 'media', 'category') ?? asset('assets/images/icons/default.svg') }}" style="max-width: 25px; max-height: 25px; object-fit: cover; border-radius: 5px;" alt="{{$category->name}}">
                                        <span>{{ $category->name }}</span>
                                        @if($category->children->isNotEmpty())
                                        <i class="fa-regular fa-plus"></i>
                                        @endif
                                    </a>
                                    @if($category->children->isNotEmpty())
                                    <ul class="submenu mm-collapse">
                                        @foreach($category->children as $sub)
                                        <li><a class="mobile-menu-link" href="{{ route('shop.index', ['category_id' => $category->id]) }}">{{ $sub->name }}</a></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>--}}
                        <form action="#" class="search-header">
                            {{--<input type="text" placeholder="{{ trans('site/site.search_placeholder') }}" required>
                            <a href="#" class="rts-btn btn-primary radious-sm with-icon">
                                <div class="btn-text">
                                    {{ trans('site/site.search') }}
                                </div>
                                <div class="arrow-icon">
                                    <i class="fa-light fa-magnifying-glass"></i>
                                </div>
                                <div class="arrow-icon">
                                    <i class="fa-light fa-magnifying-glass"></i>
                                </div>
                            </a>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

