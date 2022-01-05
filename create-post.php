<?php 
    require_once 'controllers/postController.php';
    if (!empty($_POST)) {
        $new_post = createPost($_POST, $_SESSION['USER_ID']);

        foreach($new_post as $msg) {
            echo $msg;
        }

        if ($_SESSION['post_ok'] == 1) {
            echo '<script>setTimeout(function () {location.href="single-post.php?pid='.$_SESSION['insertId'].'"},1000)</script>';
        }
    }
?>