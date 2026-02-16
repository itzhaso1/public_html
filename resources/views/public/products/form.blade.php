@extends('public.layouts.master')

@section('pageTitle')
    {{ $pageTitle }}
@endsection

@section('content')

@php
    $isEdit = isset($product);
@endphp
<script src="https://cdn.jsdelivr.net/npm/heic2any/dist/heic2any.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="w-full flex justify-center py-2">
    <div class="w-[85%] max-w-[300px] bg-red-50 border border-red-200 rounded-2xl p-3 text-center shadow-sm">
        <div class="text-red-600 text-lg mb-1">⚠️</div>
        <div class="text-[11px] leading-relaxed text-gray-800">
            يرجى تنفيذ الشروط <span class="font-bold text-red-600 underline">بالتفصيل</span>،
            <br>
            أو <span class="font-bold text-red-700">سوف يتم رفض حسابك</span>.
        </div>
    </div>
</div>

<div class="bg-gray-100" dir="rtl">

    <div class="bg-white px-3 sm:px-4 pt-2 sm:pt-3 pb-24 space-y-3 sm:space-y-4 max-w-md mx-auto w-full">


        @if(session('success'))
            <div class="rounded-2xl bg-green-100 text-green-800 px-4 py-3 text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl bg-red-100 text-red-800 px-4 py-3 text-center font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="text-center mb-2">

            <h1 class="text-2xl font-bold tracking-tight text-gray-800">
                {{ $isEdit ? 'تحديث المنتج' : 'إضافة منتج' }}
            </h1>
        </div>

        <form
            id="productForm"
            action="{{ route('public.products.store', request()->query()) }}"
            method="POST"
            enctype="multipart/form-data"
           class="space-y-6"

        >
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- شريط التقدم -->
            <div class="space-y-2">
                <div id="stepIndicator" class="text-center text-xs text-gray-500">الخطوة 1 من 7</div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div id="stepProgress" class="h-2 bg-indigo-600 transition-all" style="width: 14%;"></div>
                </div>
            </div>

            {{-- ================== اللغة العربية ================== --}}
            @foreach (config('translatable.locales') as $locale)
                @if($locale === 'ar')

                    <!-- STEP 1 -->
                    <div class="step" data-step="1">
                        <label class="text-sm text-gray-600">(AR) اسم الحساب</label>
                        <input
                            type="text"
                            name="{{ $locale }}[name]"
                            maxlength="20"
                            minlength="3"
                            placeholder="مثال: حساب فير 8 لليوم او حساب كلاش محروق"
                            value="{{ old($locale.'.name', $product?->translateOrNew($locale)->name ?? '') }}"
                            oninput="updateCounter(this, 'nameCounter')"
                            class="mt-2 w-full rounded-2xl border border-gray-300 bg-gray-50
                                   px-4 py-5 text-lg
                                   placeholder:text-gray-400
                                   focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                        <div id="nameCounter" class="text-xs text-gray-400 mt-1">0 / 20</div>
                        @error($locale.'.name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- STEP 2 -->
                    <div class="step hidden" data-step="2">
                        <label class="text-sm text-gray-600">(AR) الوصف المختصر</label>
                        <textarea
                            name="{{ $locale }}[short_description]"
                            rows="2"
                            maxlength="37"
                            oninput="updateCounter(this, 'shortDescCounter')"
                            class="mt-2 w-full rounded-2xl border border-gray-300 bg-gray-50
                                   px-4 py-5 text-lg
                                   placeholder:text-gray-400
                                   focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >{{ old(
                            $locale.'.short_description',
                            $product?->translateOrNew($locale)->short_description
                            ?? 'لفل الحساب: () | عدد السكنات: ()'
                        ) }}</textarea>
                        <div id="shortDescCounter" class="text-xs text-gray-400 mt-1">
                            {{ strlen(old(
                                $locale.'.short_description',
                                $product?->translateOrNew($locale)->short_description
                                ?? 'لفل الحساب: () | عدد السكنات: ()'
                            )) }} / 35
                        </div>
                        @error($locale.'.short_description')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- STEP 3 -->
                    <div class="step hidden" data-step="3">
                        <label class="text-sm text-gray-600">(AR) الوصف الكامل</label>
                        <textarea
                            name="{{ $locale }}[description]"
                            rows="6"
                            class="mt-2 w-full rounded-2xl border border-gray-300 bg-gray-50
                                   px-4 py-5 text-lg
                                   focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        >{{ old(
                            $locale.'.description',
                            $product?->translateOrNew($locale)->description
                            ?? "فير باس:
لفل الحساب: ( )
عدد السكنات: ( )
عدد الرقصات: ( )
تسجيل دخول: ( )
عدد الأسلحة ماكس 🔫: ( من أصل )"
                        ) }}</textarea>
                        @error($locale.'.description')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                @endif
            @endforeach

            <!-- STEP 4 -->
            <div class="step hidden" data-step="4">
                <div>
                    <label class="text-sm text-gray-600">رقم هاتفك</label>
                    <input
                        type="text"
                        name="client_number"
                        value="{{ old('client_number', $product->client_number ?? '') }}"
                        class="mt-2 w-full rounded-2xl border border-gray-300 bg-gray-50
                               px-4 py-5 text-lg
                               focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @error('client_number')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">السعر بريال</label>
                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        value="{{ old('price', $product->price ?? '') }}"
                        class="mt-2 w-full rounded-2xl border border-gray-300 bg-gray-50
                               px-4 py-5 text-lg
                               focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @error('price')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- النوع ثابت --}}
            <input type="hidden" name="type_id" value="{{ old('type_id', $product?->type_id ?? 2) }}">
            <input type="hidden" name="slug" value="{{ old('slug', $product?->slug ?? Str::random(32)) }}">
            <input type="hidden" name="category_id" value="{{ old('category_id', $product?->category_id ?? $data['categories']->first()->id) }}">
            <input type="hidden" name="stock" value="{{ old('stock', $product?->stock ?? 1) }}">

            <!-- STEP 5 (الصورة الرئيسية) -->
            <div class="step hidden" data-step="5">
                <div class="space-y-2">
                    <label class="text-sm text-gray-600">
                        صورة <span class="text-indigo-600 font-semibold">الملف الشخصي</span>
                    </label>

                    <div class="rounded-xl bg-red-50 border border-red-300 p-4 text-center space-y-2">
                        <div class="text-sm font-bold text-red-700">⚠️ تنبيه</div>
                        <div class="text-sm text-red-600">يرجى نسخ النص التالي ووضعه في الملف الشخصي للحساب</div>

                        <div onclick="copyStoreOnly()" class="cursor-pointer select-none rounded-lg bg-white border p-3">
                            <div class="font-bold tracking-widest">مــتــجـر الــمــمالـــك</div>
                            <div class="text-green-600 font-semibold">WHATSAPP+962ᅠ0777ᅠ515ﾠ306</div>
                            <div class="text-xs text-gray-500 mt-2">اضغط هنا لنسخ النص</div>
                        </div>
                    </div>

                    <label for="product_image" class="flex items-center justify-center gap-2 w-full py-4 rounded-2xl border-2 border-dashed border-indigo-300 bg-indigo-50 text-indigo-700 font-semibold text-base cursor-pointer active:scale-[0.98] transition">
                        📷 اختر صورة
                    </label>

                    <input id="product_image" type="file" name="product" accept="image/*" class="hidden" onchange="previewMainImage(this)">

                    <div id="imagePreviewBox" class="hidden mt-3 relative">
                        <img id="imagePreview" class="w-full h-48 object-cover rounded-xl border" alt="معاينة الصورة">
                        <button type="button" onclick="removeMainImage()"
                                class="absolute top-2 right-2 bg-red-500 text-white w-7 h-7 rounded-full flex items-center justify-center shadow-lg border border-white">
                            ✕
                        </button>
                    </div>

                    <p id="product_image_name" class="text-xs text-gray-500">لم يتم اختيار ملف</p>

                    @error('product')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- STEP 6 (المعرض) -->
            <div class="step hidden" data-step="6">
                <div class="space-y-2">
                    <label class="text-sm text-gray-600">
                        صور استعراض الحساب
                        <span class="text-red-600 font-semibold">
                            (يُمنع وضع صورة البروفايل مرة أخرى)
                        </span>
                    </label>

                    <label for="gallery_images"
                           class="flex items-center justify-center gap-2
                                  w-full py-4 rounded-2xl
                                  border-2 border-dashed border-emerald-300
                                  bg-emerald-50 text-emerald-700
                                  font-semibold text-base
                                  cursor-pointer
                                  active:scale-[0.98] transition">
                        🖼️ اختر صور
                    </label>

                    <input id="gallery_images" type="file" name="gallery[]" accept="image/*" multiple
                           class="hidden" onchange="previewGalleryImages(this)">

                    <p id="gallery_images_name" class="text-xs text-gray-500">لم يتم اختيار أي ملفات</p>

                    <div id="galleryPreview" class="grid grid-cols-3 gap-2 mt-3"></div>

                    @error('gallery')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    @error('gallery.*')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <p class="mt-2 text-base font-bold text-red-700">
                    🚫 ممنوع تمامًا رفع صور مُمنتجة أو مُركّبة  
                    ✔️ يُقبل فقط تصوير الشاشة الأصلي بدون تعديل
                </p>
            </div>

            <!-- STEP 7 (المراجعة) -->
            <div class="step hidden" data-step="7">
                <div class="rounded-2xl bg-gray-50 border border-gray-200 p-4 space-y-2 text-sm">
                    <div>اسم الحساب: <span id="reviewName" class="font-semibold">—</span></div>
                    <div>الوصف المختصر: <span id="reviewShort" class="font-semibold">—</span></div>
                    <div>السعر: <span id="reviewPrice" class="font-semibold">—</span></div>
                    <div>رقم الهاتف: <span id="reviewPhone" class="font-semibold">—</span></div>
                    <div>الصورة الرئيسية: <span id="reviewMain" class="font-semibold">—</span></div>
                    <div>صور المعرض: <span id="reviewGallery" class="font-semibold">0</span></div>
                </div>
                <p class="text-xs text-gray-500 text-center mt-2">راجع البيانات ثم اضغط نشر الحساب</p>
            </div>

            <!-- أزرار التنقل -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t p-4 space-y-2">
                <div class="flex gap-2">
                    <button type="button" id="wizardPrevBtn" onclick="prevStep()"
                            class="w-1/2 bg-gray-200 text-gray-800 py-4 rounded-2xl font-bold text-lg">
                        السابق
                    </button>
                    <button type="button" id="wizardNextBtn" onclick="nextStep()"
                            class="w-1/2 bg-indigo-600 text-white py-4 rounded-2xl font-bold text-lg">
                        التالي
                    </button>
                </div>

                <button type="submit" id="finalSubmit"
                        class="hidden w-full bg-indigo-600 text-white py-5 rounded-2xl font-bold text-xl shadow-lg active:scale-[0.98] transition">
                    نشر الحساب
                </button>
            </div>
        </form>
    </div>
