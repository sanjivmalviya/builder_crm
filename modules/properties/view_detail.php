<?php

 require_once('../../functions.php');

 $login_id = $_SESSION['crm_credentials']['user_id'];
 $login_type = $_SESSION['crm_credentials']['user_type'];

 $table_name = 'tbl_properties_floors';
 $field_name = 'property_id';

 $houses = "SELECT * FROM ".$table_name." WHERE $field_name = '".$_GET['id']."' AND delete_status = '0' ";
 $houses = getRaw($houses); 

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
                        <div class="card-box1">
                           <div class="row">

                              <table id="" class="table table-striped table-bordered table-condensed table-hover" style="margin-top: 50px;">
                                
                                <thead>
                                       <th>#</th>
                                       <th class="text-center">Floor</th>
                                       <th class="text-center">Floor Type</th>
                                       <th class="text-center">House Number</th>
                                       <th class="text-center">Last Updated</th>           
                                       <th class="text-center">Actions</th>           
                                </thead>

                                <tbody>
                                  
                                  <?php if(isset($houses) && count($houses) > 0){ ?>

                                    <?php $i=1; foreach($houses as $rs){ 

                                    ?>

                                    <tr id="property_detail_row_<?php echo $rs['id']; ?>">
                                             <td><?php echo $i++; ?></td>
                                             <td class="text-center"><?php echo $rs['floor']; ?></td>
                                             <td class="text-center"><?php echo $rs['floor_type']; ?></td>
                                             <td class="text-center"><?php echo $rs['house_number']; ?></td>
                                             <td class="text-center"><?php echo date('d-m-Y', strtotime($rs['updated_at'])); ?></td>
                                             <td class="text-center">
                                                <a href="javascript:;" class="remove-property-floor" data-delete-row="property_detail_row_" data-delete-table="tbl_properties_floors" data-delete-id="id" data-delete-value="<?php echo $rs['id']; ?>" ><i class="fa fa-trash-o text-danger ml-2" aria-hidden="true"></i></a>
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
