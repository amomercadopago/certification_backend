<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$cacheConfig = [
    'config_cache_path' => 'data/cache/config-cache.php',
];

return (new ConfigAggregator([
    \Mezzio\ProblemDetails\ConfigProvider::class,
    /** Project configs */
    \App\ConfigProvider::class,

    /** Libraries configs */
    \Mezzio\Cors\ConfigProvider::class,
    \Laminas\Di\ConfigProvider::class,
    \Laminas\Diactoros\ConfigProvider::class,
    \Laminas\HttpHandlerRunner\ConfigProvider::class,
    \Laminas\Serializer\ConfigProvider::class,
    \Mezzio\ConfigProvider::class,
    \Mezzio\Helper\ConfigProvider::class,
    \Mezzio\Router\ConfigProvider::class,
    \Mezzio\Router\FastRouteRouter\ConfigProvider::class,
    \Mezzio\Tooling\ConfigProvider::class,
    \WShafer\PSR11MonoLog\ConfigProvider::class,

    /** Cache config */
    new ArrayProvider($cacheConfig),

    /** Environment configs */
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
], $cacheConfig['config_cache_path']))->getMergedConfig();
