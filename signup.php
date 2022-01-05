<?php 
    require_once 'controllers/userController.php';
    if (!empty($_POST)) {
        $register = register($_POST);

        foreach ($register as $reg) {
            echo $reg;
        }

        if ($_SESSION['reg_success']==1) {
            echo '<script>setTimeout(function() {location.href="profile.php"}, 1000)</script>';
        }
    }
?>