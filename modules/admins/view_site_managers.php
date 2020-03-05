<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_site_managers';
 $field_name = 'id';
 
 $site_managers = "SELECT * FROM tbl_site_managers WHERE delete_status = '0' ORDER BY id DESC ";
 $site_managers = getRaw($site_managers);

 if(isset($_GET['delete_id'])){
   
   $form_data = array(
      'delete_status' => '1'
   );

   if(update($table_name,$field_name,$_GET['delete_id'],$form_data)){
      
      $success = "Record Deleted Successfully";
      header('location:view_site_managers.php');

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
                     
                  </div>
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">
                           <div class="col-xs-12">
                              <div class="page-title-box" style="height: 50px;">
                                 <h4 class="page-title">Site Managers</h4>
                              </div>
                           </div>
                           </div>
                           <div class="row">

                           		<table class="table table-striped table-bordered table-condensed table-hover dataTable" style="margin-top: 50px;">
                           			
                           			<thead>
                                       <th>#</th>
                                       <th class="text-center">Profile Pic</th>           
                                       <th class="text-center">Code</th>
                                       <th class="text-center">Site Name</th>
                                       <th class="text-center">Site Person Name</th>
                                       <th class="text-center">Contact</th>
                                       <th class="text-center">Designation</th>
                                       <th class="text-center">City</th>
                                       <th class="text-center">Username</th>
                                       <th class="text-center">Password</th>           
                                       <th class="text-center">Active Status</th>           
                                       <th class="text-center">Added at</th>           
                                       <th class="text-center">Action</th>           
                           			</thead>

                           			<tbody>
                           				
                           				<?php if(isset($site_managers) && count($site_managers) > 0){ ?>

                           					<?php $i=1; foreach($site_managers as $rs){ ?>

                           					<tr>
                                             <td><?php echo $i++; ?></td>
                                             <td class="text-center"><?php if(isset($rs['profile_pic']) && $rs['profile_pic'] != ''){ ?> <a href="<?php echo "../../uploads/profile_pic/".$rs['profile_pic']; ?>"><img src="<?php echo "../../uploads/profile_pic/".$rs['profile_pic']; ?>" width="50" height="50"></a> <?php }else{ echo 'N/A'; } ?></td>
                                             <td class="text-center"><?php echo $rs['code']; ?></td>
                                             <td class="text-center"><?php echo $rs['site_name']; ?></td>
                                             <td class="text-center"><?php echo $rs['site_person_name']; ?></td>
                                             <td class="text-center"><?php echo $rs['contact']; ?></td>
                                             <td class="text-center"><?php  
                                                   $designation_name = getOne('tbl_designation_master','id',$rs['designation']);
                                                   echo $designation_name = $designation_name['name']; ?>
                                             </td>
                                             <td class="text-center"><?php  
                                                   $city_name = getOne('tbl_city_master','id',$rs['city']);
                                                   echo $city_name = $city_name['name']; ?>
                                             </td>
                                             <td class="text-center"><?php echo $rs['username']; ?></td>
                                             <td class="text-center"><?php echo $rs['password']; ?></td>
                                             <!-- <td class="text-center"><?php echo ($rs['active_status'] == '1') ? 'Active' : 'Inactive'; ?></td> -->
                                             <td class="text-center" class="text-center">
                                                <?php if($rs['active_status'] == '1'){ ?>
                                                   <a onclick=" return confirm('Make Inactive ?');" class="btn btn-success btn-xs active-inactive-btn" data-record-id="<?php echo $rs['id']; ?>" data-record-table="tbl_site_managers" data-row="<?php echo "row_status_".$rs['id']; ?>" data-record-status="<?php echo $rs['active_status']; ?>" >Active</a>
                                                <?php }else{ ?>
                                                   <a onclick=" return confirm('Make Active ?');" class="btn btn-danger btn-xs active-inactive-btn" data-record-id="<?php echo $rs['id']; ?>" data-record-table="tbl_site_managers" data-record-status="<?php echo $rs['active_status']; ?>" >Inactive</a>
                                                <?php } ?></td>
                                             <td class="text-center"><?php echo date('d-m-Y', strtotime($rs['created_at'])); ?></td>
                                             <td class="text-center">
                                                <a href="site_manager_roles.php?site_manager_id=<?php echo $rs['id']; ?>"><i class="fa fa-user"></i></a> 
                                                <a href="add_site_manager.php?edit_id=<?php echo $rs['id']; ?>"><i class="fa fa-pencil" style="font-size: 15px;padding: 2px;"></i></a>
                                                <a href="view_site_managers.php?delete_id=<?php echo $rs['id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash" style="font-size: 15px;padding: 2px;"></i></a>
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

      <script>
         
         $(function(){

            $('.danger').popover({ html : true});

         });

        

      </script>

   </body>
</html>
