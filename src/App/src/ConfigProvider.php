<?php

declare(strict_types=1);

namespace App;

use AmoCRM\OAuth\OAuthConfigInterface;
use AmoCRM\OAuth\OAuthServiceInterface;
use App\Config\AmoConfig;
use App\Exception\Delegator\LoggerProblemDetailsListenerDelegator;
use App\Factory\JwtParserFactory;
use App\Service\AmoAuthService;
use Lcobucci\JWT\Token\Parser;
use Mezzio\ProblemDetails\ProblemDetailsMiddleware;

class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'factories'  => [
                    Parser::class => JwtParserFactory::class
                ],
                'aliases' => [
                    OAuthConfigInterface::class => AmoConfig::class,
                    OAuthServiceInterface::class => AmoAuthService::class,
                ],
                'delegators' => [
                    ProblemDetailsMiddleware::class => [
                        LoggerProblemDetailsListenerDelegator::class,
                    ],
                ],
            ],
        ];
    }
}
