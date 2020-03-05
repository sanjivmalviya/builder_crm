
<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];

   $statuses = getAll('tbl_lead_statuses_master');


   $table_name = 'tbl_lead_statuses_master';
   $field_name = 'id';

   if(isset($_POST['submit'])){

      $name = $_POST['name'];
      $status_class = $_POST['status_class'];

   	$form_data = array(	
   	'name' => $name,			
      'status_class' => $status_class         
   	);

      if(isExists($table_name,'name',$name)){

   			$error = "Oops ! Status already exists, try a different one";

      }else{
   
         if(insert($table_name,$form_data)){              
   			$success = "Lead Status Addded Successfully";
         }else{
            $error = "Failed to Add Lead Status";
   		}		   		
         
      }

   }

   if(isset($_GET['edit_id'])){

         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);
         $name = $edit_data['name'];
         $status_class = $edit_data['status_class'];

   }

   if(isset($_POST['update'])){

      $form_data = array(
         'name'=>sanitize($_POST['name']),
         'status_class'=>sanitize($_POST['status_class'])
      );

      if(update($table_name,$field_name,$_GET['edit_id'],$form_data)){
         $success = "Data Updated Successfully";
      }else{
         $error = "Failed to Update Data";
      }

   }

   if(isset($_GET['delete_id'])){
         
      if(delete($table_name,$field_name,$_GET['delete_id'])){
         $success = "Record Deleted Successfully";
         header('location:lead_status.php');
      }else{
         $error = "Failed to Delete Record";
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
                           <h4 class="page-title">Lead Status</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                   
                  </div>
                  <div class="row">  
                        <div class="card-box">
                          

                               <form method="post" class="form-horizontal">
                                  <div class="col-md-12">
                                       <div class="form-group">
                                          <label for="name">Status<span class="text-danger">*</span></label>
                                          <input type="text" name="name" parsley-trigger="change" required="" placeholder="" class="form-control" id="name" value="<?php if(isset($name)){ echo $name; } ?>" >
                                       </div>
                                    </div>

                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <label for="status_class">Status Class (optional)<span class="text-danger">*</span></label>
                                          <input type="text" name="status_class" parsley-trigger="change"  placeholder="" class="form-control" id="status_class" value="<?php if(isset($status_class)){ echo $status_class; } ?>" >
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

                                       <div class="col-md-12" align="left">

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

                  <div class="row">
                     <div class="col-md-6">
                     <table class="table table-striped table-condensed table-bordered">
                        <thead>
                           <th>Name</th>
                           <th>Color Code</th>
                           <th class="text-right">Actions</th>
                        </thead>


                        <tbody>
                           <?php if(isset($statuses)){ ?>
                              <?php foreach($statuses as $rs){ ?>

                                 <tr>
                                    <td><?php echo $rs['name']; ?></td>
                                    <td><?php echo $rs['status_class']; ?></td>
                                    <td class="text-right">
                                       <a href="lead_status.php?edit_id=<?php echo $rs['id']; ?>"><i class="fa fa-pencil"></i></a>
                                       <a href="lead_status.php?delete_id=<?php echo $rs['id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a>
                                    </td>
                                 </tr>
                                                     
                              <?php } ?>
                           <?php } ?>
                        </tbody>
                     </table>
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