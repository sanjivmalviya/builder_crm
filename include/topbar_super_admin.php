<?php

    require_once('../../functions.php');
?>
<!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="dashboard.php" class="logo"><span>Nikki<span>Bites</span></span><i class="mdi mdi-layers"></i></a>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">

                        <!-- Navbar-left -->
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <button class="button-menu-mobile open-left waves-effect">
                                    <i class="mdi mdi-menu"></i>
                                </button>
                            </li>
                         
                        </ul>

                        <!-- Right(Notification) -->
                        <ul class="nav navbar-nav navbar-right">
                            
                            <li class="dropdown user-box">
                                <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-user" style="font-size: 22px;"></i>
                                    <!-- <img src="../../assets/images/super_admin_profile.png" alt="user-img" class="img-circle user-img"> -->
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                                    <li>
                                        <h5>Hi, <?php echo $_SESSION["crm_credentials"]['user_name']; ?></h5>
                                    </li>                                   
                                    <li><a href="../../modules/owner/change_password.php"><i class="ti-settings m-r-5"></i> Change Password</a></li>
                                    <li><a href="../../modules/login/logout.php"><i class="ti-power-off m-r-5"></i> <span class="text-danger">Logout</span></a></li>
                                </ul>
                            </li>

                        </ul> <!-- end navbar-right -->

                    </div><!-- end container -->
                </div><!-- end navbar -->
            </div>
            <!-- Top Bar End -->
