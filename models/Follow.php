<?php 
    class Follow {
        public $errors, $followedId, $authorId;
        public function __construct($followedId, $authorId) 
        {
            $this->errors = [];
            $this->followedId = $followedId;
            $this->authorId = $authorId;
        }

        private function validate($action) {
            $doesProfileExist = DbConnect()->prepare("SELECT * FROM `users` WHERE `id`=?");
            $doesProfileExist->execute([$this->followedId]);
            $profileExists = $doesProfileExist->rowCount();
            
            if (!$profileExists) {
                array_push($this->errors, '<div class="alert alert-danger">You cannot follow an account that does not exist!</div>');
            }
            
            
            $isFollowing = DbConnect()->prepare("SELECT * FROM `follows` WHERE `followedid`=? AND `authorid`=?");
            $isFollowing->execute([$this->followedId, $this->authorId]);
            $foundFollowing = $isFollowing->rowCount();
            if ($action == "create") {
                if ($foundFollowing) {
                    array_push($this->errors, '<div class="alert alert-danger">You are already following this user!</div>');
                }
            }

            if ($action == "delete") {
                if (!$foundFollowing) {
                    array_push($this->errors, '<div class="alert alert-danger">You cannot unfollow a user you are not  following!</div>');
                }
            }

            if ($this->followedId == $this->authorId) {
                array_push($this->errors, '<div class="alert alert-danger">You cannot follow yourself!</div>');
            }
            
        }

        public function create() {
            $this->validate("create");
            if (!count($this->errors)) {
                $addFollow = DbConnect()->prepare("INSERT INTO `follows` (`followedid`, `authorid`)VALUES(?,?)");
                if ($addFollow->execute([$this->followedId, $this->authorId])) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return false;
            }
        }

        public function delete() {
            $this->validate("delete");
            if (!count($this->errors)) {
                $delete = DbConnect()->prepare("DELETE FROM `follows` WHERE `followedid`=? AND `authorid`=?");
                if($delete->execute([$this->followedId, $this->authorId])) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return false;
            }
        }

        public static function isVistorFollowing($followedId, $visitorId) {
            $isVisitorFollowing = DbConnect()->prepare("SELECT * FROM `follows` WHERE `followedid`=? AND `authorid`=?");
            $isVisitorFollowing->execute([$followedId, $visitorId]);
            $visitorIsFollowing = $isVisitorFollowing->rowCount();
            if ($visitorIsFollowing) {
                return true;
            }else {
                return false;
            }
        }

        public static function getFollowersById($id) {
            $followersArray = [];
            $followers = DbConnect()->prepare("SELECT `f`.*, `u`.`name`, `u`.`email`, `u`.`id` as `uid` FROM `follows` `f` INNER JOIN `users` `u` ON `f`.`authorid`=`u`.`id` WHERE `followedid`=?");
            $followers->execute([$id]);
            $userFollowers = $followers->fetch(PDO::FETCH_ASSOC);
            do {
                array_push($followersArray, $userFollowers);
            }while ($userFollowers = $followers->fetch(PDO::FETCH_ASSOC));

            return $followersArray;
        }

        public static function getFollowingById($id) {
            $followingArray = [];
            $following = DbConnect()->prepare("SELECT `f`.*, `u`.`name`, `u`.`email`, `u`.`id` as `uid` FROM `follows` `f` INNER JOIN `users` `u` ON `f`.`followedid`=`u`.`id` WHERE `authorid`=?");
            $following->execute([$id]);
            $userFollowing = $following->fetch(PDO::FETCH_ASSOC);
            do {
                array_push($followingArray, $userFollowing);
            }while ($userFollowing = $following->fetch(PDO::FETCH_ASSOC));

            return $followingArray;
        }

        public static function countFollowersById($id) {
            $followers = DbConnect()->prepare("SELECT COUNT(*) as `total` FROM `follows` WHERE `followedid`=?");
            $followers->execute([$id]);
            $followersCount = $followers->fetch(PDO::FETCH_ASSOC)['total'];
            return $followersCount; 
        }

        public static function countFollowingById($id) {
            $following = DbConnect()->prepare("SELECT COUNT(*) as `total` FROM `follows` WHERE `authorid`=?");
            $following->execute([$id]);
            $followingCount = $following->fetch(PDO::FETCH_ASSOC)['total'];
            return $followingCount; 
        }
    }
    