</div>

<!-- عداد التحميل -->
<div id="uploadBox" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white w-11/12 max-w-md rounded-2xl p-6 space-y-4 text-center">
        <h2 class="text-lg font-bold text-gray-800">جاري رفع الملف...</h2>
        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
            <div id="progressBar" class="bg-indigo-600 h-4 w-0 transition-all"></div>
        </div>
        <div id="progressPercent" class="text-sm font-semibold text-gray-700">0%</div>
        <div id="progressInfo" class="text-xs text-gray-500">0 MB / 0 MB</div>
        <div id="progressTime" class="text-xs text-gray-500">الوقت المتبقي: --</div>
    </div>
</div>

<script>
let currentStep = 1;
const totalSteps = 7;
let isProcessingImages = false;

function setWizardBusy(state, label = 'التالي') {
    isProcessingImages = state;
    const nextBtn = document.getElementById('wizardNextBtn');
    const submitBtn = document.getElementById('finalSubmit');

    if (nextBtn) {
        nextBtn.disabled = state;
        nextBtn.classList.toggle('opacity-50', state);
        nextBtn.classList.toggle('cursor-not-allowed', state);
        nextBtn.textContent = state ? 'جاري تجهيز الصور...' : label;
    }

    if (submitBtn) {
        submitBtn.disabled = state;
        submitBtn.classList.toggle('opacity-50', state);
        submitBtn.classList.toggle('cursor-not-allowed', state);
    }
}

