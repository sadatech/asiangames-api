            <div class="page-sidebar-wrapper">
                <!-- END SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item start active open">
                            <a href="{{ url('/') }}" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                @if(Request::is('/'))
                                    <span class="selected"></span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item start active open">
                            <a href="#" class="nav-link nav-toggle">
                                <i class="icon-notebook"></i>
                                <span class="title">Sports Management</span>
                                @if(Request::is('branchsport'))                        
                                    <span class="selected"></span>                 
                                @endif
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start {{ Request::is('branchsport') ? 'open' : '' }}">
                                    <a href="{{ url('/branchsport') }}" class="nav-link ">
                                        <i class="icon-social-dribbble"></i>
                                        <span class="title">Branch Sports</span>
                                    </a>                                    
                                </li>
                                <li class="nav-item start {{ Request::is('kindsport') ? 'open' : '' }}">
                                    <a href="#" class="nav-link ">
                                        <i class="icon-support"></i>
                                        <span class="title">Kind of Sports</span>                                        
                                    </a>
                                </li>
                                <li class="nav-item start {{ Request::is('typesport') ? 'open' : '' }}">
                                    <a href="#" class="nav-link ">
                                        <i class="icon-screen-tablet"></i>
                                        <span class="title">Type of Sports</span>                                        
                                    </a>
                                </li>
                            </ul>
                        </li>                        
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div><!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->