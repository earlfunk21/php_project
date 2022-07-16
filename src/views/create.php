<?php include "static/components/header.php"; ?>

<div class="container">
    <div class="row align-items-center vh-100">
        <div class="col-6 mx-auto">
            <div class="card shadow-lg border-black border-4">
                <div class="card-body d-flex flex-column align-items-center">
                    <form action="/create" method="post">
                        <div class="my-3">
                            <h1 class="text-primary text-center pt-4">Register</h1>
                        </div>
                        <div class="my-4">
                            <hr>
                        </div>
                        <div class="mb-3">
                            <?php include "static/components/message.php"; ?>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" name="username" autocomplete="username">
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email" autocomplete="email">
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password1" autocomplete="password">
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password (Again)" name="password2" autocomplete="password">
                        </div>
                        <div class="mb-3 mt-3 d-flex justify-content-between">
                            <input type="submit" value="Submit" class="btn btn-primary">
                            <a href="/login">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "static/components/footer.php"; ?>