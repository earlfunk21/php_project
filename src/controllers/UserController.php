<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Lib\Response;
use App\Models\UserModel;
use App\Lib\Authentication;

use \Exception;
use App\Lib\Session;

class UserController
{
    private static $userModel;
    private static $auth;

    public function __construct(){
        self::$userModel = new UserModel();
        self::$auth = new Authentication();
    }

    public static function login($query){
        $username = $query['username'];
        $password = $query['password'];
        self::$auth->login($username, $password);
        Response::redirect("/profile/" . $username);
    }

    public static function loginView(){
        if (self::$auth->isLoggedIn()){
            Response::redirect("/");
        }
        Response::asView("/login", ["title" => "Login Page"]);
    }

    public static function logout(){
        self::$auth->logout();
        Response::redirect("/login");
    }

    public static function profileView($username){
        self::$auth->requireLogin();
        $data["username"] = $username;
        $data["title"] = "Profile Page";
        Response::asView("/profile", $data);
    }

    public static function createView(){
        if (self::$auth->isLoggedIn()){
            Response::redirect("/profile/". Session::get('username'));
        }
        $data["title"] = "Create Account Page";
        Response::asView("create", $data);
    }

    public static function create($query){
        if ($query["password1"] !== $query["password2"]){
            Session::message("Passwords do not match", "danger");
            Response::redirect("/create");
        }
        $query["password"] = $query["password1"];
        self::$userModel->createUser($query);
        Session::message("Successfully created");
        Response::redirect("/login");
    }

    public static function execute(string $method){
        if (!in_array($method, get_class_methods(new UserController))){
            Response::asJson(["message" => "$method not defined in " . __CLASS__], 500);
            exit();            
        }
        return [__CLASS__ , $method];
    }
}
