<script>

  var login_id = "<?php echo $_SESSION['crm_credentials']['user_id']; ?>";

  $('#bookings').DataTable( {
      // scrollY:        '50vh',
      // scrollCollapse: true,
      // paging:         false
  });

  $('.followup-nav-item:first').addClass('active');
  $('.autonumber').autoNumeric('init');
  $('#city_id,#state_id,#country_id,#property_type_id,#property_interested_for_id,#property_category_id,#possesion_status_id,#lead_source_id,#lead_status,#property_tower,#employee_id,#visit_type').select2();
    // ,#property_tower,#property_floor

  $(document).on('click', '.panel-heading span.clickable', function(e){
      var $this = $(this);
    if(!$this.hasClass('panel-collapsed')) {
      $this.parents('.panel').find('.panel-body').slideUp();
      $this.addClass('panel-collapsed');
      $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
      
    } else {
      $this.parents('.panel').find('.panel-body').slideDown();
      $this.removeClass('panel-collapsed');
      $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
      
    }
  })

  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-bottom-left",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  
  $(document).on('click','#add_site_visit', function(){

    if($('#site_visit_date').val() == ''){
      $('#add-site-message').html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select date </div>');
      return false;
    }

    var form_data = {
      lead_id : $('#lead_id').val(),
      visit_date : $('#site_visit_date').val(),
      visit_type : $('#site_visit_type').val(),
      visit_status : $('#site_visit_status').val(),
    };

    visit_type_text = $('#site_visit_type option:selected').text();
    visit_status_text = $('#site_visit_status option:selected').text();

    $.ajax({
      url : '../../ajax/add_site_visit.php',
      type : 'POST',
      dataType : 'json',
      data : { form_data },
      success : function(data){
        
        if(data.status="1"){
          $('.site-visit-records').append('<tr id="site_visit_row_'+data.last_id+'"><td>'+form_data.visit_date+'</td><td>'+visit_type_text+'</td><td>'+visit_status_text+'</td><td><a href="javascript:;" class="remove-site-visit" data-delete-row="site_visit_row_" data-delete-table="tbl_lead_site_visit" data-delete-id="id" data-delete-value="'+data.last_id+'"><i class="fa fa-trash text-muted" aria-hidden="true"></i></a></td></tr>')
          $('#add-site-message').html('<div class="alert alert-primary" role="alert"><i class="fa fa-check"></i> Visit Added Successfully</div>');
        }else{
          $('#add-site-message').html('<div class="alert alert-danger" role="alert">Failed to add visit, something went wrong </div>');
        }
      }

    })

  
  });

  $(document).on('click','#add_followup_note', function(){
    
    var followup_type = 1; // Note

    if($('#note_text').val() == ''){
      $('#add-note-message').html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please enter a note </div>');
      return false;
    }

    var form_data = {
      lead_id : $('#lead_id').val(),
      followup_type : followup_type,
      note_text : $('#note_text').val(),
    };

    $.ajax({
      url : '../../ajax/add_followup_note.php',
      type : 'POST',
      dataType : 'json',
      data : { form_data },
      success : function(data){
       
        // console.log(data);

        if(data.status="1"){
          $('#add-note-message').html('<div class="alert alert-primary" role="alert"><i class="fa fa-check"></i> Note Added Successfully </div>');
          $('#note_text').val('')
          setTimeout(function(){
            window.location.reload();
          },1000)
        }else{
          $('#add-note-message').html('<div class="alert alert-danger" role="alert">Failed to add note, something went wrong </div>');
        }

      }

    })

  
  });

  $(document).on('click','#add_followup_action', function(){
    
    var followup_type = 2; // ACTION

    if($('#action_text').val() == ''){
      $('#add-action-message').html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please enter a note </div>');
      return false;
    }else if($('#action_type').val() == ''){
      $('#add-action-message').html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select type </div>');
      return false;
    }else if($('#action_date').val() == ''){
      $('#add-action-message').html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select date </div>');
      return false;
    }else if($('#action_time').val() == ''){
      $('#add-action-message').html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select time </div>');
      return false;
    }

    var form_data = {
      lead_id : $('#lead_id').val(),
      followup_type : followup_type,
      action_text : $('#action_text').val(),
      action_type : $('#action_type').val(),
      action_date : $('#action_date').val(),
      action_time : $('#action_time').val(),
    };

    $.ajax({
      url : '../../ajax/add_followup_action.php',
      type : 'POST',
      dataType : 'json',
      data : { form_data },
      success : function(data){

        if(data.status="1"){
          $('#add-action-message').html('<div class="alert alert-primary" role="alert"><i class="fa fa-check"></i> Action Added Successfully </div>');
          $('#action_text').val('');
          setTimeout(function(){
            window.location.reload();
          },1000)
        }else{
          $('#add-action-message').html('<div class="alert alert-danger" role="alert">Failed to add note, something went wrong </div>');
        }

      }

    })

  
  });

  $(document).on('click','#add_followup_sms', function(){
    
    var followup_type = 3; // SMS

    if($('#sms_text').val() == ''){
      $('#add-sms-message').html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please enter a sms </div>');
      return false;
    }

    var form_data = {
      lead_id : $('#lead_id').val(),
      followup_type : followup_type,
      sms_text : $('#sms_text').val(),
      sms_mobile_number : $('#mobile_number').val()
    };

    $.ajax({
      url : '../../ajax/add_followup_sms.php',
      type : 'POST',
      dataType : 'json',
      data : { form_data },
      success : function(data){
       
        // console.log(data);

        if(data.status="1"){
          $('#add-sms-message').html('<div class="alert alert-primary" role="alert"><i class="fa fa-check"></i> SMS Sent Successfully </div>');
          $('#sms_text').val('');
          setTimeout(function(){
            window.location.reload();
          },1000)
        }else{
          $('#add-sms-message').html('<div class="alert alert-danger" role="alert">Failed to send SMS, something went wrong </div>');
        }

      }

    })

  
  });

  $(document).on('click','#add_followup_whatsapp', function(){
    
    var followup_type = 4; // Note

    if($('#whatsapp_text').val() == ''){
      $('#add-whatsapp-message').html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please enter a whatsapp </div>');
      return false;
    }

    var form_data = {
      lead_id : $('#lead_id').val(),
      followup_type : followup_type,
      whatsapp_text : $('#whatsapp_text').val(),
      whatsapp_mobile_number : $('#mobile_number').val()
    };

    $.ajax({
      url : '../../ajax/add_followup_whatsapp.php',
      type : 'POST',
      dataType : 'json',
      data : { form_data },
      success : function(data){
       
        // console.log(data);

        if(data.status="1"){
          $('#add-whatsapp-message').html('<div class="alert alert-primary" role="alert"><i class="fa fa-check"></i> Whatsapp Added Successfully </div>');
          $('#whatsapp_text').val('');

          window.open("https://web.whatsapp.com/send?phone="+data.data.whatsapp_mobile_number+"&text="+data.data.whatsapp_text,"_blank");
          
          // setTimeout(function(){
          //   window.location.reload();
          // },1000)

        }else{
          $('#add-whatsapp-message').html('<div class="alert alert-danger" role="alert">Failed to add whatsapp, something went wrong </div>');
        }

      }

    })

  
  });
 
  $(document).on('click','.followup-nav-item', function(){

    // clear all messages
    $('#add-site-message,#add-note-message,#add-action-message').html('');
    
    $('.followup-nav-item').removeClass('active');
    $(this).addClass('active');

  });
  
  // soft delete site visit record
  $(document).on('click','.remove-site-visit', function(){

    var form_data = {
      delete_row : $(this).attr('data-delete-row'),
      delete_table : $(this).attr('data-delete-table'),
      delete_id : $(this).attr('data-delete-id'),
      delete_value : $(this).attr('data-delete-value')
    };
    softDeleteRecord(form_data);

  });

  // soft delete followup
  $(document).on('click','.remove-followup', function(){

    var form_data = {
      delete_row : $(this).attr('data-delete-row'),
      delete_table : $(this).attr('data-delete-table'),
      delete_id : $(this).attr('data-delete-id'),
      delete_value : $(this).attr('data-delete-value')
    };

    softDeleteRecord(form_data);

  });

  // soft delete lead
  $(document).on('click','.remove-lead', function(){

    var form_data = {
      delete_row : $(this).attr('data-delete-row'),
      delete_table : $(this).attr('data-delete-table'),
      delete_id : $(this).attr('data-delete-id'),
      delete_value : $(this).attr('data-delete-value')
    };
    softDeleteRecord(form_data);

  });

  // soft delete lead
  $(document).on('click','.remove-property-floor', function(){
    
    var form_data = {
      delete_row : $(this).attr('data-delete-row'),
      delete_table : $(this).attr('data-delete-table'),
      delete_id : $(this).attr('data-delete-id'),
      delete_value : $(this).attr('data-delete-value')
    };
    
    softDeleteRecord(form_data);

  });

  // soft delete payment slab's payout
  $(document).on('click','.remove-property', function(){

    var form_data = {
      delete_row : $(this).attr('data-delete-row'),
      delete_table : $(this).attr('data-delete-table'),
      delete_id : $(this).attr('data-delete-id'),
      delete_value : $(this).attr('data-delete-value')
    };

     swal({
        title: "Are you sure?",
        text: "Your will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
      },
      
      function(){

        $.ajax({

          url : '../../ajax/soft_delete_properties.php',
          type : 'POST',
          dataType : 'json',
          data : { form_data },
          success : function(data){
            // console.log(data);
            if(data.status == '1'){
              $('#'+form_data.delete_row+form_data.delete_value).fadeOut(800);
              swal("Deleted!", data.msg, "success");
            }else{
              swal("Oops!", data.msg, "danger");
            }
          }

        });

      });

  });

  /*********************/
  /* CUSTOM FUNCTIONS */
  /*********************/

  // soft deleting a record from database
  function softDeleteRecord(form_data,){
    
      swal({
        title: "Are you sure?",
        text: "Your will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
      },
      
      function(){

        $.ajax({

          url : '../../ajax/soft_delete.php',
          type : 'POST',
          dataType : 'json',
          data : { form_data },
          success : function(data){
            // console.log(data);
            if(data.status == '1'){
              $('#'+form_data.delete_row+form_data.delete_value).fadeOut(800);
              swal("Deleted!", data.msg, "success");
            }else{
              swal("Oops!", data.msg, "danger");
            }
          }

        });

      });

    }

    $(document).on('click','.followup-action-status', function(){

      var form_data = {
        row_title : $(this).attr('data-row-title'),
        status_title : $(this).attr('data-status-title'),
        current_status : $(this).attr('data-status'),
        table : "tbl_followups",
        id : $(this).attr('data-id')
      };

      if(form_data.current_status == "1"){
        confirmButtonClass = "btn-success";
        confirmButtonText = "Yes, Mark Completed !";
      }else{
        confirmButtonClass = "btn-danger";
        confirmButtonText = "Yes, Mark Cancelled !";
      }
      
      swal({
        title: "Are you sure?",
        text: "You wont change it later !",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: confirmButtonClass,
        confirmButtonText: confirmButtonText,
        closeOnConfirm: false
      },

      function(){

        $.ajax({

          url : '../../ajax/change_status.php',
          type : 'POST',
          dataType : 'json',
          data : { form_data },
          success : function(data){
            // console.log(data);
            // return false;
            if(data.status == '1'){
              $('#'+form_data.row_title+form_data.id).fadeOut(800);
              swal("Status Updated!", data.msg, "success");
            }else{
              swal("Oops!", data.msg, "danger");
            }
          }

        });

      });

    });

    $(document).on('click','.change-lead-status', function(){

      var form_data = {
        status_title : $(this).attr('data-status-title'),
        current_status : $(this).attr('data-status'),
        table : "tbl_leads",
        id : $(this).attr('data-id')
      };

      swal({
        title: "Are you sure?",
        text: "You wont change it later !",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-success",
        confirmButtonText: "Yes, Change Status !",
        closeOnConfirm: false
      },

      function(){

        $.ajax({

          url : '../../ajax/change_status.php',
          type : 'POST',
          dataType : 'json',
          data : { form_data },
          success : function(data){
            // console.log(data);
            // return false;
            if(data.status == '1'){
              // $('#'+form_data.row_title+form_data.id).fadeOut(800);
              swal("Status Updated!", data.msg, "success");
            }else{
              swal("Oops!", data.msg, "danger");
            }
          }

        });

      });

    });

    function getFloorsByTower(tower,sub_element){

      var form_data = {
        login_id : login_id,
        tower : tower
      };

      $.ajax({
        url : '../../ajax/getFloorByTower.php',
        type : 'POST',
        dataType : 'json',
        data : { form_data },
        success : function(data){

          $('#'+sub_element).html(data.html);
        }

      })

    }

    $(document).on('change','#property_tower', function(){

      getFloorsByTower($(this).val(),$(this).attr('data-sub-element'));

    });

    function getHouseNumbersByTower(property_id,floor,sub_element){

      var form_data = {
        login_id : login_id,
        property_id : property_id,
        floor : floor,
        sub_element: sub_element
      };

      $.ajax({
        url : '../../ajax/getHouseNumbersByTower.php',
        type : 'POST',
        dataType : 'json',
        data : { form_data },
        success : function(data){

          // console.log(data.html);
          $('#'+sub_element).html(data.html);
        
        }

      })

    }

    $(document).on('change','#property_floor', function(){

      var property_id = $(this).children(":selected").attr("id");
      var floor = $(this).val();
      var sub_element = $(this).attr('data-sub-element');
      getHouseNumbersByTower(property_id,floor,sub_element);

    });

    function validateIfAlreadyExists(form_data){

       var status = 0;

       $.ajax({
        url : '../../ajax/validateIfAlreadyExists.php',
        type : 'POST',
        async : false,
        dataType : 'json',
        data : { form_data },
        success : function(data){
          // return data.status;
          status = data.status;
        }

      });

      return status;

    }

    $(document).on('focusout','.validate-if-already-exists',function(){

      var title = $(this).attr('data-title');

      var form_data = {
        table_name : $(this).attr('data-table-name'),
        field_name : $(this).attr('id'),
        value : $(this).val()
      };

     if(validateIfAlreadyExists(form_data) == 1){
     
      $('#'+form_data.field_name+"_msg").addClass('text-danger').html('<div class="alert alert-danger"> '+title+' Already Exists</div>');
     
      $('#save_lead').prop('disabled',true);
    
     }else{
     
        $('#'+form_data.field_name+"_msg").removeClass('text-danger').html('');
        $('#save_lead').prop('disabled',false);
     
     }  

    });

    var subtotal = 0;
    $(document).on('focusout','#basic_cost_of_unit,#floor_rise_price,#garden_facing_price,#discount,#development_charges,#maintanance_charges,#document_charges,#gst', function(){

      var basic_cost_of_unit = parseFloat($('#basic_cost_of_unit').val());
      var floor_rise_price = parseFloat($('#floor_rise_price').val());
      var garden_facing_price = parseFloat($('#garden_facing_price').val());
      var discount = parseFloat($('#discount').val());

      var subtotal = (basic_cost_of_unit + floor_rise_price + garden_facing_price) - discount;
      $('#subtotal').val(subtotal);

      var development_charges = parseFloat($('#development_charges').val());
      var maintanance_charges = parseFloat($('#maintanance_charges').val());
      var document_charges = parseFloat($('#document_charges').val());
      var gst = parseFloat($('#gst').val());

      var subtotal_additional_amount = development_charges + maintanance_charges + document_charges + gst;
      $('#subtotal_additional_amount').val(subtotal_additional_amount);

      var total_amount = subtotal + subtotal_additional_amount;
      $('#total_amount').val(total_amount);

    });

    var i = 1;
    $(document).on('click','.add-booking-payment-slab', function(){

        $html = '<tr id="payment_slabs_row_'+i+'"><td width="25%"><select class="form-control payment_slab_id"id="payment_slab_id_0"name="payment_slab_id[]"parsley-trigger="change"placeholder=""value="<?php if(isset($edit_data['payment_slab_id'])){echo $edit_data['payment_slab_id'];} ?>" required><option value="">--Select Source--</option><?php if(isset($payment_slabs)){ ?><?php foreach($payment_slabs as $rs){ ?><option value="<?php echo $rs['id'] ?>"<?php if(isset($edit_data['payment_slab_id'])&&$edit_data['payment_slab_id']==$rs['id']){echo "selected";} ?>><?php echo $rs['name'] ?></option><?php } ?><?php } ?></select><td width="25%"><input class="form-control payment_percentage"id="payment_percentage_0"data-id="'+i+'"name="payment_percentage[]"placeholder="%" required></td><td width="25%"><div class="date input-group"data-provide="datepicker"><input class="form-control payment_expected_date" name="payment_expected_date[]" id="payment_expected_date_'+i+'"autocomplete="off" required><div class="input-group-addon"><span class="glyphicon glyphicon-th"></span></div></div></td><td width="25%"><input class="form-control"placeholder="..."readonly id="payment_amount_'+i+'"></td><td><i class="fa fa-close payment_slabs_close" id="payment_slabs_row_'+i+'"></i></td></tr>';
        $('.payment_slabs_block').append($html);
        i++;

    });

    $(document).on('click','.payment_slabs_close', function(){

        $('#'+$(this).attr('id')).remove();

    });

    $(document).on('focusout','.payment_percentage', function(){
        var percentage = 0;
        var percent = parseFloat($(this).val());
        var element_id = $(this).attr('data-id');
        var subtotal = parseFloat($('#subtotal').val());

        var percentage = (subtotal * percent) / 100;
        console.log(percentage);
        console.log(element_id);

        $('#payment_amount_'+element_id).val(percentage);


    });
  
</script>
