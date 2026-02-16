@extends('dashboard.layouts.master')

@section('pageTitle')
تعديل القسم:
@endsection
<style>
/* 🩹 تصحيح ترتيب الطبقات */
.select2-container--open {
    z-index: 99999 !important;
}

/* منع ظهور التمرير الأفقي عند الفتح */
body.select2-open {
    overflow-x: hidden !important;
}

/* ⚡️ تحسين شامل لصفحة تعديل القسم */
body {
    background-color: #f8fafc !important;
    font-family: 'Tajawal', 'Cairo', sans-serif !important;
    direction: rtl !important;
}

/* 🧭 عنوان البطاقة */
.card-header {
    background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%) !important;
    color: #fff !important;
    border-radius: 10px 10px 0 0 !important;
}
.card-header h3 {
    color: #fff !important;
}

/* 💎 تنسيق البطاقة */
.card {
    border: none !important;
    border-radius: 12px !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05) !important;
    background: #ffffff !important;
}

/* 🏷️ العناوين داخل الفورم */
label.form-label {
    font-weight: 600 !important;
    color: #1e293b !important;
    margin-bottom: 6px !important;
    display: block;
}

/* ✍️ الحقول النصية */
.form-control, .form-select {
    border-radius: 10px !important;
    border: 1px solid #d1d5db !important;
    padding: 10px 12px !important;
    transition: all 0.25s ease-in-out !important;
    background-color: #f9fafb !important;
}
.form-control:focus, .form-select:focus {
    border-color: #2563eb !important;
    background-color: #fff !important;
    box-shadow: 0 0 6px rgba(37, 99, 235, 0.3) !important;
}

/* 🎯 أزرار التبويبات */
.nav-tabs .nav-link {
    color: #475569 !important;
    background-color: #f1f5f9 !important;
    border-radius: 10px 10px 0 0 !important;
    margin-left: 4px !important;
    font-weight: 500 !important;
}
.nav-tabs .nav-link.active {
    background: linear-gradient(90deg, #2563eb, #3b82f6) !important;
    color: #fff !important;
}

/* 🧩 مربعات Select2 */
.select2-container--default .select2-selection--multiple {
    min-height: 85px !important;
    border: 1px solid #d1d5db !important;
    border-radius: 10px !important;
    background-color: #ffffff !important;
    padding: 8px 10px !important;
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: flex-start !important;
    gap: 5px !important;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.05) !important;
    transition: all 0.25s ease-in-out !important;
}
.select2-container--default .select2-selection--multiple:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 5px rgba(59,130,246,0.3) !important;
}

/* وسوم Select2 */
.select2-container--default .select2-selection__choice {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
    border: 1px solid #bfdbfe !important;
    border-radius: 8px !important;
    padding: 6px 10px !important;
    margin: 3px !important;
    color: #1e3a8a !important;
    font-weight: 500 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
    transition: all 0.25s ease-in-out !important;
}
.select2-container--default .select2-selection__choice:hover {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe) !important;
    transform: translateY(-1px);
}

/* زر الإزالة (X) */
.select2-container--default .select2-selection__choice__remove {
    color: #ef4444 !important;
    font-size: 16px !important;
    font-weight: bold !important;
    cursor: pointer !important;
    transition: all 0.2s ease-in-out !important;
}
.select2-container--default .select2-selection__choice__remove:hover {
    color: #fff !important;
    background-color: #ef4444 !important;
    border-radius: 50% !important;
    padding: 0 5px !important;
}

