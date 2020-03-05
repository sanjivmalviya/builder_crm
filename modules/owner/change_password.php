<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $super_admin = getOne('tbl_super_admin','super_admin_id','1');
   
   if(isset($_POST['submit'])){

      $username = $_POST['username'];
      $password = $_POST['password'];

      if($password != ""){

         $update = "UPDATE tbl_super_admin SET username = '$username', password = '$password' "; 

      }else{
         
         $update = "UPDATE tbl_super_admin SET username = '$username' "; 
         
      }      
      
      if(query($update)){
         $success = "Login Credentials Updated Successfully";
      }else{
         $error = "Something went wrong, try again later";
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
                           <h4 class="page-title">Update Password</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                   
                  </div>
                  <div class="row">   
                     
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">
                               <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                 <div class="col-md-12">
                                    <div class="row">


                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="username">Username<span class="text-danger">*</span></label>
                                             <input type="text" name="username" parsley-trigger="change" required="" placeholder="" class="form-control" id="username" value="<?php if(isset($super_admin['username'])){ echo $super_admin['username']; } ?>" >
                                          </div>
                                       </div>

                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="password">Password<span class="text-danger">*</span></label>
                                             <input type="password" name="password" parsley-trigger="change"  placeholder="" class="form-control" id="password" >
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
                                          <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>
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