<div id="layoutSidenav_nav">

    <div class="user_profile">
        <img class="profile-image"
            src="{{ Auth::user()->profile_image ? asset('uploads/user-images/' . Auth::user()->profile_image) : asset('assets/img/no-img.jpg') }}"
            alt="">

        <div class="profile-title">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
        <div class="profile-description">{{ Auth::user()->roles->name }}</div>
    </div>

    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">

            <div class="nav">

                {{-- <a class="nav-link" target="_blank" href="{{ route('home') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-globe"></i></div>
                    View Website
                </a> --}}

                @if (Helper::hasRight('partner.view'))
                    <a class="nav-link {{ Route::is('admin.machineTrans.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.machineTrans.dashboard') }}"
                        href="{{ route('admin.machineTrans.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div> Dashboard
                    </a>
                @endif

                {{-- Setting --}}
                {{-- @if (Helper::hasRight('setting.view'))
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#settingNav"
                        aria-expanded="@if (Route::is('admin.setting.general') || Route::is('admin.setting.static.content') || Route::is('admin.setting.legal.content') || Route::is('admin.contact') || Route::is('admin.setting.journey.unity.content') || Route::is('admin.resource')) true @else false @endif"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div> Setup
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse @if (Route::is('admin.setting.general') || Route::is('admin.setting.static.content') || Route::is('admin.setting.legal.content') || Route::is('admin.contact') || Route::is('admin.setting.journey.unity.content') || Route::is('admin.resource')) show @endif" id="settingNav"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav down">
                            @if (Helper::hasRight('setting.general'))
                                <a class="nav-link {{ Route::is('admin.setting.general') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.general') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> General Setting </a>
                            @endif

                            @if (Helper::hasRight('setting.static-content'))
                                <a class="nav-link {{ Route::is('admin.setting.static.content') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.static.content') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Static Content</a>
                            @endif
                            @if (Helper::hasRight('setting.journey-content'))
                                <a class="nav-link {{ Route::is('admin.setting.journey.unity.content') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.journey.unity.content') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Frontend Content</a>
                            @endif
                            @if (Helper::hasRight('setting.alumni-content'))
                                <a class="nav-link {{ Route::is('admin.setting.alumni-content') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.alumni-content') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Alumni Page Content</a>
                            @endif
                            @if (Helper::hasRight('setting.legal-content'))
                                <!--<a class="nav-link {{ Route::is('admin.setting.legal.content') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.legal.content') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Legal Content</a>-->
                            @endif

                            @if (Helper::hasRight('contact.view'))
                                <a class="nav-link {{ Route::is('admin.contact') ? 'active' : '' }}"
                                    href="{{ route('admin.contact') }}"><i class="fa-solid fa-angles-right ikon"></i>
                                    Contact Management
                                </a>
                            @endif

                            
                        </nav>
                    </div>
                @endif --}}


                {{-- Addministrator  --}}
                @if (Helper::hasRight('setting.view'))
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#setupNav"
                        aria-expanded="@if (Route::is('admin.role') ||
                                Route::is('admin.role.create') ||
                                Route::is('admin.role.edit') ||
                                Route::is('admin.role.right') ||
                                Route::is('admin.partner') ||
                                Route::is('admin.partner.product') ||
                                Route::is('admin.user')) true @else false @endif"
                        aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-school"></i></div> Administration
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse @if (Route::is('admin.role') ||
                            Route::is('admin.role.create') ||
                            Route::is('admin.role.edit') ||
                            Route::is('admin.role.right') ||
                            Route::is('admin.partner') ||
                            Route::is('admin.partner.product') ||
                            Route::is('admin.user')) show @endif" id="setupNav"
                        aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav down">
                            @if (Helper::hasRight('role.view'))
                                <a class="nav-link {{ Route::is('admin.role') || Route::is('admin.role.create') || Route::is('admin.role.edit') ? 'active' : '' }}"
                                    href="{{ route('admin.role') }}"><i class="fa-solid fa-angles-right ikon"></i> Role
                                    Management</a>
                            @endif


                            @if (Helper::hasRight('user.view'))
                                <a class="nav-link {{ Route::is('admin.user') ? 'active' : '' }}"
                                    href="{{ route('admin.user') }}"><i class="fa-solid fa-angles-right ikon"></i> User
                                    Management
                                </a>
                            @endif


                            @if (Helper::hasRight('department.view'))
                                <a class="nav-link {{ Route::is('admin.department.index') ? 'active' : '' }}"
                                    href="{{ route('admin.department.index') }}"><i
                                        class="fa-solid fa-angles-right ikon"></i> Department
                                    Management
                                </a>
                            @endif
                        </nav>
                    </div>
                @endif


                {{-- Machine Transfer  --}}
                @if (Helper::hasRight('activity.view'))
                
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#unitNav"
                        aria-expanded="{{ Route::is('admin.unit.user') || Route::is('admin.machineTrans.*') || Route::is('machine-transfer.*') ? 'true' : 'false' }}"
                        aria-controls="unitNav">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-shapes"></i></div>
                        Unit Management
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse {{ Route::is('admin.unit.user') || Route::is('admin.machineTrans.*') || Route::is('machine-transfer.*') ? 'show' : '' }}"
                        id="unitNav" data-bs-parent="#sidenavAccordion">

                        <nav class="sb-sidenav-menu-nested nav down">

                            @if (Helper::hasRight('event.view'))
                                {{-- Unit List --}}
                                @if (Helper::hasRight('alumni.view'))
                                    <a class="nav-link {{ Route::is('admin.unit.user') ? 'active' : '' }}"
                                        href="{{ route('admin.unit.user') }}">
                                        <i class="fa-solid fa-angles-right ikon"></i> Unit List
                                    </a>
                                @endif    

                                {{-- Machine Transfer --}}
                                <a class="nav-link {{ Route::is('admin.machineTrans.user') ? 'active' : '' }}"
                                    href="{{ route('admin.machineTrans.user') }}">
                                    <i class="fa-solid fa-angles-right ikon"></i> Machine Transfer
                                </a>
                            @endif

                            @if (Helper::hasRight('category.view'))
                                {{-- Machine Transfer Approvals --}}
                                <a class="nav-link {{ Route::is('machine-transfer.approvals') ? 'active' : '' }}"
                                    href="{{ route('machine-transfer.approvals') }}">
                                    <i class="fa-solid fa-angles-right ikon"></i> Transfer Verification
                                </a>
                            @endif    
                        </nav>
                    </div>
                @endif

                  {{-- Product Management --}}
                @if (Helper::hasRight('activity.view'))
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#categoryNav"
                        aria-expanded="{{ Route::is('admin.category.*') || Route::is('admin.subcategory.*') || Route::is('admin.product.*') ? 'true' : 'false' }}"
                        aria-controls="categoryNav">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-layer-group"></i></div>
                        Product Management
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse {{ Route::is('admin.category.*') || Route::is('admin.subcategory.*') || Route::is('admin.product.*') ? 'show' : '' }}"
                        id="categoryNav" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav down">
                            {{-- Categories --}}
                            @if (Helper::hasRight('category.view'))
                                <a class="nav-link {{ Route::is('admin.category.index') || Route::is('admin.category.create') || Route::is('admin.category.edit') ? 'active' : '' }}"
                                    href="{{ route('admin.category.index') }}">
                                    <i class="fa-solid fa-angles-right ikon"></i> Categories
                                </a>
                            @endif

                            {{-- Sub Categories --}}
                            
                                <a class="nav-link {{ Route::is('admin.subcategory.index') || Route::is('admin.subcategory.create') || Route::is('admin.subcategory.edit') ? 'active' : '' }}"
                                    href="{{ route('admin.subcategory.index') }}">
                                    <i class="fa-solid fa-angles-right ikon"></i> Sub Categories
                                </a>
                            

                            {{-- Products --}}
                          
                                <a class="nav-link {{ Route::is('admin.product.index') || Route::is('admin.product.create') || Route::is('admin.product.edit') ? 'active' : '' }}"
                                    href="{{ route('admin.product.index') }}">
                                    <i class="fa-solid fa-angles-right ikon"></i> Products
                                </a>
                            
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </nav>
</div>