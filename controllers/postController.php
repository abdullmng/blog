<?php 
    require_once 'connections/db.php';
    function showAll() {
        $posts = Post::getPosts();
        return $posts;
    }

    function deletePost($id) {
        if (Post::deletePost($id)) {
            return array('<div class="alert alert-danger">Post Deleted</div>');
        }
    }

    function createPost($data, $userid) {
        if (isset($_SESSION['post_ok']) && isset($_SESSION['insertId'])) {
            unset($_SESSION['post_ok']);
            unset($_SESSION['insertId']);
        }
        $post = new Post($data, $userid);
        if ($post->insertPost()) {
            $_SESSION['post_ok'] = 1;
            $_SESSION['insertId'] = $post->insertId;
            return array('<div class="alert alert-success">Post created!</div>');
        }else {
            $_SESSION['post_ok'] = 0;
            return $post->errors;
        }
    }