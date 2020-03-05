<?php

   include('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $table_name = 'tbl_properties';
   $field_name = 'id';    

   // Fetching data from masters
   $property_types = getRaw("SELECT * FROM tbl_property_types_master ORDER by id ASC");

   if(isset($_POST['submit'])){

        // echo "<xmp>";
        // print_r($_POST);
        // exit;

        $form_data = array(
          'site_id' => $login_id, 
          'date' => $_POST['date'], 
          'property_type_id' => $_POST['property_type_id'],
          'tower' => $_POST['tower'], 
          'no_of_floors' => $_POST['no_of_floors'],
          'average_price_per_unit' => $_POST['average_price_per_unit'], 
          'average_super_built_up_area' => $_POST['average_super_built_up_area'], 
          'average_carpet_area' => $_POST['average_carpet_area']
        );

        if(insert('tbl_properties',$form_data)){
            
            $last_id = last_id('tbl_properties','id');

            $i=0;
            foreach($_POST['floor'] as $rs){

              $dataset['property_id'] = $last_id;
              $dataset['floor'] = $rs;
              $dataset['floor_type'] = $_POST['floor_property_type'][$i];
              for($j=$_POST['floor_house_range_start'][$i];$j<=$_POST['floor_house_range_end'][$i];$j++){
                  $dataset['house_number'] = $j; 
                  $data[] = $dataset;

                  if(insert('tbl_properties_floors',$dataset)){
                    $success = "Property added successfully";
                  }else{
                    $error = "Failed to add Property";
                  }
              }

              $i++;
            }       

      }else{
     
        $error = "Failed to add Property";
     
      }

    }

   if(isset($_GET['edit_id'])){

         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);         
         
         $edit_data = array(
            'date' => $edit_data['date'],
            'name' => $edit_data['name'],
            'mobile_number' => $edit_data['mobile_number'],
            'phone' => $edit_data['phone'],
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
            'interested_for' => $edit_data['interested_for'],
            'property_category_id' => $edit_data['property_category_id'],
            'possesion_status_id' => $edit_data['possesion_status_id'],
            'planning_within' => $edit_data['planning_within'],
            'property_source_id' => $edit_data['property_source_id'],
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
        'interested_for' => $_POST['interested_for'],
        'property_category_id' => $_POST['property_category_id'],
        'possesion_status_id' => $_POST['possesion_status_id'],
        'planning_within' => $_POST['planning_within'],
        'property_source_id' => $_POST['property_source_id'],
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

      if(update('tbl_properties',$field_name,$_GET['edit_id'],$form_data)){
        
        $success = "property Updated Successfully";
      
      }else{
      
        $error = "Failed to update property";
      
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

                  <div class="row">   

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">

                              <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                                 <div class="col-md-12">

                                    <div class="row">   
                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label>Date <span class="text-danger">*</span></label>

                                             <div class="input-group">

                                                <input type="date" required="" class="form-control" placeholder="mm/dd/yyyy" id="date" value="<?php if(isset($edit_data['date'])){ echo date('Y-m-d',strtotime($edit_data['date'])); }else{ echo date('Y-m-d'); } ?>" name="date" >

                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="property_type_id">Property Type<span class="text-danger">*</span></label>

                                             <select name="property_type_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="property_type_id" value="<?php if(isset($edit_data['property_type_id'])){ echo $edit_data['property_type_id']; } ?>">
                                              <option value="">--Select Type--</option>
                                              <?php if(isset($property_types)){ ?>
                                                  <?php foreach($property_types as $rs){ ?>

                                                    <option <?php if(isset($edit_data['property_type_id']) && $edit_data['property_type_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                    <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="tower">Tower<span class="text-danger">*</span></label>

                                             <input type="text" name="tower" parsley-trigger="change" required="" placeholder="" class="form-control" id="tower" value="<?php if(isset($edit_data['tower'])){ echo $edit_data['tower']; } ?>">

                                          </div>

                                       </div>    

                                      

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="average_price_per_unit">Average Price Per Unit<span class="text-danger">*</span></label>

                                             <input type="text" name="average_price_per_unit" parsley-trigger="change" required="" placeholder="" class="form-control" id="average_price_per_unit" value="<?php if(isset($edit_data['average_price_per_unit'])){ echo $edit_data['average_price_per_unit']; } ?>">

                                          </div>

                                       </div> 

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="average_super_built_up_area">Average Super Built-up Area<span class="text-danger">*</span></label>

                                             <input type="text" name="average_super_built_up_area" parsley-trigger="change" required="" placeholder="" class="form-control" id="average_super_built_up_area" value="<?php if(isset($edit_data['average_super_built_up_area'])){ echo $edit_data['average_super_built_up_area']; } ?>">

                                          </div>

                                       </div> 

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="average_carpet_area">Average Carpet Area<span class="text-danger">*</span></label>

                                             <input type="text" name="average_carpet_area" parsley-trigger="change" required="" placeholder="" class="form-control" id="average_carpet_area" value="<?php if(isset($edit_data['average_carpet_area'])){ echo $edit_data['average_carpet_area']; } ?>">

                                          </div>

                                       </div>    

                                            <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="no_of_floors">No. Of Floors<span class="text-danger">*</span></label>

                                             <select name="no_of_floors" id="no_of_floors" class="form-control">
                                               <option value="">Select Floors</option>
                                               <option value="1">1</option>
                                               <option value="2">2</option>
                                               <option value="3">3</option>
                                               <option value="4">4</option>
                                               <option value="5">5</option>
                                               <option value="6">6</option>
                                               <option value="7">7</option>
                                             </select>

                                        <!--      <input type="text" name="no_of_floors" parsley-trigger="change" required="" placeholder="" class="form-control" id="no_of_floors" value="<?php if(isset($edit_data['no_of_floors'])){ echo $edit_data['no_of_floors']; } ?>"> -->

                                          </div>

                                       </div>      




                                    </div>

                                    <div class="row">
                                      
                                      <table class="table table-striped table-condensed table-bordered">
                                        <thead>
                                          <tr>
                                            <td>Floor</td>
                                            <td>Property Type</td>
                                            <td>House Start Range</td>
                                            <td>House End Range</td>
                                          </tr>
                                        </thead>

                                          <tbody class="addRow">
                                            
                                          </tbody>
                                      </table>

                                    </div>

                                    <div class="row">
                                       

                                       <div class="col-md-12" align="right">

                                          <?php if(isset($edit_data)){ ?>                                             

                                            <button type="submit" name="update" id="update" class="btn btn-danger btn-bordered waves-effect w-md waves-light m-b-5">Update</button>

                                         <?php }else{ ?>

                                            <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>

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

        $('#property_type_id').on('change', function(){
          $('#no_of_floors').val("");
          $('.addRow').html("");
        });
        
        $('#no_of_floors').on('change', function(){

          var floor_names = {
            0 : "Ground Floor",
            1 : "First Floor",
            2 : "Second Floor",
            3 : "Third Floor",
            4 : "Fourth Floor",
            5 : "Fifth Floor",
            6 : "Sixth Floor",
            7 : "Seventh Floor"
          };

          var selected_property_type = $('#property_type_id').val();

          var property_types = <?php echo json_encode($property_types); ?>;

          var options = "";
          $.each(property_types, function(key,value){
            if(selected_property_type == '1'){
              options =  "<option value='1'>Residential</option>"; 
            }else if(selected_property_type == '2'){
              options =  "<option value='2'>Commercial</option>"; 
            }else if(selected_property_type == '3'){
              if(value.id != '3'){
                options +=  "<option value='"+value.id+"'>"+value.name+"</option>"; 
              }
            }
          });

          var floors = $(this).val();
          var html = "";
          $('.addRow').html(html);
          for(var i = 0; i <= floors; i++){
            html += ' <tr> <td> '+floor_names[i]+' <input type="hidden" value="'+i+'" name="floor[]"> </td> <td> <select class="form-control" name="floor_property_type[]">'+options+'</select> </td> <td>  <input type="text" name="floor_house_range_start[]" class="form-control"> </td> <td>  <input type="text" name="floor_house_range_end[]" class="form-control"> </td></tr>';
          }
          $('.addRow').append(html);

        });

      </script>


   </body>

</html>
