<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_booking_payment_slabs';
 $field_name = 'booking_id';

 $booking_id = $_GET['id'];
 $detail = getWhere($table_name,$field_name,$booking_id);

 function getPaymentSlabs($slab_id){

      $get = getOne('tbl_payment_slabs_master','id',$slab_id);
      return $get['name'];

 }

 $property_amount = getPropertyAmount($booking_id);

 $payouts = "SELECT 
   det.payment_date as payment_date,
   det.id as id,
   det.payment_slab_id as payment_slab_id,
   det.amount as amount,
   det.payment_type as payment_type,
   det.cheque_number as cheque_number,
   det.bank_name as bank_name,
   det.bank_ifsc as bank_ifsc,
   det.account_holder_name as account_holder_name,
   det.cheque_clearing_date as cheque_clearing_date, 
   det.cheque_status as cheque_status 
   FROM tbl_booking_payments det INNER JOIN tbl_booking_payment_slabs mst ON mst.id = det.payment_slab_id WHERE mst.booking_id = '".$booking_id."' AND det.delete_status = '0' ORDER BY det.id DESC ";
 $payouts = getRaw($payouts);

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
         <?php //require_once('../../include/topbar.php'); ?>
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
                        <h4>Payments Slabs</h4>
                     </div>
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                              <table id="bookings" class="table table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                
                                <tbody>
                                    <tr>
                                       <th>Slab</th>
                                       <th>Percentage</th>
                                       <th>Amount</th>
                                       <th>Received Amount</th>
                                       <th>Recovery</th>
                                       <th>Expected Date</th>
                                       <th>Status</th>
                                       <th class="text-center">Action</th>
                                    </tr>

                                    <?php if(isset($detail) && count($detail) > 0){ ?>
                                       <?php foreach($detail as $rs){ ?>
                                          <tr>
                                             <td><?php echo getPaymentSlabs($rs['payment_slab_id']); ?></td>
                                             <td><?php echo $rs['payment_percentage']." %"; ?></td>
                                             <td><?php  
                                                $payment_percentage_amount = ($property_amount * $rs['payment_percentage']) /100 ; 
                                                echo "<i class='fa fa-rupee'></i> ".number_format($payment_percentage_amount,2);
                                                ?></td>
                                                <td>
                                                   <?php 
                                                    $paid_slab_amount = "SELECT IFNULL(SUM(amount),0) as paid_slab_amount FROM tbl_booking_payments WHERE payment_slab_id = '".$rs['payment_slab_id']."' AND delete_status = '0' AND cheque_status = '1' ";
                                                    $paid_slab_amount = getRaw($paid_slab_amount);
                                                    $paid_slab_amount = $paid_slab_amount[0]['paid_slab_amount'];
                                                    echo "<i class='fa fa-rupee'></i> ".number_format($paid_slab_amount,2);
                                                    ?>
                                                </td>
                                             <td>
                                                <?php 
                                                   $recovery = ($paid_slab_amount * 100) / $payment_percentage_amount;
                                                   echo number_format($recovery,2)." %";
                                                ?>
                                             </td>
                                             <td><?php echo date('d-m-Y', strtotime($rs['expected_date'])); ?></td>
                                             <!-- <td><?php if(isset($rs['recieved_date'])){ echo date('d-m-Y', strtotime($rs['recieved_date'])); } ?></td> -->
                                             <td><?php 
                                                if($recovery == 0){
                                                   echo "<span class='text-danger'>PENDING</span>";
                                                }else if($recovery < 100){
                                                   echo "<span class='text-info'>PARTIALLY PAID</span>";
                                                }else if($recovery == 100){
                                                   echo "<span class='text-success'>PAID</span>";
                                                }  
                                                ?>
                                             </td>
                                             <td class="text-center">
                                                <?php if($recovery < 100){ ?>
                                                   <a href="pay.php?id=<?php echo $rs['id']; ?>" class="btn btn-primary btn-xs">Pay Now</a>
                                                <?php }else{ ?>
                                                   <a href="" class="btn btn-primary btn-xs disabled">Paid</a>
                                                <?php } ?>
                                             </td>
                                          </tr>
                                       <?php } ?>
                                    <?php } ?>

                             </tbody>

                              </table>

                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-12">
                        <h4>All Payouts</h4>
                     </div>
                     <div class="col-sm-12">
                        <div class="card-box">
                           <table id="bookings" class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                
                             <tbody>
                                 <tr>
                                    <th>#</th>
                                    <th width="10%">Payment Date</th>
                                    <th width="20%">Payment Slab</th>
                                    <th>Amount</th>
                                    <th>Payment Type</th>
                                    <th>Cheque Number</th>
                                    <th>Bank Name</th>
                                    <th>IFSC</th>
                                    <th>Account Holder Name</th>
                                    <th>Cheque Clearning Date</th>
                                    <th>Cheque Status</th>
                                    <th class="text-center">Action</th>
                                 </tr>

                                 <?php if(isset($payouts) && count($payouts) > 0){ ?>
                                    <?php $i=1; foreach($payouts as $rs){ ?>
                                       <tr id="payout_row_<?php echo $rs['id']; ?>">
                                          <td><?php echo $i++; ?></td>
                                          <td><?php echo date('d-m-Y', strtotime($rs['payment_date'])); ?></td>
                                          <td><?php echo getPaymentSlabName($rs['payment_slab_id']); ?></td>
                                          <td><?php echo $rs['amount']; ?></td>
                                          <td><?php echo $rs['payment_type']; ?></td>
                                          <td><?php echo $rs['cheque_number']; ?></td>
                                          <td><?php echo $rs['bank_name']; ?></td>
                                          <td><?php echo $rs['bank_ifsc']; ?></td>
                                          <td><?php echo $rs['account_holder_name']; ?></td>
                                          <td><?php echo $rs['cheque_clearing_date']; ?></td>
                                          <td><?php 
                                             if($rs['cheque_status'] == '1' ){
                                                echo "<span class='text-success'>PAID</span>";
                                             }else{
                                                echo "<span class='text-danger'>PENDING</span>";
                                             }  
                                             ?>
                                          </td>
                                          <td class="text-center">
                                             <a href="javascript:;" class="btn btn-danger btn-xs remove-payment" data-delete-row="payout_row_" data-delete-table="tbl_booking_payments" data-delete-id="id" data-delete-value="<?php echo $rs['id']; ?>"><i class="fa fa-trash"></i></a>
                                          </td>
                                       </tr>
                                    <?php } ?>
                                 <?php } ?>

                          </tbody>

                           </table>
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
         $(document).on('click','.remove-payment', function(){

             var form_data = {
               delete_row : $(this).attr('data-delete-row'),
               delete_table : $(this).attr('data-delete-table'),
               delete_id : $(this).attr('data-delete-id'),
               delete_value : $(this).attr('data-delete-value')
             };

             softDeleteRecord(form_data);

           });
      </script>


   </body>
</html>
