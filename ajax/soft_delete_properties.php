<?php

	require_once('../functions.php');

	$delete_table = $_POST['form_data']['delete_table'];
	$delete_id = $_POST['form_data']['delete_id'];
	$delete_value = $_POST['form_data']['delete_value'];

	$update = "UPDATE ".$delete_table." SET delete_status = '1' WHERE ".$delete_id." = '".$delete_value."' ";
	$update2 = "UPDATE tbl_properties_floors SET delete_status = '1' WHERE property_id = '".$delete_value."' ";
	
	if(query($update) && query($update2)){
		 $status = 1;
		 $msg = 'Record Deleted Successfully';
	}else{
		 $status = 0;
		 $msg = 'Ooops ! Failed to Update Status';
	}

	$json = array('status'=>$status,'msg'=>$msg);
	echo json_encode($json);
?>