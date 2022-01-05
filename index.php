<?php 
    require('controllers/postController.php');
    $posts = showAll();
    $pageTitle = "Home";
    include 'header.php'
?>
    <section class="mt-5">
        <div class="container">
            <?php foreach ($posts as $post) {?>
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="bg-light p-4 text-center">
                        <h1>
                            <a href="single-post.php?pid=<?php echo $post['id']?>"><?php echo $post['title']?></a>
                        </h1>
                        <p>Posted On: <?php echo $post['created_at']?></p>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </section>
<?php include 'footer.php'?>
    