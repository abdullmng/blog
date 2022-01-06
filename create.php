<?php 
    require_once 'controllers/userController.php';
    $pageTitle = "Create Post";
    include 'header.php';
?>
<section class="mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <form action="" id="post-form">
                    <div class="mb-4">
                        <label for="title">Post Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label for="body">Post Body</label>
                        <textarea name="body" id="body" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div id="post-result"></div>
                    <di class="mb-4">
                        <button type="submit" class="btn btn-primary" id="post-btn">Post</button>
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
        let form = {uri: "create-post.php", btn: $("#post-btn"), result: $("#post-result"), btnDefault: $("#post-btn").html(), btnLoadMsg: "Posting...", data: data, method: "post"}
        let req = ajaxReqAlt(form)
    })
</script>
<?php include 'footer.php'?>