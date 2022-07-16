<?php

declare(strict_types=1);

require __DIR__ . "/src/lib/ErrorHandler.php";

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");


use App\Lib\Router;

$router = new Router();

session_start();
