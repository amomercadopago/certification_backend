<?php
declare(strict_types=1);

use Psr\Log\LoggerInterface;
use WShafer\PSR11MonoLog\MonologFactory;
use Monolog\Logger;

$logPath = $_SERVER['DOCUMENT_ROOT'] ? "{$_SERVER['DOCUMENT_ROOT']}/../data/log/" : "{$_SERVER['PWD']}/data/log/";
$logStream = 'false' === getenv('DEV_MODE') ? 'php://stdout' : ($logPath) . (new \DateTime)->format('Y_m_d') . '.log';

return [
    'dependencies' => [
        'factories' => [
            'logger' => MonologFactory::class,
            'errorChannel' => [
                MonologFactory::class,
                'errorChannel'
            ],
            Logger::class => [
                MonologFactory::class,
                'consoleChannel'
            ],
        ],
        'aliases' => [
            LoggerInterface::class => Logger::class,
        ],
    ],
    'monolog' => [
        'handlers' => [
            'errorLog' => [
                'type'  => 'stream',
                'formatter' => 'lineFormatter',
                'options'   => [
                    'stream' => 'php://stderr',
                    'level'  => Logger::WARNING,
                ],
            ],
            'consoleLog' => [
                'type' => 'stream',
                'formatter' => 'lineFormatter',
                'options'   => [
                    'stream' => $logStream,
                    'level'  => Logger::INFO,
                ],
            ],
        ],
        'channels' => [
            'errorChannel' => [
                'name' => 'errorChannel',
                'handlers' => ['errorLog'],
                'processors' => ['psrProcessor', 'uidProcessor'],
            ],
            'consoleChannel' => [
                'name' => 'consoleChannel',
                'handlers' => ['consoleLog'],
                'processors' => ['psrProcessor', 'uidProcessor'],
            ],
        ],
        'formatters' => [
            'lineFormatter' => [
                'type' => 'line',
                'options' => [
                    'format' => "[%datetime%] %level_name%: %message% %context%\n",
                    'dateFormat' => 'Y-m-d H:i:s T',
                    'allowInlineLineBreaks' => false,
                    'ignoreEmptyContextAndExtra' => false,
                ],
            ],
        ],
        'processors' => [
            'psrProcessor' => [
                'type' => 'psrLogMessage',
                'options' => [],
            ],
            'uidProcessor' => [
                'type' => 'uid',
                'options' => [],
            ],
        ],
    ],
];
