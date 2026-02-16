@extends('dashboard.layouts.master')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-dropdown {
        text-align: right;
        direction: rtl;
        }
    </style>
@endsection

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')
    @include('dashboard.layouts.common._partial.messages')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle }}</span>
                    <span class="mt-1 text-muted fw-bold fs-7">{{ $pageTitle }}</span>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            
            <div class="py-3 card-body">
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>{{ __('site/site.coupon_code') }}</label>
                            <input type="text" name="code" class="form-control" required>
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.type') }}</label>
                            <select name="type" class="form-control">
                                <option value="fixed">{{ __('site/site.fixed') }}</option>
                                <option value="percentage">{{ __('site/site.percentage') }}</option>
                            </select>
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.value') }}</label>
                            <input type="number" name="value" class="form-control">
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.min_spend') }}</label>
                            <input type="number" name="min_spend" class="form-control">
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.max_spend') }}</label>
                            <input type="number" name="max_spend" class="form-control">
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.starts_at') }}</label>
                            <input type="date" name="starts_at" class="form-control">
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.expires_at') }}</label>
                            <input type="date" name="expires_at" class="form-control">
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.status') }}</label>
                            <select name="status" class="form-control">
                                <option value="active">{{ __('site/site.active') }}</option>
                                <option value="inactive">{{ __('site/site.inactive') }}</option>
                            </select>
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.select_products') }}</label>
                            <select name="products[]" id="applicable_products" class="form-control" multiple>
                                @foreach ($products as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.exclude_products') }}</label>
                            <select name="excluded_products[]" id="excluded_products" class="form-control" multiple>
                                @foreach ($products as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.select_categories') }}</label>
                            <select name="categories[]" id="applicable_categories" class="form-control" multiple>
                                @foreach ($categories as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="col-md-6">
                            <label>{{ __('site/site.exclude_categories') }}</label>
                            <select name="excluded_categories[]" id="excluded_categories" class="form-control" multiple>
                                @foreach ($categories as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            
                    <button type="submit" class="mt-3 btn btn-primary w-100">
                        {{ __('site/site.save_coupon') }}
                    </button>
                </form>
            </div>
            <!--begin::Body-->
        </div>
    @endsection

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#applicable_products').select2({
                    placeholder: "{{ __('site.select_products') }}",
                    width: '100%',
                    dropdownAutoWidth: true,
                    dropdownParent: $('#applicable_products').parent(),
                });
                $('#excluded_products').select2({
                    placeholder: "{{ __('site.exclude_products') }}",
                    width: '100%',
                    dropdownParent: $('#excluded_products').parent(),
                    dir: 'rtl',
                    dropdownAutoWidth: true,
                });
                $('#applicable_categories').select2({
                    placeholder: "{{ __('site.select_categories') }}",
                    width: '100%',
                    dropdownParent: $('#applicable_categories').parent(),
                    dir: 'rtl',
                    dropdownAutoWidth: true,
                });
                $('#excluded_categories').select2({
                    placeholder: "{{ __('site.exclude_categories') }}",
                    width: '100%',
                    dropdownParent: $('#excluded_categories').parent(),
                    dir: 'rtl',
                    dropdownAutoWidth: true,
                });
            });
        </script>
    @endpush
