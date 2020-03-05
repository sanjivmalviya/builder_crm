<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $table_name = 'tbl_site_managers';
   $field_name = 'id';    

   $designations = 'SELECT * FROM tbl_designation_master ORDER BY name ASC';
   $designations = getRaw($designations);

   $cities = 'SELECT * FROM tbl_cities_master ORDER BY name ASC';
   $cities = getRaw($cities);


   if(isset($_POST['submit'])){

    $next_id = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "'.DB.'" AND TABLE_NAME = "tbl_site_managers" ';
    $next_id = getRaw($next_id);
    $next_id = $next_id[0]['AUTO_INCREMENT'];
    $code = 'STM'.sprintf('%05d',($next_id));

    $upload_dir = '../../uploads/profile_pic/';
    $extensions = array('jpg','jpeg','png');   
    
    $profile_pic = array();
    foreach ($_FILES['profile_pic']["error"] as $key => $error) {

        if ($error == UPLOAD_ERR_OK) {  

            $tmp_name = $_FILES['profile_pic']["tmp_name"][$key];
            $file_name = $_FILES['profile_pic']["name"][$key];
            $extension = explode('.',$file_name);
            $file_extension = end($extension);

            if(in_array($file_extension, $extension)){
                
                $new_file_name = md5(uniqid()).".".$file_extension;             
                $destination = $upload_dir.$new_file_name;
                if(move_uploaded_file($tmp_name, $destination)){
                    $profile_pic[] = $new_file_name;
                }
            }   

        }
    }

    if(count($profile_pic) > 0){
        $profile_pic = $profile_pic[0];
    }else{
        $profile_pic = "";
    }

    $form_data = array(
        'code' => $code,
        'site_name' =>  $_POST['site_name'],
        'site_person_name' =>  $_POST['site_person_name'],
        'contact' =>  $_POST['contact'],
        'username' =>  $_POST['username'],
        'password' =>  $_POST['password'],
        'profile_pic' =>  $profile_pic,
        'city' =>  $_POST['city'],
        'designation' =>  $_POST['designation'],
        'remark' =>  $_POST['remark']
     );

    if(insert('tbl_site_managers',$form_data)){
    
      $success = "Site Manager Added Successfully";
    
    }else{
    
      $error = "Failed to add Site Manager";
    
    }

   }



   if(isset($_GET['edit_id'])){

         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);         

         $edit_data = array(
            'code' => $edit_data['code'],
            'site_name' =>  $edit_data['site_name'],
            'site_person_name' =>  $edit_data['site_person_name'],
            'contact' =>  $edit_data['contact'],
            'username' =>  $edit_data['username'],
            'password' =>  $edit_data['password'],
            'profile_pic' =>  $edit_data['profile_pic'],
            'remark' =>  $edit_data['remark'],
            'city' =>  $edit_data['city'],
            'designation' =>  $edit_data['designation'],
         );

   }

   if(isset($_POST['update'])){

    $upload_dir = '../../uploads/profile_pic/';
    $extensions = array('jpg','jpeg','png');   
    
    $profile_pic = array();
    foreach ($_FILES['profile_pic']["error"] as $key => $error) {

        if ($error == UPLOAD_ERR_OK) {  

            $tmp_name = $_FILES['profile_pic']["tmp_name"][$key];
            $file_name = $_FILES['profile_pic']["name"][$key];
            $extension = explode('.',$file_name);
            $file_extension = end($extension);

            if(in_array($file_extension, $extension)){
                
                $new_file_name = md5(uniqid()).".".$file_extension;             
                $destination = $upload_dir.$new_file_name;
                if(move_uploaded_file($tmp_name, $destination)){
                    $profile_pic[] = $new_file_name;
                }
            }   

        }
    }

    if(count($profile_pic) > 0){
        $profile_pic = $profile_pic[0];
    }else{
        $profile_pic = "";
    }


    $form_data = array(
        'site_name' =>  $_POST['site_name'],
        'site_person_name' =>  $_POST['site_person_name'],
        'contact' =>  $_POST['contact'],
        'username' =>  $_POST['username'],
        'city' =>  $_POST['city'],
        'designation' =>  $_POST['designation'],
        'remark' =>  $_POST['remark']
    );

    if(isset($profile_pic) && $profile_pic != ''){
      $form_data['profile_pic'] = $profile_pic;
    }
    if(isset($_POST['password']) && $_POST['password'] != ''){
      $form_data['password'] = $_POST['password'];
    }

    if(update('tbl_site_managers',$field_name,$_GET['edit_id'],$form_data)){
    
      $success = "Site Manager Updated Successfully";
    
    }else{
    
      $error = "Failed to updated Site Manager";
    
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

                           <h4 class="page-title">Add Site Manager</h4>

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

                                       <div class="col-md-12">
                                        <h5>Site Manager Details : </h5>
                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="site_name">Site Name<span class="text-danger">*</span></label>

                                             <input type="text" name="site_name" parsley-trigger="change" required="" placeholder="" class="form-control" id="site_name" value="<?php if(isset($edit_data['site_name'])){ echo $edit_data['site_name']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="site_person_name">Site Person Name<span class="text-danger">*</span></label>

                                             <input type="text" name="site_person_name" parsley-trigger="change" required="" placeholder="" class="form-control" id="site_person_name" value="<?php if(isset($edit_data['site_person_name'])){ echo $edit_data['site_person_name']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="contact">Contact<span class="text-danger">*</span></label>

                                             <input type="number" maxlength="10" minlength="10" name="contact" required="" parsley-trigger="change" placeholder="" class="form-control" id="contact" value="<?php if(isset($edit_data['contact'])){ echo $edit_data['contact']; } ?>">

                                          </div>

                                       </div>


                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="username">Username<span class="text-danger">*</span></label>

                                             <input required="" type="text" name="username" parsley-trigger="change" placeholder="" class="form-control" id="username" value="<?php if(isset($edit_data['username'])){ echo $edit_data['username']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="password">Password<span class="text-danger">*</span></label>

                                             <input required="" type="password" name="password" parsley-trigger="change" placeholder="" class="form-control" id="password" value="<?php if(isset($edit_data['password'])){ echo $edit_data['password']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="designation">Designation<span class="text-danger">*</span></label>

                                             <select required="" name="designation" class="form-control" id="designation">
                                              <option value="">Select Designation</option>
                                              <?php if(isset($designations)){ ?>
                                                <?php foreach($designations as $rs){ ?>
                                                  <option <?php if($edit_data['designation'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>
                                                <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="city">City<span class="text-danger">*</span></label>

                                             <select required="" name="city" class="form-control" id="city">
                                              <option value="">Select city</option>
                                              <?php if(isset($cities)){ ?>
                                                <?php foreach($cities as $rs){ ?>
                                                  <option <?php if($edit_data['city'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>
                                                <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>



                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label class="control-label">Profile Pic <?php if(isset($edit_data['profile_pic'])){ ?> <a href="<?php echo '../../uploads/profile_pic/'.$edit_data['profile_pic']; ?>">View</a> <?php } ?> </label>

                                             <input type="file" class="filestyle" data-buttonname="btn-default" name="profile_pic[]" id="profile_pic" >

                                          </div>

                                       </div>


                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="remark">Remark</label>

                                             <textarea name="remark" parsley-trigger="change" placeholder="" class="form-control" id="remark" value="<?php if(isset($edit_data['remark'])){ echo $edit_data['remark']; } ?>"><?php if(isset($edit_data['remark'])){ echo $edit_data['remark']; } ?></textarea>

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



      <script>

         

         $('.generatePassword').on('click', function(){



            var password = randomPassword();

            $('#employee_password').val(password);



         });



      </script>



   </body>

</html>
