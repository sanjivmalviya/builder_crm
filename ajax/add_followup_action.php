<?php

	require_once('../functions.php');

	$form_data = array(
		'lead_id' => $_POST['form_data']['lead_id'],
		'followup_type' => $_POST['form_data']['followup_type'],
		'action_text' => $_POST['form_data']['action_text'],
		'action_type' => $_POST['form_data']['action_type'],
		'action_date' => $_POST['form_data']['action_date'],
		'action_time' => $_POST['form_data']['action_time']
	);

	if(insert('tbl_followups',$form_data)){
		 $status = 1;
		 $msg = 'Action Added Successfully';
	}else{
		 $status = 0;
		 $msg = 'Ooops ! Failed to Add Action';
	}

	$json = array('status'=>$status,'msg'=>$msg);
	echo json_encode($json);
?>