@extends('website.layouts.common.website')
@section('css')
<script src="https://cdn.tailwindcss.com"></script>
{{--<style>
    :root {
        --footer-height: 76px;
    }

    .slide {
        flex-shrink: 0;
    }
</style>--}}
<style>
    .slider-track {
        display: flex;
        transition: transform 0.4s ease-in-out;
        will-change: transform;
    }

    .slide {
        flex: 0 0 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slide-inner {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slide-inner img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
    }

    .thumb-active {
        border: 2px solid #2563eb !important;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3);
    }

    .thumbs-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .thumbs-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .video-container {
    border: 3px solid #b91c1c; /* اللون الأحمر */
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

video {
    width: 100%;
    display: block;
}

</style>
@endsection

@section('pageTitle')
{{$pageTitle ?? $product?->name}}
@endsection

@section('content')
<main class="flex-grow pb-[var(--footer-height)]">
    <div class="container mx-auto px-4">

       <!-- سلايدر -->
<section class="mt-6">
  <div id="sliderWrap"
    class="relative w-full max-w-sm mx-auto overflow-hidden rounded-lg shadow-lg bg-white">
    <div id="sliderTrack"
      class="slider-track flex transition-transform duration-500 ease-in-out">
      <!-- الصور الكبيرة -->
      <div class="flex-shrink-0 w-full aspect-[4/3] bg-black flex items-center justify-center">
        <img src="image1.jpg" alt="صورة 1"
          class="w-full h-full object-contain">
      </div>
      <div class="flex-shrink-0 w-full aspect-[4/3] bg-black flex items-center justify-center">
        <img src="image2.jpg" alt="صورة 2"
          class="w-full h-full object-contain">
      </div>
      <div class="flex-shrink-0 w-full aspect-[4/3] bg-black flex items-center justify-center">
        <img src="image3.jpg" alt="صورة 3"
          class="w-full h-full object-contain">
      </div>
    </div>

    <!-- أزرار -->
    <button id="prevBtn"
      class="absolute left-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-70 p-2 rounded-full shadow-sm hover:bg-opacity-90 z-20 transition-all"
      aria-label="السابق">‹</button>
    <button id="nextBtn"
      class="absolute right-2 top-1/2 -translate-y-1/2 bg-white bg-opacity-70 p-2 rounded-full shadow-sm hover:bg-opacity-90 z-20 transition-all"
      aria-label="التالي">›</button>
  </div>
<!-- الثمبنات -->
<div class="max-w-sm mx-auto mt-3 overflow-visible">
 <div class="max-w-sm mx-auto mt-3 overflow-visible">
  <div id="thumbs"
    class="flex gap-3 overflow-x-auto thumbs-scroll py-3 px-4 touch-pan-x snap-x snap-mandatory justify-start items-center"
    style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
    
    <img src="image1.jpg" alt="صورة مصغرة 1"
      class="w-20 h-20 object-cover rounded-xl border-2 border-transparent cursor-pointer hover:scale-105 hover:shadow-lg hover:border-blue-500 transition-all duration-300 ease-out">
      
    <img src="image2.jpg" alt="صورة مصغرة 2"
      class="w-20 h-20 object-cover rounded-xl border-2 border-transparent cursor-pointer hover:scale-105 hover:shadow-lg hover:border-blue-500 transition-all duration-300 ease-out">
      
    <img src="image3.jpg" alt="صورة مصغرة 3"
      class="w-20 h-20 object-cover rounded-xl border-2 border-transparent cursor-pointer hover:scale-105 hover:shadow-lg hover:border-blue-500 transition-all duration-300 ease-out">
  </div>
</div>

</div>
<div class="flex justify-center mt-5 gap-3">
  
  <button id="downloadThumbsBtn"
          class="group relative inline-flex items-center gap-2 text-sm font-semibold text-gray-800 px-4 py-2 rounded-full border border-gray-300 bg-white/30 backdrop-blur-md shadow-sm hover:bg-white/50 hover:shadow-md hover:scale-105 transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600 group-hover:translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
    </svg>
    تحميل صور الحساب
  </button>
<!-- Progress Bar -->
<div id="progressWrap" class="hidden w-full max-w-sm mx-auto mt-4">
  <div class="w-full bg-gray-200 rounded-full h-3">
    <div id="progressBar" class="h-3 rounded-full bg-blue-600 transition-all duration-300" style="width: 0%;"></div>
  </div>
  <div id="progressText" class="text-center text-sm text-gray-700 mt-1 font-semibold">
    0%
  </div>
</div>

  <button id="copyLinkBtn"
      class="px-6 py-2 text-sm font-semibold text-gray-800 bg-white/40 border border-gray-300 rounded-full hover:bg-white/60 hover:scale-105 transition-all duration-300 shadow-md flex items-center gap-2">
      🔗 نسخ رابط الحساب
  </button>

</div>


</section>

<script>
  const track = document.getElementById('sliderTrack');
  const slides = track.children;
  const thumbs = document.querySelectorAll('#thumbs img');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  let currentIndex = 0;

  function updateSlider() {
    track.style.transform = `translateX(-${currentIndex * 100}%)`;
    thumbs.forEach((thumb, i) => {
      thumb.classList.toggle('border-blue-500', i === currentIndex);
    });
  }

  nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % slides.length;
    updateSlider();
  });

  prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    updateSlider();
  });

  thumbs.forEach((thumb, i) => {
    thumb.addEventListener('click', () => {
      currentIndex = i;
      updateSlider();
    });
  });

  updateSlider();
