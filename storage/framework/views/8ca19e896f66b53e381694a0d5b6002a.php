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
                                    <li><a href="<?php echo e(route('Admin')); ?>">CMS</a></li>
                                    <li><a href="<?php echo e(route('Basicdata')); ?>">Basic Data</a></li>
                                    <li><a href="<?php echo e(route('CRM')); ?>">CRM</a></li>
                                </ul>
                            </li>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['services-view', 'projects-view', 'portfolios-view', 'offers-view', 'interior-design-galleries-view'])): ?>
                            <li style="color:#e8e8e8" class="menu-title">Main Section</li>
                            
                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'services-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-briefcase"></i><span> Services <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'services-create')): ?>
                                    <li><a href="<?php echo e(route('service.create')); ?>">Add New Service</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('service.index')); ?>">Services List</a></li>
                                    <li><a href="<?php echo e(route('service.trashed')); ?>">Trashed Services</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'projects-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-building"></i><span> Projects <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'projects-create')): ?>
                                    <li><a href="<?php echo e(route('project.create')); ?>">Add New Project</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('project.index')); ?>">Projects List</a></li>
                                    <li><a href="<?php echo e(route('project.trashed')); ?>">Trashed Projects</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'portfolios-view')): ?>
                            <li class="has_sub" hidden>
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-folder-open"></i><span> Portfolio <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'portfolios-create')): ?>
                                    <li><a href="<?php echo e(route('portfolio.create')); ?>">Add New Portfolio</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('portfolio.index')); ?>">Portfolio List</a></li>
                                    <li><a href="<?php echo e(route('portfolio.trashed')); ?>">Trashed Portfolios</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'offers-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-tag"></i><span> Offers <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'offers-create')): ?>
                                    <li><a href="<?php echo e(route('offer.create')); ?>">Add New Offer</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('offer.index')); ?>">Offers List</a></li>
                                    <li><a href="<?php echo e(route('offer.trashed')); ?>">Trashed Offers</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'interior-design-galleries-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-paint-brush"></i><span> Interior Gallery <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'interior-design-galleries-create')): ?>
                                    <li><a href="<?php echo e(route('interior-design-gallery.create')); ?>">Add New Gallery</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('interior-design-gallery.index')); ?>">Gallery List</a></li>
                                    <li><a href="<?php echo e(route('interior-design-gallery.trashed')); ?>">Trashed Galleries</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('news-view')): ?>
                            <li style="color:#e8e8e8" class="menu-title">News Sections</li>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'news-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> News Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'news-create')): ?>
                                    <li><a href="<?php echo e(route('newscategories.create')); ?>">Add New Category</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('newscategories.index')); ?>">News Categories List</a></li>
                                    <li><a href="<?php echo e(route('newscategories.trashed')); ?>">Removed Categories List</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> News <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'news-create')): ?>
                                    <li><a href="<?php echo e(route('news-back.create')); ?>">Add New Blog</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('news-back.index')); ?>">News List</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['sliders-view', 'home-sections-view'])): ?>
                            <li style="color:#e8e8e8" class="menu-title">Home Sections</li>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'sliders-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-view-carousel"></i><span> Sliders <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'sliders-create')): ?>
                                    <li><a href="<?php echo e(route('slider.create')); ?>">Add New Slider</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('slider.index')); ?>">Sliders List</a></li>
                                    <li><a href="<?php echo e(route('slider.trashed')); ?>">Trashed Sliders</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'home-sections-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-large"></i><span> Home Blocks <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'home-sections-edit')): ?>
                                    <li><a href="<?php echo e(route('homeblock.create')); ?>">Add New Home Block</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('homeblock.index')); ?>">Home Blocks List</a></li>
                                    <li><a href="<?php echo e(route('homeblock.trashed')); ?>">Trashed Blocks</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-id-card-o"></i><span> Cards <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'home-sections-edit')): ?>
                                    <li><a href="<?php echo e(route('card.create')); ?>">Add New Card</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('card.index')); ?>">Cards List</a></li>
                                    <li><a href="<?php echo e(route('card.trashed')); ?>">Trashed Cards</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-question-circle"></i><span> Home FAQs <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'home-sections-edit')): ?>
                                    <li><a href="<?php echo e(route('homefaq.create')); ?>">Add New FAQ</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('homefaq.index')); ?>">FAQs List</a></li>
                                    <li><a href="<?php echo e(route('homefaq.trashed')); ?>">Trashed FAQs</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="<?php echo e(route('homecontact.index')); ?>" class="waves-effect"><i class="fa fa-phone"></i><span> Home Contact Section </span></a>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['about-information-view', 'about-features-view', 'about-custom-blocks-view', 'certificates-view', 'contact-information-view'])): ?>
                            <li style="color:#e8e8e8" class="menu-title">About & Contact</li>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'about-information-view')): ?>
                            <li>
                                <a href="<?php echo e(route('about-information.index')); ?>" class="waves-effect"><i class="fa fa-file-text-o"></i><span> About Information </span></a>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'about-features-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-star"></i><span> About Features </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'about-features-create')): ?>
                                    <li><a href="<?php echo e(route('about-feature.create')); ?>">Add New Feature</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('about-feature.index')); ?>">Features List</a></li>
                                    <li><a href="<?php echo e(route('about-feature.trashed')); ?>">Trashed Features</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'about-custom-blocks-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-large"></i><span> About Blocks </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'about-custom-blocks-create')): ?>
                                    <li><a href="<?php echo e(route('about-custom-block.create')); ?>">Add New Block</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('about-custom-block.index')); ?>">Blocks List</a></li>
                                    <li><a href="<?php echo e(route('about-custom-block.trashed')); ?>">Trashed Blocks</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'certificates-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-certificate"></i><span> Certificates </span><span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'certificates-create')): ?>
                                    <li><a href="<?php echo e(route('certificate.create')); ?>">Add New Certificate</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('certificate.index')); ?>">Certificates List</a></li>
                                    <li><a href="<?php echo e(route('certificate.trashed')); ?>">Trashed Certificates</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'contact-information-view')): ?>
                            <li>
                                <a href="<?php echo e(route('contact-information.index')); ?>" class="waves-effect"><i class="fa fa-info-circle"></i><span> Contact Information </span></a>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['partners-view', 'team-view', 'services-view', 'page-banners-view'])): ?>
                            <li style="color:#e8e8e8" class="menu-title">General Section</li>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'partners-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-handshake-o"></i><span> Partners <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'partners-create')): ?>
                                    <li><a href="<?php echo e(route('partner.create')); ?>">Add New Partner</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('partner.index')); ?>">Partners List</a></li>
                                    <li><a href="<?php echo e(route('partner.trashed')); ?>">Trashed Partners</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'team-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-users"></i><span> Team Members <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'team-create')): ?>
                                    <li><a href="<?php echo e(route('admin.team.create')); ?>">Add New Team Member</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('admin.team.index')); ?>">Team Members List</a></li>
                                    <li><a href="<?php echo e(route('admin.team.trashed')); ?>">Trashed Members</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'services-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-comment-question-outline"></i><span> FAQs <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'services-create')): ?>
                                    <li><a href="<?php echo e(route('faq.create')); ?>">Add New FAQ</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('faq.index')); ?>">FAQs List</a></li>
                                    <li><a href="<?php echo e(route('faq.trashed')); ?>">Trashed FAQs</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'page-banners-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-image"></i><span> Page Banners <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'page-banners-edit')): ?>
                                    <li><a href="<?php echo e(route('page-banner.create')); ?>">Add New Banner</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('page-banner.index')); ?>">Banners List</a></li>
                                    <li><a href="<?php echo e(route('page-banner.trashed')); ?>">Trashed Banners</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['home-sections-view', 'interior-order-view', 'contact-page-sections-view', 'about-page-sections-view', 'menus-view', 'users-view', 'roles-view', 'settings-view', 'activity-logs-view'])): ?>
                            <li style="color:#e8e8e8" class="menu-title">Settings</li>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'home-sections-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-th-list"></i><span> Home Sections <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?php echo e(route('home-sections.index')); ?>">Manage Sections</a></li>
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'home-projects-view')): ?>
                                    <li><a href="<?php echo e(route('home-project-settings.index')); ?>">Our Projects Settings</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('home-sections.trashed')); ?>">Trashed Sections</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->hasPermission('interior-order-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-paint-brush"></i><span> Interior Order <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?php echo e(route('home-interior-settings.index')); ?>">Home Slider Settings</a></li>
                                    <li><a href="<?php echo e(route('interior-category-order.index')); ?>">Category Order</a></li>
                                    <li><a href="<?php echo e(route('interior-design-gallery.order-index')); ?>">Index Page Order</a></li>
                                    <li><a href="<?php echo e(route('interior-design-gallery.order-all')); ?>">All Images Order</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->hasPermission('contact-page-sections-view')): ?>
                            <li>
                                <a href="<?php echo e(route('contact-page-sections.index')); ?>" class="waves-effect"><i class="fa fa-file-text-o"></i><span> Contact Page Sections </span></a>
                            </li>
                            <?php endif; ?>

                            <?php if(auth()->user()->hasPermission('about-page-sections-view')): ?>
                            <li>
                                <a href="<?php echo e(route('about-page-sections.index')); ?>" class="waves-effect"><i class="fa fa-info-circle"></i><span> About Page Sections </span></a>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'menus-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-bars"></i><span> Menu Management <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?php echo e(route('admin.menu.index')); ?>">Menus List</a></li>
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'menus-create')): ?>
                                    <li><a href="<?php echo e(route('admin.menu.create')); ?>">Add New Menu</a></li>
                                    <?php endif; ?>
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'menus-edit')): ?>
                                    <li><a href="<?php echo e(route('admin.menu.settings')); ?>">Menu Settings</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('admin.menu.trashed')); ?>">Trashed Menus</a></li>
                                    <li><a href="<?php echo e(route('admin.menu.guide')); ?>"><i class="fa fa-book text-info"></i> User Guide</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'users-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> Users <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'users-create')): ?>
                                    <li><a href="<?php echo e(route('users.create')); ?>">Add New User</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('users.index')); ?>">Users List</a></li>
                                    <li><a href="<?php echo e(route('admin.users.roles.index')); ?>">User Roles</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'roles-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-shield"></i><span> Roles & Permissions <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?php echo e(route('admin.roles.index')); ?>">Roles List</a></li>
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'roles-create')): ?>
                                    <li><a href="<?php echo e(route('admin.roles.create')); ?>">Add New Role</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('admin.roles.trashed')); ?>">Trashed Roles</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'settings-view')): ?>
                            <li>
                                <a href="<?php echo e(route('site-settings.index')); ?>" class="waves-effect"><i class="fa fa-cog"></i><span> Site Settings </span></a>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'settings-view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.seo-pages.index')); ?>" class="waves-effect"><i class="fa fa-search"></i><span> SEO Pages </span></a>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'activity-logs-view')): ?>
                            <li>
                                <a href="<?php echo e(route('admin.activity-logs.index')); ?>" class="waves-effect"><i class="fa fa-history"></i><span> Activity Logs </span></a>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End --><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Admin\resources/views/includes/side.blade.php ENDPATH**/ ?>