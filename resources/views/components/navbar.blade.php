   <!-- Navigation Bar-->
   <div class="bg-primary-darker sticky-top" style="z-index : 1030;">
       <div class="content py-3 container">
           <!-- Toggle Main Navigation -->
           <div class="d-lg-none">
               <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
               <button type="button"
                   class="btn w-100 btn-alt-secondary d-flex justify-content-between align-items-center"
                   data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
                   Menu
                   <i class="fa fa-bars"></i>
               </button>
           </div>
           <!-- END Toggle Main Navigation -->

           <!-- Main Navigation -->
           <div id="main-navigation" class="d-none d-lg-block mt-2 mt-lg-0">
               <ul class="nav-main nav-main-dark nav-main-horizontal nav-main-hover">
                   <li class="nav-main-item">
                       <a class="nav-main-link active" href="/">
                           <i class="nav-main-link-icon si si-compass"></i>
                           <span class="nav-main-link-name">Dashboard</span>
                       </a>
                   </li>
                   <li class="nav-main-heading">Tracer Study</li>
                   <li class="nav-main-item">
                       <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="false" href="#">
                           <i class="nav-main-link-icon fa fa-user-graduate"></i>
                           <span class="nav-main-link-name">Tracer Study</span>
                       </a>
                       <ul class="nav-main-submenu">
                           <li class="nav-main-item">
                               <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                   aria-expanded="false" href="/kuesioner">
                                   <span class="nav-main-link-name">Isi Kuesioner</span>
                               </a>
                               <ul class="nav-main-submenu">
                                   @php
                                       $existingTracer = \App\Models\TracerStudy::where('user_id', Auth::user()->id)->first();
                                   @endphp
                                   <li class="nav-main-item">
                                       @if($existingTracer)
                                           <a class="nav-main-link disabled" href="{{ route('new-tracer.show', $existingTracer->alumni_id) }}" tabindex="-1" aria-disabled="true">
                                               <span class="nav-main-link-name">Tracer Study Alumni</span>
                                           </a>
                                       @else
                                           <a class="nav-main-link" href="{{ route('new-tracer.index') }}">
                                               <span class="nav-main-link-name">Tracer Study Alumni</span>
                                           </a>
                                       @endif
                                   </li>
                               </ul>
                           </li>
                           @php
                               $tracerStudy = \App\Models\TracerStudy::where('user_id', Auth::user()->id)->first();
                               $tracerPengguna = null;
                               if ($tracerStudy) {
                                   $tracerPengguna = \App\Models\TracerPengguna::where('tracer_study_id', $tracerStudy->id)->first();
                               }
                           @endphp
                           @if ($tracerPengguna)
                            <li class="nav-main-item">
                                @if (!empty($tracerPengguna->token_akses))
                                    <a class="nav-main-link" href="{{ route('supervisor.questionnaire.hasil', ['token' => $tracerPengguna->token_akses]) }}">
                                        <span class="nav-main-link-name">Tracer Study Pengguna</span>
                                    </a>
                                @else
                                    <a class="nav-main-link disabled" href="#" tabindex="-1" aria-disabled="true">
                                        <span class="nav-main-link-name">Tracer Study Pengguna</span>
                                    </a>
                                @endif
                            </li>
                            @endif
                       </ul>
                   </li>
                   @if (!Auth::user()->role === 'alumni')
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
