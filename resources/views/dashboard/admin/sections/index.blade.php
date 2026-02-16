@extends('dashboard.layouts.master')



<style>
/* 🫥 إخفاء أزرار التصدير والطباعة */
div.dt-buttons {
    display: none !important;
}

/* 🫥 إخفاء عمود "الوصف" بالكامل من الجدول */
table.dataTable th:nth-child(3),
table.dataTable td:nth-child(3) {
    display: none !important;
}

/* ✅ عرض الكروت بدل الجدول في الجوال والأجهزة الصغيرة */
@media (max-width: 1200px) {

    /* إخفاء رأس الجدول */
    table.dataTable thead {
        display: none !important;
    }

    /* إزالة شكل الجدول الكلاسيكي */
    table.dataTable {
        border: none !important;
        width: 100% !important;
        display: block !important;
    }

    /* 📦 جعل الصفوف شبكة grid */
    table.dataTable tbody {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)) !important;
        gap: 15px !important;
    }

    /* 🧩 تنسيق كل كرت (صف) */
    table.dataTable tbody tr {
        display: block !important;
        background: #ffffff !important;
        border-radius: 14px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
        padding: 16px 18px !important;
        border: 1px solid #e5e7eb !important;
        transition: all 0.2s ease-in-out;
    }

    table.dataTable tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(37, 99, 235, 0.15) !important;
    }

    /* ✏️ تنسيق كل حقل داخل الكرت */
    table.dataTable tbody td {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 8px 0 !important;
        border-bottom: 1px solid #f1f5f9 !important;
        font-size: 15px !important;
        color: #1e293b !important;
    }

    table.dataTable tbody td:last-child {
        border-bottom: none !important;
    }

    /* عنوان الحقل */
    table.dataTable tbody td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #2563eb;
        flex: 1;
        text-align: right;
    }

    /* المحتوى */
    table.dataTable tbody td span,
    table.dataTable tbody td div {
        flex: 1.5;
        text-align: left;
    }

    /* اسم القسم */
    table.dataTable tbody td:first-child {
        font-weight: 700 !important;
        color: #0f172a !important;
        font-size: 16px !important;
        padding-bottom: 10px !important;
    }

    /* زر الإجراءات */
    table.dataTable tbody td:last-child {
        text-align: center !important;
    }
}

/* 📱 في الشاشات الصغيرة جدًا (موبايل صغير) */
@media (max-width: 600px) {
    table.dataTable tbody {
        grid-template-columns: 1fr !important; /* صف واحد فقط */
    }
}
/* ✨ زر الحذف بتصميم فخم 3D */
.table .btn-delete,
button.btn-delete,
a.btn-delete {
    background: linear-gradient(145deg, #ef4444, #b91c1c) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    padding: 8px 16px !important;
    box-shadow: 0 4px 0 #991b1b, 0 6px 12px rgba(0, 0, 0, 0.15) !important;
    transition: all 0.2s ease-in-out !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
}

/* عند المرور عليه */
.table .btn-delete:hover,
button.btn-delete:hover,
a.btn-delete:hover {
    background: linear-gradient(145deg, #dc2626, #ef4444) !important;
    box-shadow: 0 3px 0 #7f1d1d, 0 8px 18px rgba(239, 68, 68, 0.4) !important;
    transform: translateY(-2px);
}

/* عند الضغط */
.table .btn-delete:active,
button.btn-delete:active,
a.btn-delete:active {
    transform: translateY(2px) !important;
    box-shadow: 0 1px 0 #7f1d1d, 0 2px 6px rgba(0, 0, 0, 0.2) !important;
}

/* أيقونة الحذف داخل الزر */
.btn-delete i,
.btn-delete svg {
    font-size: 16px;
    color: #fff !important;
    transition: transform 0.2s ease-in-out;
}

.btn-delete:hover i,
.btn-delete:hover svg {
    transform: rotate(15deg);
}

/* ✨ تحسين الأزرار الأخرى بجانبه (التعديل مثلاً) */
.table .btn-edit,
a.btn-edit {
    background: linear-gradient(145deg, #3b82f6, #1d4ed8) !important;
    color: #fff !important;
    border: none !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    padding: 8px 16px !important;
    box-shadow: 0 4px 0 #1e40af, 0 6px 12px rgba(0, 0, 0, 0.15) !important;
    transition: all 0.2s ease-in-out !important;
}

.table .btn-edit:hover {
    background: linear-gradient(145deg, #2563eb, #3b82f6) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35) !important;
}
/* 💎 تأثير فخم و3D واقعي على زر الحذف */
.btn-delete {
    background: linear-gradient(145deg, #f43f5e, #b91c1c) !important;
    border-radius: 12px !important;
    border: none !important;
    padding: 10px 20px !important;
    font-weight: 600 !important;
    color: white !important;
    letter-spacing: 0.3px !important;
    text-transform: none !important;
    position: relative !important;
    box-shadow: 
        inset 0 2px 4px rgba(255,255,255,0.2),
        0 6px 0 #991b1b,
        0 8px 18px rgba(0,0,0,0.15) !important;
    transition: all 0.25s ease-in-out !important;
}

/* ✨ لمعة خفيفة متحركة */
.btn-delete::after {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 200%;
    height: 100%;
    background: linear-gradient(
        120deg,
        transparent 0%,
        rgba(255,255,255,0.3) 50%,
        transparent 100%
    );
    transform: skewX(-20deg);
    animation: shimmer 4s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* 🫧 نبض خفيف كل بضع ثوانٍ */
@keyframes pulseGlow {
    0%, 100% {
        box-shadow: 0 6px 0 #991b1b, 0 8px 18px rgba(239,68,68,0.25);
        transform: scale(1);
    }
    50% {
        box-shadow: 0 6px 10px rgba(239,68,68,0.45), 0 0 25px rgba(239,68,68,0.25);
        transform: scale(1.03);
    }
}

.btn-delete {
    animation: pulseGlow 5s infinite ease-in-out;
}

/* 💥 تأثير الضغط */
.btn-delete:active {
    transform: translateY(3px) scale(0.97);
    box-shadow: 0 3px 0 #7f1d1d, 0 3px 8px rgba(0,0,0,0.2);
}

/* 🩵 تحسين مظهر أيقونة داخل الزر */
.btn-delete i,
.btn-delete svg {
    font-size: 16px;
    transition: transform 0.25s ease;
}
.btn-delete:hover i,
.btn-delete:hover svg {
    transform: rotate(-15deg);
}


</style>



@section('pageTitle')
{{$pageTitle}}
@endsection

@section('content')
@include('dashboard.layouts.common._partial.messages')
<div id="kt_content_container" class="container-xxl">
    <div class="mb-5 card card-xxl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="pt-5 border-0 card-header">
            <h3 class="card-title align-items-start flex-column">
                <span class="mb-1 card-label fw-bolder fs-3">{{$pageTitle}}</span>
                <span class="mt-1 text-muted fw-bold fs-7">{{$pageTitle}}</span>
                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover">
                    <a href="{{ route('admin.sections.create') }}" class="btn btn-sm btn-light btn-active-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        اضافشه قسم جديد
                    </a>
                </div>
            </h3>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="py-3 card-body">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table table-striped table-row-bordered gy-5 gs-7">
                    {!! $dataTable->table() !!}
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>
    @endsection

    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {!! $dataTable->scripts() !!}
    @endpush
