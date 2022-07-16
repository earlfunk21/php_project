<?php

declare(strict_types=1);

namespace App\Lib;

use App\Lib\Session;

class Response{

    public static function asView(string $file, array $data = [], $statusCode = 200) {
        http_response_code($statusCode);
        require_once __DIR__ . "/../views/$file.php";
        Session::clearMessage();
    }

    public static function asJson(array $data, $statusCode = 200) {
        http_response_code($statusCode);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }

    public static function redirect($uri){
        header('Location: '. $uri); 
        exit();
    }
}