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

      $condition = "";
      
      if($employee_id != ""){
      
          $condition = " AND lead.employee_id = '".$_GET['employee_id']."' ";
      
      }
      if($date_from != ""){
      
          $condition = " AND visit.visit_date = '".$date_from."' ";
      
      }
      if($date_to != ""){
      
          $condition = " AND visit.visit_date = '".$date_to."' ";
      
      }
      if($employee_id != "" && $date_from != ""){
      
          $condition = " AND lead.employee_id = '".$employee_id."' AND visit.visit_date = '".$date_from."' ";
      
      }
      if($employee_id != "" && $date_to != ""){

          $condition = " AND lead.employee_id = '".$employee_id."' AND visit.visit_date = '".$date_to."' ";
      
      }
      if($date_from != "" && $date_to != ""){
      
          $condition = " AND (visit.visit_date BETWEEN '".$date_from."' AND '".$date_to."') ";

      }
      if($employee_id != "" && $date_from != "" && $date_to != ""){

        $condition = " AND  lead.employee_id = '".$_GET['employee_id']."' AND (visit.visit_date BETWEEN '".$date_from."' AND  '".$date_to."') ";
      }

      if(isset($_GET['visit_type']) && $_GET['visit_type'] != ""){
        $condition .= "AND visit.visit_type = '".$_GET['visit_type']."' ";
      }

      $visits = " SELECT lead.code,lead.employee_id,lead.id,visit.visit_date,visit.visit_type,visit.visit_status FROM tbl_lead_site_visit visit INNER JOIN tbl_leads lead ON visit.lead_id = lead.id WHERE visit.delete_status = '0' ".$condition;

   }else{

      $visits = "SELECT lead.code,lead.employee_id,lead.id,visit.visit_date,visit.visit_type,visit.visit_status FROM tbl_lead_site_visit visit INNER JOIN tbl_leads lead ON visit.lead_id = lead.id WHERE visit.delete_status = '0' AND visit.visit_date = '".$today."' ORDER BY visit.id ASC ";

   }

   if(isset($_GET['next_day']) && $_GET['next_day'] != ""){
      
      $datetime = new DateTime('tomorrow');
      $next_day = $datetime->format('Y-m-d');
      
      $visits = "SELECT lead.code,lead.employee_id,lead.id,visit.visit_date,visit.visit_type,visit.visit_status FROM tbl_lead_site_visit visit INNER JOIN tbl_leads lead ON visit.lead_id = lead.id WHERE visit.delete_status = '0' AND visit.visit_date = '".$next_day."' ORDER BY visit.id ASC ";
   
   }

   $visits = getRaw($visits);
   $countRecords = count($visits);

   // Pagination
   $records_per_page = 30;
   $pagination = new Zebra_Pagination();
   $pagination->records(count($visits));
   $pagination->records_per_page($records_per_page);
   // $pagination->reverse(true);

   $visits = array_slice(
      $visits,
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

                       <div class="col-md-3">

                          <div class="form-group">

                             <label for="visit_type">Visit Type</label>

                             <select name="visit_type" id="visit_type" class="form-control select2">
                               <option value="">All</option>
                               <option value="0">Site Visit</option>
                               <option value="1">Field Visit</option>
                               <option value="2">Re-Visit</option>
                             </select>

                          </div>

                       </div>


                      <div class="col-md-12 pt-2">
                        <p><?php if($countRecords > 0){ echo "<span class='text-primary text-bold'>".$countRecords." Records Found </span>"; }else{ echo "<span class='text-danger text-bold'>No Records Found</span>"; }  ?></p>
                        <button type="submit" name="search" class="btn btn-primary btb-md"><i class="fa fa-search"></i> Search</button>
                        <a href="visit_report.php" name="search" class="btn btn-default btb-md"><i class="fa fa-refresh"></i></a>
                        <a href="visit_report.php?next_day=1" name="search" class="btn btn-default btb-md pull-right "><i class="fa fa-chevron-right"></i> Next Day Visits</a>
                      </div>
                  </form>
                    
                </div>
            </div>

            <hr>

            <div class="row">
              
              <table id="visit_report" class="table table-striped table-condensed table-hover table-bordered">
                <thead>
                  <th>#</th>
                  <th>Code</th>
                  <th>Generated By</th>
                  <th>Visit Date</th>
                  <th>Visit Type</th>
                  <th>Visit Status</th>
                </thead>

                <tbody>
                  <?php if(isset($visits) && count($visits) > 0){ ?>
                    <?php foreach($visits as $rs){ ?>
                        <tr>
                          <td><?php echo $i++; ?></td>
                          <td><a href="../lead/lead_detail.php?lead_id=<?php echo $rs['id']; ?>"><?php echo $rs['code']; ?></a></td>
                          <td><?php echo getEmployeeName($rs['employee_id']); ?></td>
                          <td><?php echo date('d-m-Y', strtotime($rs['visit_date'])); ?></td>
                          <td><?php 
                            if($rs['visit_type'] == "0"){ 
                                echo "Site Visit"; 
                            }else if($rs['visit_type'] == "1"){ 
                                echo "Field Visit"; 
                            }else if($rs['visit_type'] == "2"){ 
                                echo "Re-Visit"; 
                            } ?>
                         </td>
                         <td><?php 
                            if($rs['visit_status'] == "0"){ 
                                echo "<span class='text-danger'>Pending</span>"; 
                            }else if($rs['visit_status'] == "1"){ 
                                echo "<span class='text-primary'>Visited</span>"; 
                            }else if($rs['visit_status'] == "2"){ 
                                echo "<span class='text-warning'>Pending But Not Responding</span>"; 
                            } ?>
                         </td>
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
