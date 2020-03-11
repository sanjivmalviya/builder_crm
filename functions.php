<?php

error_reporting(0);

session_start();
date_default_timezone_set('Asia/Kolkata');
$timestamp = date('Y-m-d h:i:s');
$baseurl = "http://".$_SERVER['SERVER_NAME']."/softworld_projects/builder_crm";
//  $baseurl = "http://".$_SERVER['SERVER_NAME']."";
define('ROOT',$baseurl);
define('APPPATH',$_SERVER['DOCUMENT_ROOT']."/softworld_projects/builder_crm");
//  define('APPPATH',$_SERVER['DOCUMENT_ROOT']."");
define('DB',"softworld_builder_crm");

$loginId = $_SESSION['crm_credentials']['user_id'];

// database connection
function connect(){

    $host = 'localhost';
    $user = 'root';
    $password = '';

    $db = DB;

    $connect = mysqli_connect($host,$user,$password,$db);
    return $connect;

}

function last_id($table,$field_name){


    $connect = connect();
    

    $getLastId = "SELECT MAX($field_name) as last_id FROM $table";

    $getLastId = mysqli_query($connect,$getLastId);

    $getLastId = mysqli_fetch_assoc($getLastId);

    return $getLastId['last_id'];


}



// insert into table

function insert($table,$form_data){ 


    $connect = connect();

    

    // retrieve the keys of the array (column titles)

    $fields = array_keys($form_data);



    // build the query

    $sql = "INSERT INTO ".$table."

    (`".implode('`,`', $fields)."`)

    VALUES('".implode("','", $form_data)."')";
    

    // run and return the query result resource

    return mysqli_query($connect,$sql);

}



function update($table,$field_name,$field_value,$form_data) {

    $set = '';

    $x = 1;



    foreach($form_data as $name => $value) {

        $set .= "{$name} = \"{$value}\"";

        if($x < count($form_data)) {

            $set .= ',';

        }

        $x++;

    }

    $sql = "UPDATE {$table} SET {$set} WHERE $field_name = {$field_value}";
    
    if(query($sql)) {

        return true;

    }



    return false;

}



function sanitize($value){

    

    $connect = connect();

    return mysqli_real_escape_string($connect,$value);



}



// raw query

function query($qry){



    $connect = connect();



    if(mysqli_query($connect,$qry)){

        return 1;

    }else{

        return 0;

    }    



}



// check if record already exists

function delete($table,$field,$field_value){



    $connect = connect();



    $delete = "DELETE FROM $table WHERE $field = '$field_value' ";

    

    if(mysqli_query($connect,$delete)){

        return 1;

    }else{

        return 0;

    }

    

}



function truncate($table_name){



    $connect = connect();



    $query = "TRUNCATE $table_name";

    if(mysqli_query($connect,$query)){

        return 1;

    }else{

        return 0;

    }

}



// auto increment field value

function getIncrement($field,$table,$au_value,$first_laters,$first_laters_value,$total_laters,$default_value){



     $connect = connect();



     $get = "SELECT $field FROM $table ORDER BY $au_value DESC LIMIT 1";

     $get=mysqli_query($connect,$get);



     if($get){

            $rs=mysqli_fetch_assoc($get);

            $PO_sub=$rs[$field];

            $PO = substr($PO_sub , $first_laters);                               

            $PO_count = str_pad($PO + 1,$total_laters,0,STR_PAD_LEFT);

            $PO_ins =  $first_laters_value.$PO_count;

            

      }else{

             $PO_ins = $default_value;

      }



      return $PO_ins;

}



// check if record already exists

function isExists($table,$field,$field_value){



    $connect = connect();



    $check = "SELECT * FROM $table WHERE $field = '$field_value' ";

    $check = mysqli_query($connect,$check);



    if(mysqli_num_rows($check) > 0){

        return 1;

    }else{

        return 0;

    }



}

