<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <div class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 420px;">
            <button type="button" class="btn btn-sm btn-light border-0 text-secondary d-lg-none" data-toggle="layout"
                data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <button type="button" class="btn btn-sm btn-light border-0 text-secondary d-none d-lg-inline-block" data-toggle="layout"
                data-action="sidebar_mini_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="akila-header-search d-none d-sm-flex align-items-center flex-grow-1">
                <i class="fa fa-search text-muted"></i>
                <input type="text" id="akila-global-table-search" placeholder="Cari data pada halaman ini..." autocomplete="off">
            </div>
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-light border-0 text-secondary rounded-circle d-flex align-items-center justify-content-center"
                style="width: 34px; height: 34px;" data-toggle="layout" data-action="dark_mode_toggle" title="Tema Tampilan">
                <i class="fa fa-cog"></i>
            </button>

            <!-- User Dropdown -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-sm bg-transparent border-0 d-flex align-items-center p-1"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="akila-avatar-ring">
                        <i class="fa fa-user"></i>
                    </span>
                    <span class="d-none d-md-inline-block ms-2 fw-semibold text-dark" style="font-size: 0.84rem;">{{ Auth::user()->username }}</span>
                    <i class="opacity-50 fa fa-fw fa-angle-down d-none d-md-inline-block ms-1 text-muted" style="font-size: 0.75rem;"></i>
                </button>
                <div class="p-0 border dropdown-menu dropdown-menu-md dropdown-menu-end shadow-sm rounded-3"
                    aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                        <img class="img-avatar img-avatar48 img-avatar-thumb" src="/assets/media/avatars/avatar10.jpg"
                            alt="">
                        <p class="mt-2 mb-0 fw-semibold text-dark">{{ Auth::user()->username }}</p>
                        <p class="mb-0 text-muted fs-xs fw-medium text-uppercase">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between rounded-2 {{ request()->routeIs('profileadmin.index') ? 'active' : '' }}"
                            href="{{ route('profileadmin.index') }}">
                            <span class="fs-sm fw-medium"><i class="fa fa-user-cog me-2 text-muted"></i>Profil Saya</span>
                        </a>
                    </div>
                    <div role="separator" class="m-0 dropdown-divider"></div>
                    <div class="p-2">
                        <form method="POST" action="/logout" class="d-flex align-items-center justify-content-between">
                            @csrf
                            <button type="submit" class="bg-transparent border-0 dropdown-item fs-sm fw-medium text-danger rounded-2">
                                <i class="fa fa-sign-out-alt me-2"></i>Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->
</header>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const globalSearch = document.getElementById('akila-global-table-search');
        if (!globalSearch) return;
        globalSearch.addEventListener('input', function () {
            const val = this.value;
            if (window.jQuery && jQuery.fn && jQuery.fn.dataTable) {
                const tables = jQuery.fn.dataTable.tables({ visible: true, api: true });
                if (tables.count() > 0) {
                    tables.search(val).draw();
                }
            }
        });
    });
</script>
