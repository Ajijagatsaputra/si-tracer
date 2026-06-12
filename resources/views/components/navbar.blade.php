<!-- Navigation Bar-->
<div class="bg-primary-darker sticky-top" style="z-index: 1030;">
    <div class="container py-3 content">
        <!-- Toggle Main Navigation -->
        <div class="d-lg-none">
            <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
            <button type="button" class="btn w-100 btn-alt-secondary d-flex justify-content-between align-items-center"
                data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
                Menu
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <!-- END Toggle Main Navigation -->

        <!-- Main Navigation -->
        <div id="main-navigation" class="mt-2 d-none d-lg-block mt-lg-0">
            <ul class="nav-main nav-main-dark nav-main-horizontal nav-main-hover">
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="nav-main-link-icon si si-compass"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </a>
                </li>

                @php
                    $user = Auth::user();
                    $existingTracer = \App\Models\TracerStudy::where('user_id', $user->id)->first();
                    $tracerPengguna = null;
                    if ($existingTracer) {
                        $tracerPengguna = \App\Models\TracerPengguna::where('tracer_study_id', $existingTracer->id)->first();
                    }
                @endphp

                <!-- Conditional Tracer Study Menu -->
                @if (!$existingTracer)
                    <!-- Direct Link if not filled yet -->
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->routeIs('new-tracer.index') ? 'active' : '' }}"
                            href="{{ route('new-tracer.index') }}">
                            <i class="nav-main-link-icon fa fa-edit"></i>
                            <span class="nav-main-link-name">Isi Tracer Study</span>
                        </a>
                    </li>
                @else
                    <!-- Dropdown if already filled -->
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu {{ request()->routeIs('new-tracer.*') || request()->routeIs('supervisor.questionnaire.*') ? 'active' : '' }}"
                            data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                            <i class="nav-main-link-icon fa fa-user-graduate"></i>
                            <span class="nav-main-link-name">Tracer Study</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ request()->routeIs('new-tracer.show') ? 'active' : '' }}"
                                    href="{{ route('new-tracer.show', $existingTracer->alumni_id) }}">
                                    <span class="nav-main-link-name">Lihat Kuesioner Saya</span>
                                </a>
                            </li>
                            @if ($tracerPengguna && !empty($tracerPengguna->token_akses))
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ request()->routeIs('supervisor.questionnaire.hasil') ? 'active' : '' }}"
                                        href="{{ route('supervisor.questionnaire.hasil', ['token' => $tracerPengguna->token_akses]) }}">
                                        <span class="nav-main-link-name">Kuesioner Atasan (Perusahaan)</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Resume & CV ATS Menu -->
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->routeIs('profile.cv') ? 'active' : '' }}"
                        href="{{ route('profile.cv') }}">
                        <i class="nav-main-link-icon fa fa-file-invoice"></i>
                        <span class="nav-main-link-name">Resume & CV ATS</span>
                    </a>
                </li>

                <!-- Bursa Kerja Menu -->
                <li class="nav-main-item">
                    <a class="nav-main-link {{ request()->routeIs('alumni.loker.*') ? 'active' : '' }}"
                        href="{{ route('alumni.loker.index') }}">
                        <i class="nav-main-link-icon fa fa-briefcase"></i>
                        <span class="nav-main-link-name">Riwayat Lamaran</span>
                    </a>
                </li>

                @if (Auth::user()->role !== 'alumni')
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="be_pages_dashboard.html">
                            <i class="nav-main-link-icon fa fa-chalkboard-teacher"></i>
                            <span class="nav-main-link-name">Perwalian</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- END Main Navigation -->
    </div>
</div>
<!-- END Navigation -->