</script>

            
            <!--
@php
    $productVideo = $product->videos->first();
@endphp

@if ($productVideo)
<div class="max-w-sm mx-auto mt-5 rounded-lg shadow-lg border-4 border-red-900 overflow-visible;
 bg-white">

    
   
    <div class="text-center py-2 bg-red-900 border-b border-red-800">

      <h3 class="text-lg font-bold text-yellow-400">استعراض الحساب</h3>


    </div>

   
<div class="video-container relative w-full aspect-video bg-black">
    <video class="absolute inset-0 w-full h-full object-contain" controls controlsList="nodownload">
        <source src="{{ asset('public/' . $productVideo->video_path) }}" type="video/mp4">
        متصفحك لا يدعم تشغيل الفيديو.
    </video>
</div>


    <!-- ا
    @if ($productVideo->video_name)
    <div class="text-center py-2 bg-gray-100 border-t border-gray-300">
        <p class="text-sm text-gray-600">{{ $product?->name }}</p>
    </div>
    @endif
   
</div>

@else
->
<div class="max-w-sm mx-auto mt-5 rounded-xl shadow-xl border border-red-600 overflow-hidden bg-white/60 backdrop-blur-md">

   ->
    <div class="text-center py-2 bg-red-600/90">
        <h3 class="text-lg font-bold text-white tracking-wide">استعراض الحساب</h3>
    </div>

 
    <div class="video-container w-full aspect-video bg-black flex items-center justify-center relative">


    
        <p class="text-white/60 text-sm absolute">لا يوجد فيديو متاح</p>

    
        <!--
        <video controls class="w-full h-full object-cover">
            <source src="{{ asset('your-video-path.mp4') }}" type="video/mp4">
        </video>
       

    </div>
</div>
 -->
@endif



        </section>
<!-- استدعاء خط عصري من Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

<section dir="rtl" class="max-w-sm mx-auto mt-6 p-6 bg-white rounded-2xl shadow-lg border border-gray-100 text-right" style="font-family: 'Tajawal', sans-serif;">
  <h2 class="text-2xl font-extrabold text-gray-900 mb-4 text-center tracking-tight">
    {{ $product?->name }}
  </h2>

 <!-- وصف المنتج من قاعدة البيانات -->
<div class="text-gray-800 text-base leading-relaxed space-y-2 font-medium bg-white/40 backdrop-blur-md border border-gray-200 p-4 rounded-2xl shadow-sm relative">
  <div id="productDescription">
    {!! nl2br(e($product?->description)) !!}
  </div>

  <!-- زر النسخ -->
  <div class="flex justify-center mt-5">
    <button id="copyDescBtn"
      class="px-6 py-2 text-sm font-semibold text-gray-800 bg-white/40 border border-gray-300 rounded-full hover:bg-white/60 hover:scale-105 transition-all duration-300 shadow-md flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2M8 16h8a2 2 0 002-2v-2M8 16v2a2 2 0 002 2h8a2 2 0 002-2v-2" />
      </svg>
      نسخ الوصف
    </button>
  </div>
</div>

<!-- إشعار النسخ -->
<div id="copyAlert"
  class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 bg-green-600 text-white px-5 py-2 rounded-full shadow-lg text-sm z-50 backdrop-blur-md bg-opacity-90">
  ✅ تم نسخ الوصف بنجاح
</div>




