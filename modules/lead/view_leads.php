<?php

 require_once('../../functions.php');

 require_once('../../libraries/Zebra_Pagination.php');
 

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_leads';
 $field_name = 'id';

 function getLastFollowUp($lead_id){
    
    $get = "SELECT created_at FROM tbl_followups WHERE lead_id = '".$lead_id."' AND delete_status = '0' ORDER BY id DESC ";
    $get = getRaw($get);
    if(isset($get) && count($get) > 0){
      $date = date('d-m-Y h:i A', strtotime($get[0]['created_at']));
    }else{
      $date = "";
    }

    return $date;

 }
 
 if(isset($_POST['filter'])){

    if(isset($_POST['lead_status_id']) && $_POST['lead_status_id'] != ""){
      $condition .= " AND lead_status = '".$_POST['lead_status_id']."' "; 
    }
    if(isset($_POST['property_type_id']) && $_POST['property_type_id'] != ""){
      $condition .= " AND property_type_id = '".$_POST['property_type_id']."' "; 
    }
    if(isset($_POST['lead_source_id']) && $_POST['lead_source_id'] != ""){
      $condition .= " AND lead_source_id = '".$_POST['lead_source_id']."' "; 
    }
    if(isset($_POST['property_category_id']) && $_POST['property_category_id'] != ""){
      $condition .= " AND property_category_id = '".$_POST['property_category_id']."' "; 
    }

    // if($login_type == "2"){
      
    //   $leads = "SELECT * FROM tbl_leads lead INNER JOIN tbl_employees emp ON lead.employee_id = emp.id INNER JOIN tbl_site_managers smt ON smt.id = emp.site_manager_id WHERE smt.id = '".$login_id."' AND lead.delete_status = '0' ".$condition." ORDER BY lead.id DESC";
    
    // }else{

      $leads = "SELECT * FROM tbl_leads WHERE employee_id = '".$login_id."' AND delete_status = '0' ".$condition." ORDER BY id DESC";

    // }


 }else{

    // if($login_type == "2"){

    //   $leads = "SELECT * FROM tbl_employees emp INNER JOIN tbl_leads lead ON lead.employee_id = emp.id INNER JOIN tbl_site_managers smt ON smt.id = emp.site_manager_id WHERE smt.id = '".$login_id."' AND lead.delete_status = '0' ORDER BY lead.id DESC";
    
    // }else{
      
      $leads = "SELECT * FROM tbl_leads WHERE employee_id = '".$login_id."' AND delete_status = '0' ORDER BY id DESC ";

    // }

 }

 $leads = getRaw($leads); 
 $leadCount = count($leads);


 // Pagination
 $records_per_page = 30;
 $pagination = new Zebra_Pagination();
 $pagination->records(count($leads));
 $pagination->records_per_page($records_per_page);
 // $pagination->reverse(true);

 $leads = array_slice(
      $leads,
      (($pagination->get_page() - 1) * $records_per_page),
      $records_per_page
  );



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
      
      <!-- Zebra Pagination -->
      <link rel="stylesheet" href="../../libraries/zebra_pagination/css/zebra_pagination.css" type="text/css">

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
                     <div id="accordion">
                       <div class="card">
                         <div class="card-header" id="headingOne">
                           <h5 class="mb-0">
                              <div class="row">
                                 <div class="col-md-4">
                                   <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                     FILTER
                                   </button>
                                 </div>
                                 <div class="col-md-8 text-right">
                                    <div class="btn-group mb-2">
                                       <div class="btn-group">
                                           <button type="button" class="btn dropdown-toggle waves-effect text-uppercase btn-secondary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> &nbsp;Sort By</button>
                                           <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
                                             <li class=""><a href="#" class="dropdown-item">Recent Leads</a></li>
                                             <li class=""><a href="#" class="dropdown-item">Recent Followup</a></li>
                                           </ul>
                                       </div>
                                   </div>
                                 </div>
                                    
                              </div>
                           </h5>
                         </div>

                         <form method="POST">

                         <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                           <div class="row">
                              <div class="card-body">
                                 <div class="col-md-3">

                                    <div class="form-group">

                                       <label for="lead_status_id">Lead Status</label>

                                       <select name="lead_status_id" parsley-trigger="change" placeholder="" class="form-control" id="lead_status_id" value="<?php if(isset($edit_data['lead_status_id'])){ echo $edit_data['lead_status_id']; } ?>">
                                        <option value="">--Select Status--</option>
                                        <?php if(isset($lead_statuses)){ ?>
                                            <?php foreach($lead_statuses as $rs){ ?>

                                              <option <?php if(isset($_POST['lead_status_id']) && $_POST['lead_status_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                            <?php } ?>
                                        <?php } ?>
                                       </select>

                                    </div>

                                 </div>
                                 <div class="col-md-3">

                                    <div class="form-group">

                                       <label for="property_type_id">Property Type</label>

                                       <select name="property_type_id" parsley-trigger="change" placeholder="" class="form-control" id="property_type_id" value="<?php if(isset($edit_data['property_type_id'])){ echo $edit_data['property_type_id']; } ?>">
                                        <?php if(isset($property_types)){ ?>
                                          <option value="">--Select Property Type--</option>
                                            <?php foreach($property_types as $rs){ ?>

                                              <option <?php if(isset($_POST['property_type_id']) && $_POST['property_type_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                            <?php } ?>
                                        <?php } ?>
                                       </select>

                                    </div>

                                 </div>
                                 <div class="col-md-3">

                                    <div class="form-group">

                                       <label for="lead_source_id">Lead Source</label>

                                       <select name="lead_source_id" parsley-trigger="change" placeholder="" class="form-control" id="lead_source_id" value="<?php if(isset($edit_data['lead_source_id'])){ echo $edit_data['lead_source_id']; } ?>">
                                        <option value="">--Select Source--</option>
                                        <?php if(isset($lead_sources)){ ?>
                                            <?php foreach($lead_sources as $rs){ ?>

                                              <option <?php if(isset($_POST['lead_source_id']) && $_POST['lead_source_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                            <?php } ?>
                                        <?php } ?>
                                       </select>

                                    </div>

                                 </div>

                                 <div class="col-md-3">

                                    <div class="form-group">

                                       <label for="property_category_id">Property Category</label>

                                       <select name="property_category_id" parsley-trigger="change" placeholder="" class="form-control" id="property_category_id" value="<?php if(isset($edit_data['property_category_id'])){ echo $edit_data['property_category_id']; } ?>">
                                        <option value="">--Select Property Category--</option>
                                        <?php if(isset($property_categories)){ ?>
                                            <?php foreach($property_categories as $rs){ ?>

                                              <option <?php if(isset($_POST['property_category_id']) && $_POST['property_category_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                            <?php } ?>
                                        <?php } ?>
                                       </select>

                                    </div>

                                 </div>

                                 <div class="col-md-12">
                                    <div class="col-md-9">
                                       <?php if( isset($leadCount) && $leadCount > 0){ ?>
                                        <div class="text-primary"><?php echo $leadCount." Lead(s) Found"; ?></div>
                                      <?php }else{ ?>
                                        <div class="text-danger">Opps ! No Leads Found !</div>
                                      <?php } ?>
                                    </div>
                                    <div class="col-md-3">
                                      <button class="btn btn-primary pull-right" type="submit" name="filter"><i class="fa fa-filter"></i> Filter</button>
                                      <a href="view_leads.php" class="btn btn-default pull-right mr-2" type="submit" name="filter"> Reset</a>
                                    </div>
                                 </div>


                              </div>
                           </div>
                         </div>
                           </form>
                       </div>
                    </div>
                        
                     </div>
                  </div>
                 
                  <div class="row">

                  <?php if(isset($leads) && count($leads) > 0){ ?>

                     <?php $i=1; foreach($leads as $rs){ 

                           $lead_status_values = getLeadStatus($rs['lead_status']);

                           ?>
                         
                           <div class="col-lg-4 mt-5" id="lead_row_<?php echo $rs['id']; ?>">
                                 <div class="card">
                                     <div class="card-header <?php echo $lead_status_values['status_class_light']; ?> pr-0 p-b-0">
                                         <h3 class="card-title text-white mb-0 text-uppercase">
                                          <div class="row">
                                             <div class="col-md-6" style="font-size: 20px;"><a href="lead_detail.php?lead_id=<?php echo $rs['id']; ?>" class="text-white"><?php echo $rs['name']; ?></a></div>
                                             <div class="col-md-6 text-right" style="font-size: 15px;">
                                                <div class="btn-group mb-2">
                                                   <div class="btn-group">
                                                       <button type="button" class="btn btn-sm  dropdown-toggle waves-effect text-uppercase <?php echo $lead_status_values['status_class']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color:<?php echo $lead_status_values['color_code']; ?>"> <?php echo $lead_status_values['lead_status']; ?> </button>
                                                       <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
                                                          <?php if(isset($lead_statuses)){ ?>
                                                           <?php foreach($lead_statuses as $val){ ?>
                                                             <li class="<?php if($val['name'] == $lead_status_values['lead_status']){ echo "active"; } ?>" ><a href="javascript:;" data-id="<?php echo $rs['id']; ?>" data-status-title="lead_status" data-status="<?php echo $val['id']; ?>" class="dropdown-item change-lead-status"><?php echo $val['name']; ?></a></li>

                                                           <?php } ?>
                                                       <?php } ?>
                                                       </ul>
                                                   </div>
                                               </div>
                                             </div>
                                          </div>
                                          </h3>
                                          <p class="text-dark"><strong>LAST FOLLOW UP : <?php echo getLastFollowUp($rs['id']); ?> </strong> </p>
                                     </div>
                                     <div class="card-body borderless p-b-0">
                                         <p class="mb-0">
                                             <ul class="list-group list-group-flush borderless no-border p-b-0">
                                               <li class="list-group-item no-padding" >Interested In - <?php echo getPropertyInterestedFor($rs['property_interested_for_id']); ?> </li>
                                               <li class="list-group-item no-padding">Property Type - <?php echo getPropertyType($rs['property_type_id']); ?></li>
                                               <li class="list-group-item no-padding no-border">Property Category - <?php echo getPropertyCategory($rs['property_category_id']); ?></li>
                                             </ul>
                                         </p>
                                     </div>
                                     <div class="card-footer">
                                         <div class="row">
                                            <div class="col-md-4">
                                               <a href="lead_detail.php?lead_id=<?php echo $rs['id']; ?>" target="_BLANK"><i class="fa fa-external-link <?php echo $lead_status_values['status_class']."-text"; ?>" aria-hidden="true"></i></a>
                                               <a href="javascript:;" class="remove-lead" data-delete-row="lead_row_" data-delete-table="tbl_leads" data-delete-id="id" data-delete-value="<?php echo $rs['id']; ?>" ><i class="fa fa-trash-o text-danger ml-2" aria-hidden="true"></i></a>
                                            </div>
                                            <div class="col-md-8 text-right text-bold">
                                               <?php echo date('d M, Y', strtotime($rs['created_at'])); ?>
                                            </div>
                                         </div>
                                     </div>
                                 </div>
                            </div>

                        <?php } ?>

                     <?php } ?>

                  
                  </div>

                  <hr>

                  <div class="row text-right">
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

      <!-- Zebra Pagination -->
      <link rel="stylesheet" href="../../libraries/zebra_pagination/javascript/zebra_pagination.js" type="text/css">

      <script>
          $('#property_type_id,#lead_source_id,#lead_status_id,#property_category_id').select2();
      </script>





   </body>
</html>
