<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'إضافة كود' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
<main class="max-w-3xl mx-auto p-4 sm:p-6">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold">{{ $pageTitle ?? 'إضافة كود' }}</h1>
            <p class="text-sm text-gray-600 mt-1">أضف كود + صورة (اختياري).</p>
        </div>
        <a href="{{ route('admin.diamond_codes.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-bold hover:bg-gray-50 transition">
            رجوع
        </a>
    </div>

    @if($errors->any())
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <form class="mt-5 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 space-y-4"
          method="POST" enctype="multipart/form-data" action="{{ route('admin.diamond_codes.store') }}">
        @csrf

        <div>
            <label class="block text-sm font-extrabold mb-2">اختر المنتج أو أنشئ منتج جديد</label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="rounded-2xl border border-gray-200 bg-white p-4 cursor-pointer">
                    <div class="flex items-center gap-2">
                        <input type="radio" name="product_mode" value="existing" class="accent-black"
                               @checked(old('product_mode', 'existing') === 'existing')>
                        <span class="font-extrabold text-sm">اختيار منتج موجود</span>
                    </div>
                    <div class="mt-3">
                        <select name="product_id" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                            <option value="">-- اختر المنتج --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>{{ $p->name }} (ID: {{ $p->id }})</option>
                            @endforeach
                        </select>
                        <div class="text-xs text-gray-500 mt-2">إذا القائمة فاضية، استخدم “منتج جديد”.</div>
                    </div>
                </label>

                <label class="rounded-2xl border border-gray-200 bg-white p-4 cursor-pointer">
                    <div class="flex items-center gap-2">
                        <input type="radio" name="product_mode" value="new" class="accent-black"
                               @checked(old('product_mode') === 'new')>
                        <span class="font-extrabold text-sm">منتج جديد (اسم على مزاجك)</span>
                    </div>
                    <div class="mt-3 space-y-2">
                        <input type="text" name="product_name" value="{{ old('product_name') }}"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"
                               placeholder="مثال: أكواد رقصات / أكواد سكن / أكواد سكاكين">
                        <input type="number" step="0.01" name="product_price" value="{{ old('product_price') }}"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm"
                               placeholder="السعر (اختياري)">
                        <div class="text-xs text-gray-500">سيتم إنشاء منتج أكواد جديد تلقائيًا.</div>
                    </div>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-sm font-extrabold mb-1">كود واحد (اختياري)</label>
            <textarea name="code" rows="2"
                      class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm font-mono"
                      placeholder="ضع كود واحد هنا">{{ old('code') }}</textarea>
            <div class="text-xs text-gray-500 mt-1">إذا بدك تضيف دفعة أكواد، استخدم الحقل اللي تحت.</div>
        </div>

        <div>
            <label class="block text-sm font-extrabold mb-1">صورة للكود الواحد (اختياري)</label>
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                   class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm">
            <div class="text-xs text-gray-500 mt-1">حتى 5MB</div>
        </div>

        <div class="pt-2 border-t border-gray-100">
            <label class="block text-sm font-extrabold mb-1">دفعة أكواد (اختياري)</label>
            <textarea name="codes" rows="6"
                      class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm font-mono"
                      placeholder="ضع كل كود بسطر&#10;CODE-1&#10;CODE-2&#10;CODE-3">{{ old('codes') }}</textarea>
            <div class="text-xs text-gray-500 mt-1">
                تقدر تضيف 5 أو 10 أكواد دفعة واحدة. سيتم تجاهل الأسطر الفارغة والتكرارات.
            </div>
        </div>

        <div>
            <label class="block text-sm font-extrabold mb-1">صور متعددة (اختياري)</label>
            <input type="file" name="images[]" accept=".jpg,.jpeg,.png,.webp" multiple
                   class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm">
            <div class="text-xs text-gray-500 mt-1">
                إذا رفعت صور متعددة، سيتم ربط كل صورة بالكود حسب ترتيب السطور (الصورة الأولى للكود الأول...).
            </div>
        </div>

        <button class="w-full rounded-xl bg-black px-5 py-3 text-sm font-extrabold text-white hover:bg-gray-800 transition">
            حفظ
        </button>
    </form>
</main>
</body>
</html>

