<?php

declare(strict_types=1);

use App\Lib\Response;


class ErrorHandler
{

    public static function handleException(Throwable $exception): void
    {
        Response::asJson([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
        ], $exception->getCode());
        die();
    }


    public static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        throw new ErrorException($errstr, 0, 500, $errfile, $errline);
    }
}