<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <div class="d-flex align-items-center">

            <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout"
                data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-none d-lg-inline-block" data-toggle="layout"
                data-action="sidebar_mini_toggle">
                <i class="fa fa-fw fa-ellipsis-v"></i>
            </button>
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
            <!-- User Dropdown -->
            <div class="dropdown d-inline-block ms-2">
                <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle" src="/assets/media/avatars/avatar10.jpg" alt="Header Avatar"
                        style="width: 21px;">
                    <span class="d-none d-sm-inline-block ms-2">{{ Auth::user()->username }}</span>
                    <i class="mt-1 opacity-50 fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1"></i>
                </button>
                <div class="p-0 border-0 dropdown-menu dropdown-menu-md dropdown-menu-end"
                    aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                        <img class="img-avatar img-avatar48 img-avatar-thumb" src="/assets/media/avatars/avatar10.jpg"
                            alt="">
                        <p class="mt-2 mb-0 fw-medium">{{ Auth::user()->username }}</p>
                        <p class="mb-0 text-muted fs-sm fw-medium">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between {{ request()->routeIs('profileadmin.index') ? 'active' : '' }}"
                            href="{{ route('profileadmin.index') }}">
                            <span class="fs-sm fw-medium">Profile</span>
                        </a>
                    </div>
                    <div role="separator" class="m-0 dropdown-divider"></div>
                    <div class="p-2">
                        <form method="POST" action="/logout" class="d-flex align-items-center justify-content-between">
                            @csrf
                            <button type="submit" class="bg-transparent border-0 dropdown-item fs-sm fw-medium">
                                Log Out
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
