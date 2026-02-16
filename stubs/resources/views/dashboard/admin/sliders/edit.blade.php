@extends('dashboard.layouts.master')

@section('pageTitle')
{{ $pageTitle }}
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{ $pageTitle . ' ' . $slider?->name}}</span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Form-->
        <div class="py-3 card-body">
            <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-5 hover-scroll-x">
                        <div class="d-grid">
                            <ul class="nav nav-tabs flex-nowrap text-nowrap">
                                @foreach(config('laravellocalization.supportedLocales') as $key=>$lang)
                                <li class="nav-item">
                                    <a class="nav-link @if($loop->first) btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 @endif"
                                        data-bs-toggle="tab" href="#{{ $key }}">{{ $lang['native'] }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        @foreach(config('laravellocalization.supportedLocales') as $key => $lang)
                        <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $key }}" role="tabpanel"
                            aria-labelledby="{{ $key }}-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="{{ $key }}[name]" class="form-label">
                                        {{ trans('dashboard/category.name') . ' / ' . $lang['native'] }}
                                    </label>
                                    <input type="text" name="{{ $key }}[name]" id="{{ $key }}[name]" class="form-control"
                                        value="{{ old($key.'.name', $slider->translate($key)->name ?? '') }}"
                                        placeholder="{{ trans('dashboard/category.category_name_placeholder') . ' / ' . $lang['native'] }}">
                                </div>
                                <div class="col-md-8">
                                    <label for="{{ $key }}[description]" class="form-label">
                                        {{ trans('dashboard/category.description') . ' / ' . $lang['native'] }}
                                    </label>
                                    <textarea name="{{ $key }}[description]" id="{{ $key }}[description]" rows="4"
                                        class="form-control">{{ old($key.'.description', $slider->translate($key)->description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-3 mb-3 text-center border rounded">
                            <label for="image" class="form-label fw-bold">الصوره</label>
                            <input class="form-control" type="file" name="slider" id="sliderInput" accept="image/*">
                            <div class="mt-2">
                                <img id="sliderPreview" src="{{ $slider->getMediaUrl('slider', $slider, null, 'media', 'slider', true) }}"
                                    alt="" width="100" style="cursor: pointer;" onclick="openImageModal(this.src, 'الصوره')">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">عرض الصورة</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="text-center modal-body">
                                <img id="popupImage" src="" class="rounded img-fluid"
                                    style="max-width: 100%; max-height: 80vh;">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-success w-100">حفظ</button>
            </form>
        </div>
        <!--end::Form-->
    </div>
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
