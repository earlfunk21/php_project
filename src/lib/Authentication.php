<?php

declare(strict_types=1);

namespace App\Lib;

use App\Lib\Response;
use App\Models\UserModel;
use App\Lib\Session;

class Authentication{
    private UserModel $userModel;

    public function __construct(){
        $this->userModel = new UserModel();
    }

    public function isLoggedIn(){
        if (isset($_SESSION["username"])){
            return true;
        }
        return false;
    }

    public function requireLogin() {
        if (!isset($_SESSION["username"])){
            Session::message("You must to login", "danger");
            Response::redirect("/login");
        }
    }

    public function login($username, $password) {
        if (!$this->userModel->isUsernameExist($username) || !$this->userModel->checkPassword($username, $password)){
            Session::message("Username or password is incorrect", "danger");
            Response::redirect("/login");
        }
        Session::set("username", $username);
        Session::message("Successfully Login");
        return $this->userModel->findUserByUsername($username);
    }

    public function logout(){
        $this->requireLogin();
        Session::message("Successfully Logout");
        Session::remove("username");
    }
}