function sendSMS($mobile_number,$message){

    // $direct_transaction_api = "http://sms.bulksmsserviceproviders.com/api/send_http.php?authkey=f148b1948e6be2ddfc5a45c9fbd3323d&mobiles=9898363557&message=Hello%20Worlds&sender=NKKBTS&route=B";

    //Your authentication key
    $authKey = "5e68dfc8660bffdaa48bb287dce708f9";
    //Multiple mobiles numbers separated by comma
    $mobileNumber = $mobile_number;
    //Sender ID,While using route4 sender id should be 6 characters long.
    $senderId = "AKSHAR";
    //Your message to send, Add URL encoding here.
    $message = $message;
    
    //Define route 
    $route = "A";
    
    $postData = array(
    'authkey' => $authKey,
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
    );
    //API URL
    $url = "http://sms.bulksmsserviceproviders.com/api/send_http.php";

    // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
        //,CURLOPT_FOLLOWLOCATION => true
    ));
    //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //get response
    $output = curl_exec($ch);
    //Print error if any
    if (curl_errno($ch)) {
        echo 'error:' . curl_error($ch);
    }
    curl_close($ch);

    return $output;

}

function sendSMS2($mobile_number,$msg){

        //Your authentication key

        $authKey = "100679AO6BL8ElT56c2fb0f";


        //Multiple mobiles numbers separated by comma

        $mobileNumber = $mobile_number;

        //Sender ID,While using route4 sender id should be 6 characters long.

        $senderId = "AHCARE";

        //Your message to send, Add URL encoding here.

        $message = urlencode($msg);



        $route = 4;

        

        //Prepare you post parameters

        $postData = array(

            'authkey' => $authKey,

            'mobiles' => $mobileNumber,

            'message' => $msg,

            'sender' => $senderId,

            'route' => $route

        );



        //API URL

        $url = "https://control.msg91.com/api/sendhttp.php";





        $ch = curl_init();

        curl_setopt_array($ch, array(

            CURLOPT_URL => $url,

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST => true,

            CURLOPT_POSTFIELDS => $postData

                //,CURLOPT_FOLLOWLOCATION => true

        ));





        //Ignore SSL certificate verification

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);





        //get response

        $output = curl_exec($ch);



        //Print error if any

        if (curl_errno($ch)) {

            echo 'error:' . curl_error($ch);

        }



        curl_close($ch);



        return 1;

              

}





function generateOTP(){

        $string = '0123456789';

        $string_shuffled = str_shuffle($string);

        $password = substr($string_shuffled, 1, 4);

        $otp = $password;



        return $otp;

}



function generateGUID() {

 

    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',



        // 32 bits for "time_low"

        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),



        // 16 bits for "time_mid"

        mt_rand( 0, 0xffff ),



        // 16 bits for "time_hi_and_version",

        // four most significant bits holds version number 4

        mt_rand( 0, 0x0fff ) | 0x4000,



        // 16 bits, 8 bits for "clk_seq_hi_res",

        // 8 bits for "clk_seq_low",

        // two most significant bits holds zero and one for variant DCE1.1

        mt_rand( 0, 0x3fff ) | 0x8000,



        // 48 bits for "node"

        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )

    );



}



function getCount($table,$delete_status=""){



    $connect = connect();

    

    if(isset($delete_status) && $delete_status != ""){





        $get = "SELECT * FROM $table WHERE delete_status = '$delete_status' ";

        if($get = mysqli_query($connect,$get)){

    

            $get = mysqli_num_rows($get);

            return $get;

        }else{

            return 0;

        }

        

    }else{



        $get = "SELECT * FROM $table";

        if($get = mysqli_query($connect,$get)){

    

            $get = mysqli_num_rows($get);

            return $get;

        }else{

            return 0;

        }



    }



}



function getCountWhere($table,$condition){



    $connect = connect();



    $get = "SELECT * FROM $table WHERE $condition ";

    if($get = mysqli_query($connect,$get)){

                        

        $get = mysqli_num_rows($get);

        return $get;

    }else{

        return 0;

    }



}



// single record

function getOne($table,$field,$field_value){



    $connect = connect();



    $get = "SELECT * FROM $table WHERE $field = '$field_value' ";

    $get = mysqli_query($connect,$get);

    $get = mysqli_fetch_assoc($get);



    return $get;



}



// where condition

function getWhere($table,$where,$field){



    $connect = connect();



    $get = "SELECT * FROM $table WHERE $where = '$field'";

    

    $get = mysqli_query($connect,$get);

    if(mysqli_num_rows($get) > 0){

        while($rs = mysqli_fetch_assoc($get)){

            $data[] = $rs;

        }

    }else{

        $data = null;

    }



    return $data;



}



