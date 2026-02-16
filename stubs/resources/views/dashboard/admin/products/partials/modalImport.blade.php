<!-- Modal -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importExcelModalLabel">استيراد منتجات من ملف Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="excelFile" class="form-label">اختر ملف Excel</label>
                        <input class="form-control" type="file" name="file" id="excelFile" accept=".xlsx,.xls" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">استيراد</button>
                </div>
            </form>
        </div>
    </div>
</div>
