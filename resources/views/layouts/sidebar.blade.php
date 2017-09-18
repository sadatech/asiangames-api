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
                            <a href="{{ url('sport') }}" class="nav-link nav-toggle">
                                <i class="icon-notebook"></i>
                                <span class="title">Sports</span>
                                @if(Request::is('sport*') || Request::is('branchsport*') || Request::is('kindsport*') || Request::is('typesport*'))
                                    <span class="selected"></span>                 
                                @endif
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start {{ Request::is('branchsport*') ? 'open' : '' }}">
                                    <a href="{{ url('branchsport') }}" class="nav-link ">
                                        <i class="icon-social-dribbble"></i>
                                        <span class="title">Branch Sports</span>
                                    </a>                                    
                                </li>
                                <li class="nav-item start {{ Request::is('kindsport*') ? 'open' : '' }}">
                                    <a href="{{ url('kindsport') }}" class="nav-link ">
                                        <i class="icon-support"></i>
                                        <span class="title">Kind of Sports</span>                                        
                                    </a>
                                </li>
                                <li class="nav-item start {{ Request::is('typesport*') ? 'open' : '' }}">
                                    <a href="{{ url('typesport') }}" class="nav-link ">
                                        <i class="fa fa-soccer-ball-o"></i>
                                        <span class="title">Type of Sports</span>                                        
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item start active open">
                            <a href="{{ url('countries') }}" class="nav-link nav-toggle">
                                <i class="fa fa-globe"></i>
                                <span class="title">Countries</span>
                                @if(Request::is('countries*'))
                                    <span class="selected"></span>                 
                                @endif                                
                            </a>                            
                        </li>
                        <li class="nav-item start active open">
                            <a href="{{ url('athletes') }}" class="nav-link nav-toggle">
                                <i class="fa fa-group"></i>
                                <span class="title">Athletes</span>
                                @if(Request::is('athletes*'))
                                    <span class="selected"></span>                 
                                @endif                                
                            </a>                            
                        </li>
                        <li class="nav-item start active open">
                            <a href="{{ url('schedules') }}" class="nav-link nav-toggle">
                                <i class="fa fa-calendar-minus-o"></i>
                                <span class="title">Schedules</span>
                                @if(Request::is('schedules*'))
                                    <span class="selected"></span>                 
                                @endif                                
                            </a>                            
                        </li>
                        <li class="nav-item start active open">
                            <a href="{{ url('matchentries') }}" class="nav-link nav-toggle">
                                <i class="fa fa-ticket"></i>
                                <span class="title">Match Entries</span>
                                @if(Request::is('matchentries*'))
                                    <span class="selected"></span>                 
                                @endif                                
                            </a>                            
                        </li>
                        <li class="nav-item start active open">
                            <a href="{{ url('scheduledetails') }}" class="nav-link nav-toggle">
                                <i class="fa fa-edit"></i>
                                <span class="title">Schedule Details</span>
                                @if(Request::is('scheduledetails*'))
                                    <span class="selected"></span>                 
                                @endif                                
                            </a>                            
                        </li>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div><!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->