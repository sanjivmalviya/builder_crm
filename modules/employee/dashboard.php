<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $total_leads = getRaw('SELECT * FROM tbl_leads WHERE employee_id = "'.$login_id.'" AND delete_status= "0" ');
   $total_leads = count($total_leads);

   $action_date = date('m/d/Y');
   $tomorrow_action_date = date('m/d/Y', strtotime('+1 day', strtotime(date('Y-m-d'))));
   $yesterday = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
   
   $today_leads = getRaw('SELECT COUNT(*) as today_leads FROM tbl_leads WHERE DATE(created_at) = DATE(NOW())');
   $today_leads = $today_leads[0]['today_leads'];
   
   $yesterday_leads = getRaw('SELECT COUNT(*) as yesterday_leads FROM tbl_leads WHERE DATE(created_at) = "'.$yesterday.'" ');
   $yesterday_leads = $yesterday_leads[0]['yesterday_leads'];

   $total_followups = getRaw('SELECT COUNT(*) as total_followups FROM tbl_followups WHERE action_date != "" AND action_status = "0" ');
   $total_followups = $total_followups[0]['total_followups'];

   $today_followups = 'SELECT flup.id as followup_id,ld.id as lead_id,ld.name as name,flup.followup_type as followup_type,flup.action_date as action_date,flup.action_time as action_time,flup.action_text as action_text FROM tbl_followups flup INNER JOIN tbl_leads ld ON flup.lead_id = ld.id WHERE flup.action_date != "" AND flup.action_date = "'.$action_date.'" AND flup.action_status = "0" ';
   $today_followups = getRaw($today_followups);
   $today_followups_count = count($today_followups);

   $tomorrow_followups = getRaw('SELECT COUNT(*) as tomorrow_followups FROM tbl_followups WHERE action_date != "" AND action_date = "'.$tomorrow_action_date.'" AND action_status = "0" ');
   $tomorrow_followups = $tomorrow_followups[0]['tomorrow_followups'];

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
            <div class="content">
            
               <section id="team" class="pb-5">
                   <div class="container">

                    <div class="row">
                      
                    </div>

                    <div class="row">
                      <div class="col-lg-6 col-xl-3">
                              <div class="card widget-box-three">
                                  <div class="card-body">
                                      <div class="float-right mt-2">
                                          <i class="mdi mdi-chart-areaspline display-6 m-0 font-80"></i>
                                      </div>
                                      <div class="overflow-hidden">
                                          <p class="text-uppercase font-weight-medium text-truncate mb-2">TOTAL LEADS</p>
                                          <h2 class="mb-0"><span data-plugin="counterup"><?php echo $total_leads; ?></span> </h2>
                                          <!-- <p class="text-muted mt-2 m-0"><span class="font-weight-medium">Last Month:</span> 0</p> -->
                                      </div>
                                  </div>
                              </div>
                      </div>

                      <div class="col-lg-6 col-xl-3">
                          <div class="card widget-box-three">
                              <div class="card-body">
                                  <div class="float-right mt-2">
                                      <i class="mdi mdi-chart-areaspline display-6 m-0 font-80"></i>
                                  </div>
                                  <div class="overflow-hidden">
                                      <p class="text-uppercase font-weight-medium text-truncate mb-2">TODAY LEADS</p>
                                      <h2 class="mb-0"><span data-plugin="counterup"><?php echo $today_leads; ?></span> 
                                        <?php if($today_leads > $yesterday_leads){ ?>
                                           <i class="mdi mdi-arrow-up text-success font-24"></i>
                                        <?php }else{ ?>
                                           <i class="mdi mdi-arrow-down text-danger font-24"></i>
                                        <?php } ?>
                                     </h2>
                                      <p class="text-muted mt-2 m-0"><span class="font-weight-medium">Yesterday :</span> <?php echo $yesterday_leads; ?></p>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="col-lg-6 col-xl-3">
                          <div class="card widget-box-three">
                              <div class="card-body">
                                  <div class="float-right mt-2">
                                      <i class="mdi mdi-chart-areaspline display-6 m-0 font-80"></i>
                                  </div>
                                  <div class="overflow-hidden">
                                      <p class="text-uppercase font-weight-medium text-truncate mb-2">TOTAL FOLLOWUPS</p>
                                      <h2 class="mb-0"><span data-plugin="counterup"><?php echo $total_followups; ?></span> </h2>
                                      <!-- <p class="text-muted mt-2 m-0"><span class="font-weight-medium">Last Month:</span> 0</p> -->
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="col-lg-6 col-xl-3">
                          <div class="card widget-box-three">
                              <div class="card-body">
                                  <div class="float-right mt-2">
                                      <i class="mdi mdi-chart-areaspline display-6 m-0 font-80"></i>
                                  </div>
                                  <div class="overflow-hidden">
                                      <p class="text-uppercase font-weight-medium text-truncate mb-2">TODAY FOLLOWUPS</p>
                                      <h2 class="mb-0"><span data-plugin="counterup"><?php echo $today_followups_count; ?></span> 
                                        <?php if($today_followups_count > $tomorrow_followups){ ?>
                                           <i class="mdi mdi-arrow-up text-success font-24"></i>
                                        <?php }else{ ?>
                                           <i class="mdi mdi-arrow-down text-danger font-24"></i>
                                        <?php } ?>
                                     </h2>
                                      <p class="text-muted mt-2 m-0"><span class="font-weight-medium">Tomorrow:</span> <?php echo $tomorrow_followups; ?></p>
                                  </div>
                              </div>
                          </div>
                      </div>

                    </div>

                    <div class="row mt-5">

                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="header-title m-t-0 m-b-30">TODAY PENDING FOLLOWUPS</h4>

                            <div class="table-responsive">
                                <table class="table table table-hover table-condensed m-0">
                                    <thead>
                                        <tr>
                                            <th>Lead Id</th>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th>Note</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php if(isset($today_followups) && count($today_followups) > 0){ ?>
                                        <?php foreach($today_followups as $rs){ ?>
                                              <tr id="follow_up_row<?php echo $rs['followup_id']; ?>" >
                                                <td><?php echo $rs['lead_id']; ?></td>
                                                <td><a href="../lead/lead_detail.php?lead_id=<?php echo $rs['lead_id']; ?>"><?php echo ($rs['followup_type'] == '1') ? 'Task' : 'Meeting'; ?></a></td>
                                                <td><?php echo $rs['name']; ?></td>
                                                <td><?php echo $rs['action_text']; ?></td>
                                                <td><?php echo $rs['action_date']; ?></td>
                                                <td><?php echo $rs['action_time']; ?></td>
                                                <td width="20%" class="text-right">
                                                <div class="btn-group">
                                                  <a data-id="<?php echo $rs['followup_id']; ?>" class="btn btn-success btn-xs waves-effect waves-light followup-action-status" data-status="1" data-status-title="action_status" data-row-title="follow_up_row" role="button">Completed</a>
                                                  <a data-id="<?php echo $rs['followup_id']; ?>" class="btn btn-danger btn-xs waves-effect waves-light followup-action-status" data-status="2" data-status-title="action_status" data-row-title="follow_up_row" role="button">Cancelled</a>
                                                </div>
                                                </td>
                                            </tr>
                                      <?php } ?>
                                      <?php } ?>


                                    </tbody>
                                </table>

                            </div> <!-- table-responsive -->
                        </div> <!-- end card -->
                    </div>
                    <!-- end col -->


                </div>


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
      <?php require_once('../../include/footer.php'); ?>

   </body>
</html>