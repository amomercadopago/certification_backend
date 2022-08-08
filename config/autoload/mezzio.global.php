<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;

return [
    ConfigAggregator::ENABLE_CACHE => getenv('DEV_MODE') !== 'true',
    'debug'  => getenv('DEV_MODE') === 'true',
    'mezzio' => [
        'error_handler' => [
            'template_404'   => 'error::404',
            'template_error' => 'error::error',
        ],
    ],
];
