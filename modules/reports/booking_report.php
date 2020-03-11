<?php

   include('../../functions.php');
   require_once('../../libraries/Zebra_Pagination.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $employees = getRaw("SELECT * FROM tbl_employees WHERE site_manager_id = '".$login_id."' AND delete_status = '0' ORDER BY name ASC ");

   $today = date('Y-m-d');

   if(isset($_GET['search'])){
      
      $employee_id = $_GET['employee_id'];
      if(isset($_GET['date_from']) && $_GET['date_from'] != ""){
        $date_from = date('Y-m-d', strtotime($_GET['date_from']));
      }else{
        $date_from = "";
      }
      if(isset($_GET['date_to']) && $_GET['date_to'] != ""){
        $date_to = date('Y-m-d', strtotime($_GET['date_to']));
      }else{
        $date_to = "";
      }

      if($employee_id != ""){
      
          $condition = " AND employee_id = '".$_GET['employee_id']."' ";
      
      }
      if($date_from != ""){
      
          $condition = " AND date = '".$date_from."' ";
      
      }
      if($date_to != ""){
      
          $condition = " AND date = '".$date_to."' ";
      
      }
      if($employee_id != "" && $date_from != ""){
      
          $condition = " AND employee_id = '".$employee_id."' AND date = '".$date_from."' ";
      
      }
      if($employee_id != "" && $date_to != ""){

          $condition = " AND employee_id = '".$employee_id."' AND date = '".$date_to."' ";
      
      }
      if($date_from != "" && $date_to != ""){
      
          $condition = " AND date BETWEEN '".$date_from."' AND '".$date_to."' ";

      }
      if($employee_id != "" && $date_from != "" && $date_to != ""){

        $condition = " AND  employee_id = '".$_GET['employee_id']."' AND date BETWEEN '".$date_from."' AND  '".$date_to."' ";
      }

      $bookings = " SELECT * FROM tbl_bookings WHERE delete_status = '0' ".$condition." ORDER BY id ASC ";

   }else{

      $bookings = " SELECT * FROM tbl_bookings WHERE delete_status = '0' AND `date` = '".$today."' ";

   }

 
   $bookings = getRaw($bookings);
   $countRecords = count($bookings);

   // Pagination
   $records_per_page = 30;
   $pagination = new Zebra_Pagination();
   $pagination->records(count($bookings));
   $pagination->records_per_page($records_per_page);
   // $pagination->reverse(true);

   $bookings = array_slice(
      $bookings,
      (($pagination->get_page() - 1) * $records_per_page),
      $records_per_page
   );

   $pageNumber = $pagination->get_page() - 1;
   if($pageNumber == 0){
      $i = 1;
   }else{
      $i = ($pageNumber * $records_per_page) + 1;
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

         <div class="content-page mt-0">

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
              <div class="row">
                <div class="col-md-12">

                    <!-- <div class="col-md-2"></div> -->
                    <form method="GET">
                      
                      <div class="col-md-3">

                          <div class="form-group">

                             <label for="name">Select Employee</label>

                             <select name="employee_id" id="employee_id" class="form-control select2">
                               <option value="">All</option>
                               <?php if(isset($employees)){ ?>
                                <?php foreach($employees as $rs){ ?>
                                  <option <?php if(isset($_GET['employee_id']) && $_GET['employee_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>
                                <?php } ?>
                              <?php } ?>

                             </select>

                          </div>

                       </div>


                       <div class="col-md-3"> 

                          <label for="date_from">Date From</label>

                          <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control" id="date_from" name="date_from" value="<?php if(isset($_GET['date_from']) && $_GET['date_from'] != ""){ echo $_GET['date_from']; } ?>" >
                            <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                            </div>
                          </div>

                       </div>

                       <div class="col-md-3"> 

                          <label for="date_to">Date To</label>

                          <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control" id="date_to" name="date_to" value="<?php if(isset($_GET['date_to']) && $_GET['date_to'] != ""){ echo $_GET['date_to']; } ?>" >
                            <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                            </div>
                          </div>

                       </div>


                      <div class="col-md-12 pt-2">
                        <p><?php if($countRecords > 0){ echo "<span class='text-primary text-bold'>".$countRecords." Records Found </span>"; }else{ echo "<span class='text-danger text-bold'>No Records Found</span>"; }  ?></p>
                        <button type="submit" name="search" class="btn btn-primary btb-md"><i class="fa fa-search"></i> Search</button>
                        <a href="lead_report.php" name="search" class="btn btn-default btb-md"><i class="fa fa-refresh"></i></a>
                      </div>
                  </form>
                    
                </div>
            </div>

            <hr>

            <div class="row">
              
              <table id="lead_report" class="table table-striped table-condensed table-hover table-bordered">
                <thead>
                  <th>#</th>
                  <th>Generated By</th>
                  <th>Booking Code</th>
                  <th>Booking Date</th>
                  <th>Name</th>
                  <th>Mobile Number</th>
                  <th>Tower</th>
                  <th>Floor</th>
                  <th>House</th>
                  <th class="text-right">Property Amount</th>
                  <th class="text-right">Payable Amount</th>
                </thead>

                <tbody>
                  <?php if(isset($bookings) && count($bookings) > 0){ ?>
                    <?php foreach($bookings as $rs){ 

                      $property_detail = getPropertyDetail($rs['property_floor_id']);

                    ?>
                        <tr>
                          <td><?php echo $i++; ?></td>
                          <td><?php echo getEmployeeName($rs['employee_id']); ?></td>
                          <td><?php echo $rs['code']; ?></td>
                          <td><?php echo $rs['date']; ?></td>
                          <td><?php echo $rs['name']; ?></td>
                          <td><?php echo $rs['residential_mobile_number']; ?></td>
                          <td class="text-center"><?php echo $property_detail['tower']; ?></td>
                          <td class="text-center"><?php echo $property_detail['floor']; ?></td>
                          <td class="text-center"><?php echo $property_detail['house_number']; ?></td>
                          <td class="text-right"><?php echo "<i class='fa fa-rupee'></i> ".number_format(getPropertyAmount($rs['id'],0)); ?></td>
                          <td class="text-right"><?php echo "<i class='fa fa-rupee'></i> ".number_format(getPayableAmount($rs['id'],0)); ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
              </table>

            </div>

            <hr>

            <div class="row">
              <?php $pagination->render(); ?>
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
