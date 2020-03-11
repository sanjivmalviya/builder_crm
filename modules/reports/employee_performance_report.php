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

      if(isset($_GET['employee_id']) && $_GET['employee_id'] != ""){
        
        $report = " SELECT * FROM tbl_employees WHERE site_manager_id = '".$login_id."' AND id = '".$_GET['employee_id']."' AND delete_status = '0' ORDER BY id ASC ";

      }else{
        
        $report = " SELECT * FROM tbl_employees WHERE site_manager_id = '".$login_id."' AND delete_status = '0' ORDER BY id ASC ";
      }

      $start_date = $date_from;
      $end_date = $date_to;


   }else{

      $report = " SELECT * FROM tbl_employees WHERE site_manager_id = '".$login_id."' AND delete_status = '0' ORDER BY id ASC ";
      $start_date = date('Y-m-01');
      $end_date = date('Y-m-t');

   }

   $report = getRaw($report);

   foreach($report as $rs){

      $dataset['employee_id'] = $rs['id'];
      $dataset['employee_name'] = $rs['name'];

      $total_bookings = "SELECT COUNT(*) as total_bookings FROM tbl_bookings WHERE employee_id = '".$rs['id']."' AND delete_status = '0' AND date BETWEEN '".$start_date."' AND '".$end_date."' ";
      $total_bookings = getRaw($total_bookings);
      $total_bookings = $total_bookings[0]['total_bookings'];
      $dataset['total_bookings'] = $total_bookings;

      $total_leads = "SELECT COUNT(*) as total_leads FROM tbl_leads WHERE employee_id = '".$rs['id']."' AND delete_status = '0' AND date BETWEEN '".$start_date."' AND '".$end_date."' ";
      $total_leads = getRaw($total_leads);
      $total_leads = $total_leads[0]['total_leads'];
      $dataset['total_leads'] = $total_leads;

      $total_followups = "SELECT COUNT(*) as total_followups FROM tbl_followups flup INNER JOIN tbl_leads lead ON flup.lead_id = lead.id WHERE lead.employee_id = '".$rs['id']."' AND flup.delete_status = '0' AND lead.delete_status = '0' AND DATE(flup.created_at) BETWEEN '".$start_date."' AND '".$end_date."' ";
      $total_followups = getRaw($total_followups);
      $total_followups = $total_followups[0]['total_followups'];
      $dataset['total_followups'] = $total_followups;

      $total_visits = "SELECT COUNT(*) as total_visits FROM tbl_lead_site_visit visit INNER JOIN tbl_leads lead ON visit.lead_id = lead.id WHERE lead.employee_id = '".$rs['id']."' AND visit.delete_status = '0' AND lead.delete_status = '0' AND visit.visit_date BETWEEN '".$start_date."' AND '".$end_date."' ";
      $total_visits = getRaw($total_visits);
      $total_visits = $total_visits[0]['total_visits'];
      $dataset['total_visits'] = $total_visits;

      $data[] = $dataset;

   }

   function cmp($a, $b) {
    if ($a['total_bookings'] == $b['total_bookings']) {
        return 0;
    }
    return ($a['total_bookings'] > $b['total_bookings']) ? -1 : 1;
   } 

   uasort($data, 'cmp');

   $countRecords = count($data);

   // Pagination
   $records_per_page = 30;
   $pagination = new Zebra_Pagination();
   $pagination->records(count($data));
   $pagination->records_per_page($records_per_page);
   // $pagination->reverse(true);

   $data = array_slice(
      $data,
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
                        <a href="employee_performance_report.php" name="search" class="btn btn-default btb-md"><i class="fa fa-refresh"></i></a>
                      </div>
                  </form>
                    
                </div>
            </div>

            <hr>

            <div class="row">
              
              <table id="lead_report" class="table table-striped table-condensed table-hover table-bordered">
                <thead>
                  <th>Rank</th>
                  <th width="40%">Employee</th>
                  <th class="text-center" width="15%">Total Bookings</th>
                  <th class="text-center" width="15%">Total Leads</th>
                  <th class="text-center" width="15%">Total Follow-Ups</th>
                  <th class="text-center" width="15%">Total Visits</th>
                </thead>

                <tbody>
                  <?php 
                    
                    $grand_total_bookings = 0; 
                    $grand_total_leads = 0; 
                    $grand_total_followups = 0; 
                    $grand_total_visits = 0; 
                    
                    if(isset($data) && count($data) > 0){ ?>
                    <?php foreach($data as $rs){ 

                        $grand_total_bookings += $rs['total_bookings']; 
                        $grand_total_leads += $rs['total_leads']; 
                        $grand_total_followups += $rs['total_followups']; 
                        $grand_total_visits += $rs['total_visits']; 

                      ?>
                        <tr>
                          <td class="text-center"><?php echo $i++; ?></td>
                          <td><?php echo $rs['employee_name']; ?></td>
                          <td class="text-center"><?php echo $rs['total_bookings']; ?></td>
                          <td class="text-center"><?php echo $rs['total_leads']; ?></td>
                          <td class="text-center"><?php echo $rs['total_followups']; ?></td>
                          <td class="text-center"><?php echo $rs['total_visits']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>

                <tfoot>
                  <tr>
                    <td colspan="2" class="text-center text-bold">GRAND TOTAL</td>
                    <td class="text-center text-bold"><?php echo $grand_total_bookings; ?></td>
                    <td class="text-center text-bold"><?php echo $grand_total_leads; ?></td>
                    <td class="text-center text-bold"><?php echo $grand_total_followups; ?></td>
                    <td class="text-center text-bold"><?php echo $grand_total_visits; ?></td>
                  </tr>
                </tfoot>
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
