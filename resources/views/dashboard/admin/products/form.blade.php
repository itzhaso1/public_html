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

               <form id="productForm"
      action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}"
      method="POST" enctype="multipart/form-data">

                    @csrf
                    @if($isEdit) @method('PUT') @endif

                    {{-- اللغات --}}
                   @foreach (config('translatable.locales') as $locale)
    @if($locale == 'ar')
        <div class="form-group mb-3">
            <label>اسم المنتج ({{ strtoupper($locale) }})</label>
            <input type="text" name="{{ $locale }}[name]" class="form-control"
                value="{{ old($locale . '.name', $product?->translateOrNew($locale)->name ?? '') }}">
        </div>

        <div class="form-group mb-3">
    <label>الوصف المختصر ({{ strtoupper($locale) }})</label>
    <textarea id="short_description_{{ $locale }}"
        name="{{ $locale }}[short_description]"
        class="form-control">{{ old($locale . '.short_description', $product?->translateOrNew($locale)->short_description ?? '') }}</textarea>
    <small id="char_count_{{ $locale }}" class="text-muted">0 / 35</small>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('short_description_{{ $locale }}');
    const counter = document.getElementById('char_count_{{ $locale }}');
    const max = 30;

    textarea.addEventListener('input', function() {
        if (this.value.length > max) {
            this.value = this.value.substring(0, max);
        }
        counter.textContent = this.value.length + " / " + max;
    });
});
</script>


       <div class="form-group mb-3">
    <label>الوصف الكامل ({{ strtoupper($locale) }})</label>
    <textarea name="{{ $locale }}[description]"
              class="form-control"
              rows="10"
              placeholder="اكتب الوصف الكامل هنا...">{{ old($locale . '.description', $product?->translateOrNew($locale)->description ?? '') }}</textarea>
</div>

    @endif
@endforeach


<div class="form-group mb-3">
    <label>رقم العميل</label>
    <input type="text" name="client_number" class="form-control"
           value="{{ old('client_number', $product->client_number ?? '') }}"
           placeholder="اكتب رقم العميل هنا">
</div>


                    {{-- بيانات عامة --}}
                    {{-- إخفاء حقل الـ Slug من الواجهة مع إبقائه في الكود --}}
<div class="form-group mb-3" style="display: none;">
    <label>Slug</label>
    <input type="text" name="slug" class="form-control"
           value="{{ old('slug', $product?->slug ?? '') }}">
</div>


                    {{-- إخفاء حقل التصنيف --}}
<div class="form-group mb-3" style="display: none;">
    <label>التصنيف</label>
    <select name="category_id" class="form-control">
        @foreach($data['categories'] as $category)
        <option value="{{ $category->id }}" @selected(old('category_id', $product?->category_id ?? '') == $category->id)>
            {{ $category->name }}
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

                  {{-- إخفاء حقل الوسوم من واجهة المستخدم --}}
<div class="form-group mb-3" style="display: none;">
    <label>الوسوم (Tags)</label>
    <select name="tags[]" class="form-control">
        @foreach($data['tags'] as $tag)
        <option value="{{ $tag->id }}" @if(isset($product) && $product?->tags->pluck('id')->contains($tag->id)) selected @endif>
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

                    {{-- إخفاء حقل الكمية المتاحة --}}
<div class="form-group mb-3" style="display: none;">
    <label>الكمية المتاحة</label>
    <input type="number" name="stock" class="form-control"
           value="{{ old('stock', $product->stock ?? '') }}">
