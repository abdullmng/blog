<?php 
    require_once 'controllers/postController.php';
    if (!empty($_POST)) {
        $update = update($_POST, $_POST['postId'], $_SESSION['USER_ID']);
        foreach ($update as $msg) {
            echo $msg;
        }

        if ($_SESSION['upd_ok'] == 1) {
            echo '<script>location.href="single-post.php?pid='.$_POST['postId'].'"</script>';
        }
    }
?>