@extends('dashboard.layouts.master')

@section('css')
<link rel="stylesheet" type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<style>
    /* ✅ تحسين التناسق على الهواتف */
    @media (max-width: 992px) {
        .card-title span {
            font-size: 1.1rem !important;
        }
        #kt_content_container {
            padding: 0 10px !important;
        }
        .card {
            margin-bottom: 1rem;
        }
    }

    @media (max-width: 576px) {
        .card-title span {
            display: block;
            text-align: center;
            line-height: 1.6;
        }
        .card-body {
            text-align: center;
            font-size: 14px;
        }
    }
</style>
@endsection

@section('pageTitle')
    {{ $PageTitle }}
@endsection

@section('content')
@include('dashboard.layouts.common._partial.messages')

<div id="kt_content_container" class="container-fluid px-3 px-md-5">
    <div class="card card-xxl-stretch mb-5 mb-xl-8 shadow-sm">
        <!--begin::Header-->
        <div class="card-header border-0 pt-4 pb-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h3 class="card-title align-items-start flex-column mb-3 mb-md-0">
                <span class="card-label fw-bolder fs-3 mb-1 text-center text-md-start">
                    <span style="color: #aecb53;">
                        {{ $PageTitle . ' فــرع ' . get_user_data()?->branch?->name }}
                    </span>
                    <br>
                    <span style="color: #804d28; font-size: 0.9rem;">
                        {{ get_user_data()?->branch?->address }}
                    </span>
                </span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-4 text-center text-md-start">
            <h5 class="fw-bold mb-0 text-secondary">
                {{ 'لوحه تحكم ' . get_user_data()?->name }}
            </h5>
        </div>
        <!--end::Body-->
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endsection
