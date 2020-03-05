<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_properties';
 $field_name = 'id';

 $properties = "SELECT * FROM ".$table_name." WHERE site_id = '".$login_id."' AND delete_status = '0' ";
 $properties = getRaw($properties); 

 if(isset($_GET['delete_id'])){
   
   $form_data = array(
      'delete_status' => '1'
   );

   if(update($table_name,$field_name,$_GET['delete_id'],$form_data)){
      
      $success = "Record Deleted Successfully";
      header('location:view_properties.php');

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
                  <!-- <div class="row">
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <h4 class="page-title">Properties</h4>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                  </div> -->
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="card-box">
                           <div class="row">

                              <table id="bookings" class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                
                                <thead>
                                       <th>#</th>
                                       <th class="text-center" width="10%">Date</th>
                                       <th class="text-center">Tower</th>
                                       <th class="text-center">Property Type</th>
                                       <th class="text-center">No. of Floors</th>
                                       <th class="text-center">Avg. Price Per Unit</th>           
                                       <th class="text-center">Avg. Super Built-Up Area</th>           
                                       <th class="text-center">Avg. Carpet Area</th>           
                                       <th class="text-center">Last Updated</th>           
                                       <th class="text-center">Properties</th>           
                                       <th class="text-center">Actions</th>           
                                </thead>

                                <tbody>
                                  
                                  <?php if(isset($properties) && count($properties) > 0){ ?>

                                    <?php $i=1; foreach($properties as $rs){ 

                                    ?>

                                    <tr id="property_row_<?php echo $rs['id']; ?>">
                                             <td><?php echo $i++; ?></td>
                                             <td class="text-center"><?php echo date('d-m-Y', strtotime($rs['date'])); ?></td>
                                             <td class="text-center"><?php echo $rs['tower']; ?></td>
                                             <td class="text-center"><?php echo getPropertyType($rs['property_type_id']); ?></td>
                                             <td class="text-center"><?php echo $rs['no_of_floors']; ?></td>
                                             <td class="text-center"><?php echo "<i class='fa fa-rupee'></i> ".number_format($rs['average_price_per_unit'],2); ?></td>
                                             <td class="text-center"><?php echo $rs['average_super_built_up_area']; ?></td>
                                             <td class="text-center"><?php echo $rs['average_carpet_area']; ?></td>
                                             <td class="text-center"><?php echo date('d-m-Y', strtotime($rs['created_at'])); ?></td>
                                             <td><a href="view_detail.php?id=<?php echo $rs['id']; ?>" class="btn btn-primary btn-xs">View Detail</a></td>
                                             <td class="text-center">
                                                <a href="add_property.php?edit_id=<?php echo $rs['id']; ?>"><i class="fa fa-pencil" style="font-size: 15px;padding: 2px;"></i></a>
                                                <a href="javascript:;" class="remove-property" data-delete-row="property_row_" data-delete-table="tbl_properties" data-delete-id="id" data-delete-value="<?php echo $rs['id']; ?>" ><i class="fa fa-trash-o text-danger ml-2" aria-hidden="true"></i></a>
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
      <?php require_once('../../include/footer.php'); ?>


   </body>
</html>
