<?php

declare(strict_types=1);

namespace App\Lib;

class Session{

    public static function message(string $message, string $error_level = "success"){
        if(isset($_SESSION["message"]) && $_SESSION["error_level"]){
            unset($_SESSION["message"]);
            unset($_SESSION["error_level"]);
        }
        self::set("message", $message);
        self::set("error_level", $error_level);
    }

    public static function clearMessage(){
        self::remove("message");
        self::remove("error_level");
    }

    public static function remove(string $session){
        if(isset($_SESSION[$session])){
            unset($_SESSION[$session]);
        }
    }

    public static function set(string $key, string $value){
        $_SESSION[$key] = $value;
    }

    public static function get(string $key){
        return $_SESSION[$key];
    }
}