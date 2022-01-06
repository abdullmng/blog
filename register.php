<?php 
    $pageTitle = "Register";
    include 'header.php';
?>
<section class="mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <h4 class="text-center">Register</h4>
                        <p class="text-center">Create your account now and start posting!</p>
                        <form action="#" id="reg-form">
                            <div class="mb-4">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div id="result"></div>
                            <div class="mb-4">
                                <button type="submit" id="btn" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $("#reg-form").submit(function(e) {
    e.preventDefault()
    let data = $(this).serialize()
    let form = {uri: "signup.php", btn: $("#btn"), result: $("#result"), btnDefault: $("#btn").html(), btnLoadMsg: "Processing...", data: data, method: "post"}
    let req = ajaxReqAlt(form)
    })
</script>
<?php include 'footer.php'?>