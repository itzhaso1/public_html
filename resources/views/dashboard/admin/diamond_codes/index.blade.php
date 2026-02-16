<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'أكواد الجواهر' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
<main class="max-w-7xl mx-auto p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold">{{ $pageTitle ?? 'أكواد الجواهر' }}</h1>
            <p class="text-sm text-gray-600 mt-1">إضافة أكواد جديدة ومتابعة الأكواد المسلّمة.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.diamond_codes.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-black px-4 py-2 text-sm font-bold text-white hover:bg-gray-800 transition">
                + إضافة كود
            </a>
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-bold hover:bg-gray-50 transition">
                لوحة التحكم
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mt-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mt-5 overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
            <tr class="text-right">
                <th class="p-3 font-extrabold">ID</th>
                <th class="p-3 font-extrabold">المنتج</th>
                <th class="p-3 font-extrabold">الحالة</th>
                <th class="p-3 font-extrabold">الكود</th>
                <th class="p-3 font-extrabold">الصورة</th>
                <th class="p-3 font-extrabold">المستخدم</th>
                <th class="p-3 font-extrabold">إجراء</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($codes as $code)
                <tr class="text-right">
                    <td class="p-3">{{ $code->id }}</td>
                    <td class="p-3 font-bold">{{ $code->product?->name ?? '-' }}</td>
                    <td class="p-3">
                        @php
                            $badge = $code->status === 'delivered'
                                ? 'bg-green-100 text-green-800 border-green-200'
                                : 'bg-yellow-100 text-yellow-800 border-yellow-200';
                            $label = $code->status === 'delivered' ? 'مُسلّم' : 'متاح';
                        @endphp
                        <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-extrabold {{ $badge }}">
                            {{ $label }}
                        </span>
                    </td>
                    <td class="p-3 font-mono text-xs max-w-[340px] break-all select-all">{{ $code->code }}</td>
                    <td class="p-3">
                        @if($code->image_path)
                            <a href="{{ route('admin.diamond_codes.image', $code) }}" target="_blank"
                               class="text-xs font-bold text-blue-700 underline">فتح</a>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="p-3">
                        <span class="text-xs text-gray-600">{{ $code->user?->email ?? '—' }}</span>
                    </td>
                    <td class="p-3">
                        @if($code->status !== 'delivered')
                            <form method="POST" action="{{ route('admin.diamond_codes.destroy', $code) }}"
                                  onsubmit="return confirm('تأكيد حذف الكود؟');">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-xl bg-red-600 px-3 py-2 text-xs font-extrabold text-white hover:bg-red-700">
                                    حذف
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td class="p-6 text-center text-gray-500" colspan="7">لا يوجد أكواد.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $codes->links() }}
    </div>
</main>
</body>
</html>

