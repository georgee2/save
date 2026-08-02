<!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="">
                        <a href="#" class="logo text-center">CRM</a>
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


                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-briefcase-check"></i><span> Jobs Postings <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('jobs-posting.create')}}">Add New Job Posting</a></li>
                                    <li><a href="{{route('jobs-posting.index')}}">Jobs Postings List</a></li>
                                    <li><a href="{{route('jobs-posting.trashed')}}">Trashed Jobs Postings</a></li>
                                    <li><a href="{{route('crm-job-applications.index')}}">Job Applications</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{route('crm-customers.index')}}" class="waves-effect"><i class="mdi mdi-18px mdi-account-multiple"></i><span> Customers</span></a>
                            </li>

                            <li>
                                <a href="{{route('crm-favourites.index')}}" class="waves-effect"><i class="mdi mdi-18px mdi-heart"></i><span> Favourites</span></a>
                            </li>

                            <li>
                                <a href="{{route('crm-contact-us.index')}}" class="waves-effect"><i class="mdi mdi-18px mdi-email"></i><span> Contact Us</span></a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-18px mdi-account-star"></i><span> Agents <span class="float-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="list-unstyled">
                                    <li><a href="{{route('crm-agents.create')}}">Add New Agent</a></li>
                                    <li><a href="{{route('crm-agents.index')}}">Agents List</a></li>
                                    <li><a href="{{route('crm-agents.trashed')}}">Trashed Agents</a></li>
                                </ul>
                            </li>



                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->