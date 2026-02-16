@extends('dashboard.layouts.master')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
            </h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="py-3 card-body">
            <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-5 hover-scroll-x">
                        <div class="d-grid">
                            <ul class="nav nav-tabs flex-nowrap text-nowrap">
                                @foreach(config('laravellocalization.supportedLocales') as $key => $lang)
                                <li class="nav-item">
                                    <a class="nav-link
                                                                @if(app()->getLocale() == $key)
                                                                    btn btn-active-light btn-color-gray-600 btn-active-color-success rounded-bottom-0 active
                                                                @endif
                                                            " data-bs-toggle="tab" href="#{{ $key }}">
                                        {{ $lang['native'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        @foreach(config('laravellocalization.supportedLocales') as $key => $lang)
                        <div class="tab-pane fade @if($loop->index == 0) show active @endif" id="{{ $key }}" role="tabpanel"
                            aria-labelledby="{{ $key }}-tab">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="{{ $key }}[name]" class="form-label">
                                        {{ trans('dashboard/category.name') . ' / ' . $lang['native'] }}
                                    </label>
                                    <input type="text" id="{{ $key }}[name]" name="{{ $key }}[name]" class="form-control"
                                        placeholder="{{ trans('dashboard/category.category_name_placeholder') . ' / ' . $lang['native'] }}"
                                        value="{{ old($key.'.name', $tag->translate($key)->name ?? '') }}" required>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="gap-2 col-md-12 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100" style="flex: 1;">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
        <!--begin::Body-->
    </div>
    @endsection

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endpush
