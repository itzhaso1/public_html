<div class="d-flex justify-content-center">
    <!-- Edit Button -->
    <a href="{{ route('admin.orders.show', $order->id) }}" class="mx-1 btn btn-success btn-sm" title="Show">
        <i class="fas fa-eye"></i> <!-- Font Awesome edit icon -->
    </a>
    {{--<a href="{{ route('general.orders.edit', $order->id) }}" class="mx-1 btn btn-primary btn-sm" title="Edit">
        <i class="fas fa-edit"></i> <!-- Font Awesome edit icon -->
    </a>--}}

    {{--<a href="{{ route('admin.orders.invoice', $order->id) }}" class="mx-1 btn btn-primary btn-sm" title="Edit">
        <i class="fas fa-download"></i> <!-- Font Awesome edit icon -->
    </a>--}}
</div>
