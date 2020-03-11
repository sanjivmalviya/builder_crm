<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_leads';
 $field_name = 'id';

 $lead_id = $_GET['lead_id'];

 $lead_detail = getOne('tbl_leads','id',$lead_id);
 $site_visits = getRaw('SELECT * FROM tbl_lead_site_visit WHERE lead_id = "'.$lead_id.'" AND delete_status = "0" ORDER BY id ASC ');

 $followups = getRaw('SELECT 
    lead.id,
    lead.employee_id,
    flup.id as followup_id,
    flup.followup_type, 
    flup.note_text, 
    flup.action_type, 
    flup.action_date, 
    flup.action_time, 
    flup.action_text, 
    flup.action_status, 
    flup.sms_text, 
    flup.whatsapp_text, 
    flup.whatsapp_mobile_number, 
    flup.created_at 
    FROM tbl_followups flup INNER JOIN tbl_leads lead ON flup.lead_id = lead.id WHERE flup.lead_id = "'.$lead_id.'" AND flup.delete_status = "0" AND lead.delete_status = "0" ORDER BY flup.id DESC ');
 
  function getVisitType($id){
     
     if($id == '0'){
      $name = "Site Visit";
     }else if($id == '1'){
      $name = "Field Visit";
     }else if($id == '2'){
      $name = "Re-Visit";
     }

     return $name;
  }

  function getVisitStatus($id){
     
     if($id == '0'){
      $name = "Pending";
     }else if($id == '1'){
      $name = "Visited";
     }else if($id == '2'){
      $name = "Pending But Not Responding";
     }

     return $name;
  }

 // echo "<xmp>";
 // print_r($site_visits);
 // exit;
 
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

   <?php require_once('../../include/headerscript.php'); ?>


   </head>

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
                  
                  <div class="col-md-5">
                      <div class="panel panel-primary">
                        <div class="panel-heading p-b-0">
                          <div class="row">
                            <div class="col-md-8"><h3 class="panel-title"><?php echo $lead_detail['name']; ?> <a href="add_lead.php?edit_id=<?php echo $lead_detail['id']; ?>"><i class="fa fa-pencil ml-2" title="Update Record"></i></a> </h3>
                              <p class="small"><?php echo $lead_detail['code']; ?></p>
                            </div>
                            <div class="col-md-4"><a class="text-white" href="javascript:void:;"><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span></a></div>
                          </div>
                        </div>
                        <div class="panel-body">
                          <table class="table table-condensed ">
                            <tr>
                              <td width="50%">Created at : </td>
                              <td width="50%" class="text-right"><?php echo date('d M, Y', strtotime($rs['created_at'])); ?></td>
                            </tr>
                            <tr>
                              <td>Last Updated at : </td>
                              <td width="50%" class="text-right"><?php echo date('d M, Y', strtotime($rs['updated_at'])); ?></td>
                            </tr>
                          </table>
                           <ul class="list-group list-group-flush borderless no-border p-b-0">
                             <li class="list-group-item p-1"><span class="text-bold">Generated By :</span> <?php echo getEmployeeName($lead_detail['employee_id']); ?></li>
                             <li class="list-group-item p-1 text-bold">Personal Details</li>
                             <li class="list-group-item p-1">Mobile Number : <?php echo $lead_detail['mobile_number']; ?></li>
                             <li class="list-group-item p-1">Phone : <?php echo $lead_detail['phone']; ?></li>
                             <li class="list-group-item p-1">Occupation : <?php echo $lead_detail['occupation']; ?></li>
                             <li class="list-group-item p-1">Company : <?php echo $lead_detail['company']; ?></li>
                             <li class="list-group-item p-1 text-bold">Address Details</li>
                             <li class="list-group-item p-1">Street Address : <?php echo $lead_detail['street_address']; ?></li>
                             <li class="list-group-item p-1">City : <?php echo getCityName($lead_detail['city_id']); ?></li>
                             <li class="list-group-item p-1">State : <?php echo getStateName($lead_detail['state_id']); ?></li>
                             <li class="list-group-item p-1"><span class="text-bold">Lead Type :</span> <?php echo getPropertyType($lead_detail['property_type_id']); ?></li>
                             <li class="list-group-item p-1"><span class="text-bold">Purpose :</span> <?php echo $lead_detail['purpose']; ?></li>
                             <li class="list-group-item p-1"><span class="text-bold">Budget Range From : </span>&nbsp; <i class="fa fa-rupee"></i><?php echo $lead_detail['budget_range_from'].' - <i class="fa fa-rupee"></i>'.$lead_detail['budget_range_to']; ?></li>
                             <li class="list-group-item p-1"><span class="text-bold">Interested For : </span> <?php echo getPropertyInterestedFor($lead_detail['property_interested_for_id']); ?></li>
                             <li class="list-group-item p-1"><span class="text-bold">Property Category :</span> <?php echo getPropertyCategory($lead_detail['property_category_id']); ?></li>
                             <li class="list-group-item p-1"><span class="text-bold">Possession Status :</span> <?php echo getPossesionStatus($lead_detail['possesion_status_id']); ?></li>
                             <li class="list-group-item p-1"><span class="text-bold">Planning Withing :</span> <?php echo $lead_detail['planning_within']; ?></li>
                             <li class="list-group-item p-1"><span class="text-bold">Lead Source :</span> <?php echo getleadSource($lead_detail['lead_source_id']); ?></li>
                             <li class="list-group-item p-1 no-border"><span class="text-bold">Lead Status :</span> <?php $value = getLeadStatus($lead_detail['lead_status']); echo $value['lead_status']; ?></li>
                             
                           </ul>
                           <table class="table">
                             <thead>
                               <tr>
                                 <td class="text-bold">Date</td>
                                 <td class="text-bold">Type</td>
                                 <td class="text-bold">Status</td>
                               </tr>
                             </thead>
                             <tbody class="site-visit-records">
                              <?php if(isset($site_visits)){ ?>
                                <?php foreach($site_visits as $site_visit){ ?>
                                   <tr id="site_visit_row_<?php echo $site_visit['id']; ?>">
                                     <td><?php echo date('d/m/Y', strtotime($site_visit['visit_date'])); ?></td>
                                     <td><?php echo getVisitType($site_visit['visit_type']); ?></td>
                                     <td><?php echo getVisitStatus($site_visit['visit_status']); ?></td>
                                     <td><a href="javascript:;" class="remove-site-visit" data-delete-row="site_visit_row_" data-delete-table="tbl_lead_site_visit" data-delete-id="id" data-delete-value="<?php echo $site_visit['id']; ?>" ><i class="fa fa-trash text-muted" aria-hidden="true"></i></a></td>
                                   </tr>
                                <?php } ?>
                             <?php } ?>

                             <input type="hidden" id="lead_id" value="<?php echo $lead_detail['id']; ?>">
                             <input type="hidden" id="mobile_number" value="<?php echo $lead_detail['mobile_number']; ?>">
                             <tfoot class="add-site-visit">

                                <tr>
                                  <td width="33%">
                                    <!-- <input type="date" class="form-control" style="width: "> -->
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" id="site_visit_date" value="<?php echo date('m/d/Y'); ?>">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                  </td>
                                  <td width="33%">
                                    <select name="" id="site_visit_type" class="form-control select2">
                                      <option value="0">Site Visit</option>
                                      <option value="1">Field Visit</option>
                                      <option value="2">Re-Visit</option>
                                    </select>
                                  </td>
                                  <td colspan="2" width="33%">
                                    <select name="" id="site_visit_status" class="form-control select2">
                                      <option value="0">Pending</option>
                                      <option value="1">Visited</option>
                                      <option value="2">Pending But Not Responding</option>
                                    </select>
                                  </td>
                                </tr>
                               
                             </tfoot>

                             </tbody>
                           </table>
                           <div class="col-md-12">
                            
                            <div id="add-site-message"></div>

                             <button id="add_site_visit" class="btn btn-primary waves-effect waves-light btn-block btn-rounded btn-sm" data-toggle="modal" data-target="#addSiteVisitModal">+ Add Site Visit</button>
                           </div>
                        </div>
                      </div>
                  </div>

                  <div class="col-md-7">
                    <div class="card-box">

                                <ul class="nav nav-tabs tabs-bordered nav-justified" role="tablist">
                                    <li class="nav-item followup-nav-item">
                                        <a class="nav-link" id="home-b2-tab" data-toggle="tab" href="#home-b2" role="tab" aria-controls="home-b2" aria-selected="false">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block"> <i class="fa fa-sticky-note-o" aria-hidden="true"></i> &nbsp; Note</span>
                                        </a>
                                    </li>
                                    <li class="nav-item followup-nav-item">
                                        <a class="nav-link" id="profile-b2-tab" data-toggle="tab" href="#profile-b2" role="tab" aria-controls="profile-b2" aria-selected="true">
                                            <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                                            <span class="d-none d-sm-block"> <i class="fa fa-anchor" aria-hidden="true"></i> &nbsp; Action</span>
                                        </a>
                                    </li>
                                    <li class="nav-item followup-nav-item">
                                        <a class="nav-link" id="message-b2-tab" data-toggle="tab" href="#message-b2" role="tab" aria-controls="message-b2" aria-selected="false">
                                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                            <span class="d-none d-sm-block"> <i class="fa fa-commenting" aria-hidden="true"></i> &nbsp; SMS</span>
                                        </a>
                                    </li>
                                    <li class="nav-item followup-nav-item">
                                        <a class="nav-link" id="setting-b2-tab" data-toggle="tab" href="#setting-b2" role="tab" aria-controls="setting-b2" aria-selected="false">
                                            <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                            <span class="d-none d-sm-block"> <i class="fa fa-whatsapp" aria-hidden="true"></i> &nbsp; Whatsapp</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="home-b2" role="tabpanel" aria-labelledby="home-b2-tab">

                                        <div class="row">
                                        
                                          <div class="col-md-12">
                                            
                                            <textarea id="note_text" class="form-control" maxlength="260" rows="3" placeholder="Leave a Note to Catch up Later..." autocomplete="off" spellcheck="false"></textarea>

                                          </div>

                                          <div class="col-md-12 mt-5">
                                            <div id="add-note-message"></div>
                                            <button class="btn btn-primary pull-right" id="add_followup_note">Save</button>
                                          </div>
                                        
                                        </div>


                                    </div>
                                    <div class="tab-pane" id="profile-b2" role="tabpanel" aria-labelledby="profile-b2-tab">
                                        <div class="row">
                                        
                                          <div class="col-md-12">
                                            
                                            <textarea id="action_text" class="form-control" maxlength="260" rows="3" placeholder="Leave a Reminder and We will notify you..." autocomplete="off" spellcheck="false"></textarea>

                                          </div>

                                          <!-- <div class="col-md-12 mt-2"> -->

                                            <div class="col-md-4 mt-2">
                                              <label for="">Type</label>
                                              <select name="" id="action_type" class="selectpicker">
                                                <option value="">--Select Type--</option>
                                                <option value="1">Task</option>
                                                <option value="2">Meeting</option>
                                              </select>
                                            </div>

                                            <div class="col-md-4 mt-2">
                                              <label for="">Date</label>
                                               <div class="input-group date" data-provide="datepicker"><input type="text" class="form-control" id="action_date">
                                                  <div class="input-group-addon">
                                                      <span class="glyphicon glyphicon-th"></span>
                                                  </div>
                                               </div>
                                            </div>

                                            <div class="col-md-4 mt-2">
                                              <label for="">Time</label>
                                              <input type="time" class="form-control" id="action_time">
                                            </div>

                                            
                                          <!-- </div> -->

                                          <div class="col-md-12 mt-5">
                                            <div id="add-action-message"></div>
                                            <button class="btn btn-primary pull-right" id="add_followup_action">Add Action</button>
                                          </div>
                                        
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="message-b2" role="tabpanel" aria-labelledby="message-b2-tab">
                                       <div class="row">
                                        
                                          <div class="col-md-12">
                                            
                                            <textarea id="sms_text" class="form-control" maxlength="260" rows="3" placeholder="Type a Message to Send..." autocomplete="off" spellcheck="false"></textarea>
                                          </div>

                                          <div class="col-md-12 mt-5">
                                            <div id="add-sms-message"></div>
                                            <button class="btn btn-primary pull-right" id="add_followup_sms">Send</button>
                                          </div>
                                        
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="setting-b2" role="tabpanel" aria-labelledby="setting-b2-tab">
                                        <div class="row">
                                        
                                          <div class="col-md-12">
                                            
                                            <textarea id="whatsapp_text" class="form-control" maxlength="260" rows="3" placeholder="Type a Message to Send..." autocomplete="off" spellcheck="false"></textarea>
                                          </div>

                                          <div class="col-md-12 mt-5">
                                            <div id="add-whatsapp-message"></div>
                                            <button class="btn btn-primary pull-right" id="add_followup_whatsapp">Send</button>
                                          </div>
                                        
                                        </div>
                                    </div>
                                </div>

                            

                            <div class="row mt-5">
                                <div class="col-sm-12 p-l-0">
                                  <div class="timeline timeline-left">
                                    <!-- <article class="timeline-item timeline-item-left">
                                        <div class="text-left">
                                            <div class="time-show first">
                                                <a href="#" class="btn btn-danger width-lg">Today</a>
                                            </div>
                                        </div>
                                    </article> -->

                                    <?php if(isset($followups) && count($followups) > 0){ ?>
                                      <?php foreach($followups as $rs){ 

                                          $action_status = "";
                                          $headline = "";
                                          $mobile_number = "";
                                          $meeting_detail = array();
                                          $task_detail = array();
                                          if($rs['followup_type'] == '1'){
                                            $headline = "left a note";
                                            $note = $rs['note_text'];
                                            $class = array('icon'=>'fa fa-sticky-note-o','bg'=>'bg-primary','text'=>'text-primary');
                                          }else if($rs['followup_type'] == '2'){
                                            if($rs['action_type'] == '1'){
                                              $headline = "created a task";
                                              $class = array('icon'=>'fa fa-thumb-tack','bg'=>'bg-danger','text'=>'text-danger');
                                              $meeting_detail = array('meeting_date'=>$rs['action_date'],'meeting_time'=>$rs['action_time']);
                                            }else if ($rs['action_type'] == '2') {
                                              
                                              $headline = "created a meeting";
                                              $class = array('icon'=>'fa fa-briefcase','bg'=>'bg-warning','text'=>'text-warning');
                                              $task_detail = array('task_date'=>$rs['action_date'],'task_time'=>$rs['action_time']);
                                            }
                                            if($rs['action_status'] == '1'){
                                              $action_status = "<span class='text-success'>[COMPLETED] </span>";
                                            }else if($rs['action_status'] == "2"){
                                              $action_status = "<span class='text-danger'>[CANCELLED] </span>";
                                            }
                                            $note = $rs['action_text'];
                                          }else if($rs['followup_type'] == '3'){
                                            $headline = "sent a sms";
                                            $note = $rs['sms_text'];
                                            $mobile_number = $lead_detail['mobile_number'];
                                            $class = array('icon'=>'fa fa-commenting-o','bg'=>'bg-dark','text'=>'text-dark');
                                          }else if($rs['followup_type'] == '4'){
                                            $headline = "sent a sms on whatsapp on ".$rs['whatsapp_mobile_number'];
                                            $note = $rs['whatsapp_text'];
                                            $class = array('icon'=>'fa fa-whatsapp','bg'=>'bg-success','text'=>'text-success');
                                          }

                                        ?>
                                        <article class="timeline-item" id="followup_row_<?php echo $rs['followup_id']; ?>">
                                            <div class="timeline-desk">
                                                <div class="panel">
                                                    <div class="timeline-box">
                                                        <span class="arrow"></span>
                                                        <span class="timeline-icon <?php echo $class['bg']; ?>"><i class="timeline-subicon <?php echo $class['icon']; ?>"></i></span>
                                                        <h4 class="<?php echo $class['text']; ?>"><?php echo $action_status.getEmployeeName($rs['employee_id'])." ".$headline; 
                                                        if(isset($meeting_detail) && count($meeting_detail) > 0){
                                                          echo " at ".$meeting_detail['meeting_time']." on ".$meeting_detail['meeting_date'];
                                                        }
                                                        if(isset($task_detail) && count($task_detail) > 0){
                                                          echo " at ".$task_detail['task_time']." on ".$task_detail['task_date'];
                                                        }
                                                        if(isset($mobile_number) && $mobile_number != ""){
                                                          echo " on ".$mobile_number;
                                                        }
                                                        ?></h4>
                                                        <p class="timeline-date text-muted">
                                                          <span class="row ">
                                                            <span class="col-md-6 "><?php echo time_ago($rs['created_at']); ?></span>
                                                            <span class="col-md-6 text-right "><small><?php echo date('d M, Y', strtotime($rs['created_at'])); ?></small></span>
                                                          </span>
                                                          </p>
                                                        <p class="mb-0 "><?php echo $note; ?></p>
                                                        <p class="text-right"><a href="javascript:;" class="remove-followup" data-delete-row="followup_row_" data-delete-table="tbl_followups" data-delete-id="id" data-delete-value="<?php echo $rs['followup_id']; ?>" ><i class="fa fa-trash text-muted"></i></a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                      <?php } ?>
                                    <?php } ?>
                                    

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

      <script>
          $('#property_type_id,#lead_source_id,#lead_status_id,#property_category_id').select2();
          $('#timepicker1').timepicker();

      </script>

   </body>
</html>
