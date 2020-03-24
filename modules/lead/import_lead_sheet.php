<?php 
  
   require_once('../../functions.php');
   require_once ('../../vendor/autoload.php');
  
   $login_id = $_SESSION['crm_credentials']['user_id'];

   $employees = getRaw("SELECT * FROM tbl_employees WHERE site_manager_id = '".$login_id."' AND delete_status = '0' ORDER BY name ASC ");
   
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

   $spreadsheet = new Spreadsheet();
   $sheet = $spreadsheet->getActiveSheet();

   if(isset($_POST['submit'])){

        $employee_id = $_POST['employee_id'];
        
        $extension = pathinfo($_FILES['excel_file']['name'], PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } elseif ($extension == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }

        // file path
        $spreadsheet = $reader->load($_FILES['excel_file']['tmp_name']);
        $sheet_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheet_data[1] as $key => $rs) {
            $fields[] = $rs;
        }
        
        unset($sheet_data[1]);
        $alphaKeyValues = array_values($sheet_data);

        foreach ($alphaKeyValues as $key => $rs) {

            $dataset = array();
            foreach ($rs as $key => $value) {
                $dataset[] = $value;
            }

            $values[] = $dataset;

        }

        foreach($values as $rs){

            $form_data = array(
               'date' => date('Y-m-d', strtotime($rs[0])),
               'name' => $rs[1],
               'mobile_number' => $rs[2],
               'phone' => $rs[3],
               'email' => $rs[4],
               'occupation' => $rs[5],
               'company' => $rs[6],
               'street_address' => $rs[7],
               'city_id' => $rs[8],
               'state_id' => $rs[9],
               'country_id' => $rs[10],
               'property_type_id' => $rs[11],
               'purpose' => $rs[12],
               'budget_range_from' => $rs[13],
               'budget_range_to' => $rs[14],
               'property_interested_for_id' => $rs[15],
               'property_category_id' => $rs[16],
               'possesion_status_id' => $rs[17],
               'planning_within' => $rs[18],
               'lead_source_id' => $rs[19],
               'remark' => $rs[20],
               'employee_id' => $employee_id,
               'lead_status' => '1'
            );

             $next_id = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "'.DB.'" AND TABLE_NAME = "tbl_leads" ';
             $next_id = getRaw($next_id);
             $next_id = $next_id[0]['AUTO_INCREMENT'];
             $code = 'AKSHARPV'.$next_id;
             $form_data['code'] = $code;

            if(insert('tbl_leads',$form_data)){
               $success = "File Imported Successfully";
            }

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

     <!--               <div class="row">

                     <div class="col-md-6">

                        <div class="page-title-box">

                           <h4 class="page-title">Create New Lead</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div> -->


                  <div class="col-md-12 p-t-30">

                     <?php if(isset($success)){ ?>

                        <div class="alert alert-success"><?php echo $success; ?></div>

                     <?php }else if(isset($warning)){ ?>

                        <div class="alert alert-warning"><?php echo $warning; ?></div>

                     <?php }else if(isset($error)){ ?>

                        <div class="alert alert-danger"><?php echo $error; ?></div>

                     <?php } ?>

                  </div> 

                  <div class="row">                       

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">

                                 <div class="col-md-12">

                                    <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                                    
                                       <div class="form-group col-md-6">

                                          <label for="name">Select Employee</label>

                                          <select name="employee_id" id="employee_id" class="form-control select2">
                                            <?php if(isset($employees)){ ?>
                                             <?php foreach($employees as $rs){ ?>
                                               <option value="<?php echo $rs['id']; ?>"><?php echo $rs['name']; ?></option>
                                             <?php } ?>
                                           <?php } ?>

                                          </select>

                                       </div>

                                       <div class="col-md-6">

                                         <div class="form-group">
                                              <label class="control-label">Leads Excel Sheet</label>
                                              <input type="file" class="filestyle" data-buttonname="btn-default" name="excel_file">
                                          </div>
                                         
                                       </div>

                                 </div>

                                 <div class="col-md-12"> 

                                      <button type="submit" name="submit" id="save_lead" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Import Leads</button>

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

          $('#date').focus();
          
      </script>


   </body>

</html>
