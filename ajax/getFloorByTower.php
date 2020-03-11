<?php

	require_once('../functions.php');

	// $login_id = $_POST['form_data']['login_id'];
    $login_id = $_SESSION['crm_credentials']['user_id'];
    $login_type = $_SESSION['crm_credentials']['user_type'];

	$tower = $_POST['form_data']['tower'];

	if($login_type == "2"){
   
    	$site_manager_id = $login_id;
   
    }else if($login_type == "3"){
	    
	    $site_manager_id = getOne('tbl_employees','id',$login_id);
	    $site_manager_id = $site_manager_id['site_manager_id'];

    }

	$data = array();

	$floors = "SELECT DISTINCT(det.floor) as floor,property_id FROM tbl_properties mst INNER JOIN tbl_properties_floors det ON mst.id = det.property_id WHERE mst.site_id = '".$site_manager_id."' AND mst.tower = '".$tower."' ORDER BY det.floor ASC ";
	
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