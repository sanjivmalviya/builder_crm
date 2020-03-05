<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $table_name = 'tbl_employees';
   $field_name = 'id';    

   $designations = getAll('tbl_designation_master');
   $departments = getAll('tbl_department_master');

   if(isset($_POST['submit'])){

    $next_id = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "'.DB.'" AND TABLE_NAME = "tbl_employees" ';
    $next_id = getRaw($next_id);
    $next_id = $next_id[0]['AUTO_INCREMENT'];
    $code = 'EMP'.sprintf('%05d',($next_id));
    
    // POST DATA
    $name = $_POST['name'];
    $mobile_number = $_POST['mobile_number'];
    $designation_id = $_POST['designation_id'];
    $department_id = $_POST['department_id'];
    $doj = $_POST['doj'];
    $dob = $_POST['dob'];
    $pan_number = $_POST['pan_number'];
    $aadhaar_number = $_POST['aadhaar_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nominee_name = $_POST['nominee_name'];
    $nominee_relation = $_POST['nominee_relation'];
    $remark = $_POST['remark'];
    
    if(isset($_POST['app_access'])){
      $app_access = 1;
    }else{
      $app_access = 0;
    }

    $upload_dir = '../../uploads/aadhaar/';
    $extensions = array('jpg','jpeg','png');   
    
    $aadhaar_file = array();
    foreach ($_FILES['aadhaar_file']["error"] as $key => $error) {

        if ($error == UPLOAD_ERR_OK) {  

            $tmp_name = $_FILES['aadhaar_file']["tmp_name"][$key];
            $file_name = $_FILES['aadhaar_file']["name"][$key];
            $extension = explode('.',$file_name);
            $file_extension = end($extension);

            if(in_array($file_extension, $extension)){
                
                $new_file_name = md5(uniqid()).".".$file_extension;             
                $destination = $upload_dir.$new_file_name;
                if(move_uploaded_file($tmp_name, $destination)){
                    $aadhaar_file[] = $new_file_name;
                }
            }   

        }
    }

    if(count($aadhaar_file) > 0){
        $aadhaar_file = $aadhaar_file[0];
    }else{
        $aadhaar_file = "";
    }

    $upload_dir = '../../uploads/pan/';
    $extensions = array('jpg','jpeg','png');   
    
    $pan_file = array();
    foreach ($_FILES['pan_file']["error"] as $key => $error) {

        if ($error == UPLOAD_ERR_OK) {  

            $tmp_name = $_FILES['pan_file']["tmp_name"][$key];
            $file_name = $_FILES['pan_file']["name"][$key];
            $extension = explode('.',$file_name);
            $file_extension = end($extension);

            if(in_array($file_extension, $extension)){
                
                $new_file_name = md5(uniqid()).".".$file_extension;             
                $destination = $upload_dir.$new_file_name;
                if(move_uploaded_file($tmp_name, $destination)){
                   $pan_file[] = $new_file_name;
                }
            }   

        }
    }

    if(count($pan_file) > 0){
        $pan_file = $pan_file[0];
    }else{
        $pan_file = "";
    }

    $form_data = array(
        'site_manager_id' => $login_id,
        'code' =>  $code,
        'name' =>  $name,
        'mobile_number' =>  $mobile_number,
        'designation_id' =>  $designation_id,
        'department_id' =>  $department_id,
        'doj' =>  $doj,
        'dob' =>  $dob,
        'pan_number' =>  $pan_number,
        'pan_file' =>  $pan_file,
        'aadhaar_number' =>  $aadhaar_number,
        'aadhaar_file' =>  $aadhaar_file,
        'username' =>  $username,
        'password' =>  $password,
        'nominee_name' =>  $nominee_name,
        'nominee_relation' =>  $nominee_relation,
        'remark' =>  $remark,
        'app_access' =>  $app_access
     );

    if(insert('tbl_employees',$form_data)){
    
      $success = "Employee Added Successfully";
    
    }else{
    
      $error = "Failed to add Employee";
    
    }


   }



   if(isset($_GET['edit_id'])){

         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);         

         $edit_data = array(
            'name' => $edit_data['name'],
            'mobile_number' => $edit_data['mobile_number'],
            'designation_id' => $edit_data['designation_id'],
            'department_id' => $edit_data['department_id'],
            'doj' => $edit_data['doj'],
            'dob' => $edit_data['dob'],
            'username' => $edit_data['username'],
            'password' => $edit_data['password'],
            'aadhaar_number' => $edit_data['aadhaar_number'],
            'aadhaar_file' => $edit_data['aadhaar_file'],
            'pan_number' => $edit_data['pan_number'],
            'pan_file' => $edit_data['pan_file'],
            'nominee_name' => $edit_data['nominee_name'],
            'nominee_relation' => $edit_data['nominee_relation'],
            'remark' => $edit_data['remark'],
            'app_access' => $edit_data['app_access'],
         );

   }



  if(isset($_POST['update'])){

      // POST DATA

      $form_data = array(
        'name' => $_POST['name'],
        'mobile_number' => $_POST['mobile_number'],
        'designation_id' => $_POST['designation_id'],
        'department_id' => $_POST['department_id'],
        'doj' => $_POST['doj'],
        'dob' => $_POST['dob'],
        'pan_number' => $_POST['pan_number'],
        'aadhaar_number' => $_POST['aadhaar_number'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'nominee_name' => $_POST['nominee_name'],
        'nominee_relation' => $_POST['nominee_relation'],
        'remark' => $_POST['remark'],
      );
      
      if(isset($_POST['app_access'])){
        $form_data['app_access'] = 1;
      }else{
        $form_data['app_access'] = 0;
      }

      $upload_dir = '../../uploads/aadhaar/';
      $extensions = array('jpg','jpeg','png');   
      
      $aadhaar_file = array();
      foreach ($_FILES['aadhaar_file']["error"] as $key => $error) {

          if ($error == UPLOAD_ERR_OK) {  

              $tmp_name = $_FILES['aadhaar_file']["tmp_name"][$key];
              $file_name = $_FILES['aadhaar_file']["name"][$key];
              $extension = explode('.',$file_name);
              $file_extension = end($extension);

              if(in_array($file_extension, $extension)){
                  
                  $new_file_name = md5(uniqid()).".".$file_extension;             
                  $destination = $upload_dir.$new_file_name;
                  if(move_uploaded_file($tmp_name, $destination)){
                      $aadhaar_file[] = $new_file_name;
                  }
              }   

          }
      }

      if(count($aadhaar_file) > 0){
          $aadhaar_file = $aadhaar_file[0];
          $form_data['aadhaar_file'] = $aadhaar_file;
      }

      $upload_dir = '../../uploads/pan/';
      $extensions = array('jpg','jpeg','png');   
      
      $pan_file = array();
      foreach ($_FILES['pan_file']["error"] as $key => $error) {

          if ($error == UPLOAD_ERR_OK) {  

              $tmp_name = $_FILES['pan_file']["tmp_name"][$key];
              $file_name = $_FILES['pan_file']["name"][$key];
              $extension = explode('.',$file_name);
              $file_extension = end($extension);

              if(in_array($file_extension, $extension)){
                  
                  $new_file_name = md5(uniqid()).".".$file_extension;             
                  $destination = $upload_dir.$new_file_name;
                  if(move_uploaded_file($tmp_name, $destination)){
                     $pan_file[] = $new_file_name;
                  }
              }   

          }
      }

      if(count($pan_file) > 0){
          $pan_file = $pan_file[0];
          $form_data['pan_file'] = $pan_file; 
      }

      if(update('tbl_employees',$field_name,$_GET['edit_id'],$form_data)){
        
        $success = "Employee Updated Successfully";
      
      }else{
      
        $error = "Failed to update employee";
      
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

                           <h4 class="page-title">Add Employee</h4>

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

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="name">Name<span class="text-danger">*</span></label>

                                             <input type="text" name="name" parsley-trigger="change" required="" placeholder="" class="form-control" id="name" value="<?php if(isset($edit_data['name'])){ echo $edit_data['name']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="mobile_number">Mobile<span class="text-danger">*</span></label>

                                             <input type="number" name="mobile_number" parsley-trigger="change" required="" placeholder="" class="form-control" id="mobile_number" value="<?php if(isset($edit_data['mobile_number'])){ echo $edit_data['mobile_number']; } ?>">

                                          </div>

                                       </div>

                                        <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="designation_id">designation</label>

                                             <select name="designation_id" required="" parsley-trigger="change" placeholder="" class="form-control" id="designation_id" value="<?php if(isset($edit_data['designation_id'])){ echo $edit_data['designation_id']; } ?>">
                                              <option value="">--Select Designation Manager--</option>
                                              <?php if(isset($designations)){ ?>
                                                  <?php foreach($designations as $rs){ ?>

                                                    <option <?php if(isset($edit_data['designation_id']) && $edit_data['designation_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="department_id">Department_id <span class="text-danger">*</span></label>

                                             <select name="department_id" parsley-trigger="change" placeholder="" class="form-control" id="department_id" value="<?php if(isset($edit_data['department_id'])){ echo $edit_data['department_id']; } ?>" required="">
                                              <option value="">--Select Department_id--</option>
                                              <?php if(isset($departments)){ ?>
                                                  <?php foreach($departments as $rs){ ?>

                                                    <option <?php if(isset($edit_data['department_id']) && $edit_data['department_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                  <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>
                                       

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label>DOJ <span class="text-danger">*</span></label>

                                             <div class="input-group">

                                                <input type="date" required="" class="form-control" placeholder="mm/dd/yyyy" id="doj" value="<?php if(isset($edit_data['doj'])){ echo date('Y-m-d',strtotime($edit_data['doj'])); }else{ echo date('Y-m-d'); } ?>" name="doj" >

                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label>DOB <span class="text-danger">*</span></label>

                                             <div class="input-group">

                                                <input type="date" required="" class="form-control" placeholder="mm/dd/yyyy" name="dob" id="dob" value="<?php if(isset($edit_data['dob'])){ echo date('Y-m-d',strtotime($edit_data['dob'])); } ?>" >

                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>

                                             </div>

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="username">Username<span class="text-danger">*</span></label>

                                             <input type="text" name="username" parsley-trigger="change" required="" placeholder="" class="form-control" id="username" value="<?php if(isset($edit_data['username'])){ echo $edit_data['username']; } ?>">

                                          </div>

                                       </div>

                                        <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="password">Password<span class="text-danger">*</span></label>

                                             <input type="password" name="password" parsley-trigger="change" required="" placeholder="" class="form-control" id="password" value="<?php if(isset($edit_data['password'])){ echo $edit_data['password']; } ?>">

                                          </div>

                                       </div>


                                        

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="aadhaar_number">Aadhaar Number</label>

                                             <input type="text" parsley-trigger="change" placeholder="" class="form-control" name="aadhaar_number" id="aadhaar_number" value="<?php if(isset($edit_data['aadhaar_number'])){ echo $edit_data['aadhaar_number']; } ?>">

                                          </div>

                                       </div>

                                       <div class="clearfix"></div>


                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label class="control-label">Upload Aadhaar <?php if(isset($edit_data['aadhaar_file'])){ ?> <a href="<?php echo '../../uploads/aadhaar/'.$edit_data['aadhaar_file']; ?>">View</a> <?php } ?> </label>

                                             <input type="file" class="filestyle" data-buttonname="btn-default" name="aadhaar_file[]" id="aadhaar_file" >

                                          </div>

                                       </div>


                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="pan_number">PAN Number</label>

                                             <input type="text" parsley-trigger="change" placeholder="" class="form-control" name="pan_number" id="pan_number" value="<?php if(isset($edit_data['pan_number'])){ echo $edit_data['pan_number']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label class="control-label">Upload PAN <?php if(isset($edit_data['pan_file'])){ ?> <a href="<?php echo '../../uploads/pan/'.$edit_data['pan_file']; ?>">View</a> <?php } ?> </label>

                                             <input type="file" class="filestyle" data-buttonname="btn-default" name="pan_file[]" id="pan_file" >

                                          </div>

                                       </div>

                                       <div class="clearfix"></div>


                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="nominee_name">Nominee Name</label>

                                             <input type="text" name="nominee_name" parsley-trigger="change" placeholder="" class="form-control" id="nominee_name" value="<?php if(isset($edit_data['nominee_name'])){ echo $edit_data['nominee_name']; } ?>">

                                          </div>

                                       </div>


                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="nominee_relation">Nominee Relation</label>

                                             <input type="text" name="nominee_relation" parsley-trigger="change" placeholder="" class="form-control" id="nominee_relation" value="<?php if(isset($edit_data['nominee_relation'])){ echo $edit_data['nominee_relation']; } ?>">

                                          </div>

                                       </div>

                                       <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="remark">Remark</label>

                                             <textarea name="remark" parsley-trigger="change" placeholder="" class="form-control" id="remark"><?php if(isset($edit_data['remark'])){ echo $edit_data['remark']; } ?></textarea>

                                          </div>

                                       </div>

                                       <div class="clearfix"></div>

                                       <div class="col-md-4 p-t-30">
                                         
                                          <div class="checkbox-control">
                                        
                                             <input type="checkbox" name="app_access" id="app_access" <?php if(isset($edit_data['app_access']) && $edit_data['app_access'] == '1'){ echo "checked"; } ?>> <label for="app_access">Allow App Access</label>
                                       
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


   </body>

</html>
