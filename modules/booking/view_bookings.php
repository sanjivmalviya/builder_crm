<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_bookings';
 $field_name = 'id';

 $bookings = "SELECT * FROM tbl_bookings WHERE employee_id = '".$login_id."' AND delete_status = '0' ";
 $bookings = getRaw($bookings); 

 if(isset($_GET['delete_id'])){
   
   $form_data = array(
      'delete_status' => '1'
   );

   if(update($table_name,$field_name,$_GET['delete_id'],$form_data)){
      
      $success = "Record Deleted Successfully";
      header('location:view_bookings.php');

   }else{
      $error = "Failed to Delete Record";
   }

 }

?>

<!DOCTYPE html>
<html>
   <head>
      <style>
         .popover{
            z-index: 99999 !important;
            max-width: 100% !important;
            width: 100% !important;
         }
      </style>
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
            <div class="content">
               <div class="container">
                  <div class="row">
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <h4 class="page-title">Bookings</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                              <table id="bookings" class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                
                                <thead>
                                       <th>#</th>
                                       <th class="text-center">Code</th>
                                       <th class="text-center" width="10%">Date</th>
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Tower</th>
                                       <th class="text-center">Floor</th>
                                       <th class="text-center">House Number</th>           
                                       <th class="text-center">Mobile Number</th>           
                                       <th class="text-center">Property Amount</th>           
                                       <th class="text-center">Payable Amount</th>           
                                       <th class="text-center">Payment Slabs</th>           
                                       <th class="text-center">Actions</th>           
                                </thead>

                                <tbody>
                                  
                                  <?php if(isset($bookings) && count($bookings) > 0){ ?>

                                    <?php $i=1; foreach($bookings as $rs){ 

                                       $property_detail = getPropertyDetail($rs['property_floor_id']);

                                    ?>

                                    <tr>
                                             <td><?php echo $i++; ?></td>
                                             <td class="text-center"><a href="booking_detail.php?id=<?php echo $rs['id']; ?>"><?php echo $rs['code']; ?></a></td>
                                             <td class="text-center"><?php echo date('d-m-Y', strtotime($rs['date'])); ?></td>
                                             <td class="text-center"><?php echo $rs['name']; ?></td>
                                             <td class="text-center"><?php echo $property_detail['tower']; ?></td>
                                             <td class="text-center"><?php echo $property_detail['floor']; ?></td>
                                             <td class="text-center"><?php echo $property_detail['house_number']; ?></td>
                                             <td class="text-center"><?php echo $rs['residential_mobile_number']; ?></td>
                                             <td class="text-center"><?php echo "<i class='fa fa-rupee'></i> ".number_format(getPropertyAmount($rs['id'])); ?></td>
                                             <td class="text-center"><a href="payable_detail.php?id=<?php echo $rs['id']; ?>"><?php echo "<i class='fa fa-rupee'></i> ".number_format(getPayableAmount($rs['id'])); ?></a></td>
                                             <td class="text-center"><a href="payment_slab_detail.php?id=<?php echo $rs['id']; ?>"><?php echo getPaymentSlabCount($rs['id']); ?></a></td>
                                             <td class="text-center">
                                                <a href="add_booking.php?edit_id=<?php echo $rs['id']; ?>"><i class="fa fa-pencil" style="font-size: 15px;padding: 2px;"></i></a>
                                                <a href="view_bookings.php?delete_id=<?php echo $rs['id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash text-danger" style="font-size: 15px;padding: 2px;"></i></a>
                                             </td>
                                    </tr>
                                    <?php } ?>

                                  <?php } ?>

                                </tbody>

                              </table>

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
                      
                           </div>
                        </div>
                     </div>
                  </div>
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
