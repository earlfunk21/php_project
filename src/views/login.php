<?php include "static/components/header.php"; ?>
    <div class="container">
    <div class="row align-items-center vh-100">
        <div class="col-6 mx-auto">
            <div class="card shadow-lg border-black border-4">
                <div class="card-body d-flex flex-column align-items-center">
                    <form action="/login" method="post">
                        <div class="my-3">
                            <h1 class="text-primary text-center pt-4">Login</h1>
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
                            <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="password">
                        </div>
                        <div class="mb-3 mt-3 d-flex justify-content-between">
                            <input type="submit" value="Login" class="btn btn-primary">
                            <a href="/create">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "static/components/footer.php"; ?>