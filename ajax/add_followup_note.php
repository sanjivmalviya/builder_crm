<?php

	require_once('../functions.php');

	$form_data = array(
		'lead_id' => $_POST['form_data']['lead_id'],
		'followup_type' => $_POST['form_data']['followup_type'],
		'note_text' => $_POST['form_data']['note_text'],
	);

	if(insert('tbl_followups',$form_data)){
		 $status = 1;
		 $msg = 'Note Added Successfully';
	}else{
		 $status = 0;
		 $msg = 'Ooops ! Failed to Add Note';
	}

	$json = array('status'=>$status,'msg'=>$msg);
	echo json_encode($json);
?>