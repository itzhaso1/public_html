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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.privacy.create') }}" class="btn btn-success">إضافة</a>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="py-3 card-body">
            <div class="container">
                
            
                @if($privacy->count())
                @foreach($privacy as $item)
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>رقم: {{ $item->id }}</strong>
                        <div>
                            <a href="{{ route('admin.privacy.edit', $item->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                            <form action="{{ route('admin.privacy.destroy', $item->id) }}" method="POST" style="display:inline-block;"
                                onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>
                        </div>
                    </div>
                
                    <div class="card-body">
                        @foreach(config('translatable.locales') as $locale)
                        <div class="border p-3 mb-3">
                            <h5>اللغة: {{ $locale == 'ar' ? 'العربية' : 'الإنجليزية' }}</h5>
                
                            <h4>{{ $item->translate($locale)->title ?? 'لا يوجد عنوان' }}</h4>
                
                            @php
                            $description = $item->translate($locale)->description ?? [];
                            @endphp
                
                            @if(is_array($description) && count($description))
                            <ul>
                                @foreach($description as $point)
                                <li>{{ $point }}</li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-muted">لا يوجد وصف</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                @else
                <div class="alert alert-info">
                    لا توجد سياسات خصوصية حالياً.
                </div>
                @endif
            </div>
        </div>
        <!--begin::Body-->
    </div>
    @endsection

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        function previewImage(inputId, previewId) {
        let input = document.getElementById(inputId);
        let preview = document.getElementById(previewId);

        input.addEventListener("change", function () {
            let file = input.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        });
    }
    function openImageModal(src, title) {
        if (src) {
            let popupImage = document.getElementById("popupImage");
            let modalTitle = document.getElementById("imageModalLabel");
            popupImage.src = src;
            modalTitle.innerText = title;
            let imageModal = new bootstrap.Modal(document.getElementById("imageModal"));
            imageModal.show();
        }
    }
    previewImage("sliderInput", "sliderPreview");
    </script>
    @endpush