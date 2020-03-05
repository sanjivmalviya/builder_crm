<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_bookings';
 $field_name = 'id';

 $booking_id = $_GET['id'];
 $detail = getOne($table_name,$field_name,$booking_id); 
 $property_detail = getPropertyDetail($detail['property_floor_id']);

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
                           <h4 class="page-title">Booking Detail</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="card-box">
                           <div class="row">

                              <table id="bookings" class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                
                                <tbody>
                                    <tr>
                                       <td>Code</td>
                                       <td><?php echo $detail['code']; ?></td>
                                    </tr>
                                    <tr>
                                       <td>Tower</td>
                                       <td><?php echo $property_detail['tower']; ?></td>
                                    </tr>
                                    <tr>
                                       <td>Floor</td>
                                       <td><?php echo $property_detail['floor']; ?></td>
                                    </tr>
                                    <tr>
                                       <td>House Number</td>
                                       <td><?php echo $property_detail['house_number']; ?></td>
                                    </tr>
                                    <tr>
                                       <td>Name</td>
                                       <td><?php echo $detail['name']; ?></td>
                                    </tr>
                                    <tr>
                                       <td>Age</td>
                                       <td><?php echo $detail['age']; ?></td>
                                    </tr>
                                    <tr>
                                       <td>Occupation</td>
                                       <td><?php echo $detail['occupation']; ?></td>
                                    </tr>
                                    <tr>
                                       <td>Co-Applicant Name</td>           
                                       <td><?php echo $detail['name_other']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Co-Applicant Age</td>           
                                       <td><?php echo $detail['age_other']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Co-Applicant Occupation</td>           
                                       <td><?php echo $detail['occupation_other']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Residential Address</td>           
                                       <td><?php echo $detail['residential_address']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Residential Mobile Number</td>           
                                       <td><?php echo $detail['residential_mobile_number']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Residential Phone</td>           
                                       <td><?php echo $detail['residential_phone']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Residential PAN Number</td>           
                                       <td><?php echo $detail['residential_pan_number']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Residential Email Address</td>           
                                       <td><?php echo $detail['residential_email_address']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Office Address</td>           
                                       <td><?php echo $detail['office_address']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Office Mobile Number</td>           
                                       <td><?php echo $detail['office_mobile_number']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Office Phone</td>           
                                       <td><?php echo $detail['office_phone']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Office PAN Number</td>           
                                       <td><?php echo $detail['office_pan_number']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Office Email Address</td>           
                                       <td><?php echo $detail['office_email_address']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Remark</td>           
                                       <td><?php echo $detail['remark']; ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Last Updated at</td>           
                                       <td><?php echo date('d-m-Y h:i A',strtotime($detail['updated_at'])); ?></td>           
                                    </tr>
                                    <tr>
                                       <td>Created at</td>           
                                       <td><?php echo  date('d-m-Y h:i A',strtotime($detail['created_at']));; ?></td>           
                                </tr></tb
                                ody>

                              </table>

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
