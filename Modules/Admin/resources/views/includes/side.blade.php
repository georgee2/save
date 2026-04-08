<!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="">
                        <a href="#" class="logo text-center">CMS</a>
                    </div>
                </div>

                <div class="sidebar-inner slimscrollleft">
                    <div id="sidebar-menu">
                        <ul>

                            <li style="color:#e8e8e8" class="menu-title">Smart Vision</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i style="color: #e8e8e8" class="fa fa-exchange"></i><span> System Dashboards <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('Admin')}}">CMS</a></li>
                                    <li><a href="{{route('Basicdata')}}">Basic Data</a></li>
                                    <li><a href="{{route('CRM')}}">CRM</a></li>
                                </ul>
                            </li>

                            {{-- Main Section - Only show if user has any of these permissions --}}
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['services-view', 'projects-view', 'portfolios-view', 'offers-view', 'interior-design-galleries-view']))
                            <li style="color:#e8e8e8" class="menu-title">Main Section</li>
                            
                            {{-- Services --}}
                            @permission('services-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-briefcase"></i><span> Services <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('services-create')
                                    <li><a href="{{route('service.create')}}">Add New Service</a></li>
                                    @endpermission
                                    <li><a href="{{route('service.index')}}">Services List</a></li>
                                    <li><a href="{{route('service.trashed')}}">Trashed Services</a></li>
                                </ul>
                            </li>
                            @endpermission

                            {{-- Projects --}}
                            @permission('projects-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-building"></i><span> Projects <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('projects-create')
                                    <li><a href="{{route('project.create')}}">Add New Project</a></li>
                                    @endpermission
                                    <li><a href="{{route('project.index')}}">Projects List</a></li>
                                    <li><a href="{{route('project.trashed')}}">Trashed Projects</a></li>
                                </ul>
                            </li>
                            @endpermission

                            {{-- Portfolio (Hidden) --}}
                            @permission('portfolios-view')
                            <li class="has_sub" hidden>
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-folder-open"></i><span> Portfolio <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('portfolios-create')
                                    <li><a href="{{route('portfolio.create')}}">Add New Portfolio</a></li>
                                    @endpermission
                                    <li><a href="{{route('portfolio.index')}}">Portfolio List</a></li>
                                    <li><a href="{{route('portfolio.trashed')}}">Trashed Portfolios</a></li>
                                </ul>
                            </li>
                            @endpermission

                            {{-- Offers --}}
                            @permission('offers-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-tag"></i><span> Offers <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('offers-create')
                                    <li><a href="{{route('offer.create')}}">Add New Offer</a></li>
                                    @endpermission
                                    <li><a href="{{route('offer.index')}}">Offers List</a></li>
                                    <li><a href="{{route('offer.trashed')}}">Trashed Offers</a></li>
                                </ul>
                            </li>
                            @endpermission

                            {{-- Interior Gallery --}}
                            @permission('interior-design-galleries-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-paint-brush"></i><span> Interior Gallery <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('interior-design-galleries-create')
                                    <li><a href="{{route('interior-design-gallery.create')}}">Add New Gallery</a></li>
                                    @endpermission
                                    <li><a href="{{route('interior-design-gallery.index')}}">Gallery List</a></li>
                                    <li><a href="{{route('interior-design-gallery.trashed')}}">Trashed Galleries</a></li>
                                </ul>
                            </li>
                            @endpermission
                            @endif

                            {{-- News Sections --}}
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('news-view'))
                            <li style="color:#e8e8e8" class="menu-title">News Sections</li>

                            @permission('news-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> News Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('news-create')
                                    <li><a href="{{route('newscategories.create')}}">Add New Category</a></li>
                                    @endpermission
                                    <li><a href="{{route('newscategories.index')}}">News Categories List</a></li>
                                    <li><a href="{{route('newscategories.trashed')}}">Removed Categories List</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> News <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('news-create')
                                    <li><a href="{{route('news-back.create')}}">Add New Blog</a></li>
                                    @endpermission
                                    <li><a href="{{route('news-back.index')}}">News List</a></li>
                                </ul>
                            </li>
                            @endpermission
                            @endif

                            {{-- Home Sections --}}
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['sliders-view', 'home-sections-view']))
                            <li style="color:#e8e8e8" class="menu-title">Home Sections</li>

                            @permission('sliders-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-view-carousel"></i><span> Sliders <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('sliders-create')
                                    <li><a href="{{route('slider.create')}}">Add New Slider</a></li>
                                    @endpermission
                                    <li><a href="{{route('slider.index')}}">Sliders List</a></li>
                                    <li><a href="{{route('slider.trashed')}}">Trashed Sliders</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('home-sections-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-large"></i><span> Home Blocks <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('home-sections-edit')
                                    <li><a href="{{route('homeblock.create')}}">Add New Home Block</a></li>
                                    @endpermission
                                    <li><a href="{{route('homeblock.index')}}">Home Blocks List</a></li>
                                    <li><a href="{{route('homeblock.trashed')}}">Trashed Blocks</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-id-card-o"></i><span> Cards <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('home-sections-edit')
                                    <li><a href="{{route('card.create')}}">Add New Card</a></li>
                                    @endpermission
                                    <li><a href="{{route('card.index')}}">Cards List</a></li>
                                    <li><a href="{{route('card.trashed')}}">Trashed Cards</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-question-circle"></i><span> Home FAQs <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('home-sections-edit')
                                    <li><a href="{{route('homefaq.create')}}">Add New FAQ</a></li>
                                    @endpermission
                                    <li><a href="{{route('homefaq.index')}}">FAQs List</a></li>
                                    <li><a href="{{route('homefaq.trashed')}}">Trashed FAQs</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('homecontact.index')}}" class="waves-effect"><i class="fa fa-phone"></i><span> Home Contact Section </span></a>
                            </li>
                            @endpermission
                            @endif

                            {{-- About & Contact --}}
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['about-information-view', 'about-features-view', 'about-custom-blocks-view', 'certificates-view', 'contact-information-view']))
                            <li style="color:#e8e8e8" class="menu-title">About & Contact</li>

                            @permission('about-information-view')
                            <li>
                                <a href="{{route('about-information.index')}}" class="waves-effect"><i class="fa fa-file-text-o"></i><span> About Information </span></a>
                            </li>
                            @endpermission

                            @permission('about-features-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-star"></i><span> About Features </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    @permission('about-features-create')
                                    <li><a href="{{route('about-feature.create')}}">Add New Feature</a></li>
                                    @endpermission
                                    <li><a href="{{route('about-feature.index')}}">Features List</a></li>
                                    <li><a href="{{route('about-feature.trashed')}}">Trashed Features</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('about-custom-blocks-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-large"></i><span> About Blocks </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    @permission('about-custom-blocks-create')
                                    <li><a href="{{route('about-custom-block.create')}}">Add New Block</a></li>
                                    @endpermission
                                    <li><a href="{{route('about-custom-block.index')}}">Blocks List</a></li>
                                    <li><a href="{{route('about-custom-block.trashed')}}">Trashed Blocks</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('certificates-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-certificate"></i><span> Certificates </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    @permission('certificates-create')
                                    <li><a href="{{route('certificate.create')}}">Add New Certificate</a></li>
                                    @endpermission
                                    <li><a href="{{route('certificate.index')}}">Certificates List</a></li>
                                    <li><a href="{{route('certificate.trashed')}}">Trashed Certificates</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('contact-information-view')
                            <li>
                                <a href="{{route('contact-information.index')}}" class="waves-effect"><i class="fa fa-info-circle"></i><span> Contact Information </span></a>
                            </li>
                            @endpermission
                            @endif

                            {{-- General Section --}}
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['partners-view', 'team-view', 'services-view', 'page-banners-view']))
                            <li style="color:#e8e8e8" class="menu-title">General Section</li>

                            @permission('partners-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-handshake-o"></i><span> Partners <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('partners-create')
                                    <li><a href="{{route('partner.create')}}">Add New Partner</a></li>
                                    @endpermission
                                    <li><a href="{{route('partner.index')}}">Partners List</a></li>
                                    <li><a href="{{route('partner.trashed')}}">Trashed Partners</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('team-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i><span> Team Members <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('team-create')
                                    <li><a href="{{route('admin.team.create')}}">Add New Team Member</a></li>
                                    @endpermission
                                    <li><a href="{{route('admin.team.index')}}">Team Members List</a></li>
                                    <li><a href="{{route('admin.team.trashed')}}">Trashed Members</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('services-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-comment-question-outline"></i><span> FAQs <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('services-create')
                                    <li><a href="{{route('faq.create')}}">Add New FAQ</a></li>
                                    @endpermission
                                    <li><a href="{{route('faq.index')}}">FAQs List</a></li>
                                    <li><a href="{{route('faq.trashed')}}">Trashed FAQs</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('page-banners-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-image"></i><span> Page Banners <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('page-banners-edit')
                                    <li><a href="{{route('page-banner.create')}}">Add New Banner</a></li>
                                    @endpermission
                                    <li><a href="{{route('page-banner.index')}}">Banners List</a></li>
                                    <li><a href="{{route('page-banner.trashed')}}">Trashed Banners</a></li>
                                </ul>
                            </li>
                            @endpermission
                            @endif

                            {{-- Settings Section --}}
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['home-sections-view', 'interior-order-view', 'contact-page-sections-view', 'about-page-sections-view', 'menus-view', 'users-view', 'roles-view', 'settings-view', 'activity-logs-view']))
                            <li style="color:#e8e8e8" class="menu-title">Settings</li>

                            @permission('home-sections-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-list"></i><span> Home Sections <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('home-sections.index')}}">Manage Sections</a></li>
                                    @permission('home-projects-view')
                                    <li><a href="{{route('home-project-settings.index')}}">Our Projects Settings</a></li>
                                    @endpermission
                                    <li><a href="{{route('home-sections.trashed')}}">Trashed Sections</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @if(auth()->user()->hasPermission('interior-order-view'))
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-paint-brush"></i><span> Interior Order <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('home-interior-settings.index')}}">Home Slider Settings</a></li>
                                    <li><a href="{{route('interior-category-order.index')}}">Category Order</a></li>
                                    <li><a href="{{route('interior-design-gallery.order-index')}}">Index Page Order</a></li>
                                    <li><a href="{{route('interior-design-gallery.order-all')}}">All Images Order</a></li>
                                </ul>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('contact-page-sections-view'))
                            <li>
                                <a href="{{route('contact-page-sections.index')}}" class="waves-effect"><i class="fa fa-file-text-o"></i><span> Contact Page Sections </span></a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('about-page-sections-view'))
                            <li>
                                <a href="{{route('about-page-sections.index')}}" class="waves-effect"><i class="fa fa-info-circle"></i><span> About Page Sections </span></a>
                            </li>
                            @endif

                            @permission('menus-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-bars"></i><span> Menu Management <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('admin.menu.index')}}">Menus List</a></li>
                                    @permission('menus-create')
                                    <li><a href="{{route('admin.menu.create')}}">Add New Menu</a></li>
                                    @endpermission
                                    @permission('menus-edit')
                                    <li><a href="{{route('admin.menu.settings')}}">Menu Settings</a></li>
                                    @endpermission
                                    <li><a href="{{route('admin.menu.trashed')}}">Trashed Menus</a></li>
                                    <li><a href="{{route('admin.menu.guide')}}"><i class="fa fa-book text-info"></i> User Guide</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('users-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> Users <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    @permission('users-create')
                                    <li><a href="{{route('users.create')}}">Add New User</a></li>
                                    @endpermission
                                    <li><a href="{{route('users.index')}}">Users List</a></li>
                                    <li><a href="{{route('admin.users.roles.index')}}">User Roles</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('roles-view')
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-shield"></i><span> Roles & Permissions <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('admin.roles.index')}}">Roles List</a></li>
                                    @permission('roles-create')
                                    <li><a href="{{route('admin.roles.create')}}">Add New Role</a></li>
                                    @endpermission
                                    <li><a href="{{route('admin.roles.trashed')}}">Trashed Roles</a></li>
                                </ul>
                            </li>
                            @endpermission

                            @permission('settings-view')
                            <li>
                                <a href="{{route('site-settings.index')}}" class="waves-effect"><i class="fa fa-cog"></i><span> Site Settings </span></a>
                            </li>
                            @endpermission

                            @permission('settings-view')
                            <li>
                                <a href="{{route('admin.seo-pages.index')}}" class="waves-effect"><i class="fa fa-search"></i><span> SEO Pages </span></a>
                            </li>
                            @endpermission

                            <li>
                                <a href="{{route('admin.analytics.index')}}" class="waves-effect"><i class="fa fa-line-chart"></i><span> Analytics </span></a>
                            </li>

                            @permission('activity-logs-view')
                            <li>
                                <a href="{{route('admin.activity-logs.index')}}" class="waves-effect"><i class="fa fa-history"></i><span> Activity Logs </span></a>
                            </li>
                            @endpermission
                            @endif

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->