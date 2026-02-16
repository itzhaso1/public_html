<div class="rts-navigation-area-breadcrumb bg_light-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="navigator-breadcrumb-wrapper">
                    <a href="{{ route('home') }}">{{ trans('site/site.home_page_title') }}</a>
                    @if (!empty($breadcrumbs) && is_array($breadcrumbs))
                        @foreach ($breadcrumbs as $breadcrumb)
                            <i class="fa-regular fa-chevron-right"></i>

                            @if (!empty($breadcrumb['url']))
                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                            @else
                                <a class="current">{{ $breadcrumb['title'] }}</a>
                            @endif
                        @endforeach
                    @elseif (!empty($pageTitle))
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current">{{ $pageTitle }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
