<?php

$env = $_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'test';
if ($env !== 'test') {
    throw new \Exception('Test suite MUST be run over test environment in a docker container !');
}

require __DIR__ . '/../vendor/autoload.php';

$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_NAME'] = 'ludicat.test';
$_SERVER['HTTP_USER_AGENT'] = 'phpunit';
