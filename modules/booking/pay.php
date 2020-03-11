<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_booking_payment_slabs';
 $field_name = 'payment_slab_id';

 $payment_slab_id = $_GET['id'];

 $booking_id = getOne('tbl_booking_payment_slabs','id',$payment_slab_id);
 $booking_id = $booking_id['booking_id'];

 // get property amount
 $property_amount = getPropertyAmount($booking_id);
 
 // get total slab amount
 $slab_percentage = getOne('tbl_booking_payment_slabs','id',$payment_slab_id);
 $slab_percentage = $slab_percentage['payment_percentage'];

 $total_slab_amount = ($property_amount * $slab_percentage) / 100;

 // get paid slab amount where amount is paid in cash or cheque is approved
 $paid_slab_amount = "SELECT IFNULL(SUM(amount),0) as paid_slab_amount FROM tbl_booking_payments WHERE payment_slab_id = '".$payment_slab_id."' AND delete_status = '0' AND cheque_status = '1' ";
 $paid_slab_amount = getRaw($paid_slab_amount);
 $paid_slab_amount = $paid_slab_amount[0]['paid_slab_amount'];

 $remaining_slab_amount = $total_slab_amount - $paid_slab_amount;

 $paid_percent_on_slab_amount = ($paid_slab_amount * 100 ) / $total_slab_amount;
 $paid_percent_on_slab_amount = number_format($paid_percent_on_slab_amount,2);
 
 $paid_percent_on_property_amount = ($paid_slab_amount * 100 ) / $property_amount;
 $paid_percent_on_property_amount = number_format($paid_percent_on_property_amount,2);
 
 if(isset($_POST['submit'])){

   if($_POST['payment_type'] == '2'){
      $cheque_status = 0;
   }else{
      $cheque_status = 1;
   }

   $form_data = array(
      'payment_date' => $_POST['payment_date'],
      'payment_slab_id' => $payment_slab_id,
      'booking_id' => $booking_id,
      'amount' => $_POST['amount'],
      'payment_type' => $_POST['payment_type'],
      'cheque_number' => $_POST['cheque_number'],
      'bank_name' => $_POST['bank_name'],
      'bank_ifsc' => $_POST['bank_ifsc'],
      'account_holder_name' => $_POST['account_holder_name'],
      'cheque_clearing_date' => $_POST['cheque_clearing_date'],
      'cheque_status' => $cheque_status
   );

   if(insert('tbl_booking_payments',$form_data)){
      $success = "Payment Received Successfully";
   }else{
      $error = "Failed to add Payment, Please try again later";
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
                     <div class="col-md-12">
                        
                     <div class="col-md-12 jumbotron p-3 mb-0" style="border: 2px solid rgba(150,215,352,0.2);">
                        <div class="col-md-4 p-3 border-rad-5 text-primary">Slab Amount : <i class="fa fa-rupee pl-2"></i> <?php echo number_format($total_slab_amount,2); ?> </div>
                        <div class="col-md-4 p-3 border-rad-5 text-primary">Paid Amount : <i class="fa fa-rupee pl-2"></i> <?php echo number_format($paid_slab_amount,2); ?> </div>
                        <div class="col-md-4 p-3 text-danger text-bold">Remaining Amount : <i class="fa fa-rupee pl-2"></i> <?php echo number_format($remaining_slab_amount,2); ?></div>

                        <div class="col-md-12 text-muted">
                           <i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php echo $paid_percent_on_slab_amount." % Paid of Total Slab Amount"; ?>
                        </div>
                        <div class="col-md-12 text-muted">
                            <i class="fa fa-check-circle-o" aria-hidden="true"></i> <?php echo $paid_percent_on_property_amount." % Paid of Total Property Amount"; ?>
                        </div>
                     </div>

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

                  <div class="row mt-5">
                     <div class="col-sm-12">
                        <div class="card-box">

                        <form method="POST">

                           <div class="row">

                              <div class="col-md-4">

                                  <div class="form-group">

                                     <label for="payment_date">Payment Date<span class="text-danger">*</span></label>

                                     <input type="date" name="payment_date" parsley-trigger="change"  placeholder="" class="form-control" id="payment_date" value="<?php if(isset($edit_data['payment_date'])){ echo $edit_data['payment_date']; }else{ echo date('Y-m-d'); } ?>" required="">

                                  </div>

                               </div>

                               <div class="col-md-4">

                                  <div class="form-group">

                                     <label for="amount">Amount<span class="text-danger">*</span></label>

                                     <input type="number" name="amount" parsley-trigger="change"  placeholder="" class="form-control" id="amount" value="<?php if(isset($edit_data['amount'])){ echo $edit_data['amount']; } ?>" required="" min="1" max="<?php echo $remaining_slab_amount;  ?>">

                                  </div>

                               </div>

                               <div class="col-md-4">

                                  <div class="form-group">

                                     <label for="payment_type">Payment Type<span class="text-danger">*</span></label>

                                     <select name="payment_type"  parsley-trigger="change" placeholder="" class="form-control payment_type" id="payment_type" value="<?php if(isset($edit_data['payment_type'])){ echo $edit_data['payment_type']; } ?>" required>
                                         <option value="1">Cash</option>
                                         <option value="2">Cheque</option>
                                     </select>

                                  </div>

                               </div>

                               <div class="bank-detail-block" style="display: none;">

                               <div class="col-md-4">

                                  <div class="form-group">

                                     <label for="cheque_number">Cheque Number</label>

                                     <input type="text" name="cheque_number" parsley-trigger="change"  placeholder="" class="form-control" id="cheque_number" value="<?php if(isset($edit_data['cheque_number'])){ echo $edit_data['cheque_number']; } ?>">

                                  </div>

                               </div>

                               <div class="col-md-4">

                                  <div class="form-group">

                                     <label for="bank_name">Bank Name</label>

                                     <input type="text" name="bank_name" parsley-trigger="change"  placeholder="" class="form-control" id="bank_name" value="<?php if(isset($edit_data['bank_name'])){ echo $edit_data['bank_name']; } ?>">

                                  </div>

                               </div>

                               <div class="col-md-4">

                                  <div class="form-group">

                                     <label for="bank_ifsc">Bank IFSC</label>

                                     <input type="text" name="bank_ifsc" parsley-trigger="change"  placeholder="" class="form-control" id="bank_ifsc" value="<?php if(isset($edit_data['bank_ifsc'])){ echo $edit_data['bank_ifsc']; } ?>">

                                  </div>

                               </div>

                               <div class="col-md-4">

                                  <div class="form-group">

                                     <label for="account_holder_name">Account Holder Name</label>

                                     <input type="text" name="account_holder_name" parsley-trigger="change"  placeholder="" class="form-control" id="account_holder_name" value="<?php if(isset($edit_data['account_holder_name'])){ echo $edit_data['account_holder_name']; } ?>">

                                  </div>

                               </div>

                               <div class="col-md-4">

                                  <div class="form-group">

                                     <label for="cheque_clearing_date">Cheque Clearing Date</label>

                                     <input type="date" name="cheque_clearing_date" parsley-trigger="change"  placeholder="" class="form-control" id="cheque_clearing_date" value="<?php if(isset($edit_data['cheque_clearing_date'])){ echo $edit_data['cheque_clearing_date']; } ?>">

                                  </div>

                               </div>


                              </div>
                             
                              <div class="col-md-12 text-right">
                                  <button type="submit" name="submit" class="btn btn-primary btn-md">Submit</button>
                              </div>

                           </div>
                           
                           </form>

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

      <script>
         
         $('#payment_type').on('change', function(){
            
            var payment_type = $(this).val();
            if(payment_type == '1'){
               $('.bank-detail-block').hide();
            }else{
               $('.bank-detail-block').show();
            }

         });

      </script>


   </body>
</html>
