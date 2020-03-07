<?php

 require_once('../../functions.php');
 
 $leads = getRaw('SELECT * FROM tbl_leads ORDER BY id ASC LIMIT 3421,570');
 $count = count($leads);

 $i=1;
 foreach($leads as $rs){

    $update = "UPDATE tbl_leads SET city_id = '1',state_id = '1',country_id = '1',lead_source_id = '1',lead_status = '1',`date` = '2020-03-07',created_at = '2020-03-07 12:00:00',updated_at = '2020-03-07 12:00:00',employee_id = '6' WHERE id = ".$rs['id']." ";
    query($update);

    $i++;
 
 }

 echo $i;
 exit;

 