/* 🖋 زر الحفظ */
.btn-primary {
    background: linear-gradient(90deg, #2563eb, #3b82f6) !important;
    border: none !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px;
    padding: 12px 0 !important;
    box-shadow: 0 3px 10px rgba(59,130,246,0.25) !important;
    transition: all 0.25s ease-in-out !important;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(59,130,246,0.35) !important;
}

/* 🧱 مسافات متوازنة */
.container {
    padding: 25px !important;
}

/* 🎯 تصميم احترافي للقائمة المنبثقة Select2 */
.select2-container--default .select2-dropdown {
    border: none !important;
    border-radius: 10px !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    background: #ffffff !important;
    overflow: hidden !important;
}

/* 🧭 تنسيق نتائج القائمة */
.select2-container--default .select2-results > .select2-results__options {
    max-height: 250px !important;
    padding: 5px !important;
    scroll-behavior: smooth !important;
}

/* 🔹 شكل كل عنصر في القائمة */
.select2-container--default .select2-results__option {
    padding: 10px 14px !important;
    border-radius: 8px !important;
    margin: 3px !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    color: #1e293b !important;
    transition: all 0.2s ease-in-out !important;
    cursor: pointer !important;
}

/* ✨ عند تمرير الماوس */
.select2-container--default .select2-results__option--highlighted {
    background: linear-gradient(90deg, #2563eb, #3b82f6) !important;
    color: #ffffff !important;
    transform: translateX(-2px);
}

/* ✅ العنصر المحدد */
.select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: #e0f2fe !important;
    color: #1e3a8a !important;
    font-weight: 600 !important;
}

/* 📱 تمرير ناعم وجميل */
.select2-results__options::-webkit-scrollbar {
    width: 6px !important;
}
.select2-results__options::-webkit-scrollbar-thumb {
    background: #94a3b8 !important;
    border-radius: 4px !important;
}
.select2-results__options::-webkit-scrollbar-thumb:hover {
    background: #64748b !important;
}
/* ❤️ تغيير لون العناصر المختارة مسبقًا إلى أحمر */
.select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: #fee2e2 !important; /* خلفية أحمر فاتح */
    color: #b91c1c !important; /* نص أحمر داكن */
    font-weight: 600 !important;
    border-radius: 8px !important;
}

/* عند التمرير على العنصر المحدد */
.select2-container--default .select2-results__option[aria-selected="true"]:hover {
    background-color: #fca5a5 !important; /* أحمر متوسط */
    color: #7f1d1d !important;
}