// all records

function getRaw($query){



        $connect = connect();



        $get = mysqli_query($connect,$query);

        if(mysqli_num_rows($get) > 0){

            while($rs = mysqli_fetch_assoc($get)){

                $data[] = $rs;

            }

        }else{

            $data = null;

        }



        return $data;

}



// all records

function getAll($table){



        $connect = connect();



        $query = "SELECT * FROM $table";

        $get = mysqli_query($connect,$query);

        if(mysqli_num_rows($get) > 0){

            while($rs = mysqli_fetch_assoc($get)){

                $data[] = $rs;

            }

        }else{

            $data = null;

        }



        return $data;

}



function getAllByOrder($table,$field_name,$ordering){



        $connect = connect();



        $query = "SELECT * FROM $table ORDER BY $field_name $ordering ";

        $get = mysqli_query($connect,$query);

        if(mysqli_num_rows($get) > 0){

            while($rs = mysqli_fetch_assoc($get)){

                $data[] = $rs;

            }

        }else{

            $data = null;

        }



        return $data;

}



function file_upload($name,$allowed_extensions,$target_path,$file_prefix=""){

    

    $files = "";

    if($name['error'][0] != '4'){

        

    $file_error = 0;

    $i=0;

    foreach($name['name'] as $value) {



        $ext = explode(".", $value);

        if(!in_array(end($ext), $allowed_extensions)){

           $file_error = 1;

        }

    }



    if($file_error == 0){



      if($file_prefix == ""){

        $file_prefix = "FILE_";

      }



      foreach ($name['name'] as $value){

          $uniqid = uniqid();

          $ext = explode(".", $value);

          $ext = end($ext);

          $filename = $file_prefix.$uniqid.".".$ext;

          move_uploaded_file($name['tmp_name'][$i], $target_path.$filename);

          $files_path[] = $target_path.$filename;

          $i++;

      }



      $files = $files_path;

      }

    

    }



    $data = array('error'=>$file_error,'files'=>$files);

    return $data;

}



function randomPassword() {

    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    $pass = array(); //remember to declare $pass as an array

    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

    for ($i = 0; $i < 8; $i++) {

        $n = rand(0, $alphaLength);

        $pass[] = $alphabet[$n];

    }

    return implode($pass); //turn the array into a string

}



function deleteById($table_name,$field_name,$field_value){



    $query = "DELETE FROM $table_name WHERE $field_name = '$field_value' ";

    if(mysqli_query($query,$connect)){

        return 1;

    }else{

        return 0;

    }



}



function selectWhereMultiple($table_name,$where,$order="ASC"){



    $connect = connect();

    

    $condition = "";

    $i=1;

    $count = count($where);



    foreach ($where as $key => $value) {



        if($i == $count){

            $condition .= $key."='".$value."' ";            

        }else{

            $condition .= $key."='".$value."' AND ";

        }

        $i++;

    }



    $query = "SELECT * FROM $table_name WHERE ".$condition." ORDER BY created_at $order";

    $query = mysqli_query($connect,$query);

    if(mysqli_num_rows($query) > 0){

        while($rs = mysqli_fetch_assoc($query)){



            $data[] = $rs;



        }

    }else{

        $data = null;

    }



    return $data;

}



function time_ago($ts){



    if(!ctype_digit($ts))



        $ts = strtotime($ts);







    $diff = time() - $ts;



    if($diff == 0)



        return 'now';



    elseif($diff > 0)



    {



        $day_diff = floor($diff / 86400);



        if($day_diff == 0)



        {



            if($diff < 60) return 'just now';



            if($diff < 120) return '1 minute ago';



            if($diff < 3600) return floor($diff / 60) . ' minutes ago';



            if($diff < 7200) return '1 hour ago';



            if($diff < 86400) return floor($diff / 3600) . ' hours ago';



        }



        if($day_diff == 1) return 'Yesterday';



        if($day_diff < 7) return $day_diff . ' days ago';



        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';



        if($day_diff < 60) return 'last month';



        return date('F Y', $ts);



    }



    else



    {



        $diff = abs($diff);



        $day_diff = floor($diff / 86400);



        if($day_diff == 0)



        {



            if($diff < 120) return 'in a minute';



            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';



            if($diff < 7200) return 'in an hour';



            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';



        }



        if($day_diff == 1) return 'Tomorrow';



        if($day_diff < 4) return date('l', $ts);



        if($day_diff < 7 + (7 - date('w'))) return 'next week';



        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';



        if(date('n', $ts) == date('n') + 1) return 'next month';



        return date('F Y', $ts);



    }



}