</div>



                    <div class="form-group mb-3">
                        <label>الحالة</label>
                        <select name="status" class="form-control">
                            
                            <option value="published" @selected(old('status', $product->status ?? '') == 'published')>منشور</option>
                           
                        </select>
                    </div>




                    <div class="form-check mb-3">
                        <input type="checkbox" name="featured" value="1" class="form-check-input" id="featured" {{ old('featured',
                            $product->featured ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured"> مباع</label>
                    </div>
                
                
                
                
                
                
                    
                    
<div class="row">
    <!-- الصورة الرئيسية -->
    <div class="col-md-12 mb-4">
        <div class="border rounded shadow-sm p-4 bg-white text-center">
            <label for="productInput" class="form-label fw-bold text-dark fs-6 d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-image-fill fs-5 text-primary"></i>
                <span>الصورة الرئيسية</span>
            </label>

            <label for="productInput" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 mb-3">
                <i class="bi bi-cloud-upload-fill"></i>
                <span>رفع صورة</span>
            </label>

            <input class="d-none" type="file" name="product" id="productInput" accept="image/*">

            <div class="preview-container mt-3">
                <img id="productPreview"
                    src="{{ isset($product) && $product->getMediaUrl('product', $product, null, 'media', 'product', true)
                        ? $product->getMediaUrl('product', $product, null, 'media', 'product', true)
                        : asset('assets/images/no-image.png') }}"
                    alt="صورة المنتج"
                    class="rounded shadow-sm border"
                    style="max-width: 250px; max-height: 250px; object-fit: contain;
; cursor:pointer;"
                    onclick="openImageModal(this.src, 'الصورة')">
            </div>
        </div>
    </div>


<!-- الصور الفرعية (Gallery) -->
<div class="col-md-12 mb-4">
    <div class="border rounded shadow-sm p-4 bg-white">

        <label class="form-label fw-bold text-dark fs-6 d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-images fs-5 text-success"></i>
            الصور الفرعية
        </label>

        <div class="text-center mb-3">
    <label for="galleryInput" class="btn btn-outline-success d-inline-flex align-items-center gap-2">
        <i class="bi bi-cloud-arrow-up-fill"></i>
        رفع صور
    </label>
</div>


        <input
            type="file"
            name="gallery[]"
            id="galleryInput"
            class="d-none"
            accept="image/*"
            multiple
            onchange="previewGallery(this)"
        >

        {{-- الصور القديمة --}}
        @if(isset($product))
            @php
                $galleryImages = $product->getMultipleMediaUrls('products/gallery', $product, 'gallery');
            @endphp

            @if(count($galleryImages))
                <div class="row g-2 mb-3">
                    @foreach($galleryImages as $img)
                        <div class="col-4 col-md-2">
                            <img
                                src="{{ $img['original'] }}"
                                class="img-fluid rounded border shadow-sm"
                                style="height:90px; width:100%; object-fit:contain; background:#f8f9fa; cursor:pointer;"

                                onclick="openImageModal(this.src, 'صورة فرعية')"
                            >
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        {{-- الصور الجديدة --}}
        <div id="galleryPreview" class="row g-2 d-none"></div>

    </div>
</div>

                    
                    
                    
                    
     

</div>

<button class="btn btn-primary w-100 py-2" type="submit">{{ $isEdit ? 'تحديث المنتج' : 'حفظ المنتج' }}</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoInput = document.getElementById('video');
    const videoName = document.getElementById('videoName');
    const videoPreview = document.getElementById('videoPreview');
    const videoContainer = document.getElementById('videoPreviewContainer');

    videoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            videoName.textContent = "🎬 " + file.name;
            videoName.classList.remove('text-muted');
            videoName.classList.add('fw-bold', 'text-success');

            const videoURL = URL.createObjectURL(file);
            videoPreview.src = videoURL;
            videoContainer.style.display = 'block';
        } else {
            videoName.textContent = "لم يتم اختيار أي ملف بعد";
            videoName.classList.add('text-muted');
            videoContainer.style.display = 'none';
            videoPreview.src = '';
        }
    });
});
</script>


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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.querySelector('input[name="ar[name]"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            // نحول الاسم إلى slug
            let slug = nameInput.value
                .trim()
                .replace(/\s+/g, '-')        // نحول المسافات إلى -
                .replace(/[^\w\-ء-ي]+/g, '') // نحذف الرموز الغريبة
                .replace(/\-\-+/g, '-')      // نمنع التكرار
                .toLowerCase();
            
            // إذا الاسم فاضي، نحط قيمة افتراضية فريدة
            slugInput.value = slug || 'product-' + Date.now();
        });
    }
});
</script>


