@include('website.layouts.common.includes._tpl_start')
@include('website.layouts.common.includes._header')

@yield('content')
@include('website.layouts.common.includes._partials.message')
@include('website.layouts.common.includes._footer')
@include('website.layouts.common.includes._tpl_end')