<style>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fade-in 0.3s ease-out;
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const unlockBtn = document.getElementById('unlockBtn');
    const modal = document.getElementById('unlockModal');
    const cancelBtn = document.getElementById('cancelUnlock');
    const copyBtn = document.getElementById('copyBtn');
    const clientNumber = document.getElementById('clientNumber');
    const copyAlert = document.getElementById('copyAlert');

    if (unlockBtn) unlockBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    if (cancelBtn) cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

    if (copyBtn && clientNumber) {
        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(clientNumber.textContent.trim())
                .then(() => {
                    copyBtn.innerHTML = '✅ تم النسخ';
                    copyBtn.classList.add('bg-green-600', 'text-white');
                    copyAlert.classList.remove('hidden');
                    setTimeout(() => {
                        copyBtn.innerHTML = '<i class="bi bi-clipboard"></i> نسخ';
                        copyBtn.classList.remove('bg-green-600', 'text-white');
                        copyAlert.classList.add('hidden');
                    }, 1500);
                })
                .catch(() => alert('حدث خطأ أثناء النسخ'));
        });
    }
});
</script>












  <!-- العملة والسعر -->
  <div class="mt-7 text-center border-t pt-4">
    <div class="flex items-center justify-center gap-3 mb-4">
      <!-- السعودية -->
      <button class="currency-btn bg-white border border-gray-200 p-1.5 rounded-full shadow-sm hover:scale-110 transition"
          data-symbol="ر.س" data-rate="1" title="الريال السعودي">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/0d/Flag_of_Saudi_Arabia.svg"
             class="w-8 h-8 rounded-full" alt="السعودية">
      </button>

      <!-- الأردن -->
      <button class="currency-btn bg-white border border-gray-200 p-1.5 rounded-full shadow-sm hover:scale-110 transition"
          data-symbol="د.أ" data-rate="0.18" title="الدينار الأردني">
        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c0/Flag_of_Jordan.svg"
             class="w-8 h-8 rounded-full" alt="الأردن">
      </button>

      <!-- أمريكا -->
      <button class="currency-btn bg-white border border-gray-200 p-1.5 rounded-full shadow-sm hover:scale-110 transition"
          data-symbol="$" data-rate="0.25" title="الدولار الأمريكي">
        <img src="https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg"
             class="w-8 h-8 rounded-full" alt="أمريكا">
      </button>
    </div>

    <div class="text-gray-500 text-base mb-1 font-medium">السعر</div>
    <div class="text-4xl font-extrabold text-green-600 product-price tracking-wide"
        data-base-price="{{ $product->price }}">
      <span class="current-price">ر.س {{ $product->price }}</span>
    </div>
  </div>
</section>

        @include('website.partials.client_number', ['product' => $product])



<!-- قسم التواصل -->
<div class="max-w-sm mx-auto mt-8 p-6 rounded-2xl shadow-lg text-center bg-gradient-to-br from-white to-blue-50 border border-blue-200">
  <h3 class="text-xl font-extrabold text-gray-900 mb-2 flex items-center justify-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h2l3 7-1.5 1.5A2 2 0 006 16h12a2 2 0 001.5-.5L19 12l3-7h2" />
    </svg>
    تواصل معنا مباشرة
  </h3>
  
  <p class="text-gray-600 mb-4 text-sm">
    نسعد بخدمتك والإجابة على استفساراتك في أي وقت 💬
  </p>

  <div class="text-2xl font-bold text-blue-700 mb-4 select-all tracking-wide">
  +966&nbsp;50&nbsp;842&nbsp;4351
</div>


  <div class="flex justify-center gap-3 flex-wrap">
   

    <a href="https://chat.whatsapp.com/LiEKm0hQPlB9yeToyetcbh" target="_blank"
       class="flex items-center gap-2 bg-[#25D366] text-white px-5 py-2.5 rounded-full shadow-md hover:bg-[#1ebe5d] hover:shadow-lg transition-all duration-200">
      💬 <span class="font-semibold">تواصل عبر واتساب</span>
    </a>
  </div>

  <div class="mt-5 text-xs text-gray-400 italic">
    متاحون يوميًا من 10 صباحًا حتى 10 مساءً
  </div>
