<?php 
    require_once 'connections/db.php';

    function addFollow($followedId, $authorId) {
        $follow = new Follow($followedId, $authorId);
        if ($follow->create()) {
            $_SESSION['fol_success'] = 1;
            return array('<div class="alert alert-success">You successfully followed this user</div>');
        }else {
            $_SESSION['fol_success'] = 0;
            return $follow->errors;
        }
    }

    function removeFollow($followedId, $authorId) {
        $follow = new Follow($followedId, $authorId);
        if ($follow->delete()) {
            $_SESSION['fol_success'] = 1;
            return array('<div class="alert alert-success">You successfully unfollowed this user</div>');
        }else {
            $_SESSION['fol_success'] = 0;
            return $follow->errors;
        }
    }