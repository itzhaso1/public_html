<div class="menu-item">
    <div class="pb-2 menu-content">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ check_guard()->name }} Dashboard</span>
    </div>
</div>
<!-- Orders -->
<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('general.orders.*') }}">
    <span class="menu-link {{ is_active('general.orders.*') }}">
        <span class="menu-icon"><i class="bi bi-box-seam fs-2"></i></span> <!-- Icon for items -->
        <span class="menu-title">الطلبات</span>
        <span class="menu-arrow"></span>
    </span>
    <div class="menu-sub menu-sub-accordion menu-active-bg">
        <div class="menu-item">
            <a class="menu-link {{ is_active('general.orders.index') }}" href="{{ route('general.orders.index') }}">
                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                <span class="menu-title">الطلبات</span>
            </a>
        </div>
    </div>
</div>
