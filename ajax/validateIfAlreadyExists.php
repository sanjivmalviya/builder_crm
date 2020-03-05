<?php

	require_once('../functions.php');

	$table_name = $_POST['form_data']['table_name'];
	$field_name = $_POST['form_data']['field_name'];
	$value = $_POST['form_data']['value'];

	$data = array();

	$check = "SELECT COUNT(*) as total_records FROM ".$table_name." WHERE ".$field_name." = '".$value."' AND ".$field_name." != '' ";
	$check = getRaw($check);

	$total_records = $check[0]['total_records'];

	if(isset($total_records) && $total_records > 0){
		$status = 1;
	}else{
		$status = 0;
	}
	
	$json = array('status'=>$status);
	echo json_encode($json);
?>