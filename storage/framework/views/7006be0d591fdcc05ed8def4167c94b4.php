<!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="">
                        <a href="#" class="logo text-center">Basic Data</a>
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

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['engineering-categories-view', 'engineering-sub-categories-view'])): ?>
                            <li style="color:#e8e8e8" class="menu-title">Projects Master</li>
                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'engineering-categories-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-grid"></i><span> Eng.Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'engineering-categories-create')): ?>
                                    <li><a href="<?php echo e(route('engineeringcategory.create')); ?>">Add New Category</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('engineeringcategory.index')); ?>">Categories List</a></li>
                                    <li><a href="<?php echo e(route('engineeringcategory.trashed')); ?>">Trashed Categories</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'engineering-sub-categories-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-sitemap"></i><span> Eng.Sub Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'engineering-sub-categories-create')): ?>
                                    <li><a href="<?php echo e(route('engineeringsubcategory.create')); ?>">Add New Sub Category</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('engineeringsubcategory.index')); ?>">Sub Categories List</a></li>
                                    <li><a href="<?php echo e(route('engineeringsubcategory.trashed')); ?>">Trashed Sub Categories</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'interior-categories-view')): ?>
                            <li style="color:#e8e8e8" class="menu-title">Interior</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-home-variant"></i><span> Int.Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'interior-categories-create')): ?>
                                    <li><a href="<?php echo e(route('interiorcategory.create')); ?>">Add New Category</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('interiorcategory.index')); ?>">Categories List</a></li>
                                    <li><a href="<?php echo e(route('interiorcategory.trashed')); ?>">Trashed Categories</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['offer-categories-view', 'offer-sub-categories-view'])): ?>
                            <li style="color:#e8e8e8" class="menu-title">Offers Master</li>
                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'offer-categories-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-tag-multiple"></i><span> Offer Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'offer-categories-create')): ?>
                                    <li><a href="<?php echo e(route('offercategory.create')); ?>">Add New Category</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('offercategory.index')); ?>">Categories List</a></li>
                                    <li><a href="<?php echo e(route('offercategory.trashed')); ?>">Trashed Categories</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'offer-sub-categories-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-tag-outline"></i><span> <small>Offer Sub Categories</small>  <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'offer-sub-categories-create')): ?>
                                    <li><a href="<?php echo e(route('offersubcategory.create')); ?>">Add New Sub Category</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('offersubcategory.index')); ?>">Sub Categories List</a></li>
                                    <li><a href="<?php echo e(route('offersubcategory.trashed')); ?>">Trashed Sub Categories</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission([
                                'project-types-view', 'emirates-view', 'project-styles-view', 'amenities-view',
                                'building-components-view', 'floor-components-view', 'income-components-view',
                                'length-components-view', 'currencies-view', 'specifications-view',
                                'substation-rooms-view', 'pumps-rooms-view', 'feasibility-study-components-view',
                                'portfolio-types-view'
                            ])): ?>
                            <li style="color:#e8e8e8" class="menu-title">Master Data</li>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'project-types-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-folder-multiple"></i><span> Project Types <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'project-types-create')): ?>
                                    <li><a href="<?php echo e(route('projecttype.create')); ?>">Add New Project Type</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('projecttype.index')); ?>">Project Types List</a></li>
                                    <li><a href="<?php echo e(route('projecttype.trashed')); ?>">Trashed Project Types</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'emirates-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-map-marker"></i><span> Emirates <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'emirates-create')): ?>
                                    <li><a href="<?php echo e(route('emirate.create')); ?>">Add New Emirate</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('emirate.index')); ?>">Emirates List</a></li>
                                    <li><a href="<?php echo e(route('emirate.trashed')); ?>">Trashed Emirates</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'project-styles-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-palette"></i><span> Project Styles <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'project-styles-create')): ?>
                                    <li><a href="<?php echo e(route('projectstyle.create')); ?>">Add New Style</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('projectstyle.index')); ?>">Styles List</a></li>
                                    <li><a href="<?php echo e(route('projectstyle.trashed')); ?>">Trashed Styles</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'amenities-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-star-circle"></i><span> Amenities <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'amenities-create')): ?>
                                    <li><a href="<?php echo e(route('amenity.create')); ?>">Add New Amenity</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('amenity.index')); ?>">Amenities List</a></li>
                                    <li><a href="<?php echo e(route('amenity.trashed')); ?>">Trashed Amenities</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'building-components-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-cube-outline"></i><span> Building Comp. <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'building-components-create')): ?>
                                    <li><a href="<?php echo e(route('buildingcomponent.create')); ?>">Add New Component</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('buildingcomponent.index')); ?>">Components List</a></li>
                                    <li><a href="<?php echo e(route('buildingcomponent.trashed')); ?>">Trashed Components</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'floor-components-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-layers"></i><span> Floor Components <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'floor-components-create')): ?>
                                    <li><a href="<?php echo e(route('floorcomponent.create')); ?>">Add Floor Component</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('floorcomponent.index')); ?>">Floor Comp. List</a></li>
                                    <li><a href="<?php echo e(route('floorcomponent.trashed')); ?>">Trashed Floor Comp.</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'income-components-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-cash-multiple"></i><span> Income Comp. <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'income-components-create')): ?>
                                    <li><a href="<?php echo e(route('incomecomponent.create')); ?>">Add New Component</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('incomecomponent.index')); ?>">Components List</a></li>
                                    <li><a href="<?php echo e(route('incomecomponent.trashed')); ?>">Trashed Components</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'length-components-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-ruler"></i><span> Length Components <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'length-components-create')): ?>
                                    <li><a href="<?php echo e(route('lengthcomponent.create')); ?>">Add Length Comp.</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('lengthcomponent.index')); ?>">Length Components List</a></li>
                                    <li><a href="<?php echo e(route('lengthcomponent.trashed')); ?>">Trashed Length Comp.</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'currencies-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-money"></i><span> Currencies <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'currencies-create')): ?>
                                    <li><a href="<?php echo e(route('currency.create')); ?>">Add New Currency</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('currency.index')); ?>">Currencies List</a></li>
                                    <li><a href="<?php echo e(route('currency.trashed')); ?>">Trashed Currencies</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'specifications-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> Specifications <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'specifications-create')): ?>
                                    <li><a href="<?php echo e(route('specification.create')); ?>">Add New Specification</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('specification.index')); ?>">Specifications List</a></li>
                                    <li><a href="<?php echo e(route('specification.trashed')); ?>">Trashed Specifications</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'substation-rooms-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-flash"></i><span> Substation Rooms <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'substation-rooms-create')): ?>
                                    <li><a href="<?php echo e(route('substationroom.create')); ?>">Add Substation Room</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('substationroom.index')); ?>">Substation Rooms List</a></li>
                                    <li><a href="<?php echo e(route('substationroom.trashed')); ?>">Trashed Substation Rooms</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'pumps-rooms-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-water-pump"></i><span> Pumps Rooms <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'pumps-rooms-create')): ?>
                                    <li><a href="<?php echo e(route('pumpsroom.create')); ?>">Add New Pumps Room</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('pumpsroom.index')); ?>">Pumps Rooms List</a></li>
                                    <li><a href="<?php echo e(route('pumpsroom.trashed')); ?>">Trashed Pumps Rooms</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'feasibility-study-components-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-file-chart"></i><span> Feasibility Study <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'feasibility-study-components-create')): ?>
                                    <li><a href="<?php echo e(route('feasibilitystudycomponent.create')); ?>">Add New Component</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('feasibilitystudycomponent.index')); ?>">Components List</a></li>
                                    <li><a href="<?php echo e(route('feasibilitystudycomponent.trashed')); ?>">Trashed Components</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'portfolio-types-view')): ?>
                            <li class="has_sub" hidden>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-briefcase"></i><span> Portfolio Types <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'portfolio-types-create')): ?>
                                    <li><a href="<?php echo e(route('portfoliotype.create')); ?>">Add New Portfolio Type</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('portfoliotype.index')); ?>">Portfolio Types List</a></li>
                                    <li><a href="<?php echo e(route('portfoliotype.trashed')); ?>">Trashed Portfolio Types</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasAnyPermission(['job-titles-view', 'job-categories-view', 'ranks-view'])): ?>
                            <li style="color:#e8e8e8" class="menu-title">Jobs Data</li>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'job-titles-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-account-card-details"></i><span> Job Titles <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'job-titles-create')): ?>
                                    <li><a href="<?php echo e(route('jobtitle.create')); ?>">Add New Job Title</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('jobtitle.index')); ?>">Job Titles List</a></li>
                                    <li><a href="<?php echo e(route('jobtitle.trashed')); ?>">Trashed Job Titles</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'job-categories-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-folder-account"></i><span> Job Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'job-categories-create')): ?>
                                    <li><a href="<?php echo e(route('jobcategory.create')); ?>">Add New Job Category</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('jobcategory.index')); ?>">Job Categories List</a></li>
                                    <li><a href="<?php echo e(route('jobcategory.trashed')); ?>">Trashed Job Categories</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'ranks-view')): ?>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-star"></i><span> Ranks <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'ranks-create')): ?>
                                    <li><a href="<?php echo e(route('rank.create')); ?>">Add New Rank</a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo e(route('rank.index')); ?>">Ranks List</a></li>
                                    <li><a href="<?php echo e(route('rank.trashed')); ?>">Trashed Ranks</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'languages-view')): ?>
                            <li style="color:#e8e8e8" class="menu-title">Language Data</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-translate"></i><span> Language Manager <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?php echo e(route('language.index')); ?>">Manage Translations</a></li>
                                </ul>
                            </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End --><?php /**PATH C:\wamp64\www\smartvisionuae\Modules/Basicdata\resources/views/includes/side.blade.php ENDPATH**/ ?>