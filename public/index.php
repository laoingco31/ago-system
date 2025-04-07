<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// I-check kung ang application ay naka-maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// I-register ang Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// I-bootstrap ang Laravel at i-handle ang request
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// I-handle ang request
$response = $app->make(Illuminate\Contracts\Http\Kernel::class)->handle(Request::capture());

// I-send ang response sa browser
$response->send();

// I-terminate ang application
$app->terminate(Request::capture(), $response);
