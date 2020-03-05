<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_booking_property_cost';
 $field_name = 'id';

 $booking_id = $_GET['id'];
 $detail = getOne($table_name,$field_name,$booking_id);

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
                           <h4 class="page-title">Property Cost Breakup</h4>
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
                                       <td>Basic Cost of Unit</td>
                                       <td class="text-right"><?php echo number_format($detail['basic_cost_of_unit'],2); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Floor Rise Price</td>
                                       <td class="text-right"><?php echo number_format($detail['floor_rise_price'],2); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Garden Facing Price</td>
                                       <td class="text-right"><?php echo number_format($detail['garden_facing_price'],2); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Discount (<?php echo $detail['discount_approved_by']; ?>)</td>
                                       <td class="text-right"><?php echo $detail['discount']; ?></td>
                                    </tr>
                                    <tr class="font-16 bg-success">
                                       <th>Property Amount</th>
                                       <th class="text-right"><?php 
                                             $property_amount = $detail['basic_cost_of_unit'] + $detail['floor_rise_price'] + $detail['garden_facing_price'] - $detail['discount']; 
                                             echo number_format($property_amount,2);
                                             ?>
                                       </th>
                                    </tr>
                                    <tr>
                                       <td>Development Charges</td>
                                       <td class="text-right"><?php echo number_format($detail['development_charges'],2); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Maintaince Charges</td>
                                       <td class="text-right"><?php echo number_format($detail['maintanance_charges'],2); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Document Charges</td>
                                       <td class="text-right"><?php echo number_format($detail['document_charges'],2); ?></td>
                                    </tr>
                                    <tr>
                                       <td>GST</td>
                                       <td class="text-right"><?php echo number_format($detail['gst'],2); ?></td>
                                    </tr>
                                     <tr class="font-16 bg-success">
                                       <th>Additional Amount</th>
                                       <th class="text-right"><?php 
                                             $additional_amount = $detail['development_charges'] + $detail['maintanance_charges'] + $detail['document_charges'] + $detail['gst']; 
                                             echo number_format($additional_amount,2);
                                             ?>
                                       </th>
                                    </tr>
                                    <tr class="font-18 bg-primary">
                                       <th>Payable Amount</th>
                                       <th class="text-right">
                                          <?php 
                                             $payable_amount = $property_amount + $additional_amount;
                                             echo number_format($payable_amount,2);
                                          ?>
                                       </th>
                                    </tr>
                                   

                             </tbody>

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
