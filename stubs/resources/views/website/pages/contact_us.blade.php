@extends('website.layouts.common.website')
@section('css')
@endsection

@section('pageTitle')
{{ $pageTitle }}
@endsection

@section('content')

<!-- rts contact main wrapper -->
<div class="rts-contact-main-wrapper-banner bg_image">
    <div class="container">
        <div class="row">
            <div class="co-lg-12">
                <div class="contact-banner-content">
                    <h1 class="title">
                        {{$contact?->title}}
                    </h1>
                    <p class="disc">
                        {{$contact?->description}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- rts contact main wrapper end -->

<div class="rts-map-contact-area rts-section-gap2">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="contact-left-area-main-wrapper">
                    <h2 class="title">
                        {{$contact?->content_title}}
                    </h2>
                    <p class="disc">
                        {{$contact?->content_description}}
                    </p>
                    <div class="location-single-card">
                        <div class="icon">
                            <i class="fa-light fa-location-dot"></i>
                        </div>
                        <div class="information">
                            <h3 class="title">{{$settings?->name}}</h3>
                            <p>{{$settings?->description}}</p>
                            <a href="#" class="number">{{$settings?->phone}}</a>
                            <a href="#" class="email">{{$settings?->email}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 pr--50 pr_sm--5 pr_md--5">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14602.288851207937!2d90.47855065!3d23.798243149999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1716725338558!5m2!1sen!2sbd"
                    width="600" height="540" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- rts contact-form area start -->

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