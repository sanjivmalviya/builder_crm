<?php

	require_once('../functions.php');

	$form_data = array(
		'lead_id' => $_POST['form_data']['lead_id'],
		'followup_type' => $_POST['form_data']['followup_type'],
		'whatsapp_text' => $_POST['form_data']['whatsapp_text'],
		'whatsapp_mobile_number' => "91".$_POST['form_data']['whatsapp_mobile_number'],
	);

	if(insert('tbl_followups',$form_data)){

		 $status = 1;
		 $msg = 'whatsapp Added Successfully';
	}else{
		 $status = 0;
		 $msg = 'Ooops ! Failed to Add whatsapp';
	}

	$json = array('status'=>$status,'msg'=>$msg,'data'=>$form_data);
	echo json_encode($json);
?>