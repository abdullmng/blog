<?php 
    class User {
        public $errors, $data, $insertId; 
        function __construct($data)
        {
            $this->errors = [];
            $this->data = $data;
            $this->insertId = 0;
        }

        private function validate() {
            if (empty(trim($this->data['name']))) {array_push($this->errors, '<div class="alert alert-danger">Please enter your full name</div>');}
            if (empty(trim($this->data['email']))) {array_push($this->errors, '<div class="alert alert-danger">Please enter yor email address</div>');}
            if (empty(trim($this->data['password']))) {array_push($this->errors, '<div class="alert alert-danger">Please enter create a password!</div>');}

            $check = DbConnect()->prepare("SELECT * FROM `users` WHERE `email`=?");
            $check->execute([$this->data['email']]);
            $foundEmail = $check->rowCount();
            if ($foundEmail) {
                array_push($this->errors, '<div class="alert alert-danger">Email already in use</div>');
            }
        }

        public function register() {
            $this->validate();
            if (!count($this->errors)) {
                $register = DbConnect()->prepare("INSERT INTO `users` (`name`, `email`, `password`)VALUES(?,?,?)");
                if ($register->execute([$this->data['name'], $this->data['email'], password_hash($this->data['password'], PASSWORD_DEFAULT)])) {
                    $this->insertId = DbConnect()->lastInsertId();
                    return true;
                }else {
                    return false;
                }
            }else {
                return false;
            }
        }

        public function login() {
            $login = DbConnect()->prepare("SELECT * FROM `users` WHERE `email`=?");
            $login->execute([$this->data['email']]);
            $foundLogin = $login->rowCount();
            $row_login = $login->fetch(PDO::FETCH_ASSOC);
            if ($foundLogin) {
                if (password_verify($this->data['password'], $row_login['password'])) {
                    $this->data = $row_login;
                    return true;
                }else {
                    array_push($this->errors, '<div class="alert alert-danger">Invalid login credentials</div>');
                    return false;
                }
            }else {
                array_push($this->errors, '<div class="alert alert-danger">Invalid login credentials</div>');
                return false;
            }
        }

        public static function findUserById($id) {
            $user = DbConnect()->prepare("SELECT * FROM `users` WHERE `id`=?");
            $user->execute([$id]);
            return $user->fetch(PDO::FETCH_ASSOC);
        }
    }