function send_notification($sender_user_type,$sender_id,$receiver_user_type,$receiver_id,$notification_title,$notification_description){

      // feed notification
      $form_data = array(

         'notification_sender_user_type' => $sender_user_type,

         'notification_sender_user_id' => $sender_id,

         'notification_receiver_user_type' => $receiver_user_type ,

         'notification_receiver_user_id' => $receiver_id,

         'notification_title' => $notification_title, 

         'notification_description' => $notification_description 

      );

      insert('tbl_notifications',$form_data);

}



function dateDiff($date1, $date2) 

{

    $date1_ts = strtotime($date1);

    $date2_ts = strtotime($date2);

    $diff = $date2_ts - $date1_ts;

    return abs(round($diff / 86400));

}

// ***************************
// CUSTOM FUNCTIONS
// ***************************

function getInvoiceAchieveTotal($customer_id,$year,$month,$type=0){

    if($type == 1){

        $invoices = "SELECT * FROM tbl_invoices inv INNER JOIN tbl_invoice_detail det ON inv.invoice_id = det.invoice_id INNER JOIN tbl_orders ord ON ord.order_id = inv.order_id WHERE inv.order_id IN(SELECT order_id FROM tbl_orders WHERE user_id = '$customer_id') GROUP BY invoice_detail_id ";     

    }else{
        
        $invoices = "SELECT * FROM tbl_invoices inv INNER JOIN tbl_invoice_detail det ON inv.invoice_id = det.invoice_id INNER JOIN tbl_orders ord ON ord.order_id = inv.order_id WHERE inv.order_id IN(SELECT order_id FROM tbl_orders WHERE user_id = '$customer_id') AND YEAR(inv.created_at) = '$year' AND MONTH(inv.created_at) = '$month' GROUP BY invoice_detail_id ";     
        
    }

    
    $invoices = getRaw($invoices);

    if(count($invoices) > 0){

        $dataset['order_product_rate'] = 0;

        foreach($invoices as $rs){

            $order_detail = getOne('tbl_order_detail','order_detail_id',$rs['order_detail_id']);
            $order_product_rate = $order_detail['order_product_rate'];
            $order_product_discount = $order_detail['order_product_discount'];
            $discount = $order_product_rate * $order_product_discount / 100;
            $order_product_rate = $order_product_rate - $discount;
            $order_product_rate = $order_product_rate * $rs['dispatch_quantity'];

            $order_product_gst = getOne('tbl_product','product_id',$order_detail['order_product_id']);
            $order_product_gst = $order_product_gst['product_gst']; 
            $order_product_gst_amount = $order_product_rate * $order_product_gst / 100;

            $dataset['invoice_id'] = $rs['invoice_id'];
            $dataset['order_product_rate'] = $order_product_rate + $order_product_gst_amount;

            $invoice[] = $dataset;

        }
                                                
    }

    foreach($invoice as $rs){
    $invoice_ids_set1[] = $rs['invoice_id'];
    }

    $invoice_ids_set1 = array_unique($invoice_ids_set1);
    foreach($invoice_ids_set1 as $rs){
    $invoice_ids_set2[] = $rs;
    } 

    $total_invoice_amount = array();
    
    foreach($invoice as $rs){
           
        if(in_array($rs['invoice_id'], $invoice_ids_set2)){
            $total_invoice_amount[$rs['invoice_id']] += $rs['order_product_rate']; 
            
        }else{
            $total_invoice_amount[$rs['invoice_id']] = $rs['order_product_rate']; 
        }

    }

    $invoice_amount = 0;
    foreach($total_invoice_amount as $invoice_id => $invoice_rate){

        $inv = getOne('tbl_invoices','invoice_id',$invoice_id);
        $added_freight = $inv['added_freight'];
        // $added_discount = $invoice_rate * $inv['added_discount'] / 100;
        $invoice_amount += $invoice_rate + $added_freight ;

    }

    return $invoice_amount;


}

