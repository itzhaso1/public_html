@extends('website.layouts.common.website')

@section('pageTitle')
{{ $pageTitle ?? 'الملف الشخصي' }}
@endsection

@section('content')
<section class="max-w-4xl mx-auto px-4 py-8" dir="rtl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">الملف الشخصي</h1>
            <p class="text-sm text-gray-600 mt-1">تحديث البريد الإلكتروني وكلمة المرور.</p>
        </div>
        <a href="{{ route('customer.purchases') }}"
           class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-bold hover:bg-gray-50 transition">
            مشترياتي
        </a>
    </div>

    @if(session('success'))
        <div class="mt-4 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h2 class="font-extrabold text-gray-900">تحديث البريد الإلكتروني</h2>

            <form class="mt-4 space-y-3" method="POST" action="{{ route('customer.profile.update') }}">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-yellow-400/60"
                           required>
                    @error('email')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-black px-5 py-3 text-sm font-extrabold text-white hover:bg-gray-800 transition">
                    حفظ البريد
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h2 class="font-extrabold text-gray-900">تغيير كلمة المرور</h2>

            <form class="mt-4 space-y-3" method="POST" action="{{ route('customer.profile.password') }}">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">كلمة المرور الحالية</label>
                    <input type="password" name="current_password"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-yellow-400/60"
                           required>
                    @error('current_password')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">كلمة المرور الجديدة</label>
                    <input type="password" name="password"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-yellow-400/60"
                           required>
                    @error('password')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-800 mb-1">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation"
                           class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-yellow-400/60"
                           required>
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-black px-5 py-3 text-sm font-extrabold text-white hover:bg-gray-800 transition">
                    تحديث كلمة المرور
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

