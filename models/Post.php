<?php 
    class Post {
        public $errors, $data, $insertId;
        private static $db;
         public function __construct($data, $userid)
         {
            $this->data = $data;
            $this->userid = $userid;
            $this->errors = [];
            self::$db = DbConnect();
         }
         private function validate() {
             if (empty(trim($this->data['title']))) {array_push($this->errors, '<div class="alert alert-danger">Please enter post Title!</div>');}
             if (empty(trim($this->data['body']))) {array_push($this->errors, '<div class="alert alert-danger">Please enter post body</div>');}
         }
         public static function getPosts() {
             $postsArray = [];
             $posts = DbConnect()->query("SELECT * FROM `posts`");
             $rows = $posts->fetch(PDO::FETCH_ASSOC);
             do {
                 $postsArray[] = $rows;
             }while($rows = $posts->fetch(PDO::FETCH_ASSOC));
             return $postsArray;
         }

         public static function getPostById($id) {
             $post = DbConnect()->prepare("SELECT `p`.*, `u`.`id` as `uid`, `u`.`name`, `u`.`email` FROM `posts` `p` INNER JOIN `users` `u` ON `p`.`userid`=`u`.`id` WHERE `p`.`id`=?");
             $post->execute([$id]);
             return $post->fetch(PDO::FETCH_ASSOC);
         }

         public function insertPost() {
             $this->validate();
             if (!count($this->errors)) {
                $insert = self::$db->prepare("INSERT INTO `posts` (`title`, `body`, `userid`)VALUES(?,?,?)");
                if ($insert->execute([$this->data['title'], $this->data['body'], $this->userid])) {
                    $this->insertId = self::$db->lastInsertId();
                    file_put_contents("file.txt", $this->insertId);
                    return true;
                }else {
                    return false;
                }
            }else {
                return false;
            }
         }

         public function updatePost($id) {
            $this->validate();
            if (!count($this->errors)) {
                $update = self::$db->prepare("UPDATE `posts` SET `title`=?, `body`=? WHERE `id`=?");
                if ($update->execute([$this->data['title'], $this->data['body'], $id])) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return false;
            }
         }

         public static function deletePost($id) {
             $delete = DbConnect()->prepare("DELETE FROM `posts` WHERE `id`=?");
             if ($delete->execute([$id])) {
                 return true;
             }else {
                 return false;
             }
         }

        public static function getPostsByAuhtorId($id) {
            $postsArray = [];
            $posts = DbConnect()->prepare("SELECT * FROM `posts` WHERE `userid`=?");
            $posts->execute([$id]);
            $userPosts = $posts->fetch(PDO::FETCH_ASSOC);
            do {
                $postsArray[] = $userPosts;
            } while ($userPosts = $posts->fetch(PDO::FETCH_ASSOC));
            return $postsArray;
        }

        public static function countPostsByUserId($id) {
            $posts = DbConnect()->prepare("SELECT COUNT(*) `total` FROM `posts` WHERE `userid`=?");
            $posts->execute([$id]);
            return $posts->fetch(PDO::FETCH_ASSOC)['total'];
        }
         //private function isVisitorOwner($postId, $userId) {
            
         //}
    }