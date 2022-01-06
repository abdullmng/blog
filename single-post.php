<?php 
    require 'controllers/postController.php';
    $pageTitle = "Post";
    include 'header.php';
    if (isset($_GET['pid'])) {
        $postId = $_GET['pid'];
        $post = Post::getPostById($postId);
        $isVisitorOwner = false;

        if ($post) {
?>
<section class="mt-5">
    <div class="container">
        <div class="row">
            <di class="col-12">
                <div id="del-result"></div>
                <div class="mb-4">
                    <?php 
                        if (isset($_SESSION['USER_ID'])) {
                            if ($post['uid'] == $_SESSION['USER_ID']) {
                                $isVisitorOwner = true;
                            }
                            if ($isVisitorOwner) {
                    ?>
                    <form action=""  id="del-form" class="form-inline">
                        <input type="hidden" name="postid" value="<?php echo $postId ?>">
                        <button type="submit" class="btn btn-danger" id="del-btn">Delete Post</button>
                        <a href="edit-post.php?pid=<?php echo $postId?>" class="btn btn-outline-success">Edit Post</a>
                    </form>
                    <?php } }?>
                </div>
                <h1><?php echo $post['title']?></h1>
                <small>By <a href="<?php if ($isVisitorOwner) {echo "profile.php";}else{echo "profile.php?uid=".$post['uid'];}?>"><?php echo $post['name']?></a> On <?php echo $post['created_at']?></small>
                <div class="post-body mt-4">
                    <?php echo $post['body']?>
                </div>
            </di>
        </div>
    </div>
</section>

<script>
    $("#del-form").submit(function (e) {
        e.preventDefault()
        let data = $(this).serialize()
        let form = {uri: "delete-post.php", btn: $("#del-btn"), result: $("#del-result"), btnDefault: $("#del-btn").html(), btnLoadMsg: "Deleting...", data: data, method: "post"}
        let req = ajaxReqAlt(form)
    })
</script>
<?php }else {?>
    <section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg-light p-4 text-center">
                        <h4>Page Not found</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>
<?php }?>
<?php include 'footer.php'?>