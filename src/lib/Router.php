<?php

declare(strict_types=1);

namespace App\Lib;

use App\Lib\Session;

class Router
{
    private array $routes = [];

    public function get(string $path, $handler): void
    {
        $this->on("GET", $path, $handler);
    }

    public function post(string $path, $handler): void
    {
        $this->on("POST", $path, $handler);
    }

    private function on(string $method, string $path, $handler): void
    {
        if ($_SERVER['REQUEST_METHOD'] != $method){
            return;
        }
        $path = trim($path, '/');
        $path = preg_replace("/{[^}]+}/", '(.+)', $path);
        $this->routes[$path] = $handler;
    }

    public function run(): void
    {
        $path = trim(parse_url($_SERVER["REQUEST_URI"])["path"], "/");
        $callback = null;
        $params = [];
        foreach ($this->routes as $route => $handler)
        {
            if (preg_match("%^{$route}$%", $path, $matches))
            {
                $callback = $handler;
                array_shift($matches);
                $params = $matches;
                break;
            }
        }

        if (is_string($callback) && is_array($callback)) {
            $className = array_shift($callback);
            $handler = new $className;
            $method = array_shift($callback);
            $callback = [$handler, $method];
        }

        if(!$callback || !is_callable($callback)){
            http_response_code(404);
            echo "404 Not Found";
            exit;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $methodsQ = array_merge($_POST, $_GET);
        $params = array_merge($params, [$methodsQ, $data]);
        call_user_func_array($callback, $params);
    }
}