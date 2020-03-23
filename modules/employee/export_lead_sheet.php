<?php 

   require_once('../../functions.php');
   require_once ('vendor/autoload.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $leadColumns = getRaw('SELECT 
      date,
      name, 
      name, 
      FROM tbl_leads');

   echo "<pre>";
   print_r($leadColumns);
   exit;

   use PhpOffice\PhpSpreadsheet\Spreadsheet;
   use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

   $spreadsheet = new Spreadsheet();
   $sheet = $spreadsheet->getActiveSheet();
   // $sheet->setCellValue('A1', 'Hello World !');

   if(isset($_POST['submit'])){

      $year = $_POST['attendance_year'];
      $month = $_POST['attendance_month'];

      $month_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);

      // Set required parameters needed to import
      $sheet->setCellValue('A1','id');
      $j=2;
      foreach($employees as $rs){
        $sheet->setCellValue('A'.$j++,$rs['id']); 
      }

      $sheet->setCellValue('B1','year'); 
      $j=2;
      foreach($employees as $rs){
        $sheet->setCellValue('B'.$j++,$year); 
      }

      $sheet->setCellValue('C1','month'); 
      $j=2;
      foreach($employees as $rs){
        $sheet->setCellValue('C'.$j++,$month); 
      }

      $sheet->setCellValue('D1','name'); 
      $j=2;
      foreach($employees as $rs){
        $sheet->setCellValue('D'.$j++,$rs['first_name']." ".$rs['last_name']); 
      }
      
      // set attendance Days of the selected month
      $letter='E';
      for($i=1;$i<=$month_days;$i++){    
          $sheet->setCellValue($letter++."1",$i); 
      }

      $writer = new Xlsx($spreadsheet); // instantiate Xlsx
      $filename = $login_id.'-ATND-SHEET-'.$year."-".$month; // set filename for excel file to be exported

      header('Content-Type: application/vnd.ms-excel'); // generate excel file
      header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
      header('Cache-Control: max-age=0');

      $writer->save('php://output');  

   }
   
?>

<!DOCTYPE html>
<html>
   <?php require_once('includes/headerscript.php'); ?>
   <body class="fixed-left">
      <!-- Begin page -->
      <div id="wrapper">
         <!-- Top Bar Start -->
         <?php require_once('includes/topbar.php'); ?>
         <!-- Top Bar End -->
         <!-- ========== Left Sidebar Start ========== -->
         <?php require_once('includes/sidebar.php'); ?>
         <!-- Left Sidebar End -->            
         <!-- ============================================================== -->
         <!-- Start right Content here -->
         <!-- ============================================================== -->
         <div class="content-page">
            <!-- Start content -->
            <div class="content">
               <div class="container">
                  <div class="row">
                     <div class="col-xs-12">
                        <div class="page-title-box">
                           <div class="col-md-6">
                              <h4 class="page-title">Export Attendance Sheet</h4>
                           </div>
                           <div class="clearfix"></div>
                           <br>
                        </div>
                     </div>
                  </div>
                  <!-- end row -->
                  <div class="row">
                     <div class="col-md-12">
                        <?php if(isset($success)){ ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php }else if(isset($error)){ ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php }else if(isset($warning)){ ?>
                        <div class="alert alert-warning"><?php echo $warning; ?></div>
                        <?php }else if(isset($info)){ ?>
                        <div class="alert alert-info"><?php echo $info; ?></div>
                        <?php } ?>
                     </div>

                     <div class="row">
                        <form method="POST">
                        <div class="col-sm-12">
                           <div class="card-box">


                            <div class="row">


                                       <div class="col-md-4">
                                         <div class="form-group">
                                           <label for="attendance_year">Year <span class="text-danger">*</span></label>
                                           <select name="attendance_year" id="attendance_year" class="form-control" required="">
                                            <?php if(isset($recentYears)){ ?>
                                              <?php foreach($recentYears as $rs){ ?>
                                                <option <?php if($this_year == $rs){ echo "selected"; } ?> value="<?php echo $rs; ?>"><?php echo $rs; ?></option>
                                              <?php } ?>
                                            <?php } ?>
                                           </select>
                                         </div>
                                       </div>

                                       <div class="col-md-4">
                                         <div class="form-group">
                                           <label for="attendance_month">Month <span class="text-danger">*</span></label>
                                           <select name="attendance_month" id="attendance_month" class="form-control" required="">
                                            <?php if(isset($months)){ ?>
                                              <?php foreach($months as $rs){ ?>
                                                <option <?php if($this_month == $rs){ echo "selected"; } ?> value="<?php echo $rs; ?>"><?php echo $rs."-".getMonthNameByNumber($rs); ?></option>
                                              <?php } ?>
                                            <?php } ?>
                                           </select>
                                         </div>
                                       </div>

                                       <div class="col-md-12">
                                           
                                              <p> <span class="text-primary">P - Presence</span> &nbsp;
                                              <span class="text-danger">A - Absent</span> &nbsp;
                                              <span class="text-info">L - Leave</span> &nbsp;
                                              <span class="text-muted"> Note : Leaving a field blank would be consider as Presence by default </span>
                                              </p>
                                           
                                       </div>

                                       <div class="col-md-12 ">

                                          <button type="submit" name="submit" class="btn btn-primary">Download Excel Sheet</button>

                                       </div>
                                       
                                     

                                    </div>
                              
                           </div>
                        </div>
                      </form>
                     </div>
                  </div>
               </div>
            </div>
            <!-- container -->
         </div>
         <!-- content -->
      </div>
      <!-- ============================================================== -->
      <!-- End Right content here -->
      <!-- ============================================================== -->
      </div>
      <!-- END wrapper -->
      <!-- START Footerscript -->
      <?php require_once('includes/footerscript.php'); ?>
      <?php require_once('includes/footer.php'); ?>
   </body>
</html>