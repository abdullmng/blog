<?php 
    require_once('connections/db.php');
    function register($data) {
        if (isset($_SESSION['reg_success'])){
            unset($_SESSION['reg_success']);
        }
        $user = new User($data);
        if ($user->register()) {
            $_SESSION['USER_ID'] = $user->insertId;
            $_SESSION['USER_EMAIL'] = $data['email'];
            $_SESSION['reg_success'] = 1;
            return array('<div class="alert alert-success">Registration successful</div>');
        }else {
            $_SESSION['reg_success'] = 0;
            return $user->errors;
        }
    }

    function login($data) {
        if (isset($_SESSION['log_success'])){
            unset($_SESSION['log_success']);
        }
        $user = new User($data);
        if ($user->login()) {
            $_SESSION['USER_ID'] = $user->data['id'];
            $_SESSION['USER_EMAIL'] = $user->data['email'];
            $_SESSION['log_success'] = 1;
            return array('<div class="alert alert-success">login successful</div>');
        }else {
            $_SESSION['log_success'] = 0;
            return $user->errors;
        }
    }

    function profile($id) {
        $user = User::findUserById($id);
        $profileArray = [
            "followers" => Follow::getFollowersById($id),
            "followersCount" => Follow::countFollowersById($id),
            "following" => Follow::getFollowingById($id),
            "followingCount" => Follow::countFollowingById($id),
            "posts" => Post::getPostsByAuhtorId($id),
            "postsCount" => Post::countPostsByUserId($id),
            "user" => $user,
        ];
        return $profileArray;
    }

    function logout() {
        unset($_SESSION["USER_ID"]);
        unset($_SESSION["USER_EMAIL"]);
        session_destroy();
    }

    function mustBeloggedIn() {
        if (!isset($_SESSION['USER_ID']) && !isset($_SESSION['USER_EMAIL'])) {
            echo '<script>location.href="login.php"</script>';
        }
    }
