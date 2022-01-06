<?php 
    require_once 'controllers/userController.php';
    require_once 'controllers/postController.php';
    $pageTitle = "Create Post";
    include 'header.php';

    if (isset($_GET['pid'])) {
        $postId = $_GET['pid'];
        $post = showSingle($postId);
        if ($post) {
?>
<section class="mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form action="" id="post-form">
                    <input type="hidden" name="postId" value="<?php echo $post['id']?>">
                    <div class="mb-4">
                        <label for="title">Post Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo $post['title']?>">
                    </div>
                    <div class="mb-4">
                        <label for="body">Post Body</label>
                        <textarea name="body" id="body" cols="30" rows="10" class="form-control"><?php echo $post['body']?></textarea>
                    </div>
                    <div id="post-result"></div>
                    <di class="mb-4">
                        <button type="submit" class="btn btn-primary" id="post-btn">Update</button>
                    </di>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    $("#post-form").submit(function (e) {
        e.preventDefault()
        let data = $(this).serialize()
        let form = {
            uri: "update-post.php", 
            btn: $("#post-btn"), 
            result: $("#post-result"), 
            btnDefault: $("#post-btn").html(), 
            btnLoadMsg: "Posting...", 
            data: data, 
            method: "post"
        }
        let req = ajaxReqAlt(form)
    })
</script>
<?php }else {echo '<section class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg-light p-4 text-center">
                        <h4>Page Not found</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>';} }?>
<?php include 'footer.php'?>