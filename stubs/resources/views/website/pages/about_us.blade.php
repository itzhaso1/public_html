@extends('website.layouts.common.website')
@section('css')
@endsection

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
    <!-- rts banner area about -->
    <div class="about-banner-area-bg rts-section-gap bg_iamge">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content-about-area">
                        <h1 class="title">{{$about?->title}}</h1>
                        <p class="disc">
                            {{$about?->description}}
                        </p>
                        <a href="{{route('contact')}}" class="rts-btn btn-primary">{{trans('site/site.contact_us')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts banner area about end -->

    <!-- rts counter area start -->
    <div class="rts-counter-area">
        <div class="container-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="counter-area-main-wrapper">
                        @forelse($aboutCounters as $aboutCounter)
                            <div class="single-counter-area">
                                <h2 class="title"><span class="counter">{{$aboutCounter?->description}}</span>M+</h2>
                                <p>
                                    {{$aboutCounter?->name}}
                                </p>
                            </div>
                        @empty

                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts counter area end -->

    <!-- about area start -->
    <div class="rts-about-area rts-section-gap2">
        <div class="container-3">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="thumbnail-left">
                        <img src="{{$aboutImg}}" alt="{{$about?->title}}">
                    </div>
                </div>
                <div class="col-lg-8 pr--60 pr_md--10 pt_md--30 pr_sm--10 pt_sm--30">
                    <div class="about-content-area-1">
                        <h2 class="title">
                            {{$about?->content_title}}
                        </h2>
                        <p class="disc">
                            {{$about?->content_description}}
                        </p>
                        <div class="check-main-wrapper">
                            <div class="single-check-area">
                                {{$about?->content_note}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->

    <!-- section-seperator start -->
    <div class="section-seperator">
        <div class="container-3">
            <hr class="section-seperator">
        </div>
    </div>
    <!-- section-seperator start -->
@endsection

@push('js')
@endpush
