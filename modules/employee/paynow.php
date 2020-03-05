<?php

   include('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $table_name = 'tbl_bookings';
   $field_name = 'id';    

   if(isset($_POST['search'])){

      if(isset($_POST['booking_id']) && $_POST['booking_id'] != ""){
          $condition = " code = '".$_POST['booking_id']."' AND delete_status = '0' AND employee_id = '".$login_id."' ";
      }else if(isset($_POST['mobile_number']) && $_POST['mobile_number'] != ""){
          $condition = " residential_mobile_number LIKE '%".$_POST['mobile_number']."%' AND delete_status = '0' AND employee_id = '".$login_id."' ";
      }

      $booking = "SELECT * FROM ".$table_name." WHERE ".$condition;
      $booking = getRaw($booking);
      
      if(isset($booking) && count($booking) > 0){

        header('location:../booking/payment_slab_detail.php?id='.$booking[0]['id']);

      }else{

        $error = "Ooops ! No Booking Found ";

      }

   }

?>



<!DOCTYPE html>

<html>

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

            <div class="content">

               <div class="container">

     <!--               <div class="row">

                     <div class="col-md-6">

                        <div class="page-title-box">

                           <h4 class="page-title">Add Booking</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div> -->

              
              <hr>
              <div class="row">
                <div class="col-md-12">

                    <!-- <div class="col-md-2"></div> -->
                    <form method="POST">
                      
                      <div class="col-md-3">

                          <div class="form-group">

                             <label for="booking_id">Booking Number</label>

                             <input type="text" name="booking_id" parsley-trigger="change" class="form-control" id="booking_id" value="<?php if(isset($_POST['booking_id'])){ echo $_POST['booking_id']; } ?>" placeholder="Enter Booking Code ">

                          </div>

                       </div>

                      
                      <div class="col-md-3">
                        <div class="form-group">
                           <label for="mobile_number">Mobile Number</label>
                           <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number" value="<?php if(isset($_POST['mobile_number'])){ echo $_POST['mobile_number']; } ?>" >

                        </div>  
                      </div>

                      <div class="col-md-4 pt-2">
                        <br>                      
                        <button type="submit" name="search" class="btn btn-primary btb-md"><i class="fa fa-search"></i> Search</button>
                      </div>
                  </form>
                    
                </div>
            </div>

            <?php if(isset($success) || isset($warning) || isset($error)){ ?>

              <div class="row">

                <div class="col-md-12 p-t-30">

                    <?php if(isset($success)){ ?>

                       <div class="alert alert-success"><?php echo $success; ?></div>

                    <?php }else if(isset($warning)){ ?>

                       <div class="alert alert-warning"><?php echo $warning; ?></div>

                    <?php }else if(isset($error)){ ?>

                       <div class="alert alert-danger"><?php echo $error; ?></div>

                    <?php } ?>

                 </div>
              </div>
            <?php } ?>

           <hr> 
                 

               </div>

               <!-- container -->

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
      <?php require_once('../../include/footer.php'); ?>

   </body>

</html>
