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
                        <h4 class="text-center">Login</h4>
                        <p class="text-center">Sign in to your account to continue!</p>
                        <form action="#" id="reg-form">
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
                                <button type="submit" id="btn" class="btn btn-primary">login</button>
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
    let form = {uri: "signin.php", btn: $("#btn"), result: $("#result"), btnDefault: $("#btn").html(), btnLoadMsg: "Validating...", data: data, method: "post"}
    let req = ajaxReqAlt(form)
    })
</script>
<?php include 'footer.php'?>