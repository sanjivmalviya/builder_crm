 <?php 

    // require('../../functions.php'); 

    $this_admin_roles = getWhere('tbl_employee_roles','employee_id',$_SESSION["crm_credentials"]['user_id']);
    
    if(isset($this_admin_roles) && count($this_admin_roles) > 0){

        foreach ($this_admin_roles as $rs) {
            $admin_menus[] = $rs['menu_id'];
        }

    }

    if(isset($admin_menus) && count($admin_menus) > 0){

        $sidebar_menus = "SELECT * FROM tbl_menus INNER JOIN tbl_modules ON tbl_modules.module_id = tbl_menus.module_id WHERE menu_id IN (".implode(",", $admin_menus).") ORDER BY tbl_modules.module_order,tbl_menus.menu_order ";
        $sidebar_menus = getRaw($sidebar_menus);    

        foreach($sidebar_menus as $rs){

            $sidebar_modules[] = $rs['module_id'];
            
        }

        $sidebar_modules = array_unique($sidebar_modules);

    }


    $hide_menus = array('Edit','edit','Delete','delete');

 ?>
 <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu" >
                        <ul>
                           <li class="menu-title" align="center">Employee</li>

                            <li>
                                <a href="../../modules/employee/dashboard.php" class="waves-effect"><i class="ti-dashboard"></i><span> Dashboard </span> </a>
                            </li>
                            <li>
                                <a href="../../modules/employee/search_leads.php" class="waves-effect"><i class="fa fa-search"></i><span> Search Leads </span> </a>
                            </li>
                            <li>
                                <a href="../../modules/employee/paynow.php" class="waves-effect"><i class="fa fa-rupee"></i><span> Quick Pay </span> </a>
                            </li>
                           <!--  
                            <li>
                                <a href="../../modules/login/dashboard.php" class="waves-effect"><i class="ti-dashboard"></i><span> Employee Trip </span> </a>
                            </li>
 -->
<!-- 
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-harddrive"></i><span> Masters </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/masters/packing.php">Packing</a></li>
                                    <li><a href="../../modules/masters/unit.php">Unit</a></li>
                                    <li><a href="../../modules/masters/expenses.php">Expense Category</a></li>
                                </ul>
                            </li> -->

                           <!--   <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-target"></i><span> Assign Target </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="../../modules/target/add.php">Create New Target</a></li>
                                    <li><a href="../../modules/target/view.php">View</a></li>
                                </ul>
                            </li>
 -->

                            <?php if(isset($sidebar_modules) && count($sidebar_modules) > 0){ ?>

                                <?php foreach($sidebar_modules as $sidebar_module_id){ 

                                    $sidebar_module_name1 = getOne('tbl_modules','module_id',$sidebar_module_id);
                                    $sidebar_module_name = $sidebar_module_name1['module_name'];

                                    ?>

                                     <li class="has_sub">
                                        <a href="javascript:void(0);" class="waves-effect"><i class="<?php echo $sidebar_module_name1['module_class']; ?>"></i><span> <?php echo ucwords($sidebar_module_name); ?> </span> <span class="menu-arrow"></span></a>
                                        <ul class="list-unstyled">
                                           <?php 


                                            if(isset($sidebar_menus) && count($sidebar_menus) > 0){ 

                                                foreach($sidebar_menus as $rs){ 
        
                                                    if($sidebar_module_id == $rs['module_id'] && !in_array($rs['menu_name'], $hide_menus)){

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
