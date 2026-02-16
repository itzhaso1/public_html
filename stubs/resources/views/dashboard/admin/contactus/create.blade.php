@extends('dashboard.layouts.master')

@section('css')

@endsection

@section('pageTitle')
{{$pageTitle}}
@endsection

@section('content')
@include('dashboard.layouts.common._partial.messages')
<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{$pageTitle}}</span>
                <span class="mt-1 text-muted fw-bold fs-7">{{$pageTitle}}</span>
            </h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="py-3 card-body">
            <form action="{{ route('admin.contact.store') }}" method="POST">
                @csrf
                <div class="container p-4 mt-2 bg-white rounded shadow">
                    <div class="row">
                        <div class="mb-5 hover-scroll-x">
                            <div class="d-grid">
                                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                                    @foreach(config('laravellocalization.supportedLocales') as $key => $lang)
                                    <li class="nav-item">
                                        <a class="nav-link @if(app()->getLocale() == $key) active @endif"
                                            data-bs-toggle="tab" href="#{{ $key }}">
                                            {{ $lang['native'] }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content" id="myTabContent">
                            @foreach(config('laravellocalization.supportedLocales') as $key => $lang)
                            <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $key }}"
                                role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label>{{ __('Title') }} / {{ $lang['native'] }}</label>
                                        <input type="text" name="{{ $key }}[title]" class="form-control"
                                            value="{{old($key.'.title', $contactUs?->translate($key)?->title)}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{ __('Short Description') }} / {{ $lang['native'] }}</label>
                                        <input type="text" name="{{ $key }}[short_description]" class="form-control"
                                            value="{{old($key.'.description', $contactUs?->translate($key)?->description)}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{ __('Content Title') }} / {{ $lang['native'] }}</label>
                                        <input type="text" name="{{ $key }}[content_title]" class="form-control"
                                            value="{{old($key.'.content_title', $contactUs?->translate($key)?->content_title)}}">
                                    </div>

                                    <div class="col-md-12">
                                        <label>{{ __('Content Description') }} / {{ $lang['native'] }}</label>
                                        <textarea name="{{ $key }}[content_description]" rows="3" class="form-control">
                                            {{old($key.'.content_description', $contactUs?->translate($key)?->content_description)}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="mt-4 btn btn-success w-100">حفظ</button>
                </div>
            </form>
        </div>
        <!--begin::Body-->
    </div>
    @endsection

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endpush
