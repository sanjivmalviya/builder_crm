<?php

	require_once('../functions.php');

	$form_data = array(
		'lead_id' => $_POST['form_data']['lead_id'],
		'followup_type' => $_POST['form_data']['followup_type'],
		'sms_text' => $_POST['form_data']['sms_text'],
		'sms_mobile_number' => $_POST['form_data']['sms_mobile_number'],
	);

	if(insert('tbl_followups',$form_data)){

		 sendSMS($_POST['form_data']['sms_mobile_number'],$_POST['form_data']['sms_text']);

		 $status = 1;
		 $msg = 'SMS Added Successfully';
	}else{
		 $status = 0;
		 $msg = 'Ooops ! Failed to Add SMS';
	}

	$json = array('status'=>$status,'msg'=>$msg);
	echo json_encode($json);
?>