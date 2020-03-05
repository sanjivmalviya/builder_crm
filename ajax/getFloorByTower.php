<?php

	require_once('../functions.php');

	$login_id = $_POST['form_data']['login_id'];
	$tower = $_POST['form_data']['tower'];

	$data = array();

	$floors = "SELECT DISTINCT(det.floor) as floor,property_id FROM tbl_properties mst INNER JOIN tbl_properties_floors det ON mst.id = det.property_id WHERE mst.site_id = '".$login_id."' AND mst.tower = '".$tower."' ORDER BY det.floor ASC ";
	
	$floors = getRaw($floors);

	if(isset($floors) && count($floors) > 0){
		foreach($floors as $rs){
			if($rs['floor'] == "0"){
				$floor_name = "Ground Floor";
			}else{
				$floor_name = $rs['floor'];
			}
			$html .= "<option value='".$rs['floor']."' id='".$rs['property_id']."' >".$floor_name."</option>";
		}
	}
	
	$json = array('html'=>$html);
	echo json_encode($json);
?>