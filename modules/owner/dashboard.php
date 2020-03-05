
<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];


?>

<!DOCTYPE html>
<html>
<head>

</head>
   <?php require_once('../../include/headerscript.php'); ?>
   <body class="fixed-left">
      <!-- Begin page -->
      <div id="wrapper">
         <!-- Top Bar Start -->
         <?php require_once('../../include/topbar.php'); ?>
         <!-- Top Bar End -->
         <!-- ========== Left Sidebar Start ========== -->
         <?php require_once('../../include/sidebar.php'); ?>
         <!-- Left Sidebar End -->
         <!-- ============================================================== -->
         <!-- Start Page Content here -->
         <!-- ============================================================== -->
         <div class="content-page">
            <!-- Start content -->
            <div class="content" style="margin-top: 45px;">
            
               <section id="team" class="pb-5">
                   <div class="container">
                       <!-- <h5 class="section-title h1">OUR TEAM</h5> -->

                   </div>
               </section>
              
            </div>
            <!-- content -->
         </div>
         <!-- ============================================================== -->
         <!-- End of the page -->
         <!-- ============================================================== -->
      </div>
      <!-- END wrapper -->
      <!-- START Footerscript -->
      <?php require_once('../../include/footerscript.php'); ?>

   </body>
</html>