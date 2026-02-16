@foreach (['success', 'error', 'warning', 'info'] as $msg)
@if(session($msg))
<div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} alert-dismissible fade show flash-message" role="alert">
    {{ session($msg) }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@endforeach

{{-- Auto hide alerts after 4 seconds --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alerts = document.querySelectorAll('.flash-message');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.classList.remove('show');
                alert.classList.add('hide');
                alert.style.opacity = '0';
            }, 4000); // 4 seconds
        });
    });
</script>
