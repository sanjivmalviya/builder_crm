<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_employees';
 $field_name = 'id';

 $employees = "SELECT * FROM tbl_employees WHERE site_manager_id = '".$login_id."' AND delete_status = '0' ";
$employees = getRaw($employees); 

 if(isset($_GET['delete_id'])){
   
   $form_data = array(
      'delete_status' => '1'
   );

   // echo "<pre>";
   // print_r($form_data);
   // exit;

   if(update($table_name,$field_name,$_GET['delete_id'],$form_data)){
      
      $success = "Record Deleted Successfully";
      header('location:view_employee.php');

   }else{
      $error = "Failed to Delete Record";
   }

 }

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
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <h4 class="page-title">Employee List</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                           		<table class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                           			
                           			<thead>
                                       <th>#</th>
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Code</th>
                                       <th class="text-center">Mobile Number</th>
                                       <th class="text-center">Designation</th>
                                       <th class="text-center">Department</th>           
                                       <th class="text-center">Username</th>           
                                       <th class="text-center">Password</th>           
                                       <th class="text-center">App Access</th>           
                                       <th class="text-center">Active/Inactive</th>           
                                       <th class="text-center">Added at</th>           
                                       <th class="text-center">Actions</th>           
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($employees) && count($employees) > 0){ ?>

                           					<?php $i=1; foreach($employees as $rs){ ?>

                           					<tr>
                                             <td><?php echo $i++; ?></td>
                                             <td class="text-center"><?php echo $rs['name']; ?></td>
                                             <td class="text-center"><?php echo $rs['code']; ?></td>
                                             <td class="text-center"><?php echo $rs['mobile_number']; ?></td>
                                             <td class="text-center"><?php echo getDesignation($rs['designation_id']); ?></td>
                                             <td class="text-center"><?php echo getDepartment($rs['department_id']); ?></td>
                                             <td class="text-center"><?php echo $rs['username']; ?></td>
                                             <td class="text-center"><?php echo $rs['password']; ?></td>
                                             <td class="text-center">
                                                <?php if($rs['app_access'] == '1'){ ?>
                                                   <a onclick=" return confirm('Make Inactive ?');" class="btn btn-success btn-xs app-access-btn" data-record-id="<?php echo $rs['id']; ?>" data-record-table="tbl_employees" data-row="<?php echo "row_status_".$rs['id']; ?>" data-record-status="<?php echo $rs['app_access']; ?>" >Allowed</a>
                                                <?php }else{ ?>
                                                   <a onclick=" return confirm('Make Active ?');" class="btn btn-danger btn-xs app-access-btn" data-record-id="<?php echo $rs['id']; ?>" data-record-table="tbl_employees" data-record-status="<?php echo $rs['app_access']; ?>" >Not Allowed</a>
                                                <?php } ?></td>
                                             <td class="text-center">
                                                <?php if($rs['active_status'] == '1'){ ?>
                                                   <a onclick=" return confirm('Make Inactive ?');" class="btn btn-success btn-xs active-inactive-btn" data-record-id="<?php echo $rs['id']; ?>" data-record-table="tbl_employees" data-row="<?php echo "row_status_".$rs['id']; ?>" data-record-status="<?php echo $rs['active_status']; ?>" >Active</a>
                                                <?php }else{ ?>
                                                   <a onclick=" return confirm('Make Active ?');" class="btn btn-danger btn-xs active-inactive-btn" data-record-id="<?php echo $rs['id']; ?>" data-record-table="tbl_employees" data-record-status="<?php echo $rs['active_status']; ?>" >Inactive</a>
                                                <?php } ?></td>
                                             <td class="text-center"><?php echo date('d-m-Y', strtotime($rs['created_at'])); ?></td>
                                             <td class="text-center">
                                                <a href="employee_roles.php?employee_id=<?php echo $rs['id']; ?>"><i class="fa fa-user"></i></a> 
                                                <a href="add_employee.php?edit_id=<?php echo $rs['id']; ?>"><i class="fa fa-pencil" style="font-size: 15px;padding: 2px;"></i></a>
                                                <a href="view_employee.php?delete_id=<?php echo $rs['id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash" style="font-size: 15px;padding: 2px;"></i></a>
                                             </td>
                           					</tr>
                           					<?php } ?>

                           				<?php } ?>

                           			</tbody>

                           		</table>

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
