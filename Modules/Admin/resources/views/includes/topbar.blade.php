<!-- Top Bar Start -->
                    <div  class="topbar">

                        <nav class="navbar-custom">
                            <!-- Search input -->
                            <div class="search-wrap" id="search-wrap">
                                <div class="search-bar">
                                    <input class="search-input" type="search" placeholder="Search" />
                                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <ul class="list-inline float-right mb-0 m-t-5">
                                
                                
                                <li class="list-inline-item dropdown notification-list hidden-xs-down">
                                    <a title="{{__('lang.Logout')}}" class="nav-link waves-effect text-primary font-weight-bold"
                                        href="{{route('logout')}}">
                                        <i class="mdi mdi-power-settings mdi-24px"></i>
                                        
                                    </a>

                                </li>

                                <!-- User-->
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <img  src="{{url('/pic/user.png')}}" alt="user" class="rounded-circle">
                                        
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}"><i class="dripicons-user text-muted"></i> {{ __('lang.staff_profile_title') }}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"><i class="dripicons-exit text-muted"></i> {{ __('lang.account_logout') }}</a>
                                    </div>
                                </li>
                            </ul>

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <img style="width: 100%;height: 80px" class="pb-2 pt-1 pl-2" src="{{url('/pic/logo.png')}}">

                                </li>
                            </ul>

                            <div class="clearfix"></div>
                        </nav>

                    </div>
                    <!-- Top Bar End -->