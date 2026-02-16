@extends('website.layouts.common.website')

@section('pageTitle')
{{ $pageTitle ?? 'تم استلام طلبك' }}
@endsection

@section('content')
@php
    $product = $mpr->product;
    $isCodes = ($product?->service_type ?? null) === 'codes';
@endphp

@include('website.diamonds.partials.header', [
    'title' => 'تم استلام طلبك',
    'subtitle' => 'طلبك قيد المراجعة وسيتم تنفيذ الشحن بعد التأكيد.',
    'active' => $isCodes ? 'codes' : 'charge',
])

<section class="max-w-3xl mx-auto px-4 pb-12" dir="rtl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-center">
            <div class="text-4xl">✅</div>
            <h2 class="mt-2 text-2xl font-extrabold text-gray-900">تم استلام طلب الدفع اليدوي</h2>
            <p class="mt-1 text-sm text-gray-600">احتفظ برقم الطلب للمتابعة.</p>
        </div>

        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4">
                <div class="text-xs text-gray-500">رقم الطلب</div>
                <div class="mt-1 font-extrabold text-gray-900 select-all">{{ $mpr->reference }}</div>
            </div>
            <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4">
                <div class="text-xs text-gray-500">الحالة</div>
                <div class="mt-1 font-extrabold text-yellow-700">قيد المراجعة</div>
            </div>
            <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4">
                <div class="text-xs text-gray-500">الباقة</div>
                <div class="mt-1 font-bold text-gray-900">{{ $product?->name }}</div>
            </div>
            <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4">
                <div class="text-xs text-gray-500">Player ID</div>
                <div class="mt-1 font-bold text-gray-900 select-all">{{ $mpr->player_id }}</div>
            </div>
        </div>

        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-4">
            <div class="text-sm font-extrabold text-gray-900 mb-2">بيانات التحويل البنكي</div>
            <div class="text-sm text-gray-700 space-y-1">
                @if(config('bank.bank_name'))
                    <div><span class="text-gray-500">البنك:</span> <span class="font-bold">{{ config('bank.bank_name') }}</span></div>
                @endif
                @if(config('bank.account_name'))
                    <div><span class="text-gray-500">اسم الحساب:</span> <span class="font-bold">{{ config('bank.account_name') }}</span></div>
                @endif
                @if(config('bank.account_number'))
                    <div><span class="text-gray-500">رقم الحساب:</span> <span class="font-bold select-all">{{ config('bank.account_number') }}</span></div>
                @endif
                @if(config('bank.iban'))
                    <div><span class="text-gray-500">IBAN:</span> <span class="font-bold select-all">{{ config('bank.iban') }}</span></div>
                @endif
                <div class="pt-2 text-xs text-gray-500">
                    بعد التحويل سيتم تنفيذ الطلب بعد التأكيد.
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <a href="{{ $isCodes ? route('website.diamonds.codes') : route('website.diamonds.charge') }}"
               class="flex-1 inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-bold text-gray-800 hover:bg-gray-50 transition">
                الرجوع لقسم الدايموند
            </a>
            <a href="{{ route('home') }}"
               class="flex-1 inline-flex items-center justify-center rounded-xl bg-black px-5 py-3 text-sm font-extrabold text-white hover:bg-gray-800 transition">
                الرئيسية
            </a>
        </div>
    </div>
</section>
@endsection

