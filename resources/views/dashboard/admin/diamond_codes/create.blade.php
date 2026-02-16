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
            <label class="block text-sm font-extrabold mb-1">منتج الأكواد</label>
            @if($products->isEmpty())
                <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-900">
                    لا يوجد منتجات في قسم <b>أكواد ملابس</b> حتى الآن.
                    <div class="mt-2">
                        أنشئ باقة أكواد من هنا:
                        <a class="font-extrabold underline" href="{{ route('admin.products.create_charge') }}">
                            إضافة منتجات الشحن/الأكواد
                        </a>
                    </div>
                </div>
            @elseif($products->count() === 1)
                @php($p = $products->first())
                <input type="hidden" name="product_id" value="{{ $p->id }}">
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-4 text-sm">
                    تم اختيار المنتج تلقائيًا:
                    <b>{{ $p->name }}</b> (ID: {{ $p->id }})
                </div>
            @else
                <select name="product_id" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                    <option value="">-- اختر المنتج --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>{{ $p->name }} (ID: {{ $p->id }})</option>
                    @endforeach
                </select>
            @endif
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

        <button class="w-full rounded-xl bg-black px-5 py-3 text-sm font-extrabold text-white hover:bg-gray-800 transition disabled:opacity-50 disabled:cursor-not-allowed"
                @disabled($products->isEmpty())>
            حفظ
        </button>
    </form>
</main>
</body>
</html>

