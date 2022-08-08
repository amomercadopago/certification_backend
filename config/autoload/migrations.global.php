<?php

declare(strict_types=1);

return [
    'migrations' => [
        'table_storage' => [
            'table_name' => 'migration_versions',
            'version_column_name' => 'version',
            'version_column_length' => 1024,
            'executed_at_column_name' => 'executed_at',
            'execution_time_column_name' => 'execution_time',
        ],
        'migrations_paths' => [
            'Migrations' => 'migrations',
        ],
        'transactional' => true,
        'check_database_platform' => true,
        'organize_migrations' => 'none',
        'connection' => null,
        'em' => null,
    ],
    'migrations_db' => [
        'dbname' => getenv('DB_DATABASE'),
        'user' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'host' => getenv('DB_HOST'),
        'driver' => getenv('DB_DRIVER'),
    ],
];
