<?php 
  
   require_once('../../functions.php');
   require_once ('../../vendor/autoload.php');
  
   $login_id = $_SESSION['crm_credentials']['user_id'];
   
   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

   $spreadsheet = new Spreadsheet();
   $sheet = $spreadsheet->getActiveSheet();
   // $sheet->setCellValue('A1', 'Hello World !');

   if(isset($_POST['submit'])){

      // Set required parameters needed to import
      $sheet->setCellValue('A1','date');
      $sheet->setCellValue('B1','name');
      $sheet->setCellValue('C1','mobile_number');
      $sheet->setCellValue('D1','phone');
      $sheet->setCellValue('E1','email');
      $sheet->setCellValue('F1','occupation');
      $sheet->setCellValue('G1','company');
      $sheet->setCellValue('H1','street_address');
      $sheet->setCellValue('I1','city_id');
      $sheet->setCellValue('J1','state_id');
      $sheet->setCellValue('K1','country_id');
      $sheet->setCellValue('L1','property_type_id');
      $sheet->setCellValue('M1','purpose');
      $sheet->setCellValue('N1','budget_range_from');
      $sheet->setCellValue('O1','budget_range_to');
      $sheet->setCellValue('P1','property_interested_for_id');
      $sheet->setCellValue('Q1','property_category_id');
      $sheet->setCellValue('R1','possesion_status_id');
      $sheet->setCellValue('S1','planning_within');
      $sheet->setCellValue('T1','lead_source_id');
      $sheet->setCellValue('U1','remark');
      
      $writer = new Xlsx($spreadsheet); // instantiate Xlsx
      $filename = $login_id.'-LEAD-SHEET-'.date('Y')."-".date('m'); // set filename for excel file to be exported

      header('Content-Type: application/vnd.ms-excel'); // generate excel file
      header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
      header('Cache-Control: max-age=0');

      $writer->save('php://output');  

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

                  <div class="row">                       

                     <div class="col-sm-12">

                        <div class="card-box">

                           <div class="row">

                              <form method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                                 <div class="col-md-12">
                                            
                                      <button type="submit" name="submit" id="save_lead" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5">Export Blank Lead Sheet</button>

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
