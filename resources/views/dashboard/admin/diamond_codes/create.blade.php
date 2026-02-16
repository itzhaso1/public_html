<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'إضافة كود جواهر' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
<main class="max-w-3xl mx-auto p-4 sm:p-6">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold">{{ $pageTitle ?? 'إضافة كود جواهر' }}</h1>
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
            <select name="product_id" class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm">
                @foreach($products as $p)
                    <option value="{{ $p->id }}" @selected(old('product_id') == $p->id)>{{ $p->name }} (ID: {{ $p->id }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-extrabold mb-1">الكود</label>
            <textarea name="code" rows="3"
                      class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm font-mono"
                      placeholder="ضع الكود هنا" required>{{ old('code') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-extrabold mb-1">صورة الكود (اختياري)</label>
            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                   class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm">
            <div class="text-xs text-gray-500 mt-1">حتى 5MB</div>
        </div>

        <button class="w-full rounded-xl bg-black px-5 py-3 text-sm font-extrabold text-white hover:bg-gray-800 transition">
            حفظ
        </button>
    </form>
</main>
</body>
</html>