<!-- ✅ عداد رفع احترافي علوي -->
<style>
/* ✨ الخلفية العامة بتصميم زجاجي وفخم */
body {
  background: linear-gradient(135deg, #eef2f3 0%, #dfe9f3 100%);
  min-height: 100vh;
  font-family: "Tajawal", sans-serif;
}

/* 💎 الكارد الزجاجي */
.card {
  background: rgba(255, 255, 255, 0.85);
  border: none;
  border-radius: 20px;
  backdrop-filter: blur(10px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease-in-out;
}
.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
}

/* 🧊 العناوين */
.card-header h3 {
  color: #1e293b;
  font-weight: 800;
  text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* 🧠 مدخلات أنيقة */
.form-control, .form-select, textarea {
  background: rgba(255, 255, 255, 0.7);
  border: 1px solid rgba(0, 0, 0, 0.08);
  border-radius: 12px;
  padding: 12px 14px;
  box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.05);
  transition: all 0.25s ease-in-out;
  font-size: 15px;
}
.form-control:focus, .form-select:focus, textarea:focus {
  background: rgba(255, 255, 255, 0.95);
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
  transform: scale(1.01);
}

/* 📦 مربعات التحميل (الصور والفيديو) */
.border.rounded.shadow-sm.p-4.bg-white {
  background: linear-gradient(145deg, #ffffff, #f3f4f6);
  border: none !important;
  border-radius: 18px !important;
  box-shadow: 6px 6px 16px rgba(0, 0, 0, 0.05), -6px -6px 16px rgba(255, 255, 255, 0.6);
  transition: all 0.3s ease;
}
.border.rounded.shadow-sm.p-4.bg-white:hover {
  transform: translateY(-4px);
  box-shadow: 8px 8px 24px rgba(0, 0, 0, 0.08);
}

/* 🌈 أزرار أنيقة بتدرجات ثلاثية الأبعاد */
.btn {
  border: none;
  border-radius: 12px !important;
  font-weight: 600;
  letter-spacing: 0.3px;
  padding: 10px 18px !important;
  transition: all 0.25s ease;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
}

.btn-primary {
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  color: #fff !important;
}
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
}

.btn-outline-primary {
  background: transparent;
  border: 2px solid #3b82f6 !important;
  color: #2563eb !important;
}
.btn-outline-primary:hover {
  background: linear-gradient(135deg, #3b82f6, #2563eb);
  color: #fff !important;
  transform: translateY(-2px);
}

/* 💚 زر رفع الصور */
.btn-outline-success {
  border: 2px solid #10b981 !important;
  color: #059669 !important;
}
.btn-outline-success:hover {
  background: linear-gradient(135deg, #10b981, #059669);
  color: #fff !important;
  transform: translateY(-2px);
}

/* 🖼️ معاينة الصور */
.preview-container img {
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  border-radius: 12px;
  object-fit: contain;
;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}
.preview-container img:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 24px rgba(37, 99, 235, 0.2);
}

/* 🎥 الفيديو */
#videoPreviewContainer video {
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
}

/* ✅ زر الحفظ الكبير */
button[type="submit"] {
  background: linear-gradient(145deg, #2563eb, #1e3a8a);
  color: white;
  border: none;
  border-radius: 14px;
  font-size: 17px;
  font-weight: 700;
  padding: 12px 20px;
  box-shadow: 0 8px 24px rgba(37, 99, 235, 0.35);
  transition: all 0.3s ease;
}
button[type="submit"]:hover {
  background: linear-gradient(145deg, #1e40af, #2563eb);
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(37, 99, 235, 0.5);
}

/* 🌫️ صندوق المودال */
.modal-content {
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(8px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
}
.modal-header {
  border: none;
  border-radius: 18px 18px 0 0;
  background: linear-gradient(135deg, #3b82f6, #2563eb);
}

/* 📱 للجوال */
@media (max-width: 768px) {
  .card {
    border-radius: 14px;
    padding: 8px;
  }
  .btn {
    font-size: 14px !important;
  }
}
</style>


<div id="uploadBarContainer">
  <div id="uploadProgressBar"></div>
</div>
<div id="uploadInfoBox">
  جاري رفع المنتج... <br>
  <strong id="percentLabel">0%</strong> |
  <span id="speedLabel">0 MB/s</span> |
  <span id="timeLabel">0s متبقية</span>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("productForm");
  const barContainer = document.getElementById("uploadBarContainer");
  const bar = document.getElementById("uploadProgressBar");
  const infoBox = document.getElementById("uploadInfoBox");
  const percentLabel = document.getElementById("percentLabel");
  const speedLabel = document.getElementById("speedLabel");
  const timeLabel = document.getElementById("timeLabel");

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const fd = new FormData(form);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", form.action, true);

    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
    if (token) xhr.setRequestHeader('X-CSRF-TOKEN', token);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    barContainer.style.display = "block";
    infoBox.style.display = "block";
    bar.style.width = "0%";
    bar.style.background = "linear-gradient(90deg, #007bff, #6610f2, #0dcaf0)";
    const start = Date.now();

    xhr.upload.onprogress = (event) => {
      if (event.lengthComputable) {
        const percent = Math.round((event.loaded / event.total) * 100);
        const elapsed = (Date.now() - start) / 1000;
        const speed = (event.loaded / 1024 / 1024 / elapsed).toFixed(2);
        const remaining = ((event.total - event.loaded) / (speed * 1024 * 1024)).toFixed(1);

        bar.style.width = percent + "%";
        percentLabel.textContent = percent + "%";
        speedLabel.textContent = speed + " MB/s";
        timeLabel.textContent = remaining + "s متبقية";
      }
    };

    xhr.onload = () => {
      if (xhr.status === 200) {
        bar.style.background = "linear-gradient(90deg, #00c851, #00e676)";
        percentLabel.textContent = "100% ✅";
        setTimeout(() => {
          barContainer.style.display = "none";
          infoBox.style.display = "none";
          window.location.reload();
        }, 1200);
      } else {
        showError();
      }
    };

    xhr.onerror = showError;

    function showError() {
      bar.style.background = "linear-gradient(90deg, #ff4444, #ff6b6b)";
      percentLabel.textContent = "فشل ❌";
      speedLabel.textContent = "";
      timeLabel.textContent = "";
      setTimeout(() => {
        barContainer.style.display = "none";
        infoBox.style.display = "none";
      }, 2000);
    }

    xhr.send(fd);
  });
});
</script>


               
        <script>
let galleryFiles = [];

function previewGallery(input) {
    const files = Array.from(input.files);
    const preview = document.getElementById('galleryPreview');

    galleryFiles = files;
    preview.innerHTML = '';

    if (!files.length) {
        preview.classList.add('d-none');
        return;
    }

    preview.classList.remove('d-none');

    files.forEach((file, index) => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = e => {
            const col = document.createElement('div');
            col.className = 'col-4 col-md-2 position-relative';

            col.innerHTML = `
                <img src="${e.target.result}"
                     class="img-fluid rounded border shadow-sm"
                     style="height:90px; width:100%; object-fit:contain; background:#f8f9fa;"
>
                <button type="button"
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                        onclick="removeGalleryImage(${index})">✕</button>
            `;
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
}

function removeGalleryImage(index) {
    galleryFiles.splice(index, 1);

    const input = document.getElementById('galleryInput');
    const dt = new DataTransfer();
    galleryFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;

    previewGallery(input);
}
</script>
            

@endsection
