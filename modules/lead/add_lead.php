<?php

   include('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $table_name = 'tbl_leads';
   $field_name = 'id';    

   if(isset($_POST['submit'])){

    $next_id = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "'.DB.'" AND TABLE_NAME = "tbl_leads" ';
    $next_id = getRaw($next_id);
    $next_id = $next_id[0]['AUTO_INCREMENT'];
    $code = 'LD'.sprintf('%05d',($next_id));
    
    // POST DATA
    $form_data = array(
      'code' => $code,
      'date' => $_POST['date'],
      'name' => $_POST['name'],
      'mobile_number' => $_POST['mobile_number'],
      'phone' => $_POST['phone'],
      'email' => $_POST['email'],
      'occupation' => $_POST['occupation'],
      'company' => $_POST['company'],
      'street_address' => $_POST['street_address'],
      'city_id' => $_POST['city_id'],
      'state_id' => $_POST['state_id'],
      'country_id' => $_POST['country_id'],
      'property_type_id' => $_POST['property_type_id'],
      'purpose' => $_POST['purpose'],
      'budget_range_from' => $_POST['budget_range_from'],
      'budget_range_to' => $_POST['budget_range_to'],
      'property_interested_for_id' => $_POST['property_interested_for_id'],
      'property_category_id' => $_POST['property_category_id'],
      'possesion_status_id' => $_POST['possesion_status_id'],
      'planning_within' => $_POST['planning_within'],
      'lead_source_id' => $_POST['lead_source_id'],
      'lead_status' => $_POST['lead_status'],
      'remark' => $_POST['remark'],
      'employee_id' => $login_id
    );
    
    $upload_dir = '../../uploads/customer_recordings/';
    $extensions = array('jpg','jpeg','png');   
    
    $customer_recording_file = array();
    foreach ($_FILES['customer_recording_file']["error"] as $key => $error) {

        if ($error == UPLOAD_ERR_OK) {  

            $tmp_name = $_FILES['customer_recording_file']["tmp_name"][$key];
            $file_name = $_FILES['customer_recording_file']["name"][$key];
            $extension = explode('.',$file_name);
            $file_extension = end($extension);

            if(in_array($file_extension, $extension)){
                
                $new_file_name = md5(uniqid()).".".$file_extension;             
                $destination = $upload_dir.$new_file_name;
                if(move_uploaded_file($tmp_name, $destination)){
                    $customer_recording_file[] = $new_file_name;
                }
            }   

        }
    }

    if(count($customer_recording_file) > 0){
      $form_data['customer_recording_file'] = $customer_recording_file[0];
    }

    // echo "<xmp>";
    // print_r($form_data);
    // exit;

    if(insert('tbl_leads',$form_data)){
    
      $success = "New Lead Created Successfully";
    
    }else{
    
      $error = "Failed to add lead";
    
    }


   }



   if(isset($_GET['edit_id'])){

         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);         
         
         $edit_data = array(
            'date' => $edit_data['date'],
            'name' => $edit_data['name'],
            'mobile_number' => $edit_data['mobile_number'],
            'phone' => $edit_data['phone'],
            'email' => $edit_data['email'],
            'occupation' => $edit_data['occupation'],
            'company' => $edit_data['company'],
            'street_address' => $edit_data['street_address'],
            'city_id' => $edit_data['city_id'],
            'state_id' => $edit_data['state_id'],
            'country_id' => $edit_data['country_id'],
            'property_type_id' => $edit_data['property_type_id'],
            'purpose' => $edit_data['purpose'],
            'budget_range_from' => $edit_data['budget_range_from'],
            'budget_range_to' => $edit_data['budget_range_to'],
            'property_interested_for_id' => $edit_data['property_interested_for_id'],
            'property_category_id' => $edit_data['property_category_id'],
            'possesion_status_id' => $edit_data['possesion_status_id'],
            'planning_within' => $edit_data['planning_within'],
            'lead_source_id' => $edit_data['lead_source_id'],
            'lead_status' => $edit_data['lead_status'],
            'remark' => $edit_data['remark'],
            'customer_recording_file' => $edit_data['customer_recording_file'],
         );

         // echo "<xmp>";
         // print_r($edit_data);
         // exit;

   }



  if(isset($_POST['update'])){

      // POST DATA
      $form_data = array(
        'date' => $_POST['date'],
        'name' => $_POST['name'],
        'mobile_number' => $_POST['mobile_number'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'occupation' => $_POST['occupation'],
        'company' => $_POST['company'],
        'street_address' => $_POST['street_address'],
        'city_id' => $_POST['city_id'],
        'state_id' => $_POST['state_id'],
        'country_id' => $_POST['country_id'],
        'property_type_id' => $_POST['property_type_id'],
        'purpose' => $_POST['purpose'],
        'budget_range_from' => $_POST['budget_range_from'],
        'budget_range_to' => $_POST['budget_range_to'],
        'property_interested_for_id' => $_POST['property_interested_for_id'],
        'property_category_id' => $_POST['property_category_id'],
        'possesion_status_id' => $_POST['possesion_status_id'],
        'planning_within' => $_POST['planning_within'],
        'lead_source_id' => $_POST['lead_source_id'],
        'lead_status' => $_POST['lead_status'],
        'remark' => $_POST['remark']
     );
      
      $upload_dir = '../../uploads/customer_recordings/';
      $extensions = array('mp3','wav');   
      
      $customer_recording_file = array();

      foreach ($_FILES['customer_recording_file']["error"] as $key => $error) {

          if ($error == UPLOAD_ERR_OK) {  

              $tmp_name = $_FILES['customer_recording_file']["tmp_name"][$key];
              $file_name = $_FILES['customer_recording_file']["name"][$key];
              $extension = explode('.',$file_name);
              $file_extension = end($extension);
              
              if(in_array($file_extension, $extension)){
                  
                  $new_file_name = md5(uniqid()).".".$file_extension;             
                  $destination = $upload_dir.$new_file_name;
                  if(move_uploaded_file($tmp_name, $destination)){
                      $customer_recording_file[] = $new_file_name;
                  }
              }   

          }
      }

      if(count($customer_recording_file) > 0){
        $form_data['customer_recording_file'] = $customer_recording_file[0];
      }

      if(update('tbl_leads',$field_name,$_GET['edit_id'],$form_data)){
        
        $success = "lead Updated Successfully";
      
      }else{
      
        $error = "Failed to update lead";
      
      }

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

         <div class="content-page">

            <!-- Start content -->

            <div class="content">

               <div class="container">

                   <div class="row">

                     <div class="col-md-6">

                        <div class="page-title-box">

                           <h4 class="page-title">Create New Lead</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div>

                  <div class="row">                       

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">

                              <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                                 <div class="col-md-12">

                                    <div class="row">   
                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label>Date <span class="text-danger">*</span></label>

                                             <div class="input-group">

                                                <input type="date" required="" class="form-control" placeholder="mm/dd/yyyy" id="date" value="<?php if(isset($edit_data['date'])){ echo date('Y-m-d',strtotime($edit_data['date'])); }else{ echo date('Y-m-d'); } ?>" name="date" tabindex="1" >

                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="lead_status">Lead Status<span class="text-danger">*</span></label>

                                             <select name="lead_status" required="" parsley-trigger="change" placeholder="" class="form-control" id="lead_status" value="<?php if(isset($edit_data['lead_status'])){ echo $edit_data['lead_status']; } ?>">
                                              <option value="">--Select Status--</option>
                                              <?php if(isset($lead_statuses)){ ?>
                                                  <?php foreach($lead_statuses as $rs){ ?>

                                                    <option <?php if(isset($edit_data['lead_status']) && $edit_data['lead_status'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                    <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="name">Name<span class="text-danger">*</span></label>

                                             <input type="text" name="name" parsley-trigger="change" required="" placeholder="" class="form-control" id="name" value="<?php if(isset($edit_data['name'])){ echo $edit_data['name']; } ?>">

                                          </div>

                                       </div>         



                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="mobile_number">Mobile<span class="text-danger">*</span></label>

                                             <input type="number" name="mobile_number" maxlength="10" parsley-trigger="change" required="" placeholder="" class="form-control validate-if-already-exists" data-table-name="tbl_leads" id="mobile_number" data-title="Mobile Number" value="<?php if(isset($edit_data['mobile_number'])){ echo $edit_data['mobile_number']; } ?>"> 
                                             <div id="mobile_number_msg"></div>

                                          </div>

                                       </div>


                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="phone">Phone</label>

                                             <input type="text" name="phone" parsley-trigger="change"  placeholder="" class="form-control validate-if-already-exists" data-table-name="tbl_leads" data-title="Phone Number" id="phone" value="<?php if(isset($edit_data['phone'])){ echo $edit_data['phone']; } ?>">
                                              <div id="phone_msg"></div>

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="email">Email</label>

                                             <input type="email" name="email" parsley-trigger="change"  placeholder="" class="form-control validate-if-already-exists" data-table-name="tbl_leads" data-title="Email" id="email" value="<?php if(isset($edit_data['email'])){ echo $edit_data['email']; } ?>">
                                              <div id="email_msg"></div>

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="occupation">Occupation</label>

                                             <input type="text" name="occupation" parsley-trigger="change" placeholder="" class="form-control" id="occupation" value="<?php if(isset($edit_data['occupation'])){ echo $edit_data['occupation']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="company">Company</label>

                                             <input type="text" name="company" parsley-trigger="change" placeholder="" class="form-control" id="company" value="<?php if(isset($edit_data['company'])){ echo $edit_data['company']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for=" ">Address</label>

                                             <input type="text" name="street_address" parsley-trigger="change" placeholder="" class="form-control" id="street_address" value="<?php if(isset($edit_data['street_address'])){ echo $edit_data['street_address']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="city_id">City<span class="text-danger">*</span></label>

                                             <select name="city_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="city_id" value="<?php if(isset($edit_data['city_id'])){ echo $edit_data['city_id']; } ?>">
                                              <option value="">--Select City--</option>
                                              <?php if(isset($cities)){ ?>
                                                  <?php foreach($cities as $rs){ ?>

                                                    <option <?php if(isset($edit_data['city_id']) && $edit_data['city_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                       <!-- <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="state_id">State<span class="text-danger">*</span></label>

                                             <select name="state_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="state_id" value="<?php if(isset($edit_data['state_id'])){ echo $edit_data['state_id']; } ?>">
                                              <option value="">--Select State--</option>
                                              <?php if(isset($states)){ ?>
                                                  <?php foreach($states as $rs){ ?>

                                                    <option <?php if(isset($edit_data['state_id']) && $edit_data['state_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div> -->

                                      <!-- <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="country_id">Country<span class="text-danger">*</span></label>

                                             <select name="country_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="country_id" value="<?php if(isset($edit_data['country_id'])){ echo $edit_data['country_id']; } ?>">
                                              <?php if(isset($countries)){ ?>
                                                  <?php foreach($countries as $rs){ ?>

                                                    <option <?php if(isset($edit_data['country_id']) && $edit_data['country_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div> -->

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="property_type_id">Property Type<span class="text-danger">*</span></label>

                                             <select name="property_type_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="property_type_id" value="<?php if(isset($edit_data['property_type_id'])){ echo $edit_data['property_type_id']; } ?>">
                                              <?php if(isset($property_types)){ ?>
                                                <option value="">--Select Property Type--</option>
                                                  <?php foreach($property_types as $rs){ ?>

                                                    <option <?php if(isset($edit_data['property_type_id']) && $edit_data['property_type_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="purpose">Purpose</label>

                                             <input type="text" name="purpose" parsley-trigger="change" placeholder="" class="form-control" id="purpose" value="<?php if(isset($edit_data['purpose'])){ echo $edit_data['purpose']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="budget_range_from">Budget Range From<span class="text-danger">*</span></label>

                                             <input type="number" required="" min="1" name="budget_range_from" parsley-trigger="change" placeholder="" class="form-control" id="budget_range_from" value="<?php if(isset($edit_data['budget_range_from'])){ echo $edit_data['budget_range_from']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="budget_range_to">Budget Range To<span class="text-danger">*</span></label>

                                             <input type="number" required="" min="0" name="budget_range_to" parsley-trigger="change" placeholder="" class="form-control" id="budget_range_to" value="<?php if(isset($edit_data['budget_range_to'])){ echo $edit_data['budget_range_to']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="property_interested_for_id">Interested For<span class="text-danger">*</span></label>

                                             <select name="property_interested_for_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="property_interested_for_id" value="<?php if(isset($edit_data['property_interested_for_id'])){ echo $edit_data['property_interested_for_id']; } ?>">
                                              <?php if(isset($property_interested_for)){ ?>
                                                <option value="">--Select Interested For --</option>
                                                  <?php foreach($property_interested_for as $rs){ ?>

                                                    <option <?php if(isset($edit_data['property_interested_for_id']) && $edit_data['property_interested_for_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                        <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="property_category_id">Property Category<span class="text-danger">*</span></label>

                                             <select name="property_category_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="property_category_id" value="<?php if(isset($edit_data['property_category_id'])){ echo $edit_data['property_category_id']; } ?>">
                                              <option value="">--Select Property Category--</option>
                                              <?php if(isset($property_categories)){ ?>
                                                  <?php foreach($property_categories as $rs){ ?>

                                                    <option <?php if(isset($edit_data['property_category_id']) && $edit_data['property_category_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="possesion_status_id">Possesion Status<span class="text-danger">*</span></label>

                                             <select name="possesion_status_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="possesion_status_id" value="<?php if(isset($edit_data['possesion_status_id'])){ echo $edit_data['possesion_status_id']; } ?>">
                                              <option value="">--Select Possesion Status--</option>
                                              <?php if(isset($possesion_statuses)){ ?>
                                                  <?php foreach($possesion_statuses as $rs){ ?>

                                                    <option <?php if(isset($edit_data['possesion_status_id']) && $edit_data['possesion_status_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="planning_within">Planning Within</label>

                                             <input type="text" name="planning_within" parsley-trigger="change" placeholder="" class="form-control" id="planning_within" value="<?php if(isset($edit_data['planning_within'])){ echo $edit_data['planning_within']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label class="control-label">Upload Customer Recording <?php if(isset($edit_data['customer_recording_file'])){ ?> <a href="<?php echo '../../uploads/customer_recordings/'.$edit_data['customer_recording_file']; ?>">View</a> <?php } ?> </label>

                                             <input type="file" class="filestyle" data-buttonname="btn-default" name="customer_recording_file[]" id="customer_recording_file">

                                          </div>

                                       </div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="lead_source_id">Lead Source<span class="text-danger">*</span></label>

                                             <select name="lead_source_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="lead_source_id" value="<?php if(isset($edit_data['lead_source_id'])){ echo $edit_data['lead_source_id']; } ?>">
                                              <option value="">--Select Source--</option>
                                              <?php if(isset($lead_sources)){ ?>
                                                  <?php foreach($lead_sources as $rs){ ?>

                                                    <option <?php if(isset($edit_data['lead_source_id']) && $edit_data['lead_source_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                       <div class="clearfix"></div>

                                       <div class="col-md-3">

                                          <div class="form-group">

                                             <label for="remark">Remark</label>

                                             <textarea name="remark" parsley-trigger="change" placeholder="" class="form-control" id="remark"><?php if(isset($edit_data['remark'])){ echo $edit_data['remark']; } ?></textarea>

                                          </div>

                                       </div>

                                    </div>

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

                                       

                                       <div class="col-md-12" align="right">

                                          <?php if(isset($edit_data)){ ?>                                             

                                            <button type="submit" name="update" id="save_lead" class="btn btn-danger btn-bordered waves-effect w-md waves-light m-b-5">Update</button>

                                         <?php }else{ ?>

                                            <button type="submit" name="submit" id="save_lead" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>

                                         <?php } ?>

                                       </div>

                                    </div>

                                 </div>

                              </form>

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

          $('#date').focus();
          
      </script>


   </body>

</html>
