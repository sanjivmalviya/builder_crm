
<?php

   require_once('../../functions.php');

   $login_id = $_SESSION['agricon_credentials']['user_id'];

   $amenities = getAll('tbl_amenity_master');
   $sub_amenities = getAll('tbl_amenity_master_detail');

   $table_name = 'tbl_amenity_master_detail';
   $field_name = 'id';

   if(isset($_POST['submit'])){

      $amenity_id = $_POST['amenity_id'];
      $name = $_POST['name'];

   	$form_data = array(	
   	'amenity_id' => $amenity_id,			
      'name' => sanitize($name)          
   	);

      if(isExists('tbl_amenity_master_detail','name',$name)){

   			$error = "Oops ! Name already exists, try a different one";

      }else{
   
         if(insert('tbl_amenity_master_detail',$form_data)){              
   			$success = "Amenity Addded Successfully";
         }else{
            $error = "Failed to Add sub_amenity";
   		}		   		
         
      }

   }

   if(isset($_GET['edit_id'])){

         $edit_data = getOne($table_name,$field_name,$_GET['edit_id']);
         $name = $edit_data['name'];
         $amenity_id = sanitize($edit_data['amenity_id']);

   }

   if(isset($_POST['update'])){

      $form_data = array('amenity_id'=>$_POST['amenity_id'],'name'=>sanitize($_POST['name']));
      if(update($table_name,$field_name,$_GET['edit_id'],$form_data)){
         $success = "Data Updated Successfully";
      }else{
         $error = "Failed to Update Data";
      }

   }

   if(isset($_GET['delete_id'])){
         
      if(delete($table_name,$field_name,$_GET['delete_id'])){
         $success = "Record Deleted Successfully";
         header('location:sub_amenity.php');
      }else{
         $error = "Failed to Delete Record";
      }

   }

   function getAmenity($amenity_id){
    
      $get = getOne('tbl_amenity_master','id',$amenity_id);
      return $get['name'];

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
                           <h4 class="page-title">Amenity</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>                   
                  </div>
                  <div class="row">   
                     
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                                 <div class="col-md-12">
                               <form method="post" class="form-horizontal">

                                    <div class="row">

                                        <div class="col-md-4">

                                          <div class="form-group">

                                             <label for="amenity_id">Amenity<span class="text-danger">*</span></label>

                                             <select required="" name="amenity_id" class="form-control" id="amenity_id">
                                              <option value="">Select Amenity</option>
                                              <?php if(isset($amenities)){ ?>
                                                <?php foreach($amenities as $rs){ ?>
                                                  <option <?php if($edit_data['amenity_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>
                                                <?php } ?>
                                              <?php } ?>
                                             </select>

                                          </div>

                                       </div>

                                    	<div class="col-md-4">
                                          <div class="form-group">
                                             <label for="name">Amenity Name<span class="text-danger">*</span></label>
                                             <input type="text" name="name" parsley-trigger="change" required="" placeholder="" class="form-control" id="name" value="<?php if(isset($name)){ echo $name; } ?>" >
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

                                       <div class="col-md-12" align="left">

                                          <?php if(isset($edit_data)){ ?>
                                             
                                             <button type="submit" name="update" id="update" class="btn btn-danger btn-bordered waves-effect w-md waves-light m-b-5">Update</button>

                                          <?php }else{ ?>

                                             <button type="submit" name="submit" id="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Submit</button>

                                          <?php } ?>
                                       
                                       </div>
                                    </div>
                              </form>
                                 </div>
                           </div>
                        </div>
                     </div>
                
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                     <table class="table table-striped table-condensed table-bordered">
                        <thead>
                           <th>Amenity</th>
                           <th>Sub Amenity</th>
                           <th class="text-right">Actions</th>
                        </thead>


                        <tbody>
                           <?php if(isset($sub_amenities)){ ?>
                              <?php foreach($sub_amenities as $rs){ ?>

                                 <tr>
                                    <td><?php echo getAmenity($rs['amenity_id']); ?></td>
                                    <td><?php echo $rs['name']; ?></td>
                                    <td class="text-right">
                                       <a href="sub_amenity.php?edit_id=<?php echo $rs['id']; ?>"><i class="fa fa-pencil"></i></a>
                                       <a href="sub_amenity.php?delete_id=<?php echo $rs['id']; ?>" onclick=" return confirm('Are you sure ?'); "><i class="fa fa-trash"></i></a>
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