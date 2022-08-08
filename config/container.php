<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Laminas\ServiceManager\ServiceManager;

try {
    (Dotenv::createUnsafeImmutable(__DIR__ . '/../'))->load();
} catch (\Throwable $e) {}

$config = require __DIR__ . '/config.php';
return new ServiceManager($config['dependencies'] + ['services' => ['config' => $config]]);
