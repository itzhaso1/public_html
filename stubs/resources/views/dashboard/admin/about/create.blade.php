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
            <form action="{{ route('admin.about.store') }}" method="POST" enctype="multipart/form-data">
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
                                            value="{{old($key.'.title', $about?->translate($key)?->title)}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{ __('Short Description') }} / {{ $lang['native'] }}</label>
                                        <input type="text" name="{{ $key }}[short_description]" class="form-control"
                                            value="{{old($key.'.short_description', $about?->translate($key)?->short_description)}}">
                                    </div>

                                    <div class="col-md-12">
                                        <label>{{ __('Description') }} / {{ $lang['native'] }}</label>
                                        <textarea name="{{ $key }}[description]" rows="3" class="form-control">
                                            {{old($key.'.description', $about?->translate($key)?->description)}}
                                        </textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{ __('Content Title') }} / {{ $lang['native'] }}</label>
                                        <input type="text" name="{{ $key }}[content_title]" class="form-control"
                                            value="{{old($key.'.content_title', $about?->translate($key)?->content_title)}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>{{ __('Content Note') }} / {{ $lang['native'] }}</label>
                                        <input type="text" name="{{ $key }}[content_note]" class="form-control"
                                            value="{{old($key.'.content_title', $about?->translate($key)?->content_title)}}">
                                    </div>

                                    <div class="col-md-12">
                                        <label>{{ __('Content Description') }} / {{ $lang['native'] }}</label>
                                        <textarea name="{{ $key }}[content_description]" rows="3" class="form-control">
                                            {{old($key.'.content_description', $about?->translate($key)?->content_description)}}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3 mb-3 text-center border rounded">
                                    <label for="image" class="form-label fw-bold">الصوره</label>
                                    <input class="form-control" type="file" name="about" id="sliderInput" accept="image/*">
                                    <div class="mt-2">
                                        <img id="sliderPreview" src="" alt="" width="100" style="cursor: pointer;"
                                            onclick="openImageModal(this.src, 'الصوره')">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel">عرض الصورة</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="text-center modal-body">
                                        <img id="popupImage" src="" class="rounded img-fluid" style="max-width: 100%; max-height: 80vh;">
                                    </div>
                                </div>
                            </div>
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
