@extends('website.layouts.common.website')

@section('pageTitle')
{{ $pageTitle }}
@endsection

@section('content')
    <!-- privacy policy area start -->
    <div class="rts-pricavy-policy-area rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container-privacy-policy">
                        <h1 class="title mb--40">{{ $pageTitle }}</h1>

                        @foreach($privacy as $item)
                            @php
                                $translation = $item->translate(app()->getLocale());
                                $title = $translation->title ?? '';
                                $description = $translation->description ?? [];
                            @endphp

                            @if($title)
                                <h2 class="title mt--40">{{ $title }}</h2>
                            @endif

                            @if(is_array($description) && count($description))
                                <ul class="section-list">
                                    @foreach($description as $point)
                                        <li>
                                            <p>{{ $point }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="disc text-muted">لا توجد تفاصيل متاحة</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- privacy policy area end -->
@endsection