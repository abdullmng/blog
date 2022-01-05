<?php 
    require_once 'controllers/postController.php';
    if (!empty($_POST)) {
        $del = deletePost($_POST['postid']);
        foreach ($del as $msg) {
            echo $msg;
        }
        echo '<script>setTimeout(function(){history.go(-1)}, 1000)</script>';
    }
?>