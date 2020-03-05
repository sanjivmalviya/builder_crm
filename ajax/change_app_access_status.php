<?php

	require_once('../functions.php');

	if($_POST['current_status'] == '1'){
		$new_status = '0';
	}else{
		$new_status = '1';
	}

	$update = "UPDATE ".$_POST['table']." SET app_access = '".$new_status."' WHERE id = ".$_POST['id']." ";
	
	if(query($update)){
		 $status = 1;
		 $msg = 'Access Status Updated Successfully';
	}else{
		 $status = 0;
		 $msg = 'Ooops ! Failed to Update Status';
	}

	$json = array('status'=>$status,'msg'=>$msg);
	echo json_encode($json);

?>