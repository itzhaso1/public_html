@extends('dashboard.layouts.master')

@section('pageTitle')
    {{$pageTitle}}
@endsection
@section('css')
@endsection
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="mb-5 card card-xxl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="pt-5 border-0 card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="mb-1 card-label fw-bolder fs-3">{{$pageTitle}}</span>
                </h3>
            </div>
            <!--end::Header-->

            <!--begin::Form-->
            <div class="py-3 card-body">
                @php
                $isEdit = isset($product);
                @endphp

                <form action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($isEdit) @method('PUT') @endif

                    {{-- اللغات --}}
                    @foreach (config('translatable.locales') as $locale)
                    <div class="form-group mb-3">
                        <label>اسم المنتج ({{ strtoupper($locale) }})</label>
                        <input type="text" name="{{ $locale }}[name]" class="form-control"
                            value="{{ old($locale . '.name', $product?->translateOrNew($locale)->name ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>الوصف المختصر ({{ strtoupper($locale) }})</label>
                        <textarea name="{{ $locale }}[short_description]"
                            class="form-control">{{ old($locale . '.short_description', $product?->translateOrNew($locale)->short_description ?? '') }}</textarea>
                    </div>
                    @endforeach

                    {{-- بيانات عامة --}}
                    <div class="form-group mb-3">
                        <label>Slug</label>
                        <input type="text" name="slug" class="form-control" value="{{ old('slug', $product?->slug ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>التصنيف</label>
                        <select name="category_id" class="form-control">
                            @foreach($data['categories'] as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id ?? '') ==
                                $category->id)>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>العلامة التجارية</label>
                        <select name="brand_id" class="form-control">
                            <option value="">بدون</option>
                            @foreach($data['brands'] as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id', $product?->brand_id ?? '') == $brand->id)>
                                {{ $brand->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>النوع</label>
                        <select name="type_id" class="form-control">
                            <option value="">اختر النوع</option>
                            @foreach($data['types'] as $type)
                            <option value="{{ $type->id }}" @selected(old('type_id', $product?->type_id ?? '') == $type->id)>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>الوسوم (Tags)</label>
                        <select name="tags[]" class="form-control">
                            @foreach($data['tags'] as $tag)
                            <option value="{{ $tag->id }}" @if(isset($product) && $product?->tags->pluck('id')->contains($tag->id)) selected
                                @endif>
                                {{ $tag->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>السعر قبل الخصم</label>
                        <input type="number" step="0.01" name="price_before_discount" class="form-control"
                            value="{{ old('price_before_discount', $product->price_before_discount ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>السعر</label>
                        <input type="number" step="0.01" name="price" class="form-control"
                            value="{{ old('price', $product->price ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>الكمية المتاحة</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>SKU</label>
                        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku ?? '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label>الحالة</label>
                        <select name="status" class="form-control">
                            <option value="draft" @selected(old('status', $product->status ?? '') == 'draft')>مسودة</option>
                            <option value="published" @selected(old('status', $product->status ?? '') == 'published')>منشور</option>
                            <option value="archived" @selected(old('status', $product->status ?? '') == 'archived')>مؤرشف</option>
                        </select>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured" {{ old('featured',
                            $product->featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured">مميز؟</label>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-3 mb-3 text-center border rounded">
                                <label for="productInput" class="form-label fw-bold">الصورة</label>

                                <input class="form-control" type="file" name="product" id="productInput" accept="image/*">

                                <div class="mt-2">
                                    <img id="productPreview"
                                        src="{{ isset($product) && $product->getMediaUrl('product', $product, null, 'media', 'product', true) ? $product->getMediaUrl('product', $product, null, 'media', 'product', true) : asset('assets/images/no-image.png') }}"
                                        alt="صورة المنتج" width="100" style="cursor: pointer;" onclick="openImageModal(this.src, 'الصورة')">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="p-3 mb-3 text-center border rounded">
                                    <label for="galleryInput" class="form-label fw-bold">الصور الفرعية (Gallery)</label>

                                    <input class="form-control" type="file" name="gallery[]" id="galleryInput" accept="image/*" multiple>

                                    <div class="mt-2 d-flex flex-wrap justify-content-center gap-2">
                                        @if(isset($product))
                                        @php
                                        // نجلب الصور من الدالة الجديدة بعد التعديل
                                        $galleryImages = $product->getMultipleMediaUrls('products/gallery', $product, 'gallery');
                                        @endphp

                                        @foreach($galleryImages as $img)
                                        <img src="{{ $img['original'] }}" alt="صورة فرعية" width="100" class="rounded border" style="cursor:pointer;"
                                            onclick="openImageModal(this.src, 'صورة فرعية')">
                                        @endforeach
                                        @endif
                                    </div>
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
                    <!-- Video Upload Field -->
                    <div class="col-md-12 mb-3">
                        <label for="video" class="form-label">الفيديو</label>
                        <input type="file" name="video" id="video" class="dropify" data-allowed-file-extensions="mp4 avi mov wmv mkv"
                            data-max-file-size="50M" accept="video/*">
                        @if(isset($product) && $product->videos->count() > 0)
                        <div class="mt-2">
                            <small class="text-muted">الفيديو الحالي:</small>
                            @foreach($product->videos as $video)
                            <div class="d-flex align-items-center mt-1">
                                <span class="badge bg-info">{{ $video?->video_name }}</span>

                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <button class="btn btn-primary" type="submit">{{ $isEdit ? 'تحديث' : 'حفظ' }}</button>
                </form>
            </div>
            <!--end::Form-->
        </div>
    </div>
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
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
previewImage("productInput", "productPreview");
</script>
@endpush
@endsection
