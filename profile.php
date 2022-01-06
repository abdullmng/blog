<?php 
    require 'controllers/userController.php';
    mustBeloggedIn();
    $pageTitle = "Profile";
    include 'header.php';
?>
<?php 
    if (isset($_GET['uid'])) {
        $profile = profile($_GET['uid']);
        $isVisitorFollowing = Follow::isVistorFollowing($_GET['uid'], $_SESSION['USER_ID']);
    }else {
        $profile = profile($_SESSION['USER_ID']);
    }
    $user = $profile["user"];
    $posts = $profile["posts"];
    $followers = $profile['followers'];
    $following = $profile['following']
?>
<section class="mt-5">
    <div class="container">
        <div class="mb-2">
            <h3><?php echo $user['name']?></h3>
            <p><?php echo $user['email']?></p>
        </div>
        <?php if (isset($_GET['uid'])) {?>
        <div class="mb-3">
            <div id="follow-result"></div>
            <?php if (!$isVisitorFollowing) {?>
            <form action="" id="follow-form">
                <input type="hidden" name="followedId" value="<?php echo $_GET['uid']?>">
                <button type="submit" id="follow-btn" class="btn btn-success">Follow <i class="fas fa-user-plus "></i></button>
            </form>
            <?php }else {?>
            <form action="" id="unfollow-form">
                <input type="hidden" name="followedId" value="<?php echo $_GET['uid']?>">
                <button type="submit" id="follow-btn" class="btn btn-danger">Unfollow <i class="fas fa-user-times"></i></button>
            </form>
            <?php }?>
        </div>
        <?php }?>
        <!-- Nav tabs -->
        <ul class="nav nav-pills" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Posts (<?php echo $profile['postsCount']?>)</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">followers(<?php echo $profile['followersCount']?>)</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">follwing(<?php echo $profile['followingCount']?>)</button>
          </li>
        </ul>
        
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab"> 
            <div class="mt-5">
                <h4>Posts</h4>
            <?php if ($profile['postsCount'] > 0) { foreach ($posts as $post) {?>
                <div class="row mb-2">
                    <div class="col-md-10">
                        <div class="bg-light p-4">
                            <h4>
                                <a href="single-post.php?pid=<?php echo $post['id']?>"><?php echo $post['title']?></a>
                            </h4>
                            <p>Posted On: <?php echo $post['created_at']?></p>
                        </div>
                    </div>
                </div>
                <?php }}else{?>
                    <div class="col-md-10">
                        <div class="bg-light p-4">
                            <h4>
                                No posts found!
                            </h4>
                        </div>
                    </div>
                <?php }?>
            </div>
          </div>
          <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <div class="mt-5">
                  <h4>Followers</h4>
                  <ul class="list-group">
                      <?php if ($profile['followersCount'] > 0) {foreach ($followers as $follower) {?>
                      <li class="list-group-item">
                        <a href="profile.php?uid=<?php echo $follower['uid']?>"><?php echo $follower['email']?></a>
                        <br><small><?php echo $follower['name']?></small>
                      </li>
                      <?php } }else {?>
                        <div class="col-md-10">
                        <div class="bg-light p-4">
                            <h4>
                                No followers found!
                            </h4>
                        </div>
                    </div>
                    <?php }?>
                  </ul>
              </div>
          </div>
          <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                <div class="mt-5">
                  <h4>Following</h4>
                  <ul class="list-group">
                      <?php if ($profile['followingCount'] > 0) { foreach ($following as $follower) {?>
                      <li class="list-group-item">
                        <a href="profile.php?uid=<?php echo $follower['uid']?>"><?php echo $follower['email']?></a>
                        <br><small><?php echo $follower['name']?></small>
                      </li>
                      <?php }}else {?>
                        <div class="col-md-10">
                        <div class="bg-light p-4">
                            <h4>
                                You are not following any user!
                            </h4>
                        </div>
                    </div>
                    <?php }?>
                  </ul>
              </div>
          </div>
        </div>
    </div>
</section>

<script>
    $("#follow-form").submit(function (e) {
        e.preventDefault()
        let data = $(this).serialize()
        let form = {uri: "follow.php", btn: $("#follow-btn"), result: $("#follow-result"), btnDefault: $("#follow-btn").html(), btnLoadMsg: "Validating...", data: data, method: "post"}
        let req = ajaxReqAlt(form)
    })
    $("#unfollow-form").submit(function (e) {
        e.preventDefault()
        let data = $(this).serialize()
        let form = {uri: "unfollow.php", btn: $("#follow-btn"), result: $("#follow-result"), btnDefault: $("#follow-btn").html(), btnLoadMsg: "Validating...", data: data, method: "post"}
        let req = ajaxReqAlt(form)
    })
</script>
<?php include 'footer.php'?>
