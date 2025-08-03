#!/usr/bin/env php
<?php

/*
|--------------------------------------------------------------------------
| Sail
|--------------------------------------------------------------------------
|
| This file loads the Docker environment and starts the Laravel application.
| This is the "master" server file which does the actual "heavy lifting"
| of getting the Laravel application ready and then passing it on to
| the HTTP server.
|
*/

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check For The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

$app = require_once __DIR__.'/bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);

/*
|--------------------------------------------------------------------------
| Shutdown The Application
|--------------------------------------------------------------------------
|
| Once Artisan has finished, we will fire off the shutdown events
| so that any final work may be done by the application before we
| turn off the lights. This is the last thing to happen to the
| application before it shuts down.
|
*/

$kernel->terminate($input, $status);

exit($status);