function getGSTTotal($customer_id,$from_date,$to_date){

    $invoices = "SELECT * FROM tbl_invoices inv INNER JOIN tbl_invoice_detail det ON inv.invoice_id = det.invoice_id INNER JOIN tbl_orders ord ON ord.order_id = inv.order_id WHERE inv.order_id IN(SELECT order_id FROM tbl_orders WHERE user_id = '$customer_id') AND DATE(inv.created_at) >= '$from_date' AND DATE(inv.created_at) <= '$to_date' GROUP BY invoice_detail_id ";     
    
    // echo $invoices = "SELECT * FROM tbl_invoices inv INNER JOIN tbl_orders ord ON inv.order_id = inv.order_id INNER JOIN tbl_invoice_detail det ON inv.invoice_id = det.invoice_id WHERE ord.user_id = '$customer_id' AND YEAR(inv.created_at) = '$year' AND MONTH(inv.created_at) = '$month' GROUP BY invoice_detail_id ";     
    
    $invoices = getRaw($invoices);

    if(count($invoices) > 0){

    $dataset['order_product_rate'] = 0;

    foreach($invoices as $rs){

    $order_detail = getOne('tbl_order_detail','order_detail_id',$rs['order_detail_id']);
    $order_product_rate = $order_detail['order_product_rate'];
    $order_product_discount = $order_detail['order_product_discount'];
    $discount = $order_product_rate * $order_product_discount / 100;
    $order_product_rate = $order_product_rate - $discount;
    $order_product_rate = $order_product_rate * $rs['dispatch_quantity'];

    $order_product_gst = getOne('tbl_product','product_id',$order_detail['order_product_id']);
    $order_product_gst = $order_product_gst['product_gst']; 
    $order_product_gst_amount = $order_product_rate * $order_product_gst / 100;

    $dataset['invoice_id'] = $rs['invoice_id'];
    $dataset['order_product_gst'] = $order_product_gst_amount;

    $invoice[] = $dataset;


    }
                                                
    }

    print_r($invoice);
    exit;

    foreach($invoice as $rs){
    $invoice_ids_set1[] = $rs['invoice_id'];
    }

    $invoice_ids_set1 = array_unique($invoice_ids_set1);
    foreach($invoice_ids_set1 as $rs){
    $invoice_ids_set2[] = $rs;
    } 

    $total_invoice_amount = array();
    
    foreach($invoice as $rs){
           
        if(in_array($rs['invoice_id'], $invoice_ids_set2)){
            $total_invoice_amount[$rs['invoice_id']] += $rs['order_product_rate']; 
            
        }else{
            $total_invoice_amount[$rs['invoice_id']] = $rs['order_product_rate']; 
        }

    }

    $invoice_amount = 0;
    foreach($total_invoice_amount as $invoice_id => $invoice_rate){

        $inv = getOne('tbl_invoices','invoice_id',$invoice_id);
        $added_freight = $inv['added_freight']; 
        // $added_discount = $invoice_rate * $inv['added_discount'] / 100;
        $invoice_amount += $invoice_rate + $added_freight ;

    }

    return $invoice_amount;


}

function convertHourstoMinutes($value){

        $value = explode(" ", $value);
        $total_mins = 0;
        if(count($value) == 2 && end($value) == "mins"){
            $total_mins += $value[0]; 
        }else if(count($value) == 4 && $value[1] == "hour"){
            $total_mins += $value[0] * 60;
            $total_mins += $value[2];  
        }
        return $total_mins;
}

function convertMinutesToHours($value){

        $value = $value * 2;
        if($value > 60){
            $value = intdiv($value, 60).' hour '. ($value % 60)." minutes";
        }

        return $value;

}
$months = array(
    "01" => 'January',
    "02" => 'February',
    "03" => 'March',
    "04" => 'April',
    "05" => 'May',
    "06" => 'June',
    "07" => 'July',
    "08" => 'August',
    "09" => 'September',
    "10" => 'October',
    "11" => 'November',
    "12" => 'December'
);


/* CUSTOM FUNCTIONS */

