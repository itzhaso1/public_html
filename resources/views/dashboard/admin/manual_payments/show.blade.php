<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'تفاصيل طلب الدفع اليدوي' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
<main class="max-w-5xl mx-auto p-4 sm:p-6">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold">{{ $pageTitle ?? 'تفاصيل طلب الدفع اليدوي' }}</h1>
            <div class="text-sm text-gray-600 mt-1">المرجع: <span class="font-mono select-all">{{ $mpr->reference }}</span></div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.manual_payments.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-bold hover:bg-gray-50 transition">
                رجوع
            </a>
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center justify-center rounded-xl bg-black px-4 py-2 text-sm font-bold text-white hover:bg-gray-800 transition">
                لوحة التحكم
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mt-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-5 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h2 class="font-extrabold text-gray-900">معلومات الطلب</h2>

            <div class="mt-3 space-y-2 text-sm">
                <div><span class="text-gray-500">الباقة:</span> <span class="font-bold">{{ $mpr->product?->name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Player ID:</span> <span class="font-bold select-all">{{ $mpr->player_id }}</span></div>
                <div><span class="text-gray-500">المبلغ:</span> <span class="font-extrabold text-green-700">ر.س {{ number_format((float)$mpr->amount, 2) }}</span></div>
                <div><span class="text-gray-500">الحالة:</span> <span class="font-extrabold">{{ $mpr->status }}</span></div>
                @if($mpr->contact_phone)
                    <div><span class="text-gray-500">الهاتف:</span> <span class="font-bold select-all">{{ $mpr->contact_phone }}</span></div>
                @endif
                @if($mpr->contact_email)
                    <div><span class="text-gray-500">الإيميل:</span> <span class="font-bold select-all">{{ $mpr->contact_email }}</span></div>
                @endif
                <div><span class="text-gray-500">IP:</span> <span class="font-mono text-xs select-all">{{ $mpr->ip ?? '-' }}</span></div>
                <div class="text-xs text-gray-500">تاريخ الإنشاء: {{ $mpr->created_at?->format('Y-m-d H:i') }}</div>
            </div>

            <div class="mt-5">
                <label class="block text-sm font-extrabold mb-2">ملاحظة الأدمن (اختياري)</label>
                <form method="POST" action="{{ route('admin.manual_payments.approve', $mpr) }}" class="space-y-3">
                    @csrf
                    <textarea name="admin_note" rows="3"
                              class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"
                              placeholder="مثال: تم التأكد من الإيصال وسيتم الشحن الآن...">{{ old('admin_note', $mpr->admin_note) }}</textarea>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <button type="submit"
                                class="flex-1 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-extrabold text-white hover:bg-green-700 transition">
                            موافقة
                        </button>
                </form>
                <form method="POST" action="{{ route('admin.manual_payments.reject', $mpr) }}" class="flex-1">
                    @csrf
                    <input type="hidden" name="admin_note" value="{{ old('admin_note', $mpr->admin_note) }}">
                    <button type="submit"
                            class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-extrabold text-white hover:bg-red-700 transition">
                        رفض
                    </button>
                </form>
                    </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h2 class="font-extrabold text-gray-900">الإيصال</h2>
            @if($receiptUrl)
                <div class="mt-3">
                    <a href="{{ $receiptUrl }}" target="_blank"
                       class="inline-flex items-center justify-center rounded-xl bg-black px-4 py-2 text-sm font-bold text-white hover:bg-gray-800 transition">
                        فتح الإيصال
                    </a>
                </div>
                <div class="mt-4 rounded-2xl border border-gray-100 bg-gray-50 p-3">
                    @if(\Illuminate\Support\Str::endsWith(strtolower($receiptUrl), ['.pdf']))
                        <div class="text-sm text-gray-600">الإيصال PDF. افتحه من الزر بالأعلى.</div>
                    @else
                        <img src="{{ $receiptUrl }}" alt="Receipt" class="w-full rounded-xl">
                    @endif
                </div>
            @else
                <div class="mt-3 text-sm text-gray-500">لا يوجد إيصال مرفوع.</div>
            @endif
        </div>
    </div>
</main>
</body>
</html>