function updateProgress(step) {
    const percent = Math.round((step / totalSteps) * 100);
    const bar = document.getElementById('stepProgress');
    if (bar) bar.style.width = percent + '%';
}

function showStep(step) {
    document.querySelectorAll('.step').forEach(el => el.classList.add('hidden'));
    const active = document.querySelector(`.step[data-step="${step}"]`);
    if (active) active.classList.remove('hidden');

    document.getElementById('wizardPrevBtn').classList.toggle('hidden', step === 1);
    document.getElementById('wizardNextBtn').classList.toggle('hidden', step === totalSteps);
    document.getElementById('finalSubmit').classList.toggle('hidden', step !== totalSteps);

    document.getElementById('stepIndicator').textContent = `الخطوة ${step} من ${totalSteps}`;
    updateProgress(step);

    if (step === totalSteps) {
        updateReview();
    }
}

function validateStep(step) {
    if (step === 1) {
        const name = document.querySelector('input[name="ar[name]"]');
        if (!name || name.value.trim().length < 3) {
            alert('اسم الحساب مطلوب (3 أحرف على الأقل)');
            return false;
        }
    }
    if (step === 2) {
        const shortDesc = document.querySelector('textarea[name="ar[short_description]"]');
        if (!shortDesc || shortDesc.value.trim().length < 5) {
            alert('الوصف المختصر مطلوب');
            return false;
        }
    }
    if (step === 5) {
        const mainImage = document.querySelector('input[name="product"]');
        if (!mainImage || mainImage.files.length === 0) {
            alert('يجب رفع صورة البروفايل');
            return false;
        }
    }
    if (step === 6) {
        const gallery = document.querySelector('input[name="gallery[]"]');
        if (!gallery || gallery.files.length < 12) {
            alert('يجب رفع 12 صورة على الأقل');
            return false;
        }
    }
    return true;
}