// Fetching data from masters
$cities = getRaw("SELECT * FROM tbl_cities_master ORDER by name ASC");
$states = getRaw("SELECT * FROM tbl_states_master ORDER by name ASC");
$countries = getRaw("SELECT * FROM tbl_countries_master ORDER by name ASC");
$property_types = getRaw("SELECT * FROM tbl_property_types_master ORDER by id ASC");
$property_categories = getRaw("SELECT * FROM tbl_property_categories_master ORDER by id ASC");
$property_interested_for = getRaw("SELECT * FROM tbl_property_interested_for_master ORDER by id ASC");
$possesion_statuses = getRaw("SELECT * FROM tbl_possesion_statuses_master ORDER by id ASC");
$lead_sources = getRaw("SELECT * FROM tbl_lead_sources_master ORDER by id ASC");
$lead_statuses = getRaw("SELECT * FROM tbl_lead_statuses_master ORDER by id ASC");
$payment_terms = getRaw("SELECT * FROM tbl_payment_terms_master ORDER by id ASC");
$payment_slabs = getRaw("SELECT * FROM tbl_payment_slabs_master ORDER BY id ASC");

function getCityName($id){

    $get = getOne('tbl_cities_master','id',$id);
    return $get['name'];

}

function getStateName($id){

    $get = getOne('tbl_states_master','id',$id);
    return $get['name'];

}

function getPropertyType($property_type_id){

   $get = getOne('tbl_property_types_master','id',$property_type_id);
   return $get['name'];

 }

 function getPropertyCategory($property_category_id){
 
   $get = getOne('tbl_property_categories_master','id',$property_category_id);
   return $get['name'];

 }

 function getPossesionStatus($possesion_status_id){
 
   $get = getOne('tbl_possesion_statuses_master','id',$possesion_status_id);
   return $get['name'];

 }

 function getleadSource($lead_source_id){
 
   $get = getOne('tbl_lead_sources_master','id',$lead_source_id);
   return $get['name'];

 }

 function getPropertyInterestedFor($property_interested_for_id){

   $get = getOne('tbl_property_interested_for_master','id',$property_interested_for_id);
   return $get['name'];

 }

 function getEmployeeName($id){

   $get = getOne('tbl_employees','id',$id);
   return $get['name'];

 }


 function getLeadStatus($lead_status){

   $get = getOne('tbl_lead_statuses_master','id',$lead_status);
   $get['lead_status'] = $get['name'];
   $get['status_class'] = $get['status_class'];
   $get['status_class_light'] = $get['status_class_light'];

   return $get;

 }

 
 function getDesignation($designation_id){
 
   $get = getOne('tbl_designation_master','id',$designation_id);
   return $get['name'];

 }

 function getDepartment($department_id){
 
   $get = getOne('tbl_department_master','id',$department_id);
   return $get['name'];

 }

 function getPropertyDetail($property_floor_id){

    $get = getRaw('SELECT det.floor,det.house_number,mst.tower FROM tbl_properties mst INNER JOIN tbl_properties_floors det ON mst.id = det.property_id WHERE det.id =  "'.$property_floor_id.'" ');
    $data = array(
      'tower' => $get[0]['tower'],
      'floor' => $get[0]['floor'],
      'house_number' => $get[0]['house_number']
    );

    return $data;

  }

 function getPropertyAmount($booking_id){

      $get = 'SELECT (basic_cost_of_unit + floor_rise_price + garden_facing_price) - discount AS property_amount FROM tbl_booking_property_cost WHERE booking_id = "'.$booking_id.'" ';
      $get = getRaw($get);
      return $get[0]['property_amount']; 

 }

 function getPayableAmount($booking_id){

      $get = 'SELECT (basic_cost_of_unit + floor_rise_price + garden_facing_price - discount) + (development_charges + maintanance_charges + document_charges + gst) AS payable_amount FROM tbl_booking_property_cost WHERE booking_id = "'.$booking_id.'" ';
      $get = getRaw($get);
      return $get[0]['payable_amount']; 

 }

 function getPaymentSlabCount($booking_id){

      $where = "booking_id = '".$booking_id."' ";
      return getCountWhere('tbl_booking_payment_slabs',$where);
      
 }

 function getPaymentSlabName($payment_slab_id){
 
   $get = getOne('tbl_payment_slabs_master','id',$payment_slab_id);
   return $get['name'];

 }


