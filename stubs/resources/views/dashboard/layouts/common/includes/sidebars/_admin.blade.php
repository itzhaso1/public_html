<div class="sidebar">
    <div class="menu-item">
        <div class="pb-2 menu-content">
            <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ check_guard()->name . ' | ' .
                $settings?->name }}
            </span>
        </div>
    </div>

    <!-- Admins Menu -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.admins.*') }}">
        <span class="menu-link {{ is_active('admin.admins.*') }}">
            <span class="menu-icon"><i class="bi bi-person fs-2"></i></span>
            <span class="menu-title">المديرين</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.admins.index') }}" href="{{ route('admin.admins.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">المديرين</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.admins.create') }}" href="{{ route('admin.admins.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">{{ trans('dashboard/admin.create_admin') }}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Users Menu -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.user.*') }}">
        <span class="menu-link {{ is_active('admin.user.*') }}">
            <span class="menu-icon"><i class="bi bi-list fs-2"></i></span>
            <span class="menu-title">المستخدمين</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.user.index') }}" href="{{ route('admin.user.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">المستخدمين</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Main Setting Menu -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.mainSettings.*') }}">
        <span class="menu-link {{ is_active('admin.mainSettings.*') }}">
            <span class="menu-icon"><i class="bi bi-person fs-2"></i></span>
            <span class="menu-title">الاعدادات العامه</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.mainSettings.index') }}"
                    href="{{ route('admin.mainSettings.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">الاعدادات العامه</span>
                </a>
                <a class="menu-link {{ is_active('admin.about.create') }}"
                    href="{{ route('admin.about.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title"> من نحن</span>
                </a>
                <a class="menu-link {{ is_active('admin.aboutCounters.index') }}" href="{{ route('admin.aboutCounters.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">عدادات من نحن</span>
                </a>
                <a class="menu-link {{ is_active('admin.contact.create') }}" href="{{ route('admin.contact.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">اتصل بنا</span>
                </a>
                <a class="menu-link {{ is_active('admin.privacy.index') }}" href="{{ route('admin.privacy.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">سياسه الخصوصيه</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Sliders -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.sliders.*') }}">
        <span class="menu-link {{ is_active('admin.sliders.*') }}">
            <span class="menu-icon"><i class="bi bi-list fs-2"></i></span>
            <span class="menu-title">الصور المتحركه</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.sliders.index') }}" href="{{ route('admin.sliders.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">الصور المتحركه</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.sliders.create') }}" href="{{ route('admin.sliders.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">إضافة صوره</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Categories Menu -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.categories.*') }}">
        <span class="menu-link {{ is_active('admin.categories.*') }}">
            <span class="menu-icon"><i class="bi bi-list fs-2"></i></span>
            <span class="menu-title">التصنيفات</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.categories.index') }}"
                    href="{{ route('admin.categories.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">التصنيفات</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.categories.create') }}"
                    href="{{ route('admin.categories.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">إضافة تصنيف</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Brands Menu -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.brands.*') }}">
        <span class="menu-link {{ is_active('admin.brands.*') }}">
            <span class="menu-icon"><i class="bi bi-list fs-2"></i></span>
            <span class="menu-title">الماركات</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.brands.index') }}" href="{{ route('admin.brands.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">الماركات</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.brands.create') }}" href="{{ route('admin.brands.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">إضافة ماركه</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Types Menu -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.types.*') }}">
        <span class="menu-link {{ is_active('admin.types.*') }}">
            <span class="menu-icon"><i class="bi bi-list fs-2"></i></span>
            <span class="menu-title">الوحدات</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.types.index') }}" href="{{ route('admin.types.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">الوحدات</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.types.create') }}" href="{{ route('admin.types.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">إضافة وحده</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Types Menu -->

    <!-- Tags Menu -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.tags.*') }}">
        <span class="menu-link {{ is_active('admin.tags.*') }}">
            <span class="menu-icon"><i class="bi bi-list fs-2"></i></span>
            <span class="menu-title">الكلمات المفتاحيه</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.tags.index') }}" href="{{ route('admin.tags.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">الكلمات المفتاحيه</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.tags.create') }}" href="{{ route('admin.tags.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">إضافة</span>
                </a>
            </div>
        </div>
    </div>

    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.coupons.*') }}">
        <span class="menu-link {{ is_active('admin.coupons.*') }}">
            <span class="menu-icon"><i class="bi bi-box-seam fs-2"></i></span> <!-- Icon for items -->
            <span class="menu-title">كوبونات الخصم</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.coupons.index') }}" href="{{ route('admin.coupons.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">الكوبونات</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.coupons.create') }}"
                    href="{{ route('admin.coupons.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">اضافه كوبون</span>
                </a>
            </div>
        </div>
    </div>


    <!-- Section Menu -->
<div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.sections.*') }}">
        <span class="menu-link {{ is_active('admin.sections.*') }}">
            <span class="menu-icon"><i class="bi bi-box-seam fs-2"></i></span> <!-- Icon for items -->
            <span class="menu-title">الاقسام</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.products.index') }}" href="{{ route('admin.sections.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">الاقسام</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.sections.create') }}"
                    href="{{ route('admin.sections.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">اضافه قسم</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Products Menu -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.products.*') }}">
        <span class="menu-link {{ is_active('admin.products.*') }}">
            <span class="menu-icon"><i class="bi bi-box-seam fs-2"></i></span> <!-- Icon for items -->
            <span class="menu-title">{{ trans('dashboard/admin.product.products') }}</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.products.index') }}" href="{{ route('admin.products.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">{{ trans('dashboard/admin.product.products') }}</span>
                </a>
            </div>
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.products.create') }}" href="{{ route('admin.products.create') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">{{ trans('dashboard/admin.product.create_product') }}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Orders -->
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ is_active('admin.orders.*') }}">
        <span class="menu-link {{ is_active('admin.orders.*') }}">
            <span class="menu-icon"><i class="bi bi-box-seam fs-2"></i></span> <!-- Icon for items -->
            <span class="menu-title">الطلبات</span>
            <span class="menu-arrow"></span>
        </span>
        <div class="menu-sub menu-sub-accordion menu-active-bg">
            <div class="menu-item">
                <a class="menu-link {{ is_active('admin.orders.index') }}" href="{{ route('admin.orders.index') }}">
                    <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                    <span class="menu-title">الطلبات</span>
                </a>
            </div>
        </div>
    </div>
</div>