</div>
<!-- Download Modal -->
<div id="downloadModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-xl shadow-lg p-6 w-80 text-center">

    <h2 class="text-lg font-bold text-gray-800 mb-3">خيارات التحميل</h2>
    <p class="text-sm text-gray-600 mb-4">اختر طريقة تحميل الصور:</p>

    <button id="downloadZip" class="w-full bg-blue-600 text-white py-2 rounded-lg mb-2">
     تحميل الصور جهاز ايفون
    </button>

    <button id="downloadInd" class="w-full bg-green-600 text-white py-2 rounded-lg mb-2">
   تحميل الصور لجهاز انرويد 
   
    </button>

    <button id="closeModal" class="w-full bg-gray-300 py-2 rounded-lg">
      إلغاء
    </button>

  </div>
</div>

  @php
        $mainImage = $product->getMediaUrl('product', $product, null, 'media', 'product');
        $galleryImages = $product->getMultipleMediaUrls('product/gallery', $product, 'media', 'gallery');
    @endphp


<script>
    window.productData = {
        mainImage: @json($mainImage),
        galleryImages: @json($galleryImages),
    };
</script>
<script>

// كشف الجهاز هل هو آيفون؟
function isIOS() {
  return /iPhone|iPad|iPod/i.test(navigator.userAgent);
}

window.addEventListener('load', () => {

  const downloadBtn = document.getElementById('downloadThumbsBtn');
  const modal = document.getElementById('downloadModal');
  const closeModal = document.getElementById('closeModal');
  const zipBtn = document.getElementById('downloadZip');
  const indBtn = document.getElementById('downloadInd');

  const gallery = (window.productData || {}).galleryImages || [];

  if (!gallery || gallery.length === 0) {
    downloadBtn.innerText = '📦 لا توجد صور متاحة';
    downloadBtn.disabled = true;
    return;
  }

  // افتح النافذة عند الضغط على زر التحميل
  downloadBtn.addEventListener('click', () => {
    modal.classList.remove("hidden");

    if (isIOS()) {
      // لو المستخدم آيفون → نخفي خيار التحميل الفردي
      indBtn.classList.add("hidden");
      zipBtn.classList.remove("hidden");
    } else {
      // غير ذلك → أندرويد أو كمبيوتر → نسمح بالخيارين
      indBtn.classList.remove("hidden");
      zipBtn.classList.remove("hidden");
    }
  });

  closeModal.addEventListener('click', () => {
    modal.classList.add("hidden");
  });

  // ---------------- ZIP لآيفون ---------------- //
  zipBtn.addEventListener('click', async () => {
    modal.classList.add("hidden");
    downloadBtn.innerHTML = "⏳ تجهيز ملف ZIP...";
    downloadBtn.disabled = true;

    const zip = new JSZip();
    const folder = zip.folder("images");
    const timestamp = Date.now();

    for (let i = 0; i < gallery.length; i++) {
      const img = gallery[i];
      const url = img.original || img.url || img;

      const response = await fetch(url);
      const blob = await response.blob();
      folder.file(`image_${i + 1}_${timestamp}.jpg`, blob);
    }

    zip.generateAsync({ type: "blob" }).then(content => {
      saveAs(content, `images_${timestamp}.zip`);
      downloadBtn.innerHTML = "تحميل صور الحساب";
      downloadBtn.disabled = false;
    });

  });

  // --------- تحميل فردي (Android / PC) --------- //
  indBtn.addEventListener('click', () => {
    modal.classList.add("hidden");
    downloadIndividual(gallery);
  });

  function downloadIndividual(gallery) {
    downloadBtn.innerHTML = "⏳ جاري تحميل الصور...";
    downloadBtn.disabled = true;

    const timestamp = Date.now();
    let index = 0;

    function next() {
      if (index >= gallery.length) {
        downloadBtn.innerHTML = "✔ تم تحميل جميع الصور";
        setTimeout(() => {
          downloadBtn.innerHTML = "تحميل صور الحساب";
          downloadBtn.disabled = false;
        }, 1500);
        return;
      }

      const img = gallery[index];
      const url = img.original || img.url || img;

      // عدّاد ظاهر
      downloadBtn.innerHTML = `🔄 تحميل (${index + 1} / ${gallery.length})`;

      const a = document.createElement("a");
      a.href = url;
      a.download = `image_${index + 1}_${timestamp}.jpg`;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);

      index++;

      setTimeout(next, 250);
    }

    next();
  }

});
</script>

@endsection

