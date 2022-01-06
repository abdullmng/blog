<?php 
    require 'controllers/followController.php';
    if (!empty($_POST)) {
        $follow = addFollow($_POST['followedId'], $_SESSION['USER_ID']);
        foreach($follow as $msg) {
            echo $msg;
        }
        if ($_SESSION['fol_success']==1) {
            echo '<script>setTimeout(function(){location.reload()},1000)</script>';
        }
    }
?>