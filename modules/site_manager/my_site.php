<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];
   $states = getAll('tbl_state');

   $possesion_statuses = getAll('tbl_possesion_statuses_master');
   $sample_house_options = getAll('tbl_sample_house_options_master');
   $amenities = getAll('tbl_amenity_master_detail');
   $possesion_years = getAll('tbl_possesion_year_master');
   $possesion_months = getAll('tbl_possesion_month_master');

   $check = getOne('tbl_site_details','site_id',$login_id);

   if(isset($_POST['submit'])){

      $form_data = array(  
         'site_id' => $login_id,
         'possesion_status_id' => $_POST['possesion_status_id'],
         'sample_house_option_id' => $_POST['sample_house_option_id'],
         'amenity_id' => implode(",", $_POST['amenity_id']),
         'water_supply' => $_POST['water_supply'],
         'power_backup' => $_POST['power_backup'],
         'balcony_flooring' => $_POST['balcony_flooring'],
         'kitchen_flooring' => $_POST['kitchen_flooring'],
         'bathroom_flooring' => $_POST['bathroom_flooring'],
         'bedroom_flooring' => $_POST['bedroom_flooring'],
         'livingroom_flooring' => $_POST['livingroom_flooring'],
         'terrace_flooring' => $_POST['terrace_flooring'],
         'master_bedroom_flooring' => $_POST['master_bedroom_flooring'],
         'doors_fitting' => $_POST['doors_fitting'],
         'windows_fitting' => $_POST['windows_fitting'],
         'electrical_fitting' => $_POST['electrical_fitting'],
         'kitchen_platform_fitting' => $_POST['kitchen_platform_fitting'],
         'bathroom_fitting' => $_POST['bathroom_fitting'],
         'toilet_fitting' => $_POST['toilet_fitting'],
         'sink_fitting' => $_POST['sink_fitting'],
         'exterior_walls' => $_POST['exterior_walls'],
         'interior_walls' => $_POST['interior_walls'],
         'kitchen_walls' => $_POST['kitchen_walls'],
         'toilet_walls' => $_POST['toilet_walls'],
         'balcony_walls' => $_POST['balcony_walls']
      );

      if(isset($_POST['possesion_status_id']) && $_POST['possesion_status_id'] == '2'){
            $form_data['possesion_year'] = $_POST['possesion_year'];
            $form_data['possesion_month'] = $_POST['possesion_month'];
      }

      $upload_dir = '../../uploads/brochures/';
      $extensions = array('jpg','jpeg','png');   
      
      $brochure_file = array();
      foreach ($_FILES['brochure_file']["error"] as $key => $error) {

          if ($error == UPLOAD_ERR_OK) {  

              $tmp_name = $_FILES['brochure_file']["tmp_name"][$key];
              $file_name = $_FILES['brochure_file']["name"][$key];
              $extension = explode('.',$file_name);
              $file_extension = end($extension);

              if(in_array($file_extension, $extension)){
                  
                  $new_file_name = md5(uniqid()).".".$file_extension;             
                  $destination = $upload_dir.$new_file_name;
                  if(move_uploaded_file($tmp_name, $destination)){
                     $brochure_file[] = $new_file_name;
                  }
              }   

          }
      }

      if(count($brochure_file) > 0){
          $form_data['brochure_file'] = $brochure_file[0]; 
      }
      
      if(isset($check) && count($check) > 0){
         
         if(update('tbl_site_details','site_id',$login_id,$form_data)){

            $success = "Details Updated Successfully";
         
         }else{
         
            $error = "Failed to Update Details";

         }

      }else{
         
         if(insert('tbl_site_details',$form_data)){
            
            $success = "Details Updated Successfully";
         
         }else{
         
            $error = "Failed to Update Details";

         }

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
                   <!-- <div class="row">
                     <div class="col-md-6">
                        <div class="page-title-box">
                           <h4 class="page-title">My Site Details</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                   
                  </div> -->
                  <div class="row">   
                     
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">
                               <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                 <div class="col-md-12">
                                    <div class="row">

                                       <div class="col-md-4" >
                                          <div class="form-group">
                                             <label for="possesion_status_id">Possesion Status<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="possesion_status_id" id="possesion_status_id" required="">
                                             <option value="">--Choose Possesion Status--</option>
                                              <?php if(isset($possesion_statuses) && count($possesion_statuses) > 0){ ?>
                                                <?php foreach($possesion_statuses as $rs){ ?>
                                                
                                                  <option <?php if($check['possesion_status_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>

                                                <?php } ?>
                                              <?php } ?>
                                             </select>
                                          </div>
                                       </div>



                                       <div class="col-md-4 possesion_year_block" 
                                       <?php 
                                          if(isset($check['possesion_status_id']) && $check['possesion_status_id'] == '2'){ 
                                             echo "style='display:block;'"; 
                                          }else{ 
                                             echo "style='display:none;'";
                                          } 
                                       ?> >
                                          <div class="form-group">
                                             <label for="possesion_year">Possesion Year<span class="text-danger">*</span></label>
                                            <select class="form-control select2 " name="possesion_year" id="possesion_year">
                                             <option value="">--Choose Year--</option>
                                              <?php if(isset($possesion_years) && count($possesion_years) > 0){ ?>
                                                <?php foreach($possesion_years as $rs){ ?>
                                                
                                                  <option <?php if($check['possesion_year'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>

                                                <?php } ?>
                                              <?php } ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-md-4 possesion_month_block" 
                                       <?php 
                                          if(isset($check['possesion_status_id']) && $check['possesion_status_id'] == '2'){ 
                                             echo "style='display:block;'"; 
                                          }else{ 
                                             echo "style='display:none;'";
                                          } 
                                       ?> >
                                          <div class="form-group">
                                             <label for="possesion_month">Possesion Month<span class="text-danger">*</span></label>
                                            <select class="form-control select2 " name="possesion_month" id="possesion_month">
                                             <option value="">--Choose Month--</option>
                                              <?php if(isset($possesion_months) && count($possesion_months) > 0){ ?>
                                                <?php foreach($possesion_months as $rs){ ?>
                                                
                                                  <option <?php if($check['possesion_month'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>

                                                <?php } ?>
                                              <?php } ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="sample_house_option_id">Sample House Option<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="sample_house_option_id" id="sample_house_option_id" required="">
                                             <option value="">--Choose Sample House Option--</option>
                                              <?php if(isset($sample_house_options) && count($sample_house_options) > 0){ ?>
                                                <?php foreach($sample_house_options as $rs){ ?>
                                                
                                                  <option <?php if($check['sample_house_option_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>

                                                <?php } ?>
                                              <?php } ?>
                                             </select>
                                          </div>
                                       </div>

                                      <div class="col-md-4">

                                          <div class="form-group">

                                             <label class="control-label">Upload Brochure <?php if(isset($check['brochure_file'])){ ?> <a href="<?php echo '../../uploads/brochures/'.$check['brochure_file']; ?>">View</a> <?php } ?> </label>

                                             <input type="file" class="filestyle" data-buttonname="btn-default" name="brochure_file[]" id="brochure_file" >

                                          </div>

                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="amenity_id">Select Amenity<span class="text-danger">*</span></label>
                                            <select class="form-control select2 js-example-basic-multiple" name="amenity_id[]" id="amenity_id" multiple="" required="">
                                             <option value="">--Choose Amenity--</option>
                                              <?php if(isset($amenities) && count($amenities) > 0){ ?>
                                                <?php foreach($amenities as $rs){ ?>
                                                
                                                  <option <?php if(in_array($rs['id'],explode(",",$check['amenity_id']))){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>

                                                <?php } ?>
                                              <?php } ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="clearfix"></div>



                                       <div class="col-md-4 p-t-30">
                                         
                                          <div class="radio-control">

                                             <label for="">Water Supply <span class="text-danger">*</span></label><br>
                                        
                                             <input required="" type="radio" name="water_supply" id="water_supply_yes" <?php if(isset($check['water_supply']) && $check['water_supply'] == '1'){ echo "checked"; } ?> value="1"> <label for="water_supply_yes">Yes, Available</label>
                                             <input required="" type="radio" name="water_supply" id="water_supply_no" <?php if(isset($check['water_supply']) && $check['water_supply'] == '0'){ echo "checked"; } ?> value="0"> <label for="water_supply_no">Not Available</label>
                                       
                                          </div>
                                       
                                       </div>

                                       <div class="col-md-4 p-t-30">
                                         
                                          <div class="radio-control">

                                             <label for="">Power Backup <span class="text-danger">*</span></label><br>
                                        
                                             <input required="" type="radio" name="power_backup" id="power_backup_yes" <?php if(isset($check['power_backup']) && $check['power_backup'] == '1'){ echo "checked"; } ?> value="1"> <label for="power_backup_yes">Yes, Available</label>
                                             <input required="" type="radio" name="power_backup" id="power_backup_no" <?php if(isset($check['power_backup']) && $check['power_backup'] == '0'){ echo "checked"; } ?> value="0"> <label for="power_backup_no">Not Available</label>
                                       
                                          </div>
                                       
                                       </div>

                                       <div class="clearfix"></div>

                                       <div class="col-md-12">
                                          <h4>Flooring Details : </h4>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="balcony_flooring">Balcony Flooring</label>
                                             <input type="text" name="balcony_flooring" parsley-trigger="change" placeholder="" class="form-control" id="balcony_flooring" value="<?php if(isset($check['balcony_flooring'])){ echo $check['balcony_flooring']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="kitchen_flooring">Kitchen Flooring</label>
                                             <input type="text" name="kitchen_flooring" parsley-trigger="change" placeholder="" class="form-control" id="kitchen_flooring" value="<?php if(isset($check['kitchen_flooring'])){ echo $check['kitchen_flooring']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="bathroom_flooring">Bathroom Flooring</label>
                                             <input type="text" name="bathroom_flooring" parsley-trigger="change" placeholder="" class="form-control" id="bathroom_flooring" value="<?php if(isset($check['bathroom_flooring'])){ echo $check['bathroom_flooring']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="bedroom_flooring">Bedroom Flooring</label>
                                             <input type="text" name="bedroom_flooring" parsley-trigger="change" placeholder="" class="form-control" id="bedroom_flooring" value="<?php if(isset($check['bedroom_flooring'])){ echo $check['bedroom_flooring']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="livingroom_flooring">Living Room Flooring</label>
                                             <input type="text" name="livingroom_flooring" parsley-trigger="change" placeholder="" class="form-control" id="livingroom_flooring" value="<?php if(isset($check['livingroom_flooring'])){ echo $check['livingroom_flooring']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="terrace_flooring">Terrace Flooring</label>
                                             <input type="text" name="terrace_flooring" parsley-trigger="change" placeholder="" class="form-control" id="terrace_flooring" value="<?php if(isset($check['terrace_flooring'])){ echo $check['terrace_flooring']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="master_bedroom_flooring">Master Bedroom Flooring</label>
                                             <input type="text" name="master_bedroom_flooring" parsley-trigger="change" placeholder="" class="form-control" id="master_bedroom_flooring" value="<?php if(isset($check['master_bedroom_flooring'])){ echo $check['master_bedroom_flooring']; } ?>">
                                          </div>
                                       </div>
                                       
                                       <div class="col-md-12">
                                          <h4>Doors Fitting : </h4>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="doors_fitting">Doors Fitting</label>
                                             <input type="text" name="doors_fitting" parsley-trigger="change" placeholder="" class="form-control" id="doors_fitting" value="<?php if(isset($check['doors_fitting'])){ echo $check['doors_fitting']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="windows_fitting">Windows Fitting</label>
                                             <input type="text" name="windows_fitting" parsley-trigger="change" placeholder="" class="form-control" id="windows_fitting" value="<?php if(isset($check['windows_fitting'])){ echo $check['windows_fitting']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="electrical_fitting">Electrical Fitting</label>
                                             <input type="text" name="electrical_fitting" parsley-trigger="change" placeholder="" class="form-control" id="electrical_fitting" value="<?php if(isset($check['electrical_fitting'])){ echo $check['electrical_fitting']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="kitchen_platform_fitting">Kitchen Platform Fitting</label>
                                             <input type="text" name="kitchen_platform_fitting" parsley-trigger="change" placeholder="" class="form-control" id="kitchen_platform_fitting" value="<?php if(isset($check['kitchen_platform_fitting'])){ echo $check['kitchen_platform_fitting']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="bathroom_fitting">Bathroom Fitting</label>
                                             <input type="text" name="bathroom_fitting" parsley-trigger="change" placeholder="" class="form-control" id="bathroom_fitting" value="<?php if(isset($check['bathroom_fitting'])){ echo $check['bathroom_fitting']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="toilet_fitting">Toilet Fitting</label>
                                             <input type="text" name="toilet_fitting" parsley-trigger="change" placeholder="" class="form-control" id="toilet_fitting" value="<?php if(isset($check['toilet_fitting'])){ echo $check['toilet_fitting']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="sink_fitting">Sink Fitting</label>
                                             <input type="text" name="sink_fitting" parsley-trigger="change" placeholder="" class="form-control" id="sink_fitting" value="<?php if(isset($check['sink_fitting'])){ echo $check['sink_fitting']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-12">
                                          <h4>Walls : </h4>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="exterior_walls">Exterior Walls</label>
                                             <input type="text" name="exterior_walls" parsley-trigger="change" placeholder="" class="form-control" id="exterior_walls" value="<?php if(isset($check['exterior_walls'])){ echo $check['exterior_walls']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="interior_walls">Interior Walls</label>
                                             <input type="text" name="interior_walls" parsley-trigger="change" placeholder="" class="form-control" id="interior_walls" value="<?php if(isset($check['interior_walls'])){ echo $check['interior_walls']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="kitchen_walls">Kitchen Walls</label>
                                             <input type="text" name="kitchen_walls" parsley-trigger="change" placeholder="" class="form-control" id="kitchen_walls" value="<?php if(isset($check['kitchen_walls'])){ echo $check['kitchen_walls']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="toilet_walls">Toilet Walls</label>
                                             <input type="text" name="toilet_walls" parsley-trigger="change" placeholder="" class="form-control" id="toilet_walls" value="<?php if(isset($check['toilet_walls'])){ echo $check['toilet_walls']; } ?>">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <label for="balcony_walls">Balcony Walls</label>
                                             <input type="text" name="balcony_walls" parsley-trigger="change" placeholder="" class="form-control" id="balcony_walls" value="<?php if(isset($check['balcony_walls'])){ echo $check['balcony_walls']; } ?>">
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
                                          <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Update</button>
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

      <script>
         
         $('#possesion_status_id').on('change', function(){
            
            var possesion_status_id = $(this).val();
            
            if(possesion_status_id == '1'){
               $('.possesion_year_block,.possesion_month_block').hide();
               // alert(0);
            }else if(possesion_status_id == '2'){
               $('.possesion_year_block,.possesion_month_block').show();
               // alert(1);
            }

         });

         $('#owner_state_id').on('change', function(){

               var state_id = $(this).val();

               $.ajax({

                  url : 'ajax/get_city.php',
                  type : 'POST',
                  dataType : 'json',
                  data : { state_id : state_id },
                  success : function(html){

                     $('#owner_city_id').html(html);

                  }

               });

         });

          $('.js-example-basic-multiple').select2();


 
      </script>

   </body>
</html>