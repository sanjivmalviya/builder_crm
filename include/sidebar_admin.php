 <?php 

    require_once('../../functions.php'); 
    
    $modules = getAllByOrder('modules','module_order','ASC');
    $sidebar_menus = getAllByOrder('tbl_menus','menu_order','ASC');

    $hide_menus = array('Edit','edit','Delete','delete');

 ?>
 <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu" >
                <div class="sidebar-inner slimscrollleft" style="overflow-y: scroll;">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <ul>
                           <li class="menu-title" align="center">ADMINISTRATOR</li>

                            <li>
                                <a href="../../modules/owner/dashboard.php" class="waves-effect"><i class="ti-dashboard"></i><span> Dashboard </span> </a>
                            </li>

                            <li>
                                <a href="../../modules/owner/owner.php" class="waves-effect"><i class="ti-user"></i><span> Company Profile </span> </a>
                            </li>

                           <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i><span> Masters </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/masters/city.php"> City </a></li>
                                    <li><a href="../../modules/masters/state.php"> State </a></li>
                                    <li><a href="../../modules/masters/country.php"> Country </a></li>
                                    <li><a href="../../modules/masters/designation.php"> Designation </a></li>
                                    <li><a href="../../modules/masters/department.php"> Department </a></li>
                                    <li><a href="../../modules/masters/expense.php"> Expense </a></li>
                                    <li><a href="../../modules/masters/possesion_status.php"> Possesion Statuses </a></li>
                                    <li><a href="../../modules/masters/possesion_year.php"> Possesion Year </a></li>
                                    <li><a href="../../modules/masters/possesion_month.php"> Possesion Month </a></li>
                                    <li><a href="../../modules/masters/property_category.php"> Property Categories </a></li>
                                    <li><a href="../../modules/masters/property_type.php"> Property Types </a></li>
                                    <li><a href="../../modules/masters/property_for.php"> Property For </a></li>
                                    <li><a href="../../modules/masters/sample_house_option.php"> Sample House Options </a></li>
                                    <li><a href="../../modules/masters/transaction_type.php"> Transaction Types </a></li>
                                    <li><a href="../../modules/masters/amenity.php"> Amenities </a></li>
                                    <li><a href="../../modules/masters/sub_amenity.php"> Sub Amenities </a></li>
                                    <li><a href="../../modules/masters/lead_source.php"> Lead Sources </a></li>
                                    <li><a href="../../modules/masters/lead_status.php"> Lead Statuses </a></li>
                                    <li><a href="../../modules/masters/lead_way.php"> Lead Ways </a></li>
                                    <li><a href="../../modules/masters/payment_terms.php"> Payment Terms </a></li>
                                </ul>
                            </li>

                            <!-- ONLY FOR DEVELOPER : START -->

                                <!--  <li class="has_sub">
                                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i><span> Modules </span> <span class="menu-arrow"></span></a>
                                    <ul class="list-unstyled">
                                        <li><a href="../../modules/menus/add.php"> Add New Module </a></li>
                                        <li><a href="../../modules/menus/view.php"> View All Modules </a></li>
                                    </ul>
                                </li> -->
                            
                             <!-- ONLY FOR DEVELOPER : ENDS -->

                     <!--        <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i><span> Manage Roles </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/admins/add_state.php"> Add/View State </a></li>                               
                                    <li><a href="../../modules/admins/add.php"> Add New Admin </a></li>
                                    <li><a href="../../modules/admins/view.php"> View All Admins </a></li>
                                </ul>
                            </li>
 -->
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i><span> Site Managers </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/admins/add_site_manager.php"> Add </a></li>
                                    <li><a href="../../modules/admins/view_site_managers.php"> View </a></li>
                                </ul>
                            </li>
<!-- 
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i><span> Order / Invoices </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/owner/orders.php"> Orders </a></li>
                                    <li><a href="../../modules/owner/invoices.php"> Invoices </a></li>
                                </ul>
                            </li> -->

<!-- 
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-settings"></i><span> Reports </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/owner/sales_by_category.php"> Sales by Category </a></li>
                                    <li><a href="../../modules/owner/sales_by_sales_person.php"> Sales by Sales Person </a></li>                               
                                </ul>
                            </li>
 -->
                       <!--      <?php if(isset($modules) && count($modules) > 0){ ?>

                                <?php foreach($modules as $rs){ ?>

                                     <li class="has_sub">
                                        <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-grid2"></i><span> <?php echo ucwords($rs['module_name']); ?> </span> <span class="menu-arrow"></span></a>
                                        <ul class="list-unstyled">
                                           <?php 

                                            $sidebar_menus = getWhere('tbl_menus','module_id',$rs['module_id']);
                                            $sidebar_module_name = $rs['module_name'];

                                            if(isset($sidebar_menus) && count($sidebar_menus) > 0){ 

                                                foreach($sidebar_menus as $rs){ 

                                                    if(!in_array($rs['menu_name'], $hide_menus)){

                                                    ?>
                                                        <li><a href="../../modules/<?php echo $sidebar_module_name; ?>/<?php echo $rs['menu_link']; ?>"> <?php echo ucwords($rs['menu_name']); ?> </a></li>
                                                    
                                                    <?php
                                                }

                                                }
                                            }

                                           ?>
                                        </ul>
                                    </li>

                                <?php } ?>

                            <?php } ?>
 
 -->

                            <li class="bg-dark">
                                <a href="../../modules/login/logout.php" class="waves-effect"><i class="mdi mdi-logout"></i><span class="text-muted"> Logout </span> </a>
                            </li>

                        </ul>
                    </div>

                    <!-- Sidebar -->
                    <div class="clearfix"></div>

                   

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->
