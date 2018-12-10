<?php

error_reporting(0);

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

//
$env = new Dotenv(__DIR__);
$env->load();
$_ENV['DB_DATABASE'] .= '_test';
///

//
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => $_ENV['DB_CONNECTION'],
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
///