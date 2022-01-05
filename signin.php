<?php 
    require_once 'controllers/userController.php';
    if (!empty($_POST)) {
        $login = login($_POST);

        foreach ($login as $log) {
            echo $log;
        }

        if ($_SESSION['log_success']==1) {
            echo '<script>setTimeout(function() {location.href="profile.php"}, 1000)</script>';
        }
    }
?>