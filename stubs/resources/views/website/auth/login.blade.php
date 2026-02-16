@extends('website.layouts.common.website')
@section('css')

@endsection

@section('pageTitle')
{{$pageTitle}}
@endsection

@section('content')
    <div class="rts-register-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="registration-wrapper-1">
                        <div class="logo-area mb--0">
                            <img class="mb--10" src="{{ $logo }}" alt="logo">
                        </div>
                        <h3 class="title">{{trans('site/site.login_to_your_account')}}</h3>
                        <form action="{{ route('auth.login.submit') }}" method="POST" class="registration-form">
                            @csrf
                            <div class="input-wrapper">
                                <label for="email">{{trans('site/site.email')}}*</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="input-wrapper">
                                <label for="password">{{trans('site/site.password')}}*</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <button class="rts-btn btn-primary">{{trans('site/site.login_to_your_account')}}</button>
                            <div class="another-way-to-registration">
                                <p><a href="{{ route('auth.register') }}">
                                    {{trans('site/site.register_new_account')}}    
                                </a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush
