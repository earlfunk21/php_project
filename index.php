<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config.php";

use App\Controllers\UserController;

$router->get("/", function(){
    echo "Home";
});

$router->get("/css/{css_path}", function($css_path){
    var_dump(__DIR__ . "\\static\\css\\$css_path.css");
    return require_once __DIR__ . "/static/css/$css_path.css";
});

$router->post("/login", UserController::execute("login"));
$router->get("/login", UserController::execute("loginView"));
$router->get("/logout", UserController::execute("logout"));
$router->get("/profile/{username}", UserController::execute("profileView"));

$router->get("/create", UserController::execute("createView"));
$router->post("/create", UserController::execute("create"));

$router->run();
