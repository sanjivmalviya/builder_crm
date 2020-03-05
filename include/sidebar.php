 <?php 

    // include('../../functions.php'); 

    if($_SESSION["crm_credentials"]['user_type'] == '1'){
        // 1 - Admin
            require_once('sidebar_admin.php');

    }else if($_SESSION["crm_credentials"]['user_type'] == '2'){
        // 2 - Site Manager 
            require_once('sidebar_site_manager.php');

    }else if($_SESSION["crm_credentials"]['user_type'] == '3'){

        // 3 - Employee
            require_once('sidebar_employee.php');

    } 

?>