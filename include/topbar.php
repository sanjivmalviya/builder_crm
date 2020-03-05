 <?php 

    // include('../../functions.php'); 

    if($_SESSION["crm_credentials"]['user_type'] == '1'){

            require_once('topbar_super_admin.php');

    }else if($_SESSION["crm_credentials"]['user_type'] == '2'){

            require_once('topbar_admin.php');

    }else if($_SESSION["crm_credentials"]['user_type'] == '3'){

            require_once('topbar_employee.php');

    }else if($_SESSION["crm_credentials"]['user_type'] == '4'){

            require_once('topbar_customer.php');

    } 

?>