{{--@push('js')
<script>
    (function () {
  const { mainImage, galleryImages } = window.productData;

  if (!mainImage && (!galleryImages || galleryImages.length === 0)) return;

  const sliderImages = [mainImage, ...galleryImages.map(img => img.original)];
  const sliderWrap = document.getElementById('sliderWrap');
  const track = document.getElementById('sliderTrack');
  const thumbsContainer = document.getElementById('thumbs');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');

  let currentIndex = 0;
  let slideWidth = 0;

  function buildSlidesAndThumbs() {
    track.innerHTML = '';
    thumbsContainer.innerHTML = '';

    sliderImages.forEach((src, idx) => {
      const slideDiv = document.createElement('div');
      slideDiv.className = 'slide';
      slideDiv.style.height = '100%';

      const inner = document.createElement('div');
      inner.className = 'slide-inner h-full';

      const img = document.createElement('img');
      img.className = 'original';
      img.src = src;
      img.alt = `Slide ${idx + 1}`;
      img.loading = 'lazy';

      inner.appendChild(img);
      slideDiv.appendChild(inner);
      track.appendChild(slideDiv);

      const thumb = document.createElement('img');
      thumb.src = src;
      thumb.dataset.index = idx;
      thumb.alt = `Thumb ${idx + 1}`;
      thumb.className = 'w-20 h-14 object-cover rounded cursor-pointer border-2 border-transparent snap-start';
      thumb.addEventListener('click', () => goToSlide(idx));
      thumbsContainer.appendChild(thumb);
    });
  }

  function updateLayout() {
    slideWidth = sliderWrap.clientWidth;
    Array.from(track.children).forEach(sl => sl.style.width = slideWidth + 'px');
    track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
  }

  function goToSlide(i, smooth = true) {
    const total = sliderImages.length;
    currentIndex = Math.max(0, Math.min(i, total - 1));
    if (!smooth) {
      track.style.transition = 'none';
      track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
      void track.offsetWidth;
      track.style.transition = 'transform 0.4s ease-in-out';
    } else {
      track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }
    updateActiveThumb();
  }

  function updateActiveThumb() {
    const thumbs = Array.from(thumbsContainer.querySelectorAll('img'));
    thumbs.forEach((t, idx) => t.classList.toggle('thumb-active', idx === currentIndex));
  }

  nextBtn.addEventListener('click', () => goToSlide((currentIndex + 1) % sliderImages.length));
  prevBtn.addEventListener('click', () => goToSlide((currentIndex - 1 + sliderImages.length) % sliderImages.length));

  window.addEventListener('resize', () => {
    clearTimeout(window._sliderResizeTimer);
    window._sliderResizeTimer = setTimeout(updateLayout, 150);
  });

  function init() {
    buildSlidesAndThumbs();
    updateLayout();
    goToSlide(0, false);
  }

  window.addEventListener('load', init);
})();
</script>
@endpush--}}
@push('js')
<script>
    (function () {
  const { mainImage, galleryImages } = window.productData || {};

  if (!mainImage && (!galleryImages || galleryImages.length === 0)) return;

  // دمج الصورة الرئيسية مع صور الجاليري
  const sliderImages = [mainImage, ...(galleryImages || []).map(img => img.original)];

  const sliderWrap = document.getElementById('sliderWrap');
  const track = document.getElementById('sliderTrack');
  const thumbsContainer = document.getElementById('thumbs');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');

  let currentIndex = 0;
  let slideWidth = 0;

  function buildSlidesAndThumbs() {
    track.innerHTML = '';
    thumbsContainer.innerHTML = '';

    sliderImages.forEach((src, idx) => {
      const slideDiv = document.createElement('div');
      slideDiv.className = 'slide';
      slideDiv.style.flexShrink = '0'; // مهم عشان كل سلايد يبقى ثابت في العرض
      slideDiv.style.height = '100%';

      const inner = document.createElement('div');
      inner.className = 'slide-inner h-full flex justify-center items-center';

      const img = document.createElement('img');
      img.className = 'original object-cover object-center w-full h-full';
      img.src = src;
      img.alt = `Slide ${idx + 1}`;
      img.loading = 'lazy';

      inner.appendChild(img);
      slideDiv.appendChild(inner);
      track.appendChild(slideDiv);

      // الثامبنيلز
      const thumb = document.createElement('img');
      thumb.src = src;
      thumb.dataset.index = idx;
      thumb.alt = `Thumb ${idx + 1}`;
      thumb.className = 'w-20 h-14 object-cover rounded cursor-pointer border-2 border-transparent snap-start';
      thumb.addEventListener('click', () => goToSlide(idx));
      thumbsContainer.appendChild(thumb);
    });
  }

  function updateLayout() {
    slideWidth = sliderWrap.clientWidth;
    Array.from(track.children).forEach(slide => {
      slide.style.width = `${slideWidth}px`;
    });
    track.style.width = `${slideWidth * sliderImages.length}px`;
    //track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    track.style.transform = `translate3d(-${currentIndex * slideWidth}px, 0, 0)`;
  }

  function goToSlide(i, smooth = true) {
    const total = sliderImages.length;
    if (total === 0) return;
    currentIndex = Math.max(0, Math.min(i, total - 1));
    if (!smooth) {
      track.style.transition = 'none';
      track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
      void track.offsetWidth; // لإعادة التفعيل
      track.style.transition = 'transform 0.4s ease-in-out';
    } else {
      track.style.transition = 'transform 0.4s ease-in-out';
      track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }
    updateActiveThumb();
    console.log('goToSlide =>', currentIndex, sliderImages[currentIndex]);
  }

  function updateActiveThumb() {
    const thumbs = thumbsContainer.querySelectorAll('img');
    thumbs.forEach((t, idx) => t.classList.toggle('thumb-active', idx === currentIndex));
  }

  nextBtn.addEventListener('click', () => goToSlide((currentIndex + 1) % sliderImages.length));
  prevBtn.addEventListener('click', () => goToSlide((currentIndex - 1 + sliderImages.length) % sliderImages.length));

  window.addEventListener('resize', () => {
    clearTimeout(window._sliderResizeTimer);
    window._sliderResizeTimer = setTimeout(updateLayout, 150);
  });

  function init() {
    buildSlidesAndThumbs();
    setTimeout(() => {
      updateLayout();
      goToSlide(0, false);
    }, 100);
  }

  window.addEventListener('load', init);
})();
</script>


<script>
  const copyBtn = document.getElementById('copyDescBtn');
  const desc = document.getElementById('productDescription');
  const alertBox = document.getElementById('copyAlert');

  copyBtn.addEventListener('click', async () => {
    try {
      const text = desc.innerText.trim();
      if (!text) return alert('الوصف فارغ 😅');

      await navigator.clipboard.writeText(text);

      // تغيير مؤقت للنص
      copyBtn.innerHTML = '✅ تم النسخ';
      copyBtn.classList.add('scale-95');

      setTimeout(() => {
        copyBtn.classList.remove('scale-95');
        copyBtn.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2M8 16h8a2 2 0 002-2v-2M8 16v2a2 2 0 002 2h8a2 2 0 002-2v-2" />
          </svg>
          نسخ الوصف
        `;
      }, 1500);

      // إشعار النسخ
      alertBox.classList.remove('hidden');
      alertBox.style.opacity = '1';
      setTimeout(() => {
        alertBox.style.opacity = '0';
        setTimeout(() => alertBox.classList.add('hidden'), 300);
      }, 2000);
    } catch (err) {
      console.error('فشل النسخ:', err);
      alert('حدث خطأ أثناء النسخ 😔');
    }
  });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const copyLinkBtn = document.getElementById('copyLinkBtn');

    copyLinkBtn.addEventListener('click', () => {
        const productUrl = "{{ url()->current() }}"; // رابط الصفحة الحالية

        navigator.clipboard.writeText(productUrl)
            .then(() => {
                copyLinkBtn.innerHTML = "✅ تم نسخ الرابط";
                copyLinkBtn.classList.add("bg-green-600", "text-white");

                setTimeout(() => {
                    copyLinkBtn.innerHTML = "🔗 نسخ رابط الحساب";
                    copyLinkBtn.classList.remove("bg-green-600", "text-white");
                }, 1500);
            })
            .catch(() => {
                alert("تعذر نسخ الرابط");
            });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    function enableBigImageDownload() {
        // الحصول على الصور الكبيرة فقط
        const sliderImages = document.querySelectorAll("#sliderTrack img");

        sliderImages.forEach((img, index) => {
            img.style.cursor = "pointer"; // شكل اليد ليوضح إنه قابل للضغط

            img.addEventListener("click", () => {
                const a = document.createElement("a");
                a.href = img.src;
                a.download = `image_${index + 1}.jpg`; // اسم الصورة عند التحميل
                document.body.appendChild(a);
                a.click();     // تحميل مباشر
                document.body.removeChild(a);
            });
        });
    }

    // نفعل التحميل بعد أن ينتهي السلايدر من بناء الصور
    setTimeout(enableBigImageDownload, 300);
});
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

@endpush
