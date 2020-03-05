<?php

   include('../../functions.php');

   $login_id = $_SESSION['crm_credentials']['user_id'];

   $table_name = 'tbl_bookings';
   $field_name = 'id';    

   if(isset($_POST['submit'])){

    $code = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "'.DB.'" AND TABLE_NAME = "'.$table_name.'" ';
    $code = getRaw($code);
    $code = $code[0]['AUTO_INCREMENT'];
    $code = 'AKSHRPV'.sprintf('%05d',($code));

    $getPropertyFloorId = "SELECT flr.id as property_floor_id FROM tbl_properties_floors flr INNER JOIN tbl_properties prop ON flr.property_id = prop.id WHERE prop.tower = '".$_POST['property_tower']."' AND flr.floor = '".$_POST['property_floor']."' AND flr.house_number = '".$_POST['property_house_number']."' ";
    $getPropertyFloorId = getRaw($getPropertyFloorId);
    $property_floor_id = $getPropertyFloorId[0]['property_floor_id'];

    $checkIfAlreadyBooked = getOne('tbl_bookings','property_floor_id',$property_floor_id);
    
    if(isset($checkIfAlreadyBooked) && count($checkIfAlreadyBooked) > 0){

        $error = "Sorry, This Property is already booked";

    }else{
        
        $form_data = array(
          'code' => $code,
          'property_floor_id' => $property_floor_id,
          'name' => $_POST['name'],
          'age' => $_POST['age'],
          'occupation' => $_POST['occupation'],
          'name_other' => $_POST['name_other'],
          'age_other' => $_POST['age_other'],
          'occupation_other' => $_POST['occupation_other'],
          'residential_address' => $_POST['residential_address'],
          'residential_mobile_number' => $_POST['residential_mobile_number'],
          'residential_phone' => $_POST['residential_phone'],
          'residential_pan_number' => $_POST['residential_pan_number'],
          'residential_email_address' => $_POST['residential_email_address'],
          'office_address' => $_POST['office_address'],
          'office_mobile_number' => $_POST['office_mobile_number'],
          'office_phone' => $_POST['office_phone'],
          'office_pan_number' => $_POST['office_pan_number'],
          'office_email_address' => $_POST['office_email_address'],
          'employee_id' => $login_id,
          'remark' => $_POST['remark']
        );

        if(insert($table_name,$form_data)){

            $last_booking_id = last_id($table_name,$field_name);
            $form_data = array(
              'booking_id' => $last_booking_id,
              'basic_cost_of_unit' => $_POST['basic_cost_of_unit'],
              'floor_rise_price' => $_POST['floor_rise_price'],
              'garden_facing_price' => $_POST['garden_facing_price'],
              'development_charges' => $_POST['development_charges'],
              'maintanance_charges' => $_POST['maintanance_charges'],
              'document_charges' => $_POST['document_charges'],
              'gst' => $_POST['gst'],
              'discount' => $_POST['discount'],
              'discount_approved_by' => $_POST['discount_approved_by']
            );
            insert('tbl_booking_property_cost',$form_data);
            $last_property_cost_id = last_id('tbl_booking_property_cost','id');

            $i=0;
            foreach($_POST['payment_slab_id'] as $rs){

              $form_data = array(
                'property_cost_id' => $last_property_cost_id,
                'booking_id' => $last_booking_id,
                'payment_slab_id' => $rs,
                'payment_percentage' => $_POST['payment_percentage'][$i],
                'expected_date' => $_POST['payment_expected_date'][$i]
              );
              if(insert('tbl_booking_payment_slabs',$form_data)){
                $success = "Property Booked Successfully";
              }else{
                $error = "Something went wrong, please try again later";
              }

              $i++;

            }

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

                           <h4 class="page-title">Add Booking</h4>

                           <div class="clearfix"></div>

                        </div>

                     </div>                   

                  </div> -->

              <?php if(isset($success) || isset($warning) || isset($error)){ ?>

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
            <?php } ?>
              
              <div class="row">
              <div class="col-sm-12">
                <div class="card-box">
                  
                  <form id="wizard-validation-form" method="POST">
                  <div>
                  <h3>Customer Details</h3>
                  <section>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                           <label for="property_tower">Property Tower<span class="text-danger">*</span></label>
                           <select name="property_tower" parsley-trigger="change" placeholder="" class="form-control" id="property_tower" data-sub-element="property_floor" required="" >
                            <?php if(isset($property_towers)){ ?>
                              <option value="">--Select Tower--</option>
                                <?php foreach($property_towers as $rs){ ?>

                                  <option <?php if(isset($edit_data['property_tower']) && $edit_data['property_tower'] == $rs['tower']){ echo "selected"; } ?> value="<?php echo $rs['tower'] ?>"><?php echo $rs['tower'] ?></option>

                                <?php } ?>
                            <?php } ?>
                           </select>

                        </div>  
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                           <label for="property_floor">Floor<span class="text-danger">*</span></label>
                           <select name="property_floor" parsley-trigger="change" placeholder="" class="form-control property_floor" id="property_floor" data-sub-element="property_house_number" required=""></select>

                        </div>  
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                           <label for="property_house_number">House Number<span class="text-danger">*</span></label>
                           <select name="property_house_number" parsley-trigger="change" placeholder="" class="form-control" id="property_house_number" required="" ></select>

                        </div>  
                      </div>

                    <div class="col-md-4">

                      <div class="form-group">

                         <label for="name">Name<span class="text-danger">*</span></label>

                         <input type="text" name="name" parsley-trigger="change"  placeholder="" class="form-control" id="name" value="<?php if(isset($edit_data['name'])){ echo $edit_data['name']; } ?>" required="">

                      </div>

                   </div> 

                   <div class="col-md-4">

                      <div class="form-group">

                         <label for="age">Age<span class="text-danger">*</span></label>

                         <input type="number" maxlength="2" name="age" parsley-trigger="change"  placeholder="" class="form-control" id="age" value="<?php if(isset($edit_data['age'])){ echo $edit_data['age']; } ?>" required="">

                      </div>

                   </div> 

                   <div class="col-md-4">

                      <div class="form-group">

                         <label for="occupation">Occupation<span class="text-danger">*</span></label>

                         <input type="text" name="occupation" parsley-trigger="change"  placeholder="" class="form-control" id="occupation" value="<?php if(isset($edit_data['occupation'])){ echo $edit_data['occupation']; } ?>" required="">

                      </div>

                   </div>


                    <div class="col-md-4">

                      <div class="form-group">

                         <label for="name">Name (Co-Applicant)</label>

                         <input type="text" name="name_other" parsley-trigger="change"  placeholder="" class="form-control" id="name_other" value="<?php if(isset($edit_data['name'])){ echo $edit_data['name']; } ?>">

                      </div>

                   </div> 

                   <div class="col-md-4">

                      <div class="form-group">

                         <label for="age">Age (Co-Applicant)</label>

                         <input type="text" name="age_other" parsley-trigger="change"  placeholder="" class="form-control" id="age_other" value="<?php if(isset($edit_data['age'])){ echo $edit_data['age']; } ?>">

                      </div>

                   </div> 

                   <div class="col-md-4">

                      <div class="form-group">

                         <label for="occupation">Occupation (Co-Applicant)</label>

                         <input type="text" name="occupation_other" parsley-trigger="change"  placeholder="" class="form-control" id="occupation_other" value="<?php if(isset($edit_data['occupation'])){ echo $edit_data['occupation']; } ?>">

                      </div>

                   </div>

                   <div class="col-md-6">
                     
                     <table class="table table-condensed table-bordered">
                       <thead>
                         <tr>
                           <th>Residential Address </th>
                         </tr>
                       </thead>
                       <tbody>
                         <tr>
                           <td>
                            <textarea id="residential_address" name="residential_address" cols="30" rows="3" class="form-control" placeholder="Enter Address (required)" required=""></textarea>
                          </td> 
                         <tr>
                         </tr>
                           <td><input type="text" class="form-control" id="residential_mobile_number" name="residential_mobile_number" placeholder="Mobile Number (required)" required=""></td>
                         <tr>
                         </tr>
                           <td><input type="text" class="form-control" id="residential_phone" name="residential_phone" placeholder="Phone Number"></td>
                         <tr>
                         </tr>
                           <td><input type="text" id="residential_email_address" name="residential_email_address" class="form-control" placeholder="Email Address"></td>
                         <tr>
                         </tr>
                           <td><input type="text" id="residential_pan_number" name="residential_pan_number" class="form-control" placeholder="PAN Number"></td>
                         </tr>
                       </tbody>
                     </table>

                   </div> 

                   <div class="col-md-6">
                     
                     <table class="table table-condensed table-bordered">
                       <thead>
                         <tr>
                           <th>Office Address</th>
                         </tr>
                       </thead>
                       <tbody>
                         <tr>
                           <td>
                            <textarea id="office_address" name="office_address" cols="30" rows="3" class="form-control" placeholder="Enter Address"></textarea>
                          </td>
                         <tr>
                         </tr>
                           <td><input type="text" class="form-control" id="office_mobile_number" name="office_mobile_number" placeholder="Mobile Number"></td>
                         <tr>
                         </tr>
                           <td><input type="text" class="form-control" id="office_phone" name="office_phone" placeholder="Phone Number"></td>
                         <tr>
                         </tr>
                           <td><input type="text" class="form-control" id="office_email_address" name="office_email_address" placeholder="Email Address"></td>
                         <tr>
                         </tr>
                           <td><input type="text" class="form-control" id="office_pan_number" name="office_pan_number" placeholder="PAN Number"></td>
                         </tr>
                       </tbody>
                     </table>

                   </div>        

                  </div>
                  </section>
                                            <h3>Property Cost</h3>
                                            <section>

                                              <table class="table table-condensed table-bordered">
                                                <tbody>
                                                  <tr>
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">Basic Cost of Unit<span class="text-danger">*</span></td>
                                                    <td width="50%"><input type="number" id="basic_cost_of_unit" name="basic_cost_of_unit" class="form-control " data-a-sign="Rs. " required="" value="0"></td>
                                                  </tr>

                                                  <tr>
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">Floor Rise Price<span class="text-danger">*</span></td>
                                                    <td width="50%"><input type="number" id="floor_rise_price" name="floor_rise_price" class="form-control " data-a-sign="Rs. " required="" value="0"></td>
                                                  </tr>

                                                  <tr>
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">Garden Facing Price<span class="text-danger">*</span></td>
                                                    <td width="50%"><input type="number" id="garden_facing_price" name="garden_facing_price" class="form-control " data-a-sign="Rs. " required="" value="0"></td>
                                                  </tr>


                                                  <tr>
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">Discount<span class="text-danger">*</span></td>
                                                    <td width="50%"><input type="number" id="discount" name="discount" class="form-control " data-a-sign="Rs. " required="" value="0"></td>
                                                  </tr>


                                                  <tr class="bg-success">
                                                    <th width="50%" class="text-center" style="padding-top: 14px;">Sub Total (Property Amount)</th>
                                                    <th width="50%"><input type="number" id="subtotal" class="form-control" data-a-sign="Rs. " readonly="" required="" ></th>
                                                  </tr>


                                                  <tr>
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">Development Charges<span class="text-danger">*</span></td>
                                                    <td width="50%"><input type="number" id="development_charges" name="development_charges" class="form-control " data-a-sign="Rs. " required="" value="0"></td>
                                                  </tr>

                                                  <tr>
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">Maintanance Charges<span class="text-danger">*</span></td>
                                                    <td width="50%"><input type="number" id="maintanance_charges" name="maintanance_charges" class="form-control " data-a-sign="Rs. " required="" value="0"></td>
                                                  </tr>

                                                  <tr>
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">Document Charges<span class="text-danger">*</span></td>
                                                    <td width="50%"><input type="number" id="document_charges" name="document_charges" class="form-control " data-a-sign="Rs. " required="" value="0"></td>
                                                  </tr>

                                                  <tr>
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">GST<span class="text-danger">*</span></td>
                                                    <td width="50%"><input type="number" id="gst" name="gst" class="form-control " data-a-sign="Rs. " required="" value="0"></td>
                                                  </tr>

                                                  <tr class="bg-success">
                                                    <th width="50%" class="text-center" style="padding-top: 14px;">Sub Total (Additional Amount)</th>
                                                    <th width="50%"><input type="number" id="subtotal_additional_amount" class="form-control" data-a-sign="Rs. " readonly="" required=""></th>
                                                  </tr>


                                                </tbody>

                                                <tfoot>
                                                  <tr class="bg-primary">
                                                    <td width="50%" class="text-center" style="padding-top: 14px;">TOTAL AMOUNT</td>
                                                    <td width="50%"><input type="text" id="total_amount" class="form-control font-18 " data-a-sign="Rs. " readonly=""></td>
                                                  </tr>
                                                </tfoot>
                                              </table>

                                              <table class="table table-striped table-condensed">
                                                <thead>
                                                  <tr>
                                                    <td>Discount Approved by (optional)</td>
                                                  </tr>
                                                  <tr>
                                                    <td><input type="text" class="form-control" name="discount_approved_by" id="discount_approved_by" placeholder="Enter Name"></td>
                                                  </tr>
                                                </thead>
                                              </table>
<!-- 
                                              <div class="col-md-6 col-md-offset-6">
                                                <table class="table table-striped table-condensed table-bordered">
                                                  <tbody>
                                                    <tr>
                                                      <td width="50%">Property Amount</td>
                                                      <td width="50%" id="property_amount"></td>
                                                    </tr>
                                                    <tr>
                                                      <td width="50%">Additional Amount</td>
                                                      <td width="50%" id="additional_amount"></td>
                                                    </tr>
                                                    <tr>
                                                      <td width="50%">Total Paying Amount</td>
                                                      <td width="50%" id="total_paying_amount"></td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                                
                                              </div>


 -->
                                            </section>
                                            <h3>Payment Slabs</h3>
                                            <section>

                                              <div class="row">
                                                
                                                <table class="table table-condensed table-bordered">
                                                  <thead>
                                                    <tr>
                                                      <th>Payment Slab</th>
                                                      <th>Percentage</th>
                                                      <th>Expected Date</th>
                                                      <th>Amount (Auto Calculated)</th>
                                                    </tr>
                                                  </thead>

                                                  <tbody class="payment_slabs_block">
                                                    <tr id="payment_slabs_row_0">
                                                      <td width="25%">
                                                        <select name="payment_slab_id[]"  parsley-trigger="change" placeholder="" class="form-control payment_slab_id" id="payment_slab_id_0" value="<?php if(isset($edit_data['payment_slab_id'])){ echo $edit_data['payment_slab_id']; } ?>" required>
                                                        <option value="">--Select Source--</option>
                                                        <?php if(isset($payment_slabs)){ ?>
                                                            <?php foreach($payment_slabs as $rs){ ?>

                                                              <option <?php if(isset($edit_data['payment_slab_id']) && $edit_data['payment_slab_id'] == $rs['id']){ echo "selected"; } ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['name'] ?></option>

                                                            <?php } ?>
                                                        <?php } ?>
                                                       </select>
                                                      </td>
                                                      <td width="25%"><input type="text" class="form-control payment_percentage" placeholder="%" id="payment_percentage_0" data-id="0" name="payment_percentage[]" required=""></td>
                                                      <td width="25%"><div class="input-group date" data-provide="datepicker"><input type="text" class="form-control payment_expected_date" name="payment_expected_date[]" id="payment_expected_date_0" autocomplete="off" required="">
                                                          <div class="input-group-addon">
                                                              <span class="glyphicon glyphicon-th"></span>
                                                          </div>
                                                       </div>
                                                      </td>
                                                      <td width="25%"><input type="text" id="payment_amount_0" placeholder="..." readonly class="form-control"></td>
                                                      <td><i class="fa fa-close" id="payment_slabs_row_0"></i></td>
                                                    </tr>
                                                  </tbody>
                                                </table>

                                              </div>

                                              <div class="row text-center">
                                                <div class="col-md-12">
                                                  <button type="button" class="btn btn-primary btn-bordered waves-effect w-md waves-light m-b-5 add-booking-payment-slab">+ Add Slab</button>
                                                </div>
                                              </div>
                                                
                                            </section>
                                            <h3>Remark</h3>
                                            <section>
                                                
                                                <div class="row">
                                                  <div class="col-md-12">
                                                    <label for="">Remark or note..</label>
                                                    <textarea name="remark" id="" cols="30" rows="10" class="form-control"></textarea>
                                                  </div>
                                                </div>

                                                <div class="row mt-5">
                                                  <div class="col-md-12 text-center">
                                                    <button type="submit" name="submit" class="btn btn-primary btn-md">Submit</button>
                                                    
                                                  </div>
                                                </div>

                                            </section>
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

         <!-- End of the page -->

         <!-- ============================================================== -->

      </div>

      <!-- END wrapper -->

      <!-- START Footerscript -->

      <?php require_once('../../include/footerscript.php'); ?>
      <?php require_once('../../include/footer.php'); ?>

   </body>

</html>
