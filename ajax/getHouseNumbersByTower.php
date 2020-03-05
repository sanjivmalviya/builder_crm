<?php

	require_once('../functions.php');

	$login_id = $_POST['form_data']['login_id'];
	$property_id = $_POST['form_data']['property_id'];
	$floor = $_POST['form_data']['floor'];

	$data = array();

	$house_numbers = "SELECT DISTINCT(house_number) as house_number,id FROM tbl_properties_floors WHERE property_id = '".$property_id."' AND floor = '".$floor."' ORDER BY house_number ASC ";
	$house_numbers = getRaw($house_numbers);

	if(isset($house_numbers) && count($house_numbers) > 0){
		foreach($house_numbers as $rs){

			$checkIfBooked = getRaw('SELECT * FROM tbl_bookings WHERE property_floor_id = "'.$rs['id'].'" AND delete_status = "0" ');
			if(isset($checkIfBooked) && count($checkIfBooked) > 0){
				$html .= "<option value='".$rs['house_number']."' disabled class='bg-muted'>".$rs['house_number']."</option>";
			}else{
				$html .= "<option value='".$rs['house_number']."'>".$rs['house_number']."</option>";
			}
		}
	}
	
	$json = array('html'=>$html);
	echo json_encode($json);
?>