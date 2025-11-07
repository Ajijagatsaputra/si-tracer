<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
        <!-- Logo -->
        <a class="fw-semibold text-dual" href="/">
            <span class="smini-visible">
                <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="tracking-wider smini-hide fs-5">
                SIKEMA<span class="fw-normal text-primary">TI</span>
            </span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div>
            <!-- Dark Mode -->
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout"
                data-action="dark_mode_toggle">
                <i class="far fa-moon"></i>
            </button>

            <!-- Close Sidebar (Mobile) -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close"
                href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">

                <!-- DASHBOARD -->
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="/">
                        <i class="nav-main-link-icon fa fa-tachometer-alt text-primary"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </a>
                </li>

                <!-- KEMAHASISWAAN -->
                <li class="nav-main-heading text-uppercase text-muted fw-bold">Kemahasiswaan</li>

                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-users text-info"></i>
                        <span class="nav-main-link-name">Data Master</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('listalumni') }}">
                                <i class="nav-main-link-icon fa fa-user-graduate"></i>
                                <span class="nav-main-link-name">Data Alumni</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('listmahasiswa') }}">
                                <i class="nav-main-link-icon fa fa-user"></i>
                                <span class="nav-main-link-name">Data Mahasiswa</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- TRACER STUDY -->
                <li class="nav-main-heading text-uppercase text-muted fw-bold">Tracer Study</li>

                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-clipboard-list text-success"></i>
                        <span class="nav-main-link-name">Kelola Tracer</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('listtraceralumni.index') }}">
                                <i class="nav-main-link-icon fa fa-user-check"></i>
                                <span class="nav-main-link-name">Alumni</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('admin.supervisor-questionnaire.index') }}">
                                <i class="nav-main-link-icon fa fa-briefcase"></i>
                                <span class="nav-main-link-name">Pengguna</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('tracer.rekap') }}">
                                <i class="nav-main-link-icon fa fa-chart-bar"></i>
                                <span class="nav-main-link-name">Hasil</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- PREDIKSI -->
                <li class="nav-main-heading text-uppercase text-muted fw-bold">Prediksi</li>

                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-brain text-warning"></i>
                        <span class="nav-main-link-name">Prediksi Alumni</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('admin.prediksi.data') }}">
                                <i class="nav-main-link-icon fa fa-database"></i>
                                <span class="nav-main-link-name">Data Prediksi</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
