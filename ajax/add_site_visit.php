<?php

	require_once('../functions.php');

	$form_data = array(
		'lead_id' => $_POST['form_data']['lead_id'],
		'visit_date' => $_POST['form_data']['visit_date'],
		'visit_type' => $_POST['form_data']['visit_type'],
		'visit_status' => $_POST['form_data']['visit_status']
	);

	if(insert('tbl_lead_site_visit',$form_data)){
		 $last_id = last_id('tbl_lead_site_visit','id');
		 $status = 1;
		 $msg = 'Site Visit Added Successfully';
	}else{
		 $status = 0;
		 $msg = 'Ooops ! Failed to Add Site Visit';
	}

	$json = array('status'=>$status,'msg'=>$msg,'last_id'=>$last_id);
	echo json_encode($json);
?>