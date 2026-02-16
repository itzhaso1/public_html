<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة باقة شحن</title>
    <!-- تنسيق جاهز -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <style>body { background-color: #f8f9fa; padding: 40px; font-family: Tahoma, sans-serif; }</style>
</head>
<body>
 
<div class="container" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">إضافة باقة جديدة (جواهر / ملابس)</h4>
        </div>
        <div class="card-body">
 
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
 
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
 
            <!-- ✅ تم التصحيح: أضفنا admin. قبل اسم الرابط -->
            <form action="{{ route('admin.products.store_charge') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">اختر النوع</label>
                    <select name="type_id" class="form-select" required>
                        <option value="" selected disabled>-- اختر --</option>
                        <option value="gems">💎 شحن جواهر</option>
                        <option value="codes">👕 أكواد ملابس</option>
                    </select>
                </div>
 
                <div class="mb-3">
                    <label class="form-label fw-bold">اسم الباقة</label>
                    <input type="text" name="name" class="form-control" placeholder="مثلاً: 100 جوهرة" required>
                </div>
 
                <div class="mb-3">
                    <label class="form-label fw-bold">السعر ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                </div>
 
                <button type="submit" class="btn btn-success w-100 py-2 fw-bold">حفظ الباقة</button>
            </form>
 
        </div>
    </div>
</div>
 
</body>
</html>