/* عند التركيز أو التحديد الجديد */
.select2-container--default .select2-results__option--highlighted[aria-selected="true"] {
    background: linear-gradient(90deg, #dc2626, #ef4444) !important; /* تدرج أحمر أنيق */
    color: #fff !important;
}
/* 🌈 Bottom Sheet محسّن لتجربة الموبايل */
@media (max-width: 768px) {

    /* خلفية التعتيم */
    .select2-backdrop {
        position: fixed !important;
        inset: 0 !important;
        background: rgba(0, 0, 0, 0.45) !important;
        backdrop-filter: blur(4px) !important;
        z-index: 9998 !important;
        animation: fadeIn 0.25s ease-in-out !important;
    }

    /* ✅ النافذة المنبثقة (Bottom Sheet) */
    .select2-container--open .select2-dropdown {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        max-width: 100vw !important;
        margin: 0 auto !important;
        transform: none !important;
        background: #fff !important;
        border-radius: 18px 18px 0 0 !important;
        box-shadow: 0 -8px 25px rgba(0, 0, 0, 0.3) !important;
        z-index: 9999 !important;
        max-height: 70vh !important;
        overflow-y: auto !important;
        animation: slideUp 0.3s ease-out !important;
    }

    /* ✅ شريط علوي داخل القائمة */
    .select2-container--open .select2-dropdown::before {
        content: "اختر من القائمة";
        display: block;
        text-align: center;
        font-weight: 600;
        font-size: 16px;
        color: #1e293b;
        padding: 14px 0;
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        border-radius: 18px 18px 0 0;
    }

    /* حقل البحث */
    .select2-container--default .select2-search--dropdown {
        padding: 10px 16px !important;
        border-bottom: 1px solid #e5e7eb !important;
        background-color: #fff !important;
    }
    .select2-container--default .select2-search__field {
        width: 100% !important;
        border-radius: 8px !important;
        border: 1px solid #d1d5db !important;
        padding: 10px 14px !important;
        font-size: 16px !important;
    }

    /* عناصر القائمة */
    .select2-results__option {
        padding: 16px 18px !important;
        font-size: 16px !important;
        text-align: right !important;
        border-bottom: 1px solid #f1f5f9 !important;
        transition: background 0.2s ease-in-out, transform 0.15s ease;
    }
    .select2-results__option:last-child {
        border-bottom: none !important;
    }

    /* العنصر المحدد */
    .select2-results__option[aria-selected="true"] {
        background: #fee2e2 !important;
        color: #b91c1c !important;
        font-weight: 600 !important;
    }

    /* عند المرور */
    .select2-results__option--highlighted {
        background: #dc2626 !important;
        color: #fff !important;
        transform: scale(1.02);
    }

    /* حركات */
    @keyframes slideUp {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* ✅ منع تحرك الصفحة عند الفتح */
    body.select2-open {
        position: fixed !important;
        overflow: hidden !important;
        width: 100% !important;
    }
    html, body {
        overscroll-behavior: none !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden !important;
    }
}

</style>
@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{'تعديل القسم: ' . $section?->name}}</span>
            </h3>
        </div>
        <!--end::Header-->

        <!--begin::Form-->
        <div class="py-3 card-body">
            <form action="{{ route('admin.sections.update', $section->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="container p-4 mt-2 bg-white rounded shadow">
                    <div class="row">
                        <div class="mb-5 hover-scroll-x">
                            <div class="d-grid">
                                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                                    @foreach(config('laravellocalization.supportedLocales') as $key => $lang)
                                    <li class="nav-item">
                                        <a class="nav-link @if(app()->getLocale() == $key) active @endif" data-bs-toggle="tab"
                                            href="#{{ $key }}">
                                            {{ $lang['native'] }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            @foreach(config('laravellocalization.supportedLocales') as $key => $lang)
                            <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ $key }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="{{ $key }}[name]" class="form-label">
                                            {{ trans('dashboard/category.name') . ' / ' . $lang['native'] }}
                                        </label>
                                        <input type="text" name="{{ $key }}[name]" class="form-control"
                                            value="{{ $section->translate($key)->name ?? '' }}" required>
                                    </div>
                                   
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="product_ids" class="form-label">اختر المنتجات</label>
                            <select name="product_ids[]" id="product_ids" class="form-select" multiple>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $section->products->contains($product->id) ? 'selected' : ''
                                    }}>
                                    {{ $product->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="category_ids" class="form-label">اختر التصنيفات</label>
                            <select name="category_ids[]" id="category_ids" class="form-select" multiple>
                                <option value="">-- بدون تصنيف --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id, $section->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="order" class="form-label">ترتيب القسم</label>
                            <select class="form-select" name="order" id="order">
                                <option value="0">-- افتراضي --</option>
                                @foreach($orders as $order)
                                <option value="{{ $order }}" {{ $section->order == $order ? 'selected' : '' }}>
                                    {{ $order }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3 w-100">تحديث</button>
            </form>
        </div>
        <!--end::Form-->
    </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
    $('#product_ids').select2({
    placeholder: "اختر المنتجات",
    allowClear: true,
    dropdownParent: $('body'), // 👈 مهم جدًا للجوال
    width: '100%'
});

$('#category_ids').select2({
    placeholder: "اختر التصنيف",
    allowClear: true,
    dropdownParent: $('body'), // 👈 نفس الشيء
    width: '100%'
});

</script>
<script>
$(document).on('select2:open', function() {
    if ($('.select2-backdrop').length === 0) {
        $('body').addClass('select2-open').append('<div class="select2-backdrop"></div>');
    }
});
$(document).on('select2:close', function() {
    $('body').removeClass('select2-open');
    $('.select2-backdrop').fadeOut(150, function() {
        $(this).remove();
    });
});


</script>


@endpush
