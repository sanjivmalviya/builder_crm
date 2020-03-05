<?php
    
    require_once('../../functions.php');
    
    unset($_SESSION['crm_credentials']);
    header('location:../../modules/login/index.php');

?>