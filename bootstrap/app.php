<?php

spl_autoload_register(function ($class) {
    $parts = explode('\\', $class);

    if ($parts[0] === "App") {
        $parts[0] = mb_strtolower($parts[0]);
    }

    $path = implode('/', $parts) . '.php';

    if (!file_exists($path)) {
        throw new \Exception('Can\'t load file' . "\r\n" . $path);
    }

    require $path;
});

$router = new App\Core\Router();
$router->callAction();