function nextStep() {
    if (isProcessingImages) {
        alert('انتظر حتى يتم تجهيز الصور');
        return;
    }
    if (!validateStep(currentStep)) return;
    if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}

function updateReview() {
    const name = document.querySelector('input[name="ar[name]"]')?.value?.trim() || '—';
    const shortDesc = document.querySelector('textarea[name="ar[short_description]"]')?.value?.trim() || '—';
    const price = document.querySelector('input[name="price"]')?.value?.trim() || '—';
    const phone = document.querySelector('input[name="client_number"]')?.value?.trim() || '—';
    const mainImage = document.querySelector('input[name="product"]')?.files?.[0]?.name || 'غير مرفوعة';
    const galleryCount = document.querySelector('input[name="gallery[]"]')?.files?.length || 0;

    document.getElementById('reviewName').textContent = name;
    document.getElementById('reviewShort').textContent = shortDesc;
    document.getElementById('reviewPrice').textContent = price ? `${price} ريال` : '—';
    document.getElementById('reviewPhone').textContent = phone;
    document.getElementById('reviewMain').textContent = mainImage;
    document.getElementById('reviewGallery').textContent = galleryCount;
}

document.addEventListener('DOMContentLoaded', () => {
    showStep(currentStep);
});
</script>

<script>
document.getElementById('productForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = this;
    const uploadBox = document.getElementById('uploadBox');
    const progressBar = document.getElementById('progressBar');
    const progressPercent = document.getElementById('progressPercent');
    const progressInfo = document.getElementById('progressInfo');
    const progressTime = document.getElementById('progressTime');

    uploadBox.classList.remove('hidden');

    const formData = new FormData(form);
    const xhr = new XMLHttpRequest();

    const startTime = new Date().getTime();

    xhr.open('POST', form.action, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

    xhr.upload.onprogress = function (e) {
        if (e.lengthComputable) {
            const percent = Math.round((e.loaded / e.total) * 100);
            progressBar.style.width = percent + '%';
            progressPercent.innerText = percent + '%';

            const loadedMB = (e.loaded / (1024 * 1024)).toFixed(2);
            const totalMB = (e.total / (1024 * 1024)).toFixed(2);
            progressInfo.innerText = `${loadedMB} MB / ${totalMB} MB`;

            const elapsedTime = (new Date().getTime() - startTime) / 1000;
            const speed = e.loaded / elapsedTime;
            const remainingTime = (e.total - e.loaded) / speed;

            progressTime.innerText = `الوقت المتبقي: ${Math.ceil(remainingTime)} ثانية`;
        }
    };

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            Swal.fire({
                icon: 'success',
                title: 'تم تحميل الحساب',
                text: 'تم رفع المنتج بنجاح',
                confirmButtonText: 'تمام'
            }).then(() => {
                window.location.reload();
            });
        } else {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'حدث خطأ أثناء رفع المنتج'
            });
            uploadBox.classList.add('hidden');
        }
    };

    xhr.onerror = function () {
        alert('فشل الاتصال');
        uploadBox.classList.add('hidden');
    };

    xhr.send(formData);
});
</script>

<script>
function updateCounter(input, counterId) {
    const counter = document.getElementById(counterId);
    counter.innerText = input.value.length + ' / ' + input.maxLength;
}
</script>

<script>
async function previewMainImage(input) {
  setWizardBusy(true);

  let file = input.files[0];
  const previewBox = document.getElementById('imagePreviewBox');
  const previewImg = document.getElementById('imagePreview');
  const fileName = document.getElementById('product_image_name');

  if (!file) {
    setWizardBusy(false);
    return;
  }

  if (file.type === 'image/heic' || file.name.toLowerCase().endsWith('.heic')) {
    const convertedBlob = await heic2any({
      blob: file,
      toType: 'image/jpeg',
      quality: 0.75
    });

    file = new File([convertedBlob], file.name.replace('.heic', '.jpg'), { type: 'image/jpeg' });
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
  }

  fileName.innerText = file.name;
  previewImg.src = URL.createObjectURL(file);
  previewBox.classList.remove('hidden');

  setWizardBusy(false);
}

function removeMainImage() {
    const input = document.getElementById('product_image');
    const previewBox = document.getElementById('imagePreviewBox');
    const fileName = document.getElementById('product_image_name');
    
    input.value = "";
    previewBox.classList.add('hidden');
    fileName.textContent = "لم يتم اختيار ملف";
}

function copyStoreOnly() {
    const text = `مــتــجـر الــمــمالـــك\nWHATSAPP+962ᅠ0777ᅠ515ﾠ306`;
    navigator.clipboard.writeText(text).then(() => {
        alert('تم نسخ النص ✔️');
    }).catch(() => {
        alert('فشل النسخ');
    });
}
</script>

<script>
let galleryFiles = [];

async function previewGalleryImages(input) {
    setWizardBusy(true);

    const preview = document.getElementById('galleryPreview');
    const nameLabel = document.getElementById('gallery_images_name');

    let files = Array.from(input.files);
    galleryFiles = [];
    preview.innerHTML = '';

    for (let file of files) {
        if (file.type === 'image/heic' || file.name.toLowerCase().endsWith('.heic')) {
            const blob = await heic2any({
                blob: file,
                toType: 'image/jpeg',
                quality: 0.8
            });

            file = new File([blob], file.name.replace('.heic', '.jpg'), {
                type: 'image/jpeg'
            });
        }
        galleryFiles.push(file);
    }

    renderGallery();
    setWizardBusy(false);
}

function renderGallery() {
    const preview = document.getElementById('galleryPreview');
    const nameLabel = document.getElementById('gallery_images_name');
    const nextBtn = document.getElementById('wizardNextBtn');

    preview.innerHTML = '';

    const dt = new DataTransfer();
    galleryFiles.forEach(f => dt.items.add(f));
    document.getElementById('gallery_images').files = dt.files;

    if (galleryFiles.length < 12) {
        nameLabel.textContent = `⚠️ يجب اختيار 12 صورة على الأقل (المختار: ${galleryFiles.length})`;
        nameLabel.classList.add('text-red-600');
        nameLabel.classList.remove('text-green-600');

        if (nextBtn) {
            nextBtn.disabled = true;
            nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    } else {
        nameLabel.textContent = `${galleryFiles.length} صور مختارة`;
        nameLabel.classList.remove('text-red-600');
        nameLabel.classList.add('text-green-600');

        if (nextBtn) {
            nextBtn.disabled = false;
            nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    galleryFiles.forEach((file, index) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'relative';

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = `w-full aspect-[6/4] object-cover bg-gray-50 rounded-lg border`;

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.innerHTML = '✖';
        removeBtn.className = `
            absolute -top-2 -right-2
            bg-red-600 text-white text-xs
            w-6 h-6 rounded-full
            flex items-center justify-center
            shadow
        `;

        removeBtn.onclick = () => removeGalleryImage(index);

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        preview.appendChild(wrapper);
    });
}

function removeGalleryImage(index) {
    galleryFiles.splice(index, 1);
    renderGallery();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection