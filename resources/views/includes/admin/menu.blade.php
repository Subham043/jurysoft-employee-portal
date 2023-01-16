
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="{{route('dashboard')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo.png') }}" alt="" height="50">
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="{{route('dashboard')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo-sm.png') }}" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo.png') }}" alt="" height="50">
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>

                <div id="scrollbar">
                    <div class="container-fluid">
            
                        <div id="two-column-menu">
                        </div>
                        <ul class="navbar-nav" id="navbar-nav">
                            <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                            @if(Auth::user() &&  Auth::user()->userType == 1)
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'department') !== false || strpos(url()->current(),'designation') !== false || strpos(url()->current(),'division') !== false || strpos(url()->current(),'employee-type') !== false|| strpos(url()->current(),'mode-of-exit') !== false || strpos(url()->current(),'medical-allowance') !== false || strpos(url()->current(),'conveyance-allowance') !== false || strpos(url()->current(),'professional-tax') !== false || strpos(url()->current(),'payslip-download-reason') !== false ? 'active' : ''}}" href="#sidebarDashboards6" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'department') !== false || strpos(url()->current(),'designation') !== false || strpos(url()->current(),'division') !== false || strpos(url()->current(),'employee-type') !== false|| strpos(url()->current(),'mode-of-exit') !== false || strpos(url()->current(),'medical-allowance') !== false || strpos(url()->current(),'conveyance-allowance') !== false || strpos(url()->current(),'professional-tax') !== false || strpos(url()->current(),'payslip-download-reason') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards6">
                                    <i class="ri-bookmark-3-fill"></i> <span data-key="t-dashboards">Master</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'department') !== false || strpos(url()->current(),'designation') !== false || strpos(url()->current(),'division') !== false || strpos(url()->current(),'employee-type') !== false || strpos(url()->current(),'mode-of-exit') !== false || strpos(url()->current(),'medical-allowance') !== false || strpos(url()->current(),'conveyance-allowance') !== false || strpos(url()->current(),'professional-tax') !== false || strpos(url()->current(),'payslip-download-reason') !== false ? 'show' : ''}}" id="sidebarDashboards6">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('department_view')}}" class="nav-link {{strpos(url()->current(),'department') !== false ? 'active' : ''}}" data-key="t-analytics"> Department </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('designation_view')}}" class="nav-link {{strpos(url()->current(),'designation') !== false ? 'active' : ''}}" data-key="t-analytics"> Designation </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('division_view')}}" class="nav-link {{strpos(url()->current(),'division') !== false ? 'active' : ''}}" data-key="t-analytics"> Division </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('employee_type_view')}}" class="nav-link {{strpos(url()->current(),'employee-type') !== false ? 'active' : ''}}" data-key="t-analytics"> Employee Type </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('exit_mode_view')}}" class="nav-link {{strpos(url()->current(),'mode-of-exit') !== false ? 'active' : ''}}" data-key="t-analytics"> Mode of Exit </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('payslip_download_reason_view')}}" class="nav-link {{strpos(url()->current(),'payslip-download-reason') !== false ? 'active' : ''}}" data-key="t-analytics"> Payslip Download Reason </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('medical_allowance_create')}}" class="nav-link {{strpos(url()->current(),'medical-allowance') !== false ? 'active' : ''}}" data-key="t-analytics"> Medical Allowance </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('conveyance_allowance_create')}}" class="nav-link {{strpos(url()->current(),'conveyance-allowance') !== false ? 'active' : ''}}" data-key="t-analytics"> Conveyance Allowance </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('professional_tax_create')}}" class="nav-link {{strpos(url()->current(),'professional-tax') !== false ? 'active' : ''}}" data-key="t-analytics"> Professional Tax </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            @endif
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'employee') !== false ? 'active' : ''}}" href="{{route(Auth::user() &&  Auth::user()->userType == 1 || Auth::user()->userType == 3 ? 'subadmin_view' : 'subadmin_detail')}}">
                                    <i class="ri-admin-fill"></i> <span data-key="t-widgets">Employee</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'payslip') !== false ? 'active' : ''}}" href="{{route(Auth::user() &&  Auth::user()->userType == 1 || Auth::user()->userType == 3 ? 'payslip_view' : 'payslip_view_user')}}">
                                    <i class="ri-file-list-3-fill"></i> <span data-key="t-widgets">Payslip</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>