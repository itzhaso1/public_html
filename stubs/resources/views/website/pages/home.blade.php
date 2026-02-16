@extends('website.layouts.common.website')
@section('css')
<style>

</style>
@endsection

@section('pageTitle')
{{$pageTitle}}
@endsection

@section('content')
    <!-- السلايدر -->
    {{--<div class="my-4 px-2">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide flex justify-center"><img src="/img/photo_٢٠٢٥-١٠-٢٠_٠١-٤٦-١٠.jpg" alt="Slide 1">
                </div>
                <div class="swiper-slide flex justify-center"><img src="/img/photo_٢٠٢٥-١٠-٢٠_٠١-٤٦-١٠.jpg" alt="Slide 2">
                </div>
                <div class="swiper-slide flex justify-center"><img src="/img/photo_٢٠٢٥-١٠-٢٠_٠١-٤٦-١٠.jpg" alt="Slide 3">
                </div>
            </div>
        </div>
    </div>--}}
    <div class="my-4 px-2">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                @php
                $imageUrl = $slider->getMediaUrl('slider', $slider, null, 'media', 'slider') ;
                @endphp

                @if($imageUrl)
                <div class="swiper-slide flex justify-center">
                    <img src="{{ asset(($imageUrl ?? 'img/قريبا.jpg')) }}" 
     alt="{{ $slider->name ?? 'slider' }}" 
     class="rounded-lg object-cover">

                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- اختيار العملة -->
    <div class="px-4 py-2 flex flex-row-reverse items-center gap-2">
        <span class="font-bold text-sm"> : اختر العملة</span>
        <button class="currency-btn" data-symbol="ر.س" data-rate="1"><img
                src="https://upload.wikimedia.org/wikipedia/commons/0/0d/Flag_of_Saudi_Arabia.svg"
                class="w-6 h-6 rounded-full"></button>
        <button class="currency-btn" data-symbol="د.أ" data-rate="0.18"><img
                src="https://upload.wikimedia.org/wikipedia/commons/c/c0/Flag_of_Jordan.svg"
                class="w-6 h-6 rounded-full"></button>
        <button class="currency-btn" data-symbol="$" data-rate="0.25"><img
                src="https://upload.wikimedia.org/wikipedia/en/a/a4/Flag_of_the_United_States.svg"
                class="w-6 h-6 rounded-full"></button>
    </div>

    <!-- أكواد فري فاير -->
    {{--<div class="px-4 py-6">
        <h2 class="text-center font-bold text-xl mb-4">اكواد فري فاير الشهرية</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-3 rounded-lg shadow text-center">
                <img src="/img/قريبا.jpg" class="product-img mx-auto" alt="كود 1">
                <h3 class="font-bold mt-2">كود 1</h3>
                <p class="text-gray-500 text-sm">وصف قصير للكود</p>
                <p class="font-semibold mt-1" data-base-price="99">ر.س 99</p>
            </div>
            <div class="bg-white p-3 rounded-lg shadow text-center">
                <img src="/img/قريبا.jpg" class="product-img mx-auto" alt="كود 2">
                <h3 class="font-bold mt-2">كود 2</h3>
                <p class="text-gray-500 text-sm">وصف قصير للكود</p>
                <p class="font-semibold mt-1" data-base-price="99">ر.س 99</p>
            </div>
            <div class="bg-white p-3 rounded-lg shadow text-center">
                <img src="/img/قريبا.jpg" class="product-img mx-auto" alt="كود 3">
                <h3 class="font-bold mt-2">كود 3</h3>
                <p class="text-gray-500 text-sm">وصف قصير للكود</p>
                <p class="font-semibold mt-1" data-base-price="99">ر.س 99</p>
            </div>
            <div class="bg-white p-3 rounded-lg shadow text-center">
                <img src="/img/قريبا.jpg" class="product-img mx-auto" alt="كود 4">
                <h3 class="font-bold mt-2">كود 4</h3>
                <p class="text-gray-500 text-sm">وصف قصير للكود</p>
                <p class="font-semibold mt-1" data-base-price="99">ر.س 99</p>
            </div>
        </div>
    </div>--}}

    @foreach($sections as $section)
    <div class="px-4 py-6">
        {{-- اسم القسم --}}
        <h2 class="text-center font-bold text-xl mb-4">
            {{ $section->name }}
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($section->products as $product)
            @php
            $imageUrl = $product->getMediaUrl('product', $product, null, 'media', 'product');
            @endphp

            <div class="bg-white p-3 rounded-lg shadow text-center">
                <img src="{{ asset(($imageUrl ?? 'img/قريبا.jpg')) }}" 
     class="product-img mx-auto rounded-md object-cover"
     alt="{{ $product->name ?? 'Product' }}">


                <h3 class="font-bold mt-2">
                    {{ $product->name }}
                </h3>

                <p class="text-gray-500 text-sm">
                    {{ $product->short_description ?? 'لا يوجد وصف لهذا المنتج' }}
                </p>

                <p class="font-semibold mt-1">
                    ر.س {{ number_format($product->price ?? 0, 2) }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <!-- المنتجات -->
    {{--<div class="px-4 py-6">
        <h2 class="text-center font-bold text-xl mb-4 border-b border-gray-300 pb-2">حسابات متجر الممالك</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="relative bg-white p-3 rounded-lg shadow text-center product" data-status="" data-discount="30">
                <img src="/img/قريبا.jpg" class="product-img mx-auto">
                <h2 class="font-bold mt-2">حساب مميز فري فاير</h2>
                <p class="text-gray-500 text-sm">فيه سكنات نادرة</p>
                <p class="font-semibold mt-1" data-base-price="99">ر.س 99</p>
                <button class="mt-2 w-full bg-black text-white py-1 rounded text-sm">عرض تفاصيل</button>
            </div>

            <div class="relative bg-white p-3 rounded-lg shadow text-center product" data-status="مباع" data-discount="">
                <img src="/img/قريبا.jpg" class="product-img mx-auto">
                <h2 class="font-bold mt-2">حساب VIP خاص</h2>
                <p class="text-gray-500 text-sm">مباع بالكامل</p>
                <p class="font-semibold mt-1" data-base-price="49">ر.س 49</p>
                <button class="mt-2 w-full bg-gray-400 text-white py-1 rounded text-sm cursor-not-allowed">مباع</button>
            </div>

            <div class="relative bg-white p-3 rounded-lg shadow text-center product" data-status="" data-discount="">
                <img src="/img/قريبا.jpg" class="product-img mx-auto">
                <h2 class="font-bold mt-2">حساب عادي</h2>
                <p class="text-gray-500 text-sm">سعر مناسب</p>
                <p class="font-semibold mt-1" data-base-price="79">ر.س 79</p>
                <button class="mt-2 w-full bg-black text-white py-1 rounded text-sm">عرض تفاصيل</button>
            </div>
        </div>
    </div>--}}
    <div class="px-4 py-6">
        <h2 class="text-center font-bold text-xl mb-4 border-b border-gray-300 pb-2">
            حسابات متجر الممالك
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($products as $product)
            @php
            $imageUrl = $product->getMediaUrl('product', $product, null, 'media', 'product');
            $isSold = $product->featured === 1; // لو المنتج مميز اعتبره مباع
            @endphp

            <div class="relative bg-white p-3 rounded-lg shadow text-center product"
                data-status="{{ $isSold ? 'مباع' : '' }}">

                {{-- الصورة --}}
               <img src="{{ asset(($imageUrl ?? 'img/قريبا.jpg')) }}" 
     class="product-img mx-auto rounded-md object-cover">


                {{-- الاسم --}}
                <h2 class="font-bold mt-2">{{ $product->name }}</h2>

                {{-- الوصف --}}
                <p class="text-gray-500 text-sm">
                    {{ $product->short_description ?? 'لا يوجد وصف متاح' }}
                </p>

                {{-- السعر --}}
                @if(!empty($product->price_before_discount))
                <p class="font-semibold mt-1 text-red-600">
                    ر.س {{ number_format($product->price, 2) }}
                    <span class="text-gray-500 text-sm">
                        (بدلاً من {{ number_format($product->price_before_discount, 2) }})
                    </span>
                </p>
                @else
                <p class="font-semibold mt-1">
                    ر.س {{ number_format($product->price, 2) }}
                </p>
                @endif

                {{-- الزر --}}
                @if($isSold)
                <button class="mt-2 w-full bg-gray-400 text-white py-1 rounded text-sm cursor-not-allowed">
                    مباع
                </button>
                @else
                <a href="{{ route('website.product.show', $product->id) }}"
                    class="mt-2 block w-full bg-black text-white py-1 rounded text-sm text-center">
                    عرض تفاصيل
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
@endsection

@push('js')

@endpush
