<?php

	require_once('../functions.php');

	$update = "UPDATE ".$_POST['form_data']['table']." SET ".$_POST['form_data']['status_title']." = '".$_POST['form_data']['current_status']."' WHERE id = ".$_POST['form_data']['id']." ";
		
	if(query($update)){
		 $status = 1;
		 $msg = 'Status Updated Successfully';
	}else{
		 $status = 0;
		 $msg = 'Ooops ! Failed to Update Status';
	}

	$json = array('status'=>$status,'msg'=>$msg);
	echo json_encode($json);
?>