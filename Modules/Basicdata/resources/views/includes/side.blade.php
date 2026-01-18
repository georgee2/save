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
                                    <li><a href="{{route('Admin')}}">CMS</a></li>
                                    <li><a href="{{route('Basicdata')}}">Basic Data</a></li>
                                    <li><a href="{{route('CRM')}}">CRM</a></li>

                                </ul>
                            </li>

                            <li style="color:#e8e8e8" class="menu-title">Projects Master</li>
                            

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-grid"></i><span> Eng.Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('engineeringcategory.create')}}">Add New Category</a></li>
                                    <li><a href="{{route('engineeringcategory.index')}}">Categories List</a></li>
                                    <li><a href="{{route('engineeringcategory.trashed')}}">Trashed Categories</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-sitemap"></i><span> Eng.Sub Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('engineeringsubcategory.create')}}">Add New Sub Category</a></li>
                                    <li><a href="{{route('engineeringsubcategory.index')}}">Sub Categories List</a></li>
                                    <li><a href="{{route('engineeringsubcategory.trashed')}}">Trashed Sub Categories</a></li>
                                </ul>
                            </li>

                            <li style="color:#e8e8e8" class="menu-title">Interior</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-home-variant"></i><span> Int.Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('interiorcategory.create')}}">Add New Category</a></li>
                                    <li><a href="{{route('interiorcategory.index')}}">Categories List</a></li>
                                    <li><a href="{{route('interiorcategory.trashed')}}">Trashed Categories</a></li>
                                </ul>
                            </li>

                            <li style="color:#e8e8e8" class="menu-title">Offers Master</li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-tag-multiple"></i><span> Offer Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('offercategory.create')}}">Add New Category</a></li>
                                    <li><a href="{{route('offercategory.index')}}">Categories List</a></li>
                                    <li><a href="{{route('offercategory.trashed')}}">Trashed Categories</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-tag-outline"></i><span> <small>Offer Sub Categories</small>  <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('offersubcategory.create')}}">Add New Sub Category</a></li>
                                    <li><a href="{{route('offersubcategory.index')}}">Sub Categories List</a></li>
                                    <li><a href="{{route('offersubcategory.trashed')}}">Trashed Sub Categories</a></li>
                                </ul>
                            </li>


                            <li style="color:#e8e8e8" class="menu-title">Master Data</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-folder-multiple"></i><span> Project Types <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('projecttype.create')}}">Add New Project Type</a></li>
                                    <li><a href="{{route('projecttype.index')}}">Project Types List</a></li>
                                    <li><a href="{{route('projecttype.trashed')}}">Trashed Project Types</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-map-marker"></i><span> Emirates <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('emirate.create')}}">Add New Emirate</a></li>
                                    <li><a href="{{route('emirate.index')}}">Emirates List</a></li>
                                    <li><a href="{{route('emirate.trashed')}}">Trashed Emirates</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-palette"></i><span> Project Styles <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('projectstyle.create')}}">Add New Style</a></li>
                                    <li><a href="{{route('projectstyle.index')}}">Styles List</a></li>
                                    <li><a href="{{route('projectstyle.trashed')}}">Trashed Styles</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-star-circle"></i><span> Amenities <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('amenity.create')}}">Add New Amenity</a></li>
                                    <li><a href="{{route('amenity.index')}}">Amenities List</a></li>
                                    <li><a href="{{route('amenity.trashed')}}">Trashed Amenities</a></li>
                                </ul>
                            </li>


                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-cube-outline"></i><span> Building Comp. <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('buildingcomponent.create')}}">Add New Component</a></li>
                                    <li><a href="{{route('buildingcomponent.index')}}">Components List</a></li>
                                    <li><a href="{{route('buildingcomponent.trashed')}}">Trashed Components</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-layers"></i><span> Floor Components <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('floorcomponent.create')}}">Add Floor Component</a></li>
                                    <li><a href="{{route('floorcomponent.index')}}">Floor Comp. List</a></li>
                                    <li><a href="{{route('floorcomponent.trashed')}}">Trashed Floor Comp.</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-cash-multiple"></i><span> Income Comp. <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('incomecomponent.create')}}">Add New Component</a></li>
                                    <li><a href="{{route('incomecomponent.index')}}">Components List</a></li>
                                    <li><a href="{{route('incomecomponent.trashed')}}">Trashed Components</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-ruler"></i><span> Length Components <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('lengthcomponent.create')}}">Add Length Comp.</a></li>
                                    <li><a href="{{route('lengthcomponent.index')}}">Length Components List</a></li>
                                    <li><a href="{{route('lengthcomponent.trashed')}}">Trashed Length Comp.</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-money"></i><span> Currencies <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('currency.create')}}">Add New Currency</a></li>
                                    <li><a href="{{route('currency.index')}}">Currencies List</a></li>
                                    <li><a href="{{route('currency.trashed')}}">Trashed Currencies</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-database-plus"></i><span> Specifications <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('specification.create')}}">Add New Specification</a></li>
                                    <li><a href="{{route('specification.index')}}">Specifications List</a></li>
                                    <li><a href="{{route('specification.trashed')}}">Trashed Specifications</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-flash"></i><span> Substation Rooms <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('substationroom.create')}}">Add Substation Room</a></li>
                                    <li><a href="{{route('substationroom.index')}}">Substation Rooms List</a></li>
                                    <li><a href="{{route('substationroom.trashed')}}">Trashed Substation Rooms</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-water-pump"></i><span> Pumps Rooms <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('pumpsroom.create')}}">Add New Pumps Room</a></li>
                                    <li><a href="{{route('pumpsroom.index')}}">Pumps Rooms List</a></li>
                                    <li><a href="{{route('pumpsroom.trashed')}}">Trashed Pumps Rooms</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-file-chart"></i><span> Feasibility Study <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('feasibilitystudycomponent.create')}}">Add New Component</a></li>
                                    <li><a href="{{route('feasibilitystudycomponent.index')}}">Components List</a></li>
                                    <li><a href="{{route('feasibilitystudycomponent.trashed')}}">Trashed Components</a></li>
                                </ul>
                            </li>

                            <li class="has_sub" hidden>
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-briefcase"></i><span> Portfolio Types <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('portfoliotype.create')}}">Add New Portfolio Type</a></li>
                                    <li><a href="{{route('portfoliotype.index')}}">Portfolio Types List</a></li>
                                    <li><a href="{{route('portfoliotype.trashed')}}">Trashed Portfolio Types</a></li>
                                </ul>
                            </li>


                            <li style="color:#e8e8e8" class="menu-title">Jobs Data</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-account-card-details"></i><span> Job Titles <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('jobtitle.create')}}">Add New Job Title</a></li>
                                    <li><a href="{{route('jobtitle.index')}}">Job Titles List</a></li>
                                    <li><a href="{{route('jobtitle.trashed')}}">Trashed Job Titles</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-folder-account"></i><span> Job Categories <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('jobcategory.create')}}">Add New Job Category</a></li>
                                    <li><a href="{{route('jobcategory.index')}}">Job Categories List</a></li>
                                    <li><a href="{{route('jobcategory.trashed')}}">Trashed Job Categories</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-star"></i><span> Ranks <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('rank.create')}}">Add New Rank</a></li>
                                    <li><a href="{{route('rank.index')}}">Ranks List</a></li>
                                    <li><a href="{{route('rank.trashed')}}">Trashed Ranks</a></li>
                                </ul>
                            </li>


                            <li style="color:#e8e8e8" class="menu-title">Language Data</li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-translate"></i><span> Language Manager <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('language.index')}}">Manage Translations</a></li>
                                </ul>
                            </li>

                            

                            

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->