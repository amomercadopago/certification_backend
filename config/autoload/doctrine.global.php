<?php

declare(strict_types=1);

use App\Factory\EntityManagerFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

return [
    'dependencies' => [
        'aliases' => [
            EntityManagerInterface::class => EntityManager::class,
        ],
        'factories' => [
            EntityManager::class => EntityManagerFactory::class
        ],
    ],
    'doctrine' => [
        'proxy_dir' => getenv('PROXY_DIR'),
    ],
];
