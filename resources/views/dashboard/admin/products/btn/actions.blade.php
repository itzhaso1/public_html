<div class="d-flex justify-content-center align-items-center gap-2">
    <!-- Edit Button -->
    <a href="{{ route('admin.products.edit', $product->id) }}" 
       class="btn btn-outline-primary btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
       style="width: 32px; height: 32px; transition: all 0.3s ease;"
       data-bs-toggle="tooltip" 
       data-bs-placement="top" 
       title="تعديل">
        <i class="fas fa-pen fa-sm"></i>
    </a>

    <!-- Delete Button -->
    <button type="button" 
            class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
            style="width: 32px; height: 32px; transition: all 0.3s ease;"
            data-bs-toggle="modal" 
            data-bs-target="#deleteModal{{ $product->id }}"
            title="حذف">
        <i class="fas fa-trash-alt fa-sm"></i>
    </button>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-bottom-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body text-center pt-0 pb-4">
                <div class="mb-3 text-danger">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10 p-4">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
                <h5 class="modal-title fw-bold mb-2" id="deleteModalLabel{{ $product->id }}">تأكيد الحذف</h5>
                <p class="text-muted mb-1">هل أنت متأكد من رغبتك في حذف هذا العنصر؟</p>
                <div class="p-2 bg-light rounded border d-inline-block mt-2 px-4">
                    <strong class="text-dark">{{ $product->name }}</strong>
                </div>
                <p class="small text-danger mt-3 mb-0">
                    <i class="fas fa-info-circle me-1"></i> هذا الإجراء نهائي ولا يمكن التراجع عنه.
                </p>
            </div>
            <div class="modal-footer border-top-0 justify-content-center bg-light py-3">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-bold">
                        <i class="fas fa-trash me-1"></i> حذف نهائي
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>