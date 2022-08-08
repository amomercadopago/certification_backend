<?php

declare(strict_types=1);

use Mezzio\Cors\Configuration\ConfigurationInterface;

return [
    ConfigurationInterface::CONFIGURATION_IDENTIFIER => [
        'allowed_origins' => [
            '*'
        ],
        'allowed_headers' => [
            'X-Auth-Token',
            'Authorization',
            'Content-Type',
            'Origin',
            'X-Requested-With',
            'Accept',
            'DNT',
            'X-CustomHeader',
            'User-Agent',
            'If-Modified-Since',
            'Access-Control-Allow-Origin',
            'Cache-Control',
        ],
        'allowed_max_age' => '600',
        'credentials_allowed' => true,
        'exposed_headers' => ['X-Custom-Header', 'X-CustomHeader'],
    ],
];