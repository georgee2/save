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

                            <li style="color:#e8e8e8" class="menu-title">Main Section</li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-briefcase"></i><span> Services <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <!-- EXTERNAL -->
                                    <li><a href="{{route('service.create')}}">Add New Service</a></li>
                                    <li><a href="{{route('service.index')}}">Services List</a></li>
                                    <li><a href="{{route('service.trashed')}}">Trashed Services</a></li>
                                </ul>
                            </li>


                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-building"></i><span> Projects <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('project.create')}}">Add New Project</a></li>
                                    <li><a href="{{route('project.index')}}">Projects List</a></li>
                                    <li><a href="{{route('project.trashed')}}">Trashed Projects</a></li>
                                </ul>
                            </li>

                            <li class="has_sub" hidden>
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-folder-open"></i><span> Portfolio <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('portfolio.create')}}">Add New Portfolio</a></li>
                                    <li><a href="{{route('portfolio.index')}}">Portfolio List</a></li>
                                    <li><a href="{{route('portfolio.trashed')}}">Trashed Portfolios</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-tag"></i><span> Offers <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('offer.create')}}">Add New Offer</a></li>
                                    <li><a href="{{route('offer.index')}}">Offers List</a></li>
                                    <li><a href="{{route('offer.trashed')}}">Trashed Offers</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-paint-brush"></i><span> Interior Gallery <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('interior-design-gallery.create')}}">Add New Gallery</a></li>
                                    <li><a href="{{route('interior-design-gallery.index')}}">Gallery List</a></li>
                                    <li><a href="{{route('interior-design-gallery.trashed')}}">Trashed Galleries</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-list"></i><span> Home Sections <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('home-sections.index')}}">Manage Sections</a></li>
                                    <li><a href="{{route('home-sections.trashed')}}">Trashed Sections</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-star"></i><span> Showcases <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('showcase.create')}}">Add New Showcase</a></li>
                                    <li><a href="{{route('showcase.index')}}">Showcases List</a></li>
                                    <li><a href="{{route('showcase.trashed')}}">Trashed Showcases</a></li>
                                </ul>
                            </li>

            
                            <li style="color:#e8e8e8" class="menu-title">News Sections</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> News Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <!-- EXTERNAL -->
                                    <li><a href="{{route('newscategories.create')}}">Add New Category</a></li>
                                    <li><a href="{{route('newscategories.index')}}">News Categories List</a></li>
                                    <li><a href="{{route('newscategories.trashed')}}">Removed Categories List</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> News <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <!-- EXTERNAL -->
                                    <li><a href="{{route('news-back.create')}}">Add New Blog</a></li>
                                    <li><a href="{{route('news-back.index')}}">News List</a></li>
                                </ul>
                            </li>


                    


            <li style="color:#e8e8e8" class="menu-title">Home Sections</li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-view-carousel"></i><span> Sliders <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('slider.create')}}">Add New Slider</a></li>
                    <li><a href="{{route('slider.index')}}">Sliders List</a></li>
                    <li><a href="{{route('slider.trashed')}}">Trashed Sliders</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-large"></i><span> Home Blocks <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('homeblock.create')}}">Add New Home Block</a></li>
                    <li><a href="{{route('homeblock.index')}}">Home Blocks List</a></li>
                    <li><a href="{{route('homeblock.trashed')}}">Trashed Blocks</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-id-card-o"></i><span> Cards <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('card.create')}}">Add New Card</a></li>
                    <li><a href="{{route('card.index')}}">Cards List</a></li>
                    <li><a href="{{route('card.trashed')}}">Trashed Cards</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-question-circle"></i><span> Home FAQs <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('homefaq.create')}}">Add New FAQ</a></li>
                    <li><a href="{{route('homefaq.index')}}">FAQs List</a></li>
                    <li><a href="{{route('homefaq.trashed')}}">Trashed FAQs</a></li>
                </ul>
            </li>

            <li>
                <a href="{{route('homecontact.index')}}" class="waves-effect"><i class="fa fa-phone"></i><span> Home Contact Section </span></a>
            </li>
            


            <li style="color:#e8e8e8" class="menu-title">About & Contact</li>

            <li>
                <a href="{{route('about-information.index')}}" class="waves-effect"><i class="fa fa-file-text-o"></i><span> About Information </span></a>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-star"></i><span> About Features </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('about-feature.create')}}">Add New Feature</a></li>
                    <li><a href="{{route('about-feature.index')}}">Features List</a></li>
                    <li><a href="{{route('about-feature.trashed')}}">Trashed Features</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-large"></i><span> About Blocks </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('about-custom-block.create')}}">Add New Block</a></li>
                    <li><a href="{{route('about-custom-block.index')}}">Blocks List</a></li>
                    <li><a href="{{route('about-custom-block.trashed')}}">Trashed Blocks</a></li>
                </ul>
            </li>

            <li>
                <a href="{{route('contact-information.index')}}" class="waves-effect"><i class="fa fa-info-circle"></i><span> Contact Information </span></a>
            </li>


            <li style="color:#e8e8e8" class="menu-title">General Section</li>

             <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-handshake-o"></i><span> Partners <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('partner.create')}}">Add New Partner</a></li>
                                <li><a href="{{route('partner.index')}}">Partners List</a></li>
                                <li><a href="{{route('partner.trashed')}}">Trashed Partners</a></li>
                            </ul>
                        </li>

                    

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i><span> Team Members <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('admin.team.create')}}">Add New Team Member</a></li>
                                <li><a href="{{route('admin.team.index')}}">Team Members List</a></li>
                                <li><a href="{{route('admin.team.trashed')}}">Trashed Members</a></li>
                            </ul>
                        </li>



            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-comment-question-outline"></i><span> FAQs <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('faq.create')}}">Add New FAQ</a></li>
                                    <li><a href="{{route('faq.index')}}">FAQs List</a></li>
                                    <li><a href="{{route('faq.trashed')}}">Trashed FAQs</a></li>
                                </ul>
                            </li>

                <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-image"></i><span> Page Banners <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('page-banner.create')}}">Add New Banner</a></li>
                                <li><a href="{{route('page-banner.index')}}">Banners List</a></li>
                                <li><a href="{{route('page-banner.trashed')}}">Trashed Banners</a></li>
                            </ul>
                        </li>



            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> Users <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <!-- EXTERNAL -->
                    <li><a href="{{route('users.create')}}">Add New User</a></li>
                    <li><a href="{{route('users.index')}}">Users List</a></li>
                </ul>
            </li>


            <li style="color:#e8e8e8" class="menu-title">Default Sections</li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-bar-chart"></i><span> Facts <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('admin.facts.create')}}">Add New Fact</a></li>
                    <li><a href="{{route('admin.facts.index')}}">Facts List</a></li>
                    <li><a href="{{route('admin.facts.trashed')}}">Trashed Facts</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cogs"></i><span> Default Process <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('admin.default-processes.create')}}">Add New Process</a></li>
                    <li><a href="{{route('admin.default-processes.index')}}">Processes List</a></li>
                    <li><a href="{{route('admin.default-processes.trashed')}}">Trashed Processes</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-image"></i><span> Default Banners <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('admin.default-banners.create')}}">Add New Banner</a></li>
                    <li><a href="{{route('admin.default-banners.index')}}">Banners List</a></li>
                    <li><a href="{{route('admin.default-banners.trashed')}}">Trashed Banners</a></li>
                </ul>
            </li>

            <li>
                <a href="{{route('site-settings.index')}}" class="waves-effect"><i class="fa fa-cog"></i><span> Site Settings </span></a>
            </li>


            <li style="color:#e8e8e8" class="menu-title">Settings</li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-bars"></i><span> Menu Management <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="{{route('admin.menu.index')}}">Menus List</a></li>
                    <li><a href="{{route('admin.menu.create')}}">Add New Menu</a></li>
                    <li><a href="{{route('admin.menu.settings')}}">Menu Settings</a></li>
                    <li><a href="{{route('admin.menu.trashed')}}">Trashed Menus</a></li>
                    <li><a href="{{route('admin.menu.guide')}}"><i class="fa fa-book text-info"></i> User Guide</a></li>
                </ul>
            </li